<?php


namespace App\DAO;


use App\CuocHop;
use App\Model\PagingResult;
use DB;
use Illuminate\Http\Request;
use App\Mail\DemoMail;
use App\SERVICES\MailService;
use Mail;

class CuocHopDAO
{

    public static function search($page, $query)
    {
        $items = array();
        $offset = 0;
        if ($page->getPageNumber() > 0) $offset = ($page->getPageNumber() - 1) * $page->getNumberPerPage();

        $sql = "select cuochop.id, cuochop.tencuochop, cuochop.idphong, cuochop.trangthai,
            lichtrinh.id as idlichtrinh, lichtrinh.idnguoidat, lichtrinh.thoigianbatdau, lichtrinh.thoigianketthuc, lichtrinh.loailichtrinh,
            lichtrinh.ngaybatdau, lichtrinh.ngayketthuc, lichtrinh.thu,
            phonghop.id as idPhongHop, phonghop.ten_phong as tenPhongHop, phonghop.loai_phong as loaiPhongHop
            from cuochop cuochop
            join lichtrinh lichtrinh
            on cuochop.idlichtrinh = lichtrinh.id
            join phonghop phonghop
            on lichtrinh.idphong = phonghop.id
            where cuochop.deleted = 0 $query";

        $count = DB::select(DB::raw("SELECT count(*) as count FROM ( $sql ) as count"));
        $count = $count[0]->count;
        if ($count > 0) {
            $numPerPage = $page->getNumberPerPage();
            $sql.= "ORDER BY ABS(DATEDIFF(lichtrinh.ngaybatdau, NOW())) asc limit $numPerPage offset $offset";
            /*$sql .= " order by bo.created_at desc limit $numPerPage offset $offset";*/
            $items = DB::select(DB::raw($sql));
        }
        if (sizeof($items) > 0) {
            $page->setItems($items);
            $page->setRowCount($count);
        }
        return $page;
    }

    public static function searchByIdLichTrinh($idlichtrinh)
    {
        $cuochop = null;
        $items = DB::select(DB::raw('select bo.id, bo.tencuochop, bo.noidungcuochop, bo.trangthai, bo.noidungtongket,
        bo.idphong, bo.idfiledinhkem, bo.idlichtrinh from cuochop bo where bo.idlichtrinh='.$idlichtrinh));
        if(sizeof($items)>0) $cuochop = $items[0];
        return $cuochop;
    }

    public static function getLastInsertedId($cuochop)
    {
        $id = DB::table('cuochop')->insertGetId(
            ['tencuochop' => $cuochop->tencuochop, 'noidungcuochop' => $cuochop->noidungcuochop,
                'trangthai' => $cuochop->trangthai, 'noidungtongket' => $cuochop->noidungtongket,
                'idphong' => $cuochop->idphong, 'idfiledinhkem' => $cuochop->idfiledinhkem,
                'idlichtrinh' => $cuochop->idlichtrinh
            ]
        );
        return $id;
    }

    public static function update($cuochop)
    {
        if($cuochop->idfiledinhkem=='') $cuochop->idfiledinhkem = null;
        DB::update('update cuochop set tencuochop = ? , noidungcuochop = ?,
                    trangthai =?, noidungtongket = ?, idphong = ?, idfiledinhkem = ?, idlichtrinh = ?
                    where id = ?', [$cuochop->tencuochop , $cuochop->noidungcuochop, $cuochop->trangthai,
            $cuochop->noidungtongket, $cuochop->idphong, $cuochop->idfiledinhkem==''?null:$cuochop->idfiledinhkem, $cuochop->idlichtrinh, $cuochop->id]);
        return true;
    }

    /*public static function deleteByIdLichTrinh($idlichtrinh)
    {
        $sql = "update cuochop set deleted = 1 where idlichtrinh = $idlichtrinh";
        \DB::delete($sql);
        return true;
    }*/

    public static function delete($id, $idlichtrinh)
    {
        $sqlSearchToDelete = "";
        $cuochop = new CuocHop();;
        if($id!='' && $id != null){
            $cuochop = self::findById($id);
            $sqlSearchToDelete.=" and ch.id = $id";
        }
        if($idlichtrinh!='' && $idlichtrinh != null){
            $cuochop = self::searchByIdLichTrinh($idlichtrinh);
            $sqlSearchToDelete.=" and ch.idlichtrinh = $idlichtrinh";
        }

        if($cuochop!=null){
            $listThanhVien = ThanhVienDAO::searchAllByCuocHop($cuochop->id);
            if(sizeof($listThanhVien) > 0){
                $arrEmail = [];
                for($i=0;$i<sizeof($listThanhVien);$i++){
                    $arrEmail[$i] = trim($listThanhVien[$i]->email);
                }
                if (sizeof($arrEmail) > 0) {
    
                    Mail::send('emailCuocHopHuy', array('tencuochop' => $cuochop->tencuochop,
                        'noidungcuochop' => $cuochop->noidungcuochop,
                        'noidungtongket' => $cuochop->noidungtongket), function ($message) use ($arrEmail) {
                        $message->to($arrEmail[0], 'Phần mềm quản lý đặt phòng')->subject('Thông báo hủy cuộc họp!')->cc(['daicq.dev@gmail.com','alone01011991@gmail.com']);
                    });
                }
            }
            

        }


        //xóa cuộc họp
        $sql = "UPDATE cuochop ch SET ch.deleted = 1 WHERE ch.deleted = 0 $sqlSearchToDelete";
        DB::update($sql);


        //Xóa thành viên thuộc cuộc họp
        $sqlDeleteThanhVien = "update thanhvien set deleted = 1 where id_cuochop
            in (select ch.id from cuochop ch where ch.deleted = 0 $sqlSearchToDelete)";
        DB::update($sqlDeleteThanhVien);

        /*  CuocHopDAO::deleteByIdLichTrinh()*/
        return true;
    }

    public static function findById($id)
    {
        $cuochop = new CuocHop();
        $items = DB::select(DB::raw('select bo.id, bo.tencuochop, bo.noidungcuochop, bo.trangthai, bo.noidungtongket,
        bo.idphong, bo.idfiledinhkem, bo.idlichtrinh from cuochop bo where bo.id='.$id));
        if(sizeof($items)>0) $cuochop = $items[0];
        return $cuochop;
    }

}
