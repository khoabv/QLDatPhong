<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth'], function () {
    Route::post('login','AuthController@authenticate');
    Route::post('register','AuthController@authenticate');
    Route::get('logout','AuthController@logout');
    Route::get('check','AuthController@check');
    Route::get('isAdmin','AuthController@isAdmin');
    Route::get('getUserLoggedOn','AuthController@getUserLoggedOn');
});

// session route
Route::post('email-exist',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@emailExist'
]);

//Đổi mật khẩu
Route::post('changeMyPass',[
    'as' => 'email-exist','uses' => 'Demo\PagesController@changeMyPass'
]);

// public route
Route::group(['prefix' => 'lichtrinh'], function (){
    Route::get('/yeucaunhuongphong/getYeuCauChuyenNhuongByIdAndLichTrinh/{id}', [
        'as' => 'admin.yeucaunhuongphong', 'uses' => 'Demo\LichTrinhController@getYeuCauChuyenNhuongByIdAndLichTrinh'
    ]);

    Route::post('/yeucaunhuongphong', 'Demo\LichTrinhController@yeucaunhuongphong')/*->name('store')*/;
    Route::post('/duyetyeucaunhuongphong', 'Demo\LichTrinhController@duyetyeucaunhuongphong')/*->name('store')*/;
    Route::post('/huyYeuCauNhuongPhong', 'Demo\LichTrinhController@huyYeuCauNhuongPhong')/*->name('store')*/;
    Route::get('/huyDatPhong/{id}',[
        'as' => 'admin.lichtrinh.huyDatPhongCus', 'uses' => 'Demo\LichTrinhController@huyDatPhong'
    ]);
    
});


