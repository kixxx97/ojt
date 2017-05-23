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

Auth::routes();

Route::get('/', 'ChatsController@index');
Route::post('messages/public', 'ChatsController@fetchMessages');
Route::post('messages/private', 'ChatsController@fetchPrivateMessages');
Route::post('messages', 'ChatsController@sendMessage');
Route::get('peers', 'ChatsController@peerChat');    
Route::get('mail', 'ChatsController@sendMail');