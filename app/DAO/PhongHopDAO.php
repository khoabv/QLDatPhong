<?php


namespace App\DAO;


use App\Model\PagingResult;
use DB;
use Illuminate\Http\Request;

class PhongHopDAO
{
    const MAX_GHE = 1000;

    public static function searchRooms($page, $query)
    {
        $items = array();
        $offset = 0;
        if ($page->getPageNumber() > 0) $offset = ($page->getPageNumber() - 1) * $page->getNumberPerPage();
        $count = DB::select(DB::raw("SELECT count(bo.id) as count FROM phonghop bo WHERE bo.deleted = 0 $query"));
        $count = $count[0]->count;
        if ($count > 0) {
            $numPerPage = $page->getNumberPerPage();
            $query .= " order by bo.created_at desc limit $numPerPage offset $offset";
            $items = DB::select(DB::raw("SELECT * FROM phonghop bo WHERE bo.deleted = 0 $query"));
        }
        if (sizeof($items) > 0) {
            $page->setItems($items);
            $page->setRowCount($count);
        }
        return $page;
    }

    public static function danhsachphonghop($query)
    {
        $items = array();
        $count = DB::select(DB::raw("SELECT count(bo.id) as count FROM phonghop bo WHERE bo.deleted = 0 $query"));
        if ($count > 0) {
            $items = DB::select(DB::raw("SELECT * FROM phonghop bo WHERE bo.deleted = 0 $query order by bo.created_at desc"));
        }
        return $items;
    }

    //Get danh sách phòng
    //Nếu $isAll==true sẽ lấy cả phòng bận, ==false sẽ chỉ lấy phòng trống
    //Nếu $top>0: chỉ trả về $top kết quả đầu tiên
    public static function getRooms($loaiPhong, $slMin, $slMax, $ngaybatdau, $ngayketthuc, $thoigianbatdau, $thoigianketthuc, $isAll, $top)
    {
        $items = array();

        $queryString = "";
        if ($loaiPhong != null && $loaiPhong != "") {
            $queryString .= " and ph.loai_phong = $loaiPhong ";
        }
        if ($slMin != null && $slMin != "") {
            $queryString .= " and ph.soluong >= $slMin ";
        }
        if (!$isAll) {
            $queryString .= " AND ( (lt.id is null or lt.deleted = 1 or lt.trangthai = 2) or
            (select count(lt2.id) from lichtrinh lt2
                where lt2.idphong = phonghop.id
                and ( (	 not (lt2.ngaybatdau<'$ngaybatdau' && lt2.ngayketthuc<'$ngaybatdau')
                    and not (lt2.ngaybatdau>'$ngayketthuc' && lt2.ngayketthuc>'$ngayketthuc')
                    )
                    and (	 not (lt2.thoigianbatdau<'$thoigianbatdau' && lt2.thoigianketthuc<'$thoigianbatdau')
                        and not (lt2.thoigianbatdau>'$thoigianketthuc' && lt2.thoigianketthuc>'$thoigianketthuc')
                    )
                ) ) = 0 ) ";
        }

        $sql = "select ph.id, ph.ten_phong as tenPhongHop, ph.loai_phong as loaiPhongHop, ph.mo_ta as moTaPhongHop, ph.soluong as soLuongGhe, ch.sgmongmuon as soGheMongmuon "
            . " from phonghop ph left join lichtrinh lt on ph.id = lt.idphong inner join cuochop ch on lt.id=ch.idlichtrinh "
            . " WHERE ph.deleted = 0 $queryString group by ph.id ";


