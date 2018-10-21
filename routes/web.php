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
	
});


Route::get('comment', 'CommentController@view');
Route::get('test', function() {
	return view('tasks.test');
});
Route::post('comment/upload/{plan_id}','CommentController@postComment')
		->name('comment.upload');
Route::post('comment/upload2/{user_id}/{plan_id}','CommentController@postComment2')
		->name('comment.upload2');


Route::get('plan','HomeController@plan');

Route::get('home','HomeController@index')->name('home');
Route::get('/search','SearchController@search');

Route::get('profile', 'HomeController@profile')->name('profile');


Route::get('signup','LoginController@signup')->name('signup');
Route::prefix('signup')->group(function () {
    Route::post('required', 'Auth\RegisterController@create');
    Route::post('changed', 'Auth\RegisterController@modify');
    
});

Route::get('login','LoginController@login')->name('login');
Route::prefix('login')->group(function () {
    Route::post('required', 'LoginController@doLogin');
    
});

Route::get('users/{id}', 'HomeController@detailUser')->name('user_detail');


Route::get('follow/{id}', 'UserPlanController@follow');
Route::get('join/{id}', 'UserPlanController@join');
Route::get('joiners/{plan_id}', 'UserPlanController@joiners');


Route::post('deny','UserPlanController@deny');
Route::post('accept','UserPlanController@accept');


Route::get('logout', function() {
    Auth::logout();
    return redirect('home');
})->name('logout');



Route::get('loading','DemoController@loading');



Route::get('test/json', function(){
	return view('test');
});
Route::post('comment/images','CommentController@showImages');
Route::get('comment/test','CommentController@testORM');

Route::resource('plans', 'PlanController');
Route::get('plans/{id}/cancel', 'PlanController@cancel');
Route::get('plans/{id}/start', 'PlanController@start');

Route::get('test/image', function(){
	return view('image_test');
});
Route::post('test/image/upload', 'CommentController@testValidate')->name('image.upload');










