<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//,'api.auth'
Route::group(['middleware' => ['web'], 'prefix'=>'user'], function () {
    Route::any('islogin', 'UserController@isLogin');
    Route::any('loginOut', 'UserController@logout');
    Route::any('login', 'UserController@login');
    Route::any('regmember', 'UserController@register');
    Route::any('send', 'UserController@sms');
    Route::any('getMember/{mobile}?', 'UserController@show');
    Route::any('updateMember/{id}', 'UserController@update');
});
Route::group(['middleware' => ['web'], 'prefix'=>'makeup'], function () {
    Route::any('/', 'MakeupController@index');
    Route::any('{id}', 'MakeupController@show');
});
Route::group(['middleware' => ['web'], 'prefix'=>'webform'], function () {
    Route::any('postWebform', 'FormController@post');
});



Route::group(['prefix' => 'admin','namespace' => 'Admin'],function ($router)
{
    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'LoginController@login');
    $router->get('logout', 'LoginController@logout');
    /*
    Route::get('/login', 'Admin\AuthController@getLogin');
    Route::post('/login', 'Admin\AuthController@postLogin');
    Route::any('/logout', function(){
        Auth::guard('admin')->logout();
        return redirect('/login');
    });
    */



    Route::group(['middleware' => ['auth.admin:admin','menu']], function () {
        Route::get('/', 'IndexController@index')->name('admin_dashboard');
        Route::resource('item', 'ItemController');
        Route::resource('type', 'ItemTypeController');
        Route::resource('makeup', 'MakeupController');
        Route::resource('feature', 'FeatureController');

        Route::get('account', 'IndexController@account');
        Route::post('account', 'IndexController@accountPost');
    });
    //初始化后台帐号
    Route::get('install', function () {
        if (0 == \App\Admin::count()) {
            $user = new \App\Admin();
            $user->name = 'admin';
            $user->email = 'admin@admin.com';
            $user->password = bcrypt('admin@2016');
            $user->save();
        }
        return redirect('admin/login');
    });
});
