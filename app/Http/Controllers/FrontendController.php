<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Space\Settings\Setting;

class FrontendController extends Controller
{
    public function index()
    {
        flash()->success('Chào mừng đến hệ thống đặt phòng họp');
        return view('front.index');
    }
}
