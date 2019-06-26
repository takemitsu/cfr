<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('ogp', 'ProjectController@getOgp')->name('ogp');

Route::apiResource('service', 'ServiceController');
Route::apiResource('project', 'ProjectController')
    ->only(['index', 'store', 'show']);
Route::apiResource('project.review', 'ReviewController')
    ->only(['index', 'store']);


Route::group(['prefix' => 'admin'], function () {
    Route::name('admin.')->group(function () {
        Route::get('login', 'Admin\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Admin\LoginController@login')->name('login-post');
        Route::get('logout', 'Admin\LoginController@logout')->name('logout');
        Route::get('home', 'Admin\HomeController@index')->name('home');

        Route::resource('project', 'Admin\ProjectController')
            ->only(['index', 'edit', 'update', 'destroy']);
        Route::resource('project.review', 'Admin\ReviewController')
            ->only(['index', 'edit', 'update', 'destroy']);
    });
});
