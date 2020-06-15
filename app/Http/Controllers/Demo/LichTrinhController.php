<?php


namespace App\Http\Controllers\Demo;

use App\DAO\CuocHopDAO;
use App\DAO\LichTrinhDAO;
use App\DAO\YeuCauNhuongPhongDAO;
use App\LichTrinh;
use App\Model\PagingResult;
use App\PhongHop;
use App\DAO\PhongHopDAO;
use App\ThongBao;
use App\YeuCauNhuongPhong;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Response;
class LichTrinhController extends Controller{

    /**
     * Hàm xử lý THÊM MỚI thông tin đặt phòng bởi người dùng Admin
     */
    public function addtientrinh(Request $request){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $lichtrinh=new LichTrinh();
        $lichtrinh->idphong=$request->ten_phong;
        $lichtrinh->idnguoidat=$request->tennguoidat;
        $lichtrinh->thoigianbatdau=$request->batdau;
        $lichtrinh->thoigianketthuc=$request->ketthuc;
        $items=array();
        $items=$request->thu;
        $thu="";
        $loaidinhki=0;
        if($request->isDinhki==true){
            /*$dateReformat = str_replace("/","-",$request->tungay);*/
            $dateReformat = $request->tungay;
            $timelaythu=strtotime($dateReformat);
            $startlaythu = getDate($timelaythu);
            /*$start=date("Y-m-d H:i:s", $timelaythu);*/
            $start=date("Y-m-d H:i:s", $timelaythu);
            /* $dateReformat2 = str_replace("/","-",$request->denngay);*/
            $dateReformat2 = $request->denngay;
            $timelaythu2=strtotime($dateReformat2);
            $startlaythu2 = getDate($timelaythu2);
            /*$end=date("Y-m-d H:i:s", $timelaythu2);*/
            $end=date("Y-m-d H:i:s", $timelaythu2);
            for($x=0;$x<sizeof($items);$x++){
                if($thu=="") $thu=$items[$x];
                else $thu.=",".$items[$x];
            }
            $loaidinhki=1;
        }else{

            /*$dateReformat = str_replace("/","-",$request->ngaydatphong);*/
            $dateReformat = $request->ngaydatphong;
            $timelaythu=strtotime($dateReformat);
            $startlaythu = getDate($timelaythu);
            /* $start=date("Y-m-d H:i:s", $timelaythu);;*/
            $start=date("Y-m-d H:i:s", $timelaythu);;
            $end=$start;

            $weekday = $startlaythu['weekday'];
            $weekday = strtolower($weekday);
            switch($weekday) {
                case 'monday':
                    $thu = '2';
                    break;
                case 'tuesday':
                    $thu = '3';
                    break;
                case 'wednesday':
                    $thu = '4';
                    break;
                case 'thursday':
                    $thu = '5';
                    break;
                case 'friday':
                    $thu = '6';
                    break;
                case 'saturday':
                    $thu = '7';
                    break;
                default:
                    $thu = 'CN';
                    break;
            }
        }

        $phonghop=new PhongHop();
        $phonghop=PhongHop::findOrFail($request->ten_phong);
        $sophong=$phonghop->ten_phong;
        $message="Admin đã đặt lịch cho bạn phòng ".$sophong." định kì vào thời gian ".$request->batdau." - ".$request->ketthuc." thứ ".$thu." hàng tuần từ ngày ".$start." đến ngày ".$end;
        $messagekhongdinhki="Admin đã đặt lịch cho bạn phòng ".$sophong." vào thời gian ".$request->batdau." - ".$request->ketthuc." thứ ".$thu.", ".$start;
        $lichtrinh->malichtrinh=$this->genRandomMaLichTrinh();
        $lichtrinh->ngaybatdau=$start;
        $lichtrinh->ngayketthuc=$end;
        $lichtrinh->thu=$thu;
        $lichtrinh->loailichtrinh=$loaidinhki;
        $lichtrinh->trangthai=0;
        $lichtrinh->deleted = 0;
        $lichtrinh->save();
        $thongbao=new ThongBao();
        $thongbao->tieude="Đặt lịch";
        $thongbao->noidung=$request->isDinhki==true?$message:$messagekhongdinhki;
        $thongbao->userid=$request->tennguoidat;
        $thongbao->loaithongbao=0;
        $thongbao -> deleted = 0;
        $thongbao -> isRead = 0;
        $thongbao->save();
        return response()->json([
            'result' => true,
            'message' => 'Thêm mới lịch trình thành công!',
            'phonghop' => $lichtrinh
        ],200);


    }

