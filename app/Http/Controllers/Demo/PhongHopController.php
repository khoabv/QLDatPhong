<?php

namespace App\Http\Controllers\Demo;

use App\LichTrinh;
use App\Model\PagingResult;
use App\PhongHop;
use App\DAO\PhongHopDAO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class PhongHopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $phonghop = PhongHop::all();
    }

    /**
     * Hàm xử lý LẤY RA DANH SÁCH PHÒNG HỌP.
     */
    public function allRooms(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $ten_phong = $request->ten_phong;
        $loaiPhong = $request->loaiPhong;
        $trang_thai = $request->trang_thai;

        $queryString = "";
        if ($ten_phong != null && $ten_phong != "") {
            $queryString .= " and bo.ten_phong like '%$ten_phong%'";
        }
        if ($loaiPhong != null && $loaiPhong != "") {
            $queryString .= " and bo.loai_phong = $loaiPhong";
        }
        if ($trang_thai != null && $trang_thai != "") {
            $queryString .= " and bo.trang_thai = $trang_thai";
        }
        $page = PhongHopDAO::searchRooms($page, $queryString);
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
     * Hàm xử lý TÌM KIẾM PHÒNG HỌP THỎA MÃN THÔNG TIN ĐẶT PHÒNG.
     */
    public function searchByExceptLichTrinh(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $batdau = $request->batdau;
        $ketthuc = $request->ketthuc;
        $ngaydatphong = $request->ngaydatphong;
        $thu = $request->thu;
        $tungay = $request->tungay;
        $denngay = $request->denngay;
        $isDinhki = $request->isDinhki;
        $idPhongHop = $request->idPhongHop;
        $loaiPhong = $request->loaiPhong;
        $soluong = $request->soluong;

        $queryString = "";
        if ($idPhongHop != null && $idPhongHop != "") {
            $queryString .= " and phonghop.id = $idPhongHop ";
        }
        if ($loaiPhong != null && $loaiPhong != "") {
            $queryString .= " and phonghop.loai_phong = $loaiPhong ";
        }
        if ($soluong != null && $soluong != "") {
            $queryString .= " and phonghop.soluong >= $soluong ";
        }

        $ngaybatdau = "";
        $ngayketthuc = "";

        if ($isDinhki == 'true') {
            $timeTuNgay = strtotime(str_replace("/", "-", $tungay));
            $ngaybatdau = date("Y-m-d", $timeTuNgay);

            $timeDenNgay = strtotime(str_replace("/", "-", $denngay));
            $ngayketthuc = date("Y-m-d", $timeDenNgay);
        } else {
            $dateReformat = str_replace("/", "-", $ngaydatphong);
            $time = strtotime($dateReformat);
            $ngaybatdau = date("Y-m-d", $time);
            $ngayketthuc = $ngaybatdau;
        }

        //        $queryString .= " and (lichtrinh.ngaybatdau is null or (lichtrinh.ngaybatdau != '$ngaybatdau')
        //            or ((lichtrinh.ngaybatdau != '$ngaybatdau') and (lichtrinh.thoigianbatdau is null or (lichtrinh.thoigianbatdau > '$batdau' && lichtrinh.thoigianbatdau > '$ketthuc'))))
        //            and ((lichtrinh.ngayketthuc != '$ngayketthuc')
        //            or (lichtrinh.thoigianketthuc is null or (lichtrinh.thoigianketthuc < '$batdau' && lichtrinh.thoigianketthuc < '$ketthuc')))";


        /*$queryString .= " AND lichtrinh.id is null or lichtrinh.deleted = 1 or (select count(lichtrinh2.id) from lichtrinh lichtrinh2
						where lichtrinh2.idphong = phonghop.id and
						( ((lichtrinh2.ngaybatdau > '$ngaybatdau' && lichtrinh2.ngaybatdau > '$ngayketthuc')
						or (lichtrinh2.ngayketthuc < '$ngaybatdau' && lichtrinh2.ngayketthuc < '$ngayketthuc'))
						or(not (lichtrinh2.thoigianbatdau > '$batdau' && lichtrinh2.thoigianbatdau > '$ketthuc')
								 or not (lichtrinh2.thoigianketthuc < '$batdau' && lichtrinh2.thoigianketthuc < '$ketthuc')
						)) = 0) ";*/

        $queryString .= " AND ( (lichtrinh.id is null or lichtrinh.deleted = 1 or lichtrinh.trangthai = 2) or
                        (select count(lichtrinh2.id) from lichtrinh lichtrinh2
						    where lichtrinh2.idphong = phonghop.id
							and ( (	 not (lichtrinh2.ngaybatdau<'$ngaybatdau' && lichtrinh2.ngayketthuc<'$ngaybatdau')
								and not (lichtrinh2.ngaybatdau>'$ngayketthuc' && lichtrinh2.ngayketthuc>'$ngayketthuc')
								)
								and (	 not (lichtrinh2.thoigianbatdau<'$batdau' && lichtrinh2.thoigianketthuc<'$batdau')
									and not (lichtrinh2.thoigianbatdau>'$ketthuc' && lichtrinh2.thoigianketthuc>'$ketthuc')
								)
							) ) = 0 ) ";

        //Tìm phòng tối ưu
        $queryOp = "";
        $rooms = PhongHopDAO::getRoomsOptimize($loaiPhong, $soluong, $ngaybatdau, $ngayketthuc, $batdau, $ketthuc);
        for ($i = 1; $i <= count($rooms); $i++) {
            $phId = $rooms[$i]->id;
            $queryOp .= " OR phonghop.id=$phId ";
        }

        $page = PhongHopDAO::searchRoomsByLichTrinh($page, $queryString, $queryOp);
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
     * Hàm xử lý LẤY RA DANH SÁCH PHÒNG/.
     */
    public function danhsachphong(Request $request)
    {
        $query = "";
        $loai_phong = $request->loai_phong;
        $items = array();
        if ($loai_phong != null && $loai_phong != '') $query .= " and bo.loai_phong = $loai_phong";

        $items = PhongHopDAO::danhsachphonghop($query);
        /*  return Response::json($page);*/
        return response()->json([
            'listphong' => $items
        ], 200);
        /*return $page;*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Hàm xử lý THÊM MỚI PHÒNG HỌP.
     */
    public function store(Request $request)
    {
        //
        $phonghop = new PhongHop();
        $phonghop->ten_phong = $request->ten_phong;
        $phonghop->mo_ta = $request->mo_ta;
        $phonghop->trang_thai = $request->trang_thai;
        $phonghop->loai_phong = $request->loai_phong;
        $phonghop->soluong = $request->soluong;
        $phonghop->deleted = 0;
        //\DB::table('phonghop')->insert((array)$phonghop);
        $phonghop->save();
        return response()->json([
            'result' => true,
            'message' => 'Thêm mới phòng họp thành công!',
            'phonghop' => $phonghop
        ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param PhongHop $phongHop
     * @return \Illuminate\Http\Response
     */
    public function show(PhongHop $phongHop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PhongHop $phongHop
     * @return \Illuminate\Http\Response
     */
    public function edit(PhongHop $phongHop)
    {
        //
    }

    /**
     * Hàm xử lý CẬP NHẬT THÔNG TIN PHÒNG HỢP LƯU VÀO CSDL.
     */
    public function update(Request $request, PhongHop $phongHop)
    {
        //
        $phongHop = PhongHop::findOrFail($request->id);
        $phongHop->ten_phong = $request->ten_phong;
        $phongHop->loai_phong = $request->loai_phong;
        $phongHop->mo_ta = $request->mo_ta;
        $phongHop->trang_thai = $request->trang_thai;
        $phongHop->soluong = $request->soluong;
        $phongHop->save();
        return response()->json([
            'result' => true,
            'message' => 'Chỉnh sửa phòng họp thành công!',
            'phonghop' => $phongHop
        ], 200);
    }

    /**
     * Hàm xử lý XÓA THÔNG TIN PHÒNG HỌP.
     */
    public function destroy($id)
    {
        //
        /*$phonghop = PhongHop::findOrFail($id);
        $phonghop->delete();*/
        PhongHopDAO::deleteById($id);
        return $phonghop = PhongHop::all();
    }

    /**
     * Hàm xử lý LẤY THÔNG TIN PHÒNG HỌP THEO ID.
     */
    public function findById($id)
    {
        return PhongHop::findOrFail($id);
    }
}
