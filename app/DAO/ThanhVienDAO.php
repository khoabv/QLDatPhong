<?php


namespace App\DAO;


class ThanhVienDAO
{
    public static function insertMultipleEmail($emails, $idcuochop)
    {
        if($emails=="") return true;
        $sql = "insert into thanhvien(email,id_cuochop) values ";
        $arrEmail = explode(",", $emails);
        $countEmail = count($arrEmail);
        if($countEmail > 0) {
            for ($i = 0; $i < $countEmail; $i++) {
                if($i==($countEmail-1)) $sql.="('$arrEmail[$i]',$idcuochop)";
                else $sql.="('$arrEmail[$i]',$idcuochop),\n";

            }
            \DB::insert($sql);
        }
        return true;
    }

    public static function deleteByIdCuocHop($idcuochop)
    {
        $sql = "update thanhvien set deleted = 1 where id_cuochop = $idcuochop";
        \DB::delete($sql);
        return true;
    }

    public static function searchAllByCuocHop($id_cuochop)
    {
        $items = array();
        $count = \DB::select(\DB::raw("SELECT count(bo.id) as count FROM thanhvien bo WHERE bo.id_cuochop=$id_cuochop"));
        if ($count > 0) {
            $items = \DB::select(\DB::raw("SELECT * FROM thanhvien bo WHERE bo.id_cuochop=$id_cuochop"));
        }
        return $items;

    }
}
