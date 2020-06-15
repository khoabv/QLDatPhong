<?php
namespace App\Http\Controllers;

use App\DAO\NguoiDungDAO;
use Hash;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Hàm xử lý XÁC THỰC THÔNG TIN ĐĂNG NHẬP.
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        //Check account is active
        $user = NguoiDungDAO::getUserByEmail($request->email);
        if($user!=null){
            if($user->isActive!=1) return response()->json(['error' => 'Tài khoản đã bị khóa'], 403);
           /* if (Hash::check($request->password, $user->password)) {
                return response()->json(compact('token'));
            }
            else  return response()->json(['error' => 'Mật khẩu không chính xác'], 401);*/
        }
       /* else{
            return response()->json(['error' => 'Tài khoản không tồn tại'], 401);
        }*/
        //END Check account is active


        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 403);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    /**
     * Hàm xử lý CHECK TÀI KHOẢN HIỆN TẠI ĐANG LOGIN VÀO HỆ THỐNG.
     */
    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }
        return response(['authenticated' => true]);
    }

    /**
     * Hàm xử lý CHECK TÀI KHOẢN ĐANG LOGIN CÓ QUYỀN LÀ ADMIN K?
     */
    public function isAdmin()
    {
        try {
            $auth = JWTAuth::parseToken()->authenticate();
            $role = $auth->getAttribute("role");
            /*return response(['role' => $user->role]);*/
            if($role=="admin") return response(['isAdmin' => true]);
            else return response(['isAdmin' => false]);
        } catch (JWTException $e) {
            return response(['isAdmin' => false]);
        }
    }

    /**
     * Hàm xử lý LẤY RA THÔNG TIN USER ĐANG LOGIN VÀO HỆ THỐNG.
     */
    public function getUserLoggedOn()
    {
        try {
            $auth = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['user' => null]);
        }
        return response(['user' => $auth]);
    }

    /**
     * Hàm xử lý ĐĂNG XUẤT TÀI KHOẢN HỆ THỐNG.
     */
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }
        return response()->json(['message' => 'Log out success'], 200);
    }
}
