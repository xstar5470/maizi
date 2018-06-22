<?php




//文件上传
Route::any('file_upload','Controller@upload');
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
        Route::get('admin','AdminController@index');
        Route::post('admin/store','AdminController@store');
        Route::post('admin/delete','AdminController@destroy');
        Route::post('admin/status','AdminController@status');
        //分类
        Route::get('type','TypeController@index');
        Route::get('type/create','TypeController@create');
        Route::get('type/{type}/edit','TypeController@edit');
        Route::post('type/store','TypeController@store');
        Route::post('type/delete','TypeController@destroy');
        Route::post('type/status','TypeController@status');
        //商品
        Route::get('goods','GoodController@index');
        Route::get('goods/create','GoodController@create');
        Route::get('goods/{id}/edit','GoodController@edit');
        Route::post('goods/store','GoodController@store');
        Route::post('goods/delete','GoodController@destroy');

        //系统
             //系统轮播图
            Route::get('system/slider','SliderController@index');
            Route::post('system/slider/store','SliderController@store');
            Route::post('system/slider/delete','SliderController@destroy');
            //系统配置
            Route::get('system/config','SiteController@index');
            Route::post('system/config/store','SiteController@store');
    });


