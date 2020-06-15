<?php


namespace App\DAO;


use App\ThongBao;
use App\YeuCauNhuongPhong;
use DB;

class YeuCauNhuongPhongDAO
{
    public static function getById($id)
    {
        $yeucaunhuongphong = new YeuCauNhuongPhong();
        $items = array();
        $sql = "select bo.id, bo.idlichtrinh as idlichtrinh, bo.idnguoidat as idnguoidat, bo.idnguoiyeucau as idnguoiyeucau, bo.lydo as lydo,
                bo.trangthai as trangthai, bo.created_at as created_at
                from yeucaunhuongphong bo where bo.id = $id";
        $items = DB::select(DB::raw($sql));
        if(sizeof($items)>0 ) return $items[0];
        return $yeucaunhuongphong;
    }

    public static function getByIdAndLichTrinh($id)
    {
        $yeucaunhuongphong = new YeuCauNhuongPhong();
        $items = array();
        $sql = "select bo.id, bo.idlichtrinh as idlichtrinh, bo.idnguoidat as idnguoidat, bo.idnguoiyeucau as idnguoiyeucau, bo.lydo as lydo,
                bo.trangthai as trangthai, bo.created_at as created_at,
                lt.idphong, lt.thoigianbatdau as batdau, lt.thoigianketthuc as ketthuc, lt.loailichtrinh, lt.trangthai as trangthailichtrinh, lt.ngaybatdau as tungay,
                lt.ngayketthuc as denngay, lt.thu, lt.malichtrinh
                from yeucaunhuongphong bo join lichtrinh lt on bo.idlichtrinh = lt.id and lt.deleted = 0 where bo.id = $id";
        $items = DB::select(DB::raw($sql));
        if(sizeof($items)>0 ) return $items[0];
        return $yeucaunhuongphong;
    }

    //Hàm insert trả về id
    public static function getLastInsertedId($yeucaunhuongphong)
    {
        $id = DB::table('yeucaunhuongphong')->insertGetId(
            ['idlichtrinh' => $yeucaunhuongphong->idlichtrinh, 'idnguoidat' => $yeucaunhuongphong->idnguoidat,
                'idnguoiyeucau' => $yeucaunhuongphong->idnguoiyeucau, 'lydo' => $yeucaunhuongphong->lydo,
                'trangthai' => $yeucaunhuongphong->trangthai
            ]
        );
        return $id;
    }

    public static function update($yeucaunhuongphong)
    {
        DB::update('update yeucaunhuongphong set idlichtrinh = ? , idnguoidat = ?,
                    idnguoiyeucau = ?, lydo = ?, trangthai = ?
                    where id = ?', [$yeucaunhuongphong->idlichtrinh , $yeucaunhuongphong->idnguoidat, $yeucaunhuongphong->idnguoiyeucau,
            $yeucaunhuongphong->lydo, $yeucaunhuongphong->trangthai, $yeucaunhuongphong->id]);
        return true;
    }

}
