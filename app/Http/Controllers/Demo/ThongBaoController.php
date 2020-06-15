<?php


namespace App\Http\Controllers\Demo;


use App\DAO\PhongHopDAO;
use App\DAO\ThongBaoDAO;
use App\Http\Controllers\Controller;
use App\Model\PagingResult;
use App\PhongHop;
use App\ThongBao;
use Illuminate\Http\Request;
use JWTAuth;

class ThongBaoController extends Controller
{

    /**
     * Hàm xử lý LẤY RA DANH SÁCH THÔNG BÁO.
     */
    public function allThongBao(Request $request)
    {
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $tieude = $request->tieude;
        $noidung = $request->noidung;
        $userid = $request->userid;

        $queryString = "";
        if ($tieude != null && $tieude != "") {
            $queryString .= " and tb.tieude like '%$tieude%'";
        }
        if ($noidung != null && $noidung != "") {
            $queryString .= " and tb.noidung = like '%$noidung%'";
        }
        if ($userid != null && $userid != "") {
            $queryString .= " and tb.userid = $userid";
        }
        $page = ThongBaoDAO::searchThongBao($page, $queryString);
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
     * Hàm xử lý LẤY RA DANH SÁCH THÔNG BÁO CỦA TÔI.
     */
    public function thongBaoCuaToi(Request $request)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        $page = new PagingResult();
        $page->setPageNumber($request->page);
        $tieude = $request->tieude;
        $noidung = $request->noidung;
        $userid = $request->userid;

        $queryString = "";
        if ($tieude != null && $tieude != "") {
            $queryString .= " and tb.tieude like '%$tieude%'";
        }
        if ($noidung != null && $noidung != "") {
            $queryString .= " and tb.noidung = like '%$noidung%'";
        }
        $queryString .= " and tb.userid = $auth->id";

        $page = ThongBaoDAO::searchThongBao($page, $queryString);
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
     * Hàm xử lý TÍNH SỐ LƯỢNG THÔNG BÁO CHƯA ĐỌC CỦA TÔI.
     */
    public function countThongBaoChuaDocCuaToi(Request $request)
    {
        $auth = JWTAuth::parseToken()->authenticate();
        $count = ThongBaoDAO::countThongBaoChuaDocByUserId($auth->id);
        /*  return Response::json($page);*/
        return response()->json([
            'count' => $count
        ], 200);
        /*return $page;*/
    }

    /**
     * Hàm xử lý LẤY THÔNG TIN THÔNG BÁO THEO ID.
     */
    public function findById($id)
    {
        $thongbao = ThongBaoDAO::getById($id);
        ThongBaoDAO::updateIsRead($id);

        return response()->json([
            'result' => true,
            'thongbao' => $thongbao
        ],200);
    }

}