        $count = DB::select(DB::raw("SELECT count(*) as count FROM ( $sql ) as count1"));
        $count = $count[0]->count;
        if ($count > 0) {
            $sql .= " ORDER BY ph.soluong asc, ABS(DATEDIFF(lt.ngaybatdau, NOW())) asc, ph.id asc";
            if ($top > 0)
                $sql .= " limit 0,$top ";
            $items = DB::select(DB::raw($sql));
        }
        return $items;
    }

    //Get danh sách phòng có thể chuyển nhượng
    public static function getRoomsOptimize($loaiPhong, $soluong, $ngaybatdau, $ngayketthuc, $thoigianbatdau, $thoigianketthuc)
    {
        $items = array();
        $result = []; //danh sách các phòng có thể chuyển nhượng
        $slg = 0;
        //Tìm phòng trống đầu tiên thỏa mãn điều kiện
        $items = PhongHopDAO::getRooms($loaiPhong, $soluong, PhongHopDAO::MAX_GHE, $ngaybatdau, $ngayketthuc, $thoigianbatdau, $thoigianketthuc, false, 1);

        if (sizeof($items) > 0) {
            $slg = $items[0]->soLuongGhe;
        }

        if ($slg > $soluong) {
            //Nếu phòng tìm được có số lượng ghế > số lượng ghế mong muốn
            //Thì thử xem có thể yêu cầu nhượng phòng hay không?

            //Lấy tất cả các phòng có số ghế nằm trong khoảng [$soluong, $slg]
            $items = PhongHopDAO::getRooms($loaiPhong, $soluong, $slg, $ngaybatdau, $ngayketthuc, $thoigianbatdau, $thoigianketthuc, true, 0);

            for ($i = 0; $i < count($items); $i++) {
                //Nếu phòng này có số ghế = đúng số ghế mong muốn của cuộc họp thì bỏ qua
                if ($items[$i]->soGheMongmuon == $items[$i]->soLuongGhe)
                    continue;

                //Nếu số ghế mong muốn ít hơn số ghế của phòng
                $slmm = $items[$i]->soGheMongmuon;
                //Thử xem có phòng nào nhỏ hơn và còn trống hay không?
                $rooms = PhongHopDAO::getRooms($loaiPhong, $slmm, $items[$i]->soLuongGhe - 1, $ngaybatdau, $ngayketthuc, $thoigianbatdau, $thoigianketthuc, false, 1);
                if (sizeof($rooms) > 0) {
                    array_push($result, $items[$i]); //Đưa vào danh sách các phòng có thể chuyển nhượng
                }
            }
        }

        return $result;
    }

    public static function searchRoomsByLichTrinh($page, $query, $queryOp)
    {
        $items = array();
        $offset = 0;
        if ($page->getPageNumber() > 0) $offset = ($page->getPageNumber() - 1) * $page->getNumberPerPage();

        $sql = "select phonghop.id, phonghop.ten_phong as tenPhongHop, phonghop.loai_phong as loaiPhongHop,
            phonghop.mo_ta as moTaPhongHop, phonghop.soluong as soLuongGhe, phonghop.trangthai
            from phonghop phonghop
            left join lichtrinh lichtrinh
            on phonghop.id = lichtrinh.idphong
            WHERE (phonghop.deleted = 0 $query) $queryOp group by phonghop.id ";

        $count = DB::select(DB::raw("SELECT count(*) as count FROM ( $sql ) as count1"));
        $count = $count[0]->count;
        if ($count > 0) {
            $numPerPage = $page->getNumberPerPage();
            $sql .= " ORDER BY phonghop.trangthai, phonghop.soluong asc, ABS(DATEDIFF(lichtrinh.ngaybatdau, NOW())) asc, phonghop.id asc limit $numPerPage offset $offset";
            $items = DB::select(DB::raw($sql));
        }

        if (sizeof($items) > 0) {
            $page->setItems($items);
            $page->setRowCount($count);
        }
        return $page;
    }

    public static function xuLyTrungBanGhi($items)
    {
        $result = [];

        for ($i = 1; $i <= count($items); $i++) {
            if ($i = 0 || $items[$i]->id != $items[$i - 1]->id) {
                $result->push($items[$i]);
            }
        }
        echo $result;
        return $result;
    }

    public static function checkdatphong($query)
    {
        $items = array();
        $count = DB::select(DB::raw("SELECT count(bo.id) as count FROM phonghop bo WHERE bo.deleted = 0 "));
    }

    public static function deleteById($id)
    {
        //xóa lịch trình
        $sql = "UPDATE phonghop SET deleted = 1 WHERE id = $id";
        DB::update($sql);
        LichTrinhDAO::delete(null, null, $id);

        /*  CuocHopDAO::deleteByIdLichTrinh()*/
        return true;
    }
}
