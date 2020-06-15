<?php


namespace App\DAO;

use App\Model\PagingResult;
use DB;
use http\Exception;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class NguoiDungDAO
{
    public static function searchUsers($page, $query)
    {
        $items = array();
        $offset = 0;
        if ($page->getPageNumber() > 0) $offset = ($page->getPageNumber() - 1) * $page->getNumberPerPage();
        $count = DB::select(DB::raw("SELECT count(bo.id) as count FROM users bo WHERE bo.deleted = 0 $query"));
        $count = $count[0]->count;
        if ($count > 0) {
            $numPerPage = $page->getNumberPerPage();
            $query .= " order by bo.created_at desc limit $numPerPage offset $offset";
            $items = DB::select(DB::raw("SELECT * FROM users bo WHERE bo.deleted = 0 $query"));
        }
        if (sizeof($items) > 0) {
            $page->setItems($items);
            $page->setRowCount($count);
        }
        return $page;
    }

    public static function danhsachnguoidung()
    {
        $items = array();
        $count = DB::select(DB::raw("SELECT count(bo.id) as count FROM users bo WHERE bo.deleted = 0 and bo.isActive = 1"));
        if ($count > 0) {
            $items = DB::select(DB::raw("SELECT * FROM users bo WHERE bo.deleted = 0  and bo.isActive = 1 order by bo.created_at desc"));
        }
        return $items;

    }

    public static function getUserByEmail($email)
    {
        $items = array();
        $items = DB::select(DB::raw("SELECT * FROM users bo where bo.deleted = 0 and bo.email = '$email'"));
        if(sizeof($items)>0) return $items[0];
        else return null;

    }

    public static function deleteById($id)
    {
        //xóa
        $sql = "UPDATE users SET deleted = 1 WHERE id = $id";
        DB::update($sql);
        LichTrinhDAO::delete(null,$id,null);
        ThongBaoDAO::delete(null, $id);

        //xóa hẳn bản ghi user trong db sau khi đổi trạng thái các data liên quan
        DB::delete("delete from users where id = $id");
        return true;
    }

    public static function changePass($idUser, $newPass)
    {
        try {
            $newPassEncode = bcrypt($newPass);
            $sql = "UPDATE users SET password = '$newPassEncode' WHERE id = $idUser";
            DB::update($sql);
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            // something went wrong whilst attempting to encode the token
            return false;
        }
    }

    public static function checkPass($credentials)
    {
        try {
            if (Hash::check($request->password, $user->password))
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return false;
            } else return true;
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return false;
        }
    }
}
