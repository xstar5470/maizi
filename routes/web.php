<?php
//前台
    Route::group(['prefix'=>'','namespace'=>'Home'],function(){
        Route::get('/','IndexController@index');
        Route::get('type/{id}','TypeController@index');
        Route::get('good/{id}','GoodController@index');
    });


//后台
    //后台登录
    Route::get('admin/login','Admin\LoginController@index');
    //验证码
    Route::get('admin/yzm','Admin\LoginController@yzm');
    //后台路由
    Route::group(['prefix' => 'admin','namespace'=>'\Admin','middleware'=>['adminLogin']],function (){
        //首页
        Route::get('/','IndexController@index');
        //管理员
        Route::resource('admin','AdminController');
        //用户
        Route::resource('user','UserController');
    });