    /**
     * Hàm xử lý ĐẶT PHÒNG bởi người dùng là user.
     */
    public function addLichTrinhByCustomer(Request $request){
        $auth = JWTAuth::parseToken()->authenticate();
//        $time = strtotime($request->ngaydatphong);
//
//        $newformat = date('Y-m-d',$time);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $lichtrinh=new LichTrinh();
        $lichtrinh->idphong=$request->ten_phong;
        $lichtrinh->idnguoidat=$request->tennguoidat;
        $lichtrinh->thoigianbatdau=$request->batdau;
        $lichtrinh->thoigianketthuc=$request->ketthuc;
        $items=array();
        $items=$request->thu;
        $thu="";
        $loaidinhki=0;
        if($request->isDinhki==true){
            /*$dateReformat = str_replace("/","-",$request->tungay);*/
            $dateReformat = $request->tungay;
            $timelaythu=strtotime($dateReformat);
            $startlaythu = getDate($timelaythu);
            /*$start=date("Y-m-d H:i:s", $timelaythu);*/
            $start=date("Y-m-d H:i:s", $timelaythu);
            /* $dateReformat2 = str_replace("/","-",$request->denngay);*/
            $dateReformat2 = $request->denngay;
            $timelaythu2=strtotime($dateReformat2);
            $startlaythu2 = getDate($timelaythu2);
            /*$end=date("Y-m-d H:i:s", $timelaythu2);*/
            $end=date("Y-m-d H:i:s", $timelaythu2);
            for($x=0;$x<sizeof($items);$x++){
                if($thu=="") $thu=$items[$x];
                else $thu.=",".$items[$x];
            }
            $loaidinhki=1;
        }else{

            /*$dateReformat = str_replace("/","-",$request->ngaydatphong);*/
            $dateReformat = $request->ngaydatphong;
            $timelaythu=strtotime($dateReformat);
            $startlaythu = getDate($timelaythu);
            /* $start=date("Y-m-d H:i:s", $timelaythu);;*/
            $start=date("Y-m-d H:i:s", $timelaythu);;
            $end=$start;

            $weekday = $startlaythu['weekday'];
            $weekday = strtolower($weekday);
            switch($weekday) {
                case 'monday':
                    $thu = '2';
                    break;
                case 'tuesday':
                    $thu = '3';
                    break;
                case 'wednesday':
                    $thu = '4';
                    break;
                case 'thursday':
                    $thu = '5';
                    break;
                case 'friday':
                    $thu = '6';
                    break;
                case 'saturday':
                    $thu = '7';
                    break;
                default:
                    $thu = 'CN';
                    break;
            }
        }

        $phonghop=new PhongHop();
        $phonghop=PhongHop::findOrFail($request->ten_phong);
        $sophong=$phonghop->ten_phong;
        $message="Bạn đã đặt thành công phòng ".$sophong." định kì vào thời gian ".$request->batdau."-".$request->ketthuc." thứ ".$thu." hàng tuần từ ngày ".$start." đến ngày ".$end;
        $messagekhongdinhki="Bạn đã đặt thành công phòng ".$sophong." vào thời gian ".$request->batdau."-".$request->ketthuc." thứ ".$thu.",".$start;
        $lichtrinh->malichtrinh=$this->genRandomMaLichTrinh();
        $lichtrinh->ngaybatdau=$start;
        $lichtrinh->ngayketthuc=$end;
        $lichtrinh->thu=$thu;
        $lichtrinh->loailichtrinh=$loaidinhki;
        $lichtrinh->trangthai=0;
        $lichtrinh->idnguoidat = $auth->id;
        $lichtrinh->deleted = 0;
        $lichtrinh->save();
        $thongbao=new ThongBao();
        $thongbao->tieude="Đặt lịch";
        $thongbao->noidung=$request->isDinhki==true?$message:$messagekhongdinhki;
        $thongbao->userid=$auth->id;
        $thongbao->loaithongbao=0;
        $thongbao->deleted = 0;
        $thongbao -> isRead = 0;
        $thongbao->save();
        return response()->json([
            'result' => true,
            'message' => 'Thêm mới lịch trình thành công!',
            'phonghop' => $lichtrinh
        ],200);


    }

