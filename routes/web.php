<?php


//后台登录
Route::get('admin/login','Admin\LoginController@index');
Route::get('admin/yzm','Admin\LoginController@yzm');
//验证码

//后台路由
Route::group(['prefix' => 'admin','namespace'=>'\Admin','middleware'=>['adminLogin']],function (){
    //首页
    Route::get('/','IndexController@index');
    //管理员
    Route::resource('admin','AdminController');
    //用户
    Route::resource('user','UserController');



});


