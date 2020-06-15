<?php


namespace App\DAO;


use DB;

class LichTrinhDAO
{

    public static function searchLichTrinh($page, $query)
    {
        $items = array();
        $offset = 0;
        if ($page->getPageNumber() > 0) $offset = ($page->getPageNumber() - 1) * $page->getNumberPerPage();

        $sql = "select bo.id, bo.malichtrinh, bo.idphong, bo.idnguoidat, bo.thoigianbatdau, bo.thoigianketthuc, bo.loailichtrinh,
        bo.trangthai, bo.ngaybatdau, bo.ngayketthuc, bo.thu,
        phonghop.id as idPhongHop, phonghop.ten_phong as tenPhongHop, phonghop.loai_phong as loaiPhongHop,
        user.name as tenNguoiDat, user.email as emailNguoiDat
        from lichtrinh bo
        join phonghop phonghop
        on bo.idphong = phonghop.id
        join users user
        on user.id = bo.idnguoidat WHERE bo.deleted = 0 $query";

        $count = DB::select(DB::raw("SELECT count(*) as count FROM ( $sql ) as count"));
        $count = $count[0]->count;
        if ($count > 0) {
            $numPerPage = $page->getNumberPerPage();
            $sql.= " ORDER BY ABS(DATEDIFF(bo.ngaybatdau, NOW())) asc limit $numPerPage offset $offset";
            /*$sql .= " order by bo.created_at desc limit $numPerPage offset $offset";*/
            $items = DB::select(DB::raw($sql));
        }
        if (sizeof($items) > 0) {
            $page->setItems($items);
            $page->setRowCount($count);
        }
        return $page;
    }

    public static function delete($id, $idnguoidat, $idphonghop)
    {
        $sqlSearchToDelete = "";
        if($id!='' && $id != null){
            $sqlSearchToDelete.=" and lt.id = $id";
        }
        if($idnguoidat!='' && $idnguoidat != null){
            $sqlSearchToDelete.=" and lt.idnguoidat = $idnguoidat";
        }
        if($idphonghop!='' && $idphonghop != null){
            $sqlSearchToDelete.=" and lt.idphong = $idphonghop";
        }
        //xóa lịch trình
        $sql = "UPDATE lichtrinh lt SET lt.deleted = 1 WHERE lt.deleted = 0 $sqlSearchToDelete";
        DB::update($sql);

        //xóa cuộc họp thuộc lịch trình
        // $sqlDeleteCuocHop = "update cuochop set deleted = 1 where idlichtrinh in (select lt.id from lichtrinh lt where lt.deleted = 0 $sqlSearchToDelete)";
        // DB::update($sqlDeleteCuocHop);
        CuocHopDAO::delete(null, $id);

        //Xóa thành viên thuộc cuộc họp
        // $sqlDeleteThanhVien = "update thanhvien set deleted = 1 where id_cuochop
        //     in (select ch.id from cuochop ch where idlichtrinh
        //     in (select lt.id from lichtrinh lt where lt.deleted = 0 $sqlSearchToDelete))";
        // DB::update($sqlDeleteThanhVien);

        /*  CuocHopDAO::deleteByIdLichTrinh()*/
        return true;
    }

}