    /**
     * Hàm xử lý cập nhật thông tin lịch trình
     */
    public function update(Request $request)
    {
        //
        $lichtrinh = LichTrinh::findOrFail($request->id);

        //        $time = strtotime($request->ngaydatphong);
//
//        $newformat = date('Y-m-d',$time);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $lichtrinh->idphong=$request->idphong;
        $lichtrinh->idnguoidat=$request->idnguoidat;
        $lichtrinh->thoigianbatdau=$request->batdau;
        $lichtrinh->thoigianketthuc=$request->ketthuc;
        $items=array();
        $items=$request->thu;
        $thu="";
        $loaidinhki=0;
        if($request->isDinhki==true){
            $dateReformat = str_replace("/","-",$request->tungay);
            $timelaythu=strtotime($dateReformat);
            $startlaythu = getDate($timelaythu);
            $start=date("Y-m-d H:i:s", $timelaythu);
            $dateReformat2 = str_replace("/","-",$request->denngay);
            $timelaythu2=strtotime($dateReformat2);
            $startlaythu2 = getDate($timelaythu2);
            $end=date("Y-m-d H:i:s", $timelaythu2);
            for($x=0;$x<sizeof($items);$x++){
                if($thu=="") $thu=$items[$x];
                else $thu.=",".$items[$x];
            }
            $loaidinhki=1;
        }else{

            $dateReformat = str_replace("/","-",$request->ngaydatphong);
            $timelaythu=strtotime($dateReformat);
            $startlaythu = getDate($timelaythu);
            $start=date("Y-m-d H:i:s", $timelaythu);;
            $end=$start;

            $weekday = $startlaythu['weekday'];
            $weekday = strtolower($weekday);
            switch($weekday) {
                case 'monday':
                    $thu = '2';
                    break;
                case 'tuesday':
                    $thu = '3';
                    break;
                case 'wednesday':
                    $thu = '4';
                    break;
                case 'thursday':
                    $thu = '5';
                    break;
                case 'friday':
                    $thu = '6';
                    break;
                case 'saturday':
                    $thu = '7';
                    break;
                default:
                    $thu = 'CN';
                    break;
            }
        }

        $phonghop=new PhongHop();
        $phonghop=PhongHop::findOrFail($request->idphong);
        $sophong=$phonghop->ten_phong;
        $message="Admin đã đặt lịch cho bạn phòng ".$sophong." định kì vào thời gian ".$request->batdau."-".$request->ketthuc." thứ ".$thu." hàng tuần từ ngày ".$start." đến ngày ".$end;
        $messagekhongdinhki="Admin đã đặt lịch cho bạn phòng ".$sophong." vào thời gian ".$request->batdau."-".$request->ketthuc." thứ ".$thu.", ".$start;
        $lichtrinh->ngaybatdau=$start;
        $lichtrinh->ngayketthuc=$end;
        $lichtrinh->thu=$thu;
        $lichtrinh->loailichtrinh=$loaidinhki;
        $lichtrinh->trangthai=0;
        $lichtrinh->save();
        $thongbao=new ThongBao();
        $thongbao->tieude="Đặt lịch";
        $thongbao->noidung=$request->isDinhki==true?$message:$messagekhongdinhki;
        $thongbao->userid=$request->idnguoidat;
        $thongbao->loaithongbao=0;
        $thongbao->save();

        return response()->json([
            'result' => true,
            'message' => 'Chỉnh sửa lịch trình thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý YÊU CẦU NHƯỢNG PHÒNG.
     */
    public function yeucaunhuongphong(Request $request)
    {
        //
        $auth = JWTAuth::parseToken()->authenticate();
        $lichtrinh = LichTrinh::findOrFail($request->idlichtrinh);

        $dataYeuCauNhuongPhong = new YeuCauNhuongPhong();
        $dataYeuCauNhuongPhong->idlichtrinh = $request->idlichtrinh;
        $dataYeuCauNhuongPhong->idnguoidat = $request->idnguoidat;
        $dataYeuCauNhuongPhong->idnguoiyeucau = $auth->id;
        $dataYeuCauNhuongPhong->lydo = $request->lydo;
        $dataYeuCauNhuongPhong->trangthai = 0; //0: chờ duyệt, `1`: đã chấp nhận, 2: từ chối nhượng phòng

        if($auth->id == $dataYeuCauNhuongPhong->idnguoidat) {
            return response()->json([
                'result' => false,
                'message' => 'Lịch trình này đã là của bạn, không cần yêu cầu nhượng phòng!',
                'lichtrinh' => $lichtrinh
            ], 200);
        }


        $idYeuCauNhuongPhong = YeuCauNhuongPhongDAO::getLastInsertedId($dataYeuCauNhuongPhong);

        $phonghop=new PhongHop();
        $phonghop=PhongHop::findOrFail($request->idphong);
        $sophong=$phonghop->ten_phong;
        $user = \App\User::findOrFail($lichtrinh->idnguoidat);

        /*$message="Bạn có một yêu cầu nhượng phòng từ email $auth->email cho đặt phòng có mã $lichtrinh->malichtrinh;
            Tên phòng: ".$sophong."; Định kì vào thời gian: ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."
            hàng tuần từ ngày ".$lichtrinh->ngaybatdau." đến ngày ".$lichtrinh->ngayketthuc."\n
            Truy cập: <a href='http://localhost:8000//lichtrinh/yeucaunhuongphong/detail/$idYeuCauNhuongPhong'>chi tiết yêu cầu nhượng phòng</a>";
        $messagekhongdinhki="Bạn có một yêu cầu nhượng phòng từ email $auth->email cho đặt phòng có mã $lichtrinh->malichtrinh;
            Tên phòng ".$sophong."; Vào thời gian ".$request->batdau." - ".$request->ketthuc."; ".$lichtrinh->thu."; Ngày: ".$lichtrinh->ngaybatdau."\n
             Truy cập: <a href='http://localhost:8000//lichtrinh/yeucaunhuongphong/detail/$idYeuCauNhuongPhong'>chi tiết yêu cầu nhượng phòng</a>";*/

        $message="Bạn có một yêu cầu nhượng phòng từ email $auth->email cho đặt phòng có mã $lichtrinh->malichtrinh;
            Tên phòng: $sophong; Định kì vào thời gian: ".$request->batdau."-".$request->ketthuc."; $lichtrinh->thu
            hàng tuần từ ngày $lichtrinh->ngaybatdau đến ngày $lichtrinh->ngayketthuc";
        $messagekhongdinhki="Bạn có một yêu cầu nhượng phòng từ email $auth->email cho đặt phòng có mã $lichtrinh->malichtrinh;
            Tên phòng: $sophong; Vào thời gian $request->batdau - $request->ketthuc; $lichtrinh->thu; Ngày: .$lichtrinh->ngaybatdau";
        $link = "http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/$idYeuCauNhuongPhong";
        $thongbao=new ThongBao();
        $thongbao->tieude="Yêu cầu nhượng phòng";
        $thongbao->noidung=$lichtrinh->loailichtrinh==1?$message:$messagekhongdinhki;
        $thongbao->userid=$lichtrinh->idnguoidat;
        $thongbao->loaithongbao=0;
        $thongbao -> deleted = 0;
        $thongbao -> isRead = 0;
        $thongbao -> link = $link;
        $thongbao->save();

        return response()->json([
            'result' => true,
            'message' => 'Yêu cầu nhượng phòng thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý DUYỆT YÊU CẦU NHƯỢNG PHÒNG.
     */
    public function duyetyeucaunhuongphong(Request $request)
    {
        //
        $lichtrinh = LichTrinh::findOrFail($request->idlichtrinh);
        $lichtrinh->idnguoidat = $request->idnguoidat;

        $dataYeuCauNhuongPhong = YeuCauNhuongPhongDAO::getById($request->id);
        if($dataYeuCauNhuongPhong->trangthai == 1) {
            return response()->json([
                'result' => true,
                'message' => 'Chuyển nhượng đặt phòng thành công!',
                'lichtrinh' => $lichtrinh
            ], 200);
        }

        $dataYeuCauNhuongPhong->trangthai = 1; //0: chờ duyệt, 1: đã chấp nhận, 2: từ chối nhượng phòng
        YeuCauNhuongPhongDAO::update($dataYeuCauNhuongPhong);
        $lichtrinh->idnguoidat = $dataYeuCauNhuongPhong->idnguoiyeucau;
        $lichtrinh->save();

        $phonghop=PhongHop::findOrFail($request->idphong);
        $sophong=$phonghop->ten_phong;

        $messageDuyet = '';
        if($dataYeuCauNhuongPhong->trangthai==1) $messageDuyet = 'đã được chấp nhận';
        else if($dataYeuCauNhuongPhong->trangthai==2) $messageDuyet = 'đã bị từ chối';
        else $messageDuyet = 'đang được xem xét';

        $message="Yêu cầu nhương phòng của bạn $messageDuyet; Thông tin đặt phòng: \n Mã đặt phòng: $lichtrinh->malichtrinh;
            Tên phòng: ".$sophong."; Định kì vào thời gian: ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."
            hàng tuần từ ngày ".$lichtrinh->ngaybatdau." đến ngày ".$lichtrinh->ngayketthuc."\n
            Truy cập: <a href='http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/$dataYeuCauNhuongPhong->id'>chi tiết yêu cầu nhượng phòng</a>";
        $messagekhongdinhki="Yêu cầu nhương phòng của bạn đã $messageDuyet; Thông tin đặt phòng: \n Mã đăt phòng: $lichtrinh->malichtrinh;
            Tên phòng ".$sophong."; Vào thời gian ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."; Ngày: ".$lichtrinh->ngaybatdau."\n
             Truy cập: <a href='http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/$dataYeuCauNhuongPhong->id'>chi tiết yêu cầu nhượng phòng</a>";

        $thongbao=new ThongBao();
        $thongbao->tieude="Duyệt yêu cầu nhượng phòng";
        $thongbao->noidung=$lichtrinh->loailichtrinh==1?$message:$messagekhongdinhki;
        $thongbao->userid=$dataYeuCauNhuongPhong->idnguoiyeucau;
        $thongbao->loaithongbao=0;
        $thongbao -> deleted = 0;
        $thongbao -> isRead = 0;
        $thongbao->save();

        return response()->json([
            'result' => true,
            'message' => 'Chuyển nhượng đặt phòng thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý HỦY YÊU CẦU NHƯỢNG PHÒNG.
     */
    public function huyYeuCauNhuongPhong(Request $request)
    {
        //
        $dataYeuCauNhuongPhong = YeuCauNhuongPhongDAO::getById($request->id);
        $dataYeuCauNhuongPhong->trangthai = 2; //trạng thái 0: chờ duyệt, 1: đã duyệt, 2: từ chối yêu cầu
        $lichtrinh = LichTrinh::findOrFail($request->idlichtrinh);
        $lichtrinh->idnguoidat = $request->idnguoidat;
        YeuCauNhuongPhongDAO::update($dataYeuCauNhuongPhong);

        $phonghop=PhongHop::findOrFail($request->idphong);
        $sophong=$phonghop->ten_phong;

        $messageDuyet = $dataYeuCauNhuongPhong->trangthai==1?'đã được chấp nhận':$dataYeuCauNhuongPhong->trangthai==2?'đã bị từ chối':'đang được xem xét';

        $message="Yêu cầu nhương phòng của bạn $messageDuyet; Thông tin đặt phòng: \n Mã đặt phòng: $lichtrinh->malichtrinh;
            Tên phòng: ".$sophong."; Định kì vào thời gian: ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."
            hàng tuần từ ngày ".$lichtrinh->ngaybatdau." đến ngày ".$lichtrinh->ngayketthuc."\n
            Truy cập: <a href='http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/$dataYeuCauNhuongPhong->id'>chi tiết yêu cầu nhượng phòng</a>";
        $messagekhongdinhki="Yêu cầu nhương phòng của bạn đã $messageDuyet; Thông tin đặt phòng: \n Mã đăt phòng: $lichtrinh->malichtrinh;
            Tên phòng ".$sophong."; Vào thời gian ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."; Ngày: ".$lichtrinh->ngaybatdau."\n
             Truy cập: <a href='http://localhost:8000/lichtrinh/yeucaunhuongphong/detail/$dataYeuCauNhuongPhong->id'>chi tiết yêu cầu nhượng phòng</a>";

        $thongbao=new ThongBao();
        $thongbao->tieude="Xử lý yêu cầu nhượng phòng";
        $thongbao->noidung=$lichtrinh->loailichtrinh==1?$message:$messagekhongdinhki;
        $thongbao->userid=$dataYeuCauNhuongPhong->idnguoiyeucau;
        $thongbao->loaithongbao=0;
        $thongbao -> deleted = 0;
        $thongbao -> isRead = 0;
        $thongbao->save();

        return response()->json([
            'result' => true,
            'message' => 'Hủy yêu cầu nhượng phòng thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý CHUYỂN NHƯỢNG ĐẶT PHÒNG
     */
    public function chuyennhuong(Request $request)
    {
        //
        $lichtrinh = LichTrinh::findOrFail($request->id);
        $lichtrinh->idnguoidat = $request->idnguoidat;

        $phonghop=new PhongHop();
        $phonghop=PhongHop::findOrFail($request->idphong);
        $sophong=$phonghop->ten_phong;
        $user = \App\User::findOrFail($lichtrinh->idnguoidat);

        $message="Admin đã chuyển nhương thành công lịch đặt phòng cho tài khoản ".$user->email."; thông tin đặt phòng: Tên phòng: ".$sophong."; Định kì vào thời gian: ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu." hàng tuần từ ngày ".$lichtrinh->ngaybatdau." đến ngày ".$lichtrinh->ngayketthuc;
        $messagekhongdinhki="Admin đã chuyển nhương thành công lịch đặt phòng cho tài khoản ".$user->email."; thông tin đặt phòng: Tên phòng ".$sophong."; Vào thời gian ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."; Ngày: ".$lichtrinh->ngaybatdau;
        $lichtrinh->save();

        //xóa các cuộc họp thuộc lịch trình này
        CuocHopDAO::delete(null,$lichtrinh->id);

        $thongbao=new ThongBao();
        $thongbao->tieude="Chuyển nhượng phòng";
        $thongbao->noidung=$lichtrinh->loailichtrinh==1?$message:$messagekhongdinhki;
        $thongbao->userid=$lichtrinh->idnguoidat;
        $thongbao->loaithongbao=0;
        $thongbao -> deleted = 0;
        $thongbao -> isRead = 0;
        $thongbao->save();

        return response()->json([
            'result' => true,
            'message' => 'Chuyển nhượng đặt phòng thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý DUYỆT ĐẶT PHÒNG
     */
    public function duyetPhong(Request $request)
    {
        //
        $lichtrinh = LichTrinh::findOrFail($request->id);
        $lichtrinh->trangthai = $request->trangthai;
        $trangThaiText = "";
        if($lichtrinh->trangthai==1) {
            $queryString = " and bo.trangthai != 2 and phonghop.id = $lichtrinh->idphong";
            $queryString .= " and not ( (bo.thoigianbatdau < '$lichtrinh->thoigianbatdau' and bo.thoigianketthuc < '$lichtrinh->thoigianbatdau')
            or (bo.thoigianbatdau > '$lichtrinh->thoigianketthuc' and bo.thoigianketthuc > '$lichtrinh->thoigianketthuc' ) ";
            if($lichtrinh->loailichtrinh==0){
                    $queryString .= " ) and bo.ngaybatdau = '$lichtrinh->ngaybatdau'";
            }
            if($lichtrinh->loailichtrinh==1){
                $queryString .= " ) and (bo.ngaybatdau > '$lichtrinh->ngaybatdau' and bo.ngaybatdau < '$lichtrinh->ngayketthuc')
            or (bo.ngayketthuc > '$lichtrinh->ngaybatdau' and bo.ngayketthuc < '$lichtrinh->ngayketthuc') ";
            }
            $page = new PagingResult();
            $page->setPageNumber($request->page);
            $page = LichTrinhDAO::searchLichTrinh($page, $queryString);
            if($page->rowCount > 0){
                return response()->json([
                    'result' => false,
                    'message' => 'Lịch trình này đã được đặt bởi người khác!',
                    'lichtrinh' => $lichtrinh
                ], 200);
            }

            $trangThaiText = 'Phê duyệt';
        }
        if($lichtrinh->trangthai==2) $trangThaiText = 'Từ chối';


        $phonghop=new PhongHop();
        $phonghop=PhongHop::findOrFail($lichtrinh->idphong);
        $sophong=$phonghop->ten_phong;
        $user = \App\User::findOrFail($lichtrinh->idnguoidat);

        $message="Admin đã $trangThaiText thành công lịch đặt phòng cho tài khoản ".$user->email."; thông tin đặt phòng: Tên phòng: ".$sophong."; Định kì vào thời gian: ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu." hàng tuần từ ngày ".$lichtrinh->ngaybatdau." đến ngày ".$lichtrinh->ngayketthuc;
        $messagekhongdinhki="Admin đã $trangThaiText thành công lịch đặt phòng cho tài khoản ".$user->email."; thông tin đặt phòng: Tên phòng ".$sophong."; Vào thời gian ".$request->batdau."-".$request->ketthuc."; ".$lichtrinh->thu."; Ngày: ".$lichtrinh->ngaybatdau;
        $lichtrinh->save();
        $thongbao=new ThongBao();
        $thongbao->tieude="Duyệt đặt phòng";
        $thongbao->noidung=$lichtrinh->loailichtrinh==1?$message:$messagekhongdinhki;
        $thongbao->userid=$lichtrinh->idnguoidat;
        $thongbao->loaithongbao=0;
        $thongbao->deleted=0;
        $thongbao -> isRead = 0;
        $thongbao->save();

        return response()->json([
            'result' => true,
            'message' => 'Duyệt lịch đặt phòng thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý HỦY ĐẶT PHÒNG TỪ CUTOMER
     */
    public function huyDatPhong($id)
    {
        //
        $lichtrinh = LichTrinh::findOrFail($id);
        $lichtrinh->trangthai = 2;
        $lichtrinh->save();
        CuocHopDAO::delete(null, $id);
        return response()->json([
            'result' => true,
            'message' => 'Hủy đặt phòng thành công!',
            'lichtrinh' => $lichtrinh
        ], 200);
    }

    /**
     * Hàm xử lý LẤY RA DANH SÁCH LỊCH TRÌNH.
     */
    public function allLichTrinh(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $malichtrinh = $request->malichtrinh;
        $idPhongHop = $request->idPhongHop;
        $loaiPhong = $request->loaiPhong;
        $idNguoiDat = $request->idNguoiDat;
        $batdau = $request->batdau;
        $ketthuc = $request->ketthuc;
        $ngaydatphong = $request->ngaydatphong;
        $tungay = $request -> tungay;
        $denngay = $request -> denngay;
        $thu = $request -> thu;
        $isDinhKi = $request -> isDinhKi;
        $searchChoDatPhong = $request -> searchChoDatPhong;
    

        $queryString = "";
        if($searchChoDatPhong=='true'){
            $queryString .= " and bo.trangthai != 2 ";//trạng thái khác 2 (từ chối)
        }
        
        if ($malichtrinh != null && $malichtrinh != "") {
            $queryString .= " and bo.malichtrinh like '%$malichtrinh%'";
        }
        if ($idPhongHop != null && $idPhongHop != "") {
            $queryString .= " and phonghop.id = $idPhongHop";
        }
        if ($loaiPhong != null && $loaiPhong != "") {
            $queryString .= " and phonghop.loai_phong = $loaiPhong";
        }
        if ($idNguoiDat != null && $idNguoiDat != "") {
            $queryString .= " and bo.idnguoidat = $idNguoiDat";
        }
        if ($batdau != null && $batdau != "") {
            $queryString .= " and bo.thoigianbatdau >= '$batdau'";
        }
        if ($ketthuc != null && $ketthuc != "") {
            $queryString .= " and bo.thoigianketthuc <= '$ketthuc'";
        }
        if(!$isDinhKi){
            if ($ngaydatphong != null && $ngaydatphong != "") {
                $dateReformat = str_replace("/","-",$ngaydatphong);
                $time=strtotime($dateReformat);
                $ngayDatPhongReformat=date("Y-m-d", $time);
                $queryString .= " and bo.ngaybatdau = '$ngayDatPhongReformat'";
            }
        }
        else{
            if ($tungay != null && $tungay != "") {
                $dateReformat = str_replace("/","-",$tungay);
                $time=strtotime($dateReformat);
                $tungayReformat=date("Y-m-d", $time);
                $queryString .= " and bo.ngaybatdau = '$tungayReformat'";
            }
            if ($denngay != null && $denngay != "") {
                $dateReformat = str_replace("/","-",$denngay);
                $time=strtotime($dateReformat);
                $tungayReformat=date("Y-m-d", $time);
                $queryString .= " and bo.ngaybatdau = '$tungayReformat'";
            }
        }

        $page = LichTrinhDAO::searchLichTrinh($page, $queryString);
        /*  return Response::json($page);*/
        return response()->json([
            'items' => $page->getItems(),
            'rowCount' => $page->getRowCount(),
            'numberPerPage' => $page->getNumberPerPage(),
            'pageNumber' => $page->getPageNumber()
        ], 200);
        /*return $page;*/
    }

    /**
     * Hàm xử lý CHECK TRÙNG LỊCH TRÌNH KHI THỰC HIỆN ĐẶT PHÒNG.
     */
    public function checkExistLichTrinh(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $idPhongHop = $request->idPhongHop;
        $loaiPhong = $request->loaiPhong;
        $idNguoiDat = $request->idNguoiDat;
        $batdau = $request->batdau;
        $ketthuc = $request->ketthuc;
        $ngaydatphong = $request->ngaydatphong;
        $tungay = $request -> tungay;
        $denngay = $request -> denngay;
        $thu = $request -> thu;
        $isDinhKi = $request -> isDinhKi;

        $queryString = " and bo.trangthai != 2 ";
        if ($idPhongHop != null && $idPhongHop != "") {
            $queryString .= " and phonghop.id = $idPhongHop";
        }
        if ($loaiPhong != null && $loaiPhong != "") {
            $queryString .= " and phonghop.loai_phong = $loaiPhong";
        }
        if ($idNguoiDat != null && $idNguoiDat != "") {
            $queryString .= " and bo.idnguoidat = $idNguoiDat";
        }
        /*if ($batdau != null && $batdau != "") {
            $queryString .= " and ( not (bo.thoigianbatdau > '$batdau' and bo.thoigianbatdau < '$ketthuc')
            or not (bo.thoigianketthuc > '$batdau' and bo.thoigianketthuc < '$ketthuc' ) ";
        }*/
        if ($batdau != null && $batdau != "") {
            $queryString .= " and not ( (bo.thoigianbatdau < '$batdau' and bo.thoigianketthuc < '$batdau')
            or (bo.thoigianbatdau > '$ketthuc' and bo.thoigianketthuc > '$ketthuc' ) ";
        }
        if($isDinhKi=='false'){
            if ($ngaydatphong != null && $ngaydatphong != "") {
                $dateReformat = str_replace("/","-",$ngaydatphong);
                $time=strtotime($dateReformat);
                $ngayDatPhongReformat=date("Y-m-d", $time);
                $queryString .= " ) and bo.ngaybatdau = '$ngayDatPhongReformat'";
            }
        }
        if($isDinhKi=='true'){
            $timeTuNgay=strtotime(str_replace("/","-",$tungay));
            $tuNgayReformat=date("Y-m-d", $timeTuNgay);

            $timeDenNgay=strtotime(str_replace("/","-",$denngay));
            $denNgayReformat=date("Y-m-d", $timeDenNgay);

            $queryString .= " ) and (bo.ngaybatdau > '$tuNgayReformat' and bo.ngaybatdau < '$denNgayReformat')
            or (bo.ngayketthuc > '$tuNgayReformat' and bo.ngayketthuc < '$denNgayReformat') ";

        }

        $page = LichTrinhDAO::searchLichTrinh($page, $queryString);
        /*  return Response::json($page);*/
        return response()->json([
            'items' => $page->getItems(),
            'rowCount' => $page->getRowCount(),
            'numberPerPage' => $page->getNumberPerPage(),
            'pageNumber' => $page->getPageNumber()
        ], 200);
        /*return $page;*/
    }

    /**
     * Hàm xử lý LẤY RA DANH SÁCH LỊCH ĐẶT PHÒNG ĐÃ ĐẶT BỞI NGƯỜI KHÁC ĐỂ THAO TÁC YÊU CẦU NHƯỢNG PHÒNG.
     */
    public function searchLichTrinhCanYeuCauNhongPhong(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $idPhongHop = $request->idPhongHop;
        $loaiPhong = $request->loaiPhong;
        $idNguoiDat = $request->idNguoiDat;
        $batdau = $request->batdau;
        $ketthuc = $request->ketthuc;
        $ngaydatphong = $request->ngaydatphong;
        $tungay = $request -> tungay;
        $denngay = $request -> denngay;
        $thu = $request -> thu;
        $isDinhKi = $request -> isDinhKi;
        $soluong = $request -> soluong;

        $queryString = " and bo.trangthai != 2 ";
        if ($idPhongHop != null && $idPhongHop != "") {
            $queryString .= " and phonghop.id = $idPhongHop";
        }
        if ($loaiPhong != null && $loaiPhong != "") {
            $queryString .= " and phonghop.loai_phong = $loaiPhong";
        }
        if ($soluong != null && $soluong != "") {
            $queryString .= " and phonghop.soluong >= $soluong";
        }
        /*if ($batdau != null && $batdau != "") {
            $queryString .= " and ( not (bo.thoigianbatdau > '$batdau' and bo.thoigianbatdau < '$ketthuc')
            or not (bo.thoigianketthuc > '$batdau' and bo.thoigianketthuc < '$ketthuc' ) ";
        }*/
        if ($batdau != null && $batdau != "") {
            $queryString .= " and not ( (bo.thoigianbatdau < '$batdau' and bo.thoigianketthuc < '$batdau')
            or (bo.thoigianbatdau > '$ketthuc' and bo.thoigianketthuc > '$ketthuc' ) ";
        }
        if($isDinhKi=='false'){
            if ($ngaydatphong != null && $ngaydatphong != "") {
                $dateReformat = str_replace("/","-",$ngaydatphong);
                $time=strtotime($dateReformat);
                $ngayDatPhongReformat=date("Y-m-d", $time);
                $queryString .= " ) and bo.ngaybatdau >= '$ngayDatPhongReformat' and bo.ngaybatdau <= '$ngayDatPhongReformat'";
            }
        }
        if($isDinhKi=='true'){
            $timeTuNgay=strtotime(str_replace("/","-",$tungay));
            $tuNgayReformat=date("Y-m-d", $timeTuNgay);

            $timeDenNgay=strtotime(str_replace("/","-",$denngay));
            $denNgayReformat=date("Y-m-d", $timeDenNgay);

            $queryString .= " ) and (bo.ngaybatdau >= '$tuNgayReformat' and bo.ngaybatdau <= '$denNgayReformat')
            or (bo.ngayketthuc >= '$tuNgayReformat' and bo.ngayketthuc <= '$denNgayReformat') ";

        }
        $queryString.=" and bo.ngaybatdau >  NOW() ";

        $page = LichTrinhDAO::searchLichTrinh($page, $queryString);
        /*  return Response::json($page);*/
        return response()->json([
            'items' => $page->getItems(),
            'rowCount' => $page->getRowCount(),
            'numberPerPage' => $page->getNumberPerPage(),
            'pageNumber' => $page->getPageNumber()
        ], 200);
        /*return $page;*/
    }

    /**
     * Hàm xử lý XÓA ĐẶT PHÒNG.
     */
    public function destroy($id)
    {
        //
        /*$lichTrinh = LichTrinh::findOrFail($id);
        $lichTrinh->delete();*/
        LichTrinhDAO::delete($id,null,null);
        return $lichTrinh = LichTrinh::all();

    }

    /**
     * Hàm xử lý LẤY RA THÔNG TIN ĐẶT PHÒNG THEO ID ĐẶT PHÒNG
     */
    public function findById($id)
    {
        return LichTrinh::findOrFail($id);
    }

    /**
     * Hàm xử lý LẤY RA YÊU CẦU NHƯỢNG PHÒNG THEO ID VÀ THEO LỊCH TRÌNH.
     */
    public function getYeuCauChuyenNhuongByIdAndLichTrinh($id)
    {
        $data = YeuCauNhuongPhongDAO::getByIdAndLichTrinh($id);
        return response()->json([
            'data' => $data
        ], 200);
    }



    public function genRandomMaLichTrinh(){
        $strDate = date('Ymd');
        $strDate.=rand(100,900);
        return $strDate;
    }
}
