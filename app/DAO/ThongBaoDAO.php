<?php


namespace App\DAO;


use App\ThongBao;
use DB;

class ThongBaoDAO
{

    public static function searchThongBao($page, $query)
    {
        $items = array();
        $offset = 0;
        if ($page->getPageNumber() > 0) $offset = ($page->getPageNumber() - 1) * $page->getNumberPerPage();
        $sql = "select tb.id, tb.tieude, tb.noidung as noidung, tb.userid as userid, tb.loaithongbao as loaithongbao, tb.created_at as created_at, tb.link as link,
                tb.isRead,
                user.email as emailNguoiNhan, user.name as tenNguoiNhan
                from thongbao tb
                join users user
                on tb.userid = user.id where tb.deleted = 0 $query";
        $count = DB::select(DB::raw("SELECT count(*) as count FROM ( $sql ) as count"));
        $count = $count[0]->count;
        if ($count > 0) {
            $numPerPage = $page->getNumberPerPage();
            $sql .= " order by tb.created_at desc limit $numPerPage offset $offset";
            $items = DB::select(DB::raw($sql));
        }
        if (sizeof($items) > 0) {
            $page->setItems($items);
            $page->setRowCount($count);
        }
        return $page;
    }

    public static function getById($id)
    {
        $thongbao = new ThongBao();
        $items = array();
        $sql = "select tb.id, tb.tieude, tb.noidung as noidung, tb.userid as userid, tb.loaithongbao as loaithongbao, tb.created_at as created_at, tb.link as link, tb.isRead,
                user.email as emailNguoiNhan, user.name as tenNguoiNhan
                from thongbao tb
                join users user
                on tb.userid = user.id where tb.id = $id";
        $items = DB::select(DB::raw($sql));
        if(sizeof($items)>0 ) return $items[0];
        return $thongbao;
    }

    public static function countThongBaoChuaDocByUserId($userid)
    {
        $count = DB::select(DB::raw("SELECT count(*) as count FROM thongbao where isRead = 0 and userid = $userid"));
        $count = $count[0]->count;
        return $count;
    }

    public static function delete($id, $userid)
    {
        $sqlSearchToDelete = "";
        if($id!='' && $id != null){
            $sqlSearchToDelete.=" and tb.id = $id";
        }
        if($userid!='' && $userid != null){
            $sqlSearchToDelete.=" and tb.userid = $userid";
        }
        //xóa cuộc họp
        $sql = "UPDATE thongbao tb SET tb.deleted = 1 WHERE tb.deleted = 0 $sqlSearchToDelete";
        DB::update($sql);

        /*  CuocHopDAO::deleteByIdLichTrinh()*/
        return true;
    }

    public static function updateIsRead($id)
    {
        //update trạng thái đọc thông báo
        $sql = "UPDATE thongbao tb SET tb.isRead = 1 WHERE tb.id = $id";
        DB::update($sql);
        return true;
    }

}
