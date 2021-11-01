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

Route::get('/', function () {
    return view('welcome');
});
//Route::get('/', 'HomeController@index')->name('home');
//Route::get('/home', 'HomeController@index')->name('home');
*/

Auth::routes();

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->where('social', 'twitter|google|facebook');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'twitter|google|facebook');

Route::get('/timeline', 'TimelineController@indexTimeLineItems')->name('timeline.index');
Route::get('/actionpost', 'DailyActionController@indexActionPost')->name('actionPost.index');
Route::post('/actionpost', 'DailyActionController@createActionPost')->name('actionPost.create');
Route::get('/okra', 'OkraSettingController@indexOkra')->name('okra.index');
Route::get('/objective', 'OkraSettingController@indexObjective')->name('objective.index');
Route::post('/objective', 'OkraSettingController@createObjective')->name('objective.create');
Route::get('/keyresult', 'OkraSettingController@indexKeyResult')->name('keyResult.index');
Route::post('/keyresult', 'OkraSettingController@createKeyResult')->name('keyResult.create');
Route::get('/action', 'OkraSettingController@indexAction')->name('action.index');
Route::post('/action', 'OkraSettingController@createAction')->name('action.create');
Route::get('/mypageinfo', 'MyPageController@indexMyPage')->name('mypageinfo.index');
Route::post('/profileimage', 'MyPageController@updateProfileImage')->name('profileImage.update');

Route::get('/', function () {
    return view('layouts/app');
});
Route::get('/{any?}', function () {
    return view('layouts/app');
});