<?php


namespace App\Http\Controllers\Demo;


use App\CuocHop;
use App\DAO\CuocHopDAO;
use App\DAO\ThanhVienDAO;
use App\Http\Controllers\Controller;
use App\LichTrinh;
use App\Mail\DemoMail;
use App\Model\PagingResult;
use App\PhongHop;
use App\SERVICES\MailService;
use App\ThongBao;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Mail;

class CuocHopController extends Controller
{
    //Hàm lấy danh sách cuộc họp
    public function all(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $idPhongHop = $request->idPhongHop;
        $batdau = $request->batdau;
        $ketthuc = $request->ketthuc;
        $ngaydatphong = $request->ngaydatphong;
        $tencuochop = $request->tencuochop;
        $idnguoidat = $request->idnguoidat;


        $queryString = "";

        if ($idPhongHop != null && $idPhongHop != "") {
            $queryString .= " and cuochop.idphong = $idPhongHop";
        }
        if ($tencuochop != null && $tencuochop != "") {
            $queryString .= " and cuochop.tencuochop like '%$tencuochop%'";
        }
        if ($idnguoidat != null && $idnguoidat != "") {
            $queryString .= " and lichtrinh.idnguoidat = $idnguoidat";
        }
        if ($batdau != null && $batdau != "") {
            $queryString .= " and lichtrinh.thoigianbatdau >= '$batdau'";
        }
        if ($ketthuc != null && $ketthuc != "") {
            $queryString .= " and lichtrinh.thoigianketthuc <= '$ketthuc'";
        }
        if ($ngaydatphong != null && $ngaydatphong != "") {
            $dateReformat = str_replace("/", "-", $ngaydatphong);
            $time = strtotime($dateReformat);
            $ngayDatPhongReformat = date("Y-m-d", $time);
            $queryString .= " and lichtrinh.ngaybatdau = '$ngayDatPhongReformat'";
        }
        $page = CuocHopDAO::search($page, $queryString);
        /*  return Response::json($page);*/
        return response()->json([
            'items' => $page->getItems(),
            'rowCount' => $page->getRowCount(),
            'numberPerPage' => $page->getNumberPerPage(),
            'pageNumber' => $page->getPageNumber()
        ], 200);
        /*return $page;*/
    }