// admin route
Route::group(['prefix' => 'admin', 'middleware' => 'api.auth'], function (){

    Route::resource('todos', 'Demo\TodosController');

    Route::post('todos/toggleTodo/{id}', [
        'as' => 'admin.todos.toggle', 'uses' => 'Demo\TodosController@toggleTodo'
    ]);

    Route::group(['prefix' => 'settings'], function () {

        Route::post('/social', [
            'as' => 'admin.settings.social', 'uses' => 'Demo\SettingsController@postSocial'
        ]);
    });

    Route::group(['prefix' => 'users'], function (){//users/get

        /*Route::post('/create',[
            'as' => 'admin.users.create', 'uses' => 'Demo\PagesController@store'
        ]);*/
        Route::post('/create', 'Demo\PagesController@store')/*->name('store')*/;

        Route::post('/update', 'Demo\PagesController@update')/*->name('update')*/;

        Route::get('/get',[
            'as' => 'admin.users', 'uses' => 'Demo\PagesController@allUsers'
        ]);

        Route::get('get/{id}', [
            'as' => 'admin.users', 'uses' => 'Demo\PagesController@findById'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.users.delete', 'uses' => 'Demo\PagesController@destroy'
        ]);
        Route::get('/danhsachnguoidung',[
            'as' => 'admin.users', 'uses' => 'Demo\PagesController@danhsachnguoidung'
        ]);

    });

    //Lịch trình
    Route::group(['prefix' => 'lichtrinh'], function (){//users/get

        Route::post('/addlichtrinh',[
            'as' => 'admin.users.create', 'uses' => 'Demo\LichTrinhController@addtientrinh'
        ]);

        Route::post('/addLichTrinhByCustomer',[
            'as' => 'admin.users.create', 'uses' => 'Demo\LichTrinhController@addLichTrinhByCustomer'
        ]);

        Route::post('/update', 'Demo\LichTrinhController@update')/*->name('update')*/;

        Route::post('/chuyennhuong', 'Demo\LichTrinhController@chuyennhuong')/*->name('update')*/;

        Route::post('/duyetPhong', 'Demo\LichTrinhController@duyetPhong')/*->name('update')*/;

        Route::get('/get',[
            'as' => 'admin.lichtrinh', 'uses' => 'Demo\LichTrinhController@allLichTrinh'
        ]);

        Route::get('/searchByLichTrinh',[
            'as' => 'admin.lichtrinh', 'uses' => 'Demo\LichTrinhController@allLichTrinh'
        ]);

        Route::get('/checkExistLichTrinh',[
            'as' => 'admin.lichtrinh', 'uses' => 'Demo\LichTrinhController@checkExistLichTrinh'
        ]);

        Route::get('/searchLichTrinhCanYeuCauNhongPhong',[
            'as' => 'admin.lichtrinh', 'uses' => 'Demo\LichTrinhController@searchLichTrinhCanYeuCauNhongPhong'
        ]);

        Route::get('/searchLichTrinhDaDat',[
            'as' => 'admin.lichtrinh', 'uses' => 'Demo\LichTrinhController@searchLichTrinhDaDat'
        ]);

        Route::get('get/{id}', [
            'as' => 'admin.lichtrinh', 'uses' => 'Demo\LichTrinhController@findById'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.lichtrinh.delete', 'uses' => 'Demo\LichTrinhController@destroy'
        ]);

    });

    //Phòng họp
    Route::group(['prefix' => 'rooms'], function (){

        /*Route::post('/create',[
            'as' => 'admin.users.create', 'uses' => 'Demo\PagesController@store'
        ]);*/
        Route::post('/create', 'Demo\PhongHopController@store')->name('store');

        Route::post('/update', 'Demo\PhongHopController@update')->name('update');

        Route::get('/get',[
            'as' => 'admin.rooms', 'uses' => 'Demo\PhongHopController@allRooms'
        ]);

        Route::get('/searchByExceptLichTrinh',[
            'as' => 'admin.rooms', 'uses' => 'Demo\PhongHopController@searchByExceptLichTrinh'
        ]);

        Route::get('get/{id}', [
            'as' => 'admin.rooms', 'uses' => 'Demo\PhongHopController@findById'
        ]);
        Route::get('/danhsachphong', [
            'as' => 'admin.rooms', 'uses' => 'Demo\PhongHopController@danhsachphong'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.rooms.delete', 'uses' => 'Demo\PhongHopController@destroy'
        ]);

    });

    //Thông báo
    Route::group(['prefix' => 'thongbao'], function (){//users/get

        Route::get('/get',[
            'as' => 'admin.thongbao', 'uses' => 'Demo\ThongBaoController@allThongBao'
        ]);

        Route::get('/thongBaoCuaToi',[
            'as' => 'admin.thongbao', 'uses' => 'Demo\ThongBaoController@thongBaoCuaToi'
        ]);

        Route::get('get/{id}', [
            'as' => 'admin.thongbao', 'uses' => 'Demo\ThongBaoController@findById'
        ]);

        Route::get('countThongBaoChuaDocCuaToi', [
            'as' => 'admin.thongbao', 'uses' => 'Demo\ThongBaoController@countThongBaoChuaDocCuaToi'
        ]);

    });

    //Cuộc họp
    Route::group(['prefix' => 'cuochop'], function (){

        /*Route::post('/create',[
            'as' => 'admin.users.create', 'uses' => 'Demo\PagesController@store'
        ]);*/
        Route::post('/create', 'Demo\CuocHopController@store')->name('store');

        Route::post('/guithongbao', 'Demo\CuocHopController@guiThongBao')->name('guiThongBao');

        Route::post('/update', 'Demo\CuocHopController@update')->name('update');

        Route::post('/uploadFileCuocHop', 'Demo\CuocHopController@uploadFileCuocHop')->name('uploadFileCuocHop');

        Route::get('/get',[
            'as' => 'admin.cuochop', 'uses' => 'Demo\CuocHopController@all'
        ]);

        Route::get('get/{id}', [
            'as' => 'admin.cuochop', 'uses' => 'Demo\CuocHopController@findById'
        ]);

        Route::delete('/{id}',[
            'as' => 'admin.cuochop.delete', 'uses' => 'Demo\CuocHopController@destroy'
        ]);

        Route::get('/getAllThanhVien',[
            'as' => 'admin.cuochop', 'uses' => 'Demo\CuocHopController@searchAllThanhVienByCuocHop'
        ]);

    });

});

