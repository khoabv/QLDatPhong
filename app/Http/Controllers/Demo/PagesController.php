<?php

namespace App\Http\Controllers\Demo;

use App\DAO\NguoiDungDAO;
use App\DAO\PhongHopDAO;
use App\Http\Controllers\AuthController;
use App\Model\PagingResult;
use App\Space\Demo\Todo;
use App\User;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

class PagesController extends Controller
{
    /**
     * Hàm xử lý CHECK TRÙNG EMAIL KHI TẠO TÀI KHOẢN NGƯỜI DÙNG
     */
    public function emailExist(Request $request)
    {
        if (User::whereEmail($request->email)->first()) {
            return 'false';
        } else {
            return 'true';
        }
    }

    /**
     * Hàm xử lý LẤY RA DANH SÁCH NGƯỜI DÙNG TRONG HỆ THỐNG.
     */
    public function allUsers(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $name = $request->name;
        $email = $request->email;
        $role = $request->role;

        $queryString = "";
        if ($name != null && $name != "") {
            $queryString .= " and bo.name like '%$name%'";
        }
        if ($email != null && $email != "") {
            $queryString .= " and bo.email like '%$email%'";
        }
        if ($role != null && $role != "") {
            $queryString .= " and bo.role = '$role'";
        }
        $page = NguoiDungDAO::searchUsers($page, $queryString);
        /*  return Response::json($page);*/
        return response()->json([
            'items' => $page->getItems(),
            'rowCount' => $page->getRowCount(),
            'numberPerPage' => $page->getNumberPerPage(),
            'pageNumber' => $page->getPageNumber()
        ], 200);
        /*return $page;*/
    }

    public function destroy($id)
    {
        /*$user = User::findOrFail($id);
        $user->delete();*/
        NguoiDungDAO::deleteById($id);
        return $users = User::all();
    }

    /**
     * Hàm xử lý THÊM MỚI TÀI KHOẢN NGƯỜI DÙNG HỆ THỐNG.
     */
    public function store(Request $request)
    {
        //$item = $request->only('name', 'email', 'password', 'role');
        $item = new User();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->password = bcrypt($request->password);
        $item->role = $request->role;
        $item->deleted = 0;
        $item->isActive = 1;
        $item->created_at = now();
        $item->save();
        return response()->json([
            'result' => true,
            'message' => 'Thêm mới người dùng thành công!',
            'user' => $item
        ], 200);
    }

    /**
     * Hàm xử lý CẬP NHẬT THÔNG TIN TÀI KHOẢN NGƯỜI DÙNG HỆ THỐNG.
     */
    public function update(Request $request)
    {
        $item = User::findOrFail($request->id);
        $item->name = $request->name;
        $item->email = $request->email;
        $item->role = $request->role;
        $item->isActive = $request->isActive;
        if ($request->isChangePass) {
            $item->password = bcrypt($request->password);
        }
        $item->save();
        return response()->json([
            'result' => true,
            'message' => 'Chỉnh sửa người dùng thành công!',
            'user' => $item
        ], 200);
    }

    /**
     * Hàm xử lý LẤY RA DANH SÁCH NGƯỜI DÙNG.
     */
    public function danhsachnguoidung(Request $request)
    {
        $items = array();

        $items = NguoiDungDAO::danhsachnguoidung();
        /*  return Response::json($page);*/
        return response()->json([
            'nguoidat' => $items
        ], 200);
        /*return $page;*/
    }

    /**
     * Hàm xử lý LẤY RA THÔNG TIN NGƯỜI DÙNG HỆ THỐNG THEO ID
     */
    public function findById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Hàm xử lý THAY ĐỔI MẬT KHẢU NGƯỜI DÙNG
     */
    public function changeMyPass(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $credentials = $user->only('email', 'password');
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'result' => false,
                'message' => 'Mật khẩu cũ không chính xác!',
                'user' => $user
            ], 200);
        }
        /*$checkPass = NguoiDungDAO::checkPass($credentials);*/
        $resultChangePass = false;
        $resultChangePass = NguoiDungDAO::changePass($user->id, $request->newPassword);
        if ($resultChangePass) {
            return response()->json([
                'result' => true,
                'message' => 'Đổi mật khẩu thành công!',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'result' => true,
                'message' => 'Đổi mật khẩu thất bại!',
                'user' => $user
            ], 200);
        }

    }
}