    //Hàm xử lý THÊM MỚI cuộc họp vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $cuochop = new CuocHop();
        $cuochop->idlichtrinh = $request->idlichtrinh;
        $cuochop->idphong = $request->idphong;
        $cuochop->tencuochop = $request->tencuochop;
        $cuochop->noidungcuochop = $request->noidungcuochop;
        $cuochop->noidungtongket = $request->noidungtongket;
        $cuochop->trangthai = $request->trangthai;
        $cuochop->idfiledinhkem = $request->idfiledinhkem;
        $cuochop->trangthai = 0;
        $cuochop->deleted = 0;
        //   $cuochop->save();
        $idAfterInserted = CuocHopDAO::getLastInsertedId($cuochop);
        $cuochop->id = $idAfterInserted;
        //them ban ghi email thanh vien tham gia cuoc hop
        ThanhVienDAO::insertMultipleEmail($request->emailThanhVien, $cuochop->id);
        return response()->json([
            'result' => true,
            'message' => 'Thêm mới cuộc họp thành công!',
            'phonghop' => $cuochop
        ], 200);

    }

    //Hàm xử lý CHỈNH SỬA thông tin cuộc họp
    public function update(Request $request)
    {
        $cuochop = CuocHopDAO::findById($request->id);
        $cuochop->idlichtrinh = $request->idlichtrinh;
        $cuochop->idphong = $request->idphong;
        $cuochop->tencuochop = $request->tencuochop;
        $cuochop->noidungcuochop = $request->noidungcuochop;
        $cuochop->noidungtongket = $request->noidungtongket;
        $cuochop->trangthai = $request->trangthai;
        $cuochop->idfiledinhkem = $request->idfiledinhkem;
        //   $cuochop->save();
        CuocHopDAO::update($cuochop);
        //them ban ghi email thanh vien tham gia cuoc hop
        ThanhVienDAO::deleteByIdCuocHop($cuochop->id);
        ThanhVienDAO::insertMultipleEmail($request->emailThanhVien, $cuochop->id);
        return response()->json([
            'result' => true,
            'message' => 'Chỉnh sửa cuộc họp thành công!',
            'phonghop' => $cuochop
        ], 200);

    }

    // function to store file in 'upload' folder
    public function uploadFileCuocHop(Request $request)
    {
        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move($upload_path, $generated_new_name);

        return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);
    }

    //Hàm xử lý GỬI THÔNG BÁO cuộc họp đến email thành viên
    public function guiThongBao(Request $request)
    {
        //   $strListEmail = $request -> emailThanhVien;on ($m) use ($user) {
        $emailStr = $request->emailThanhVien;
        $arrEmail = explode(",", $emailStr);
        $arrEmailSend = [];
        for($i=0;$i<sizeof($arrEmail);$i++){
            $arrEmailSend[$i] = trim($arrEmail[$i]);;
        }
        $emaiInfo = $request->all();
        if (sizeof($arrEmail) == 0) {
            return response()->json([
                'result' => false,
                'message' => 'Không tồn tại email nào!',
                'phonghop' => $emaiInfo
            ], 200);
        }
        Mail::send('emailCuocHop', array('tencuochop' => $emaiInfo["tencuochop"],
            'noidungcuochop' => $emaiInfo["noidungcuochop"],
            'noidungtongket' => $emaiInfo["noidungtongket"]), function ($message) use ($arrEmailSend) {
            $message->to($arrEmailSend)->subject('This is test e-mail');
           // $message->to(explode(",", $emailStr)[0], 'Phần mềm quản lý đặt phòng')->subject('Thông báo cuộc họp mới!')->cc(['daicq.dev@gmail.com','alone01011991@gmail.com']);
        });

        if (Mail::failures()) {
            return response()->json([
                'result' => false,
                'message' => 'Gửi mail thất bại!',
                'phonghop' => $emaiInfo
            ], 200);
        } else {
            return response()->json([
                'result' => true,
                'message' => 'Gửi thông báo cuộc họp thành công!',
                'phonghop' => $emaiInfo
            ], 200);
        }

    }

    //Hàm xử lý XÓA cuộc họp
    public function destroy($id)
    {
        //gửi mail thông báo hủy cuộc họp đến các thành viên
        $cuochop = CuocHopDAO::findById($id); 
        //
       /* $cuochop = CuocHop::findOrFail($id);
        $cuochop->delete();*/
       CuocHopDAO::delete($id, null);

        // $listThanhVien = ThanhVienDAO::searchAllByCuocHop($id);
        // $arrEmail = [];
        // for($i=0;$i<sizeof($listThanhVien);$i++){
        //     $arrEmail[$i] = trim($listThanhVien[$i]->email);
        // }
        // if (sizeof($arrEmail) > 0) {

        //     Mail::send('emailCuocHopHuy', array('tencuochop' => $cuochop->tencuochop,
        //         'noidungcuochop' => $cuochop->noidungcuochop,
        //         'noidungtongket' => $cuochop->noidungtongket), function ($message) use ($arrEmail) {
        //         $message->to($arrEmail[0], 'Phần mềm quản lý đặt phòng')->subject('Thông báo hủy cuộc họp!')->cc(['daicq.dev@gmail.com','alone01011991@gmail.com']);
        //     });
        // }

        return $cuochop = CuocHop::all();

    }

    public function findById($id)
    {
        $cuochop = CuocHopDAO::findById($id);
        return response()->json([
            'result' => true,
            'cuochop' => $cuochop
        ], 200);
    }

    //Hàm xử lý lấy ra danh sách email thành viên của cuộc họp
    public function searchAllThanhVienByCuocHop(Request $request)
    {
        $id = $request->id_cuochop;
        $items = ThanhVienDAO::searchAllByCuocHop($id);
        return response()->json([
            'listThanhVien' => $items
        ], 200);
    }

}
