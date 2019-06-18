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
Route::get('/curl1','Text\Textcotroller@curl1');
Route::post('/curl2','Text\Textcotroller@curl2');
Route::get('/curl2','Text\Textcotroller@curl2');
Route::get('/form1','Text\Textcotroller@form1');
Route::post('/form1','Text\Textcotroller@form1post');
Route::get('/tet','Text\Textcotroller@tet');
Route::get('/curl4','Text\Textcotroller@curl4');
Route::get('/curl5','Text\Textcotroller@curl5');
Route::get('/curl6','Text\Textcotroller@curl6');
Route::get('/curl9','Text\Textcotroller@curl9');
Route::get('/curl7','Text\Textcotroller@curl7');
Route::get('/curl8','Text\Textcotroller@curl8');
Route::get('/sign','Text\Textcotroller@sign');



//登录注册
Route::post('/lo','admin\UserController@lo');
Route::post('/re','admin\UserController@re');