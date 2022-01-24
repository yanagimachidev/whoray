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

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider')->where('social', 'twitter|google|facebook');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->where('social', 'twitter|google|facebook');

Route::get('/timeline', 'TimelineController@indexTimeLineItems')->name('timeline.index');
Route::get('/actionpost', 'DailyActionController@indexActionPost')->name('actionPost.index');
Route::post('/actionpost', 'DailyActionController@createActionPost')->name('actionPost.create');
Route::get('/okra', 'OkraSettingController@indexOkra')->name('okra.index');
Route::get('/objective', 'OkraSettingController@indexObjective')->name('objective.index');
Route::post('/objective', 'OkraSettingController@createObjective')->name('objective.create');
Route::post('/objectivestatusupdate', 'OkraSettingController@statusUpdateObjective')->name('objective.status.update');
Route::get('/keyresult', 'OkraSettingController@indexKeyResult')->name('keyResult.index');
Route::post('/keyresult', 'OkraSettingController@createKeyResult')->name('keyResult.create');
Route::post('/keyresultstatusupdate', 'OkraSettingController@statusUpdateKeyResult')->name('keyResult.status.update');
Route::get('/action', 'OkraSettingController@indexAction')->name('action.index');
Route::post('/action', 'OkraSettingController@createAction')->name('action.create');
Route::post('/actionstatusupdate', 'OkraSettingController@statusUpdateAction')->name('action.status.update');
Route::get('/mypageinfo', 'MyPageController@indexMyPage')->name('mypageinfo.index');
Route::post('/profileimage', 'MyPageController@updateProfileImage')->name('profileImage.update');
Route::post('/myinfoupdate', 'MyPageController@myInfoUpdate')->name('maypageinfo.update');

Route::get('/', function () {
    if(Auth::check()){
        return view('home');
    } else {
        return view('auth.login');
    }
});
Route::get('/{any?}', function () {
    if(Auth::check()){
        return view('home');
    } else {
        return view('auth.login');
    }
});