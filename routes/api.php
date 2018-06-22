<?php

Route::get("/",'IndexController@index');

//用户
Route::post("user/token",'UserController@getToken');