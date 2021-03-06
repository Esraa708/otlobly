<?php

use Illuminate\Support\Facades\Route;

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
Route::get('register/facebook', 'Auth\RegisterController@redirectToProvider');
Route::get('register/facebook/callback', 'Auth\RegisterController@handleProviderCallback');
Route::get('register/google', 'Auth\RegisterController@redirectToProviderGoogle');
Route::get('register/google/callback', 'Auth\RegisterController@handleProviderCallbackGoogle');
//login with facebook and google
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/google', 'Auth\LoginController@redirectToProviderGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallbackGoogle');
Route::get('user', function () {
    return response(['user' => auth()->user()]);
});
// Route::get('friends',)
Route::resource('friends', 'friendController')->except([
    'update'
]);
Route::get('/friendsnogropus', 'friendController@friendsNotInGroups');
Route::resource('groups', 'groupController')->except([
    'update'
]);
Route::post('/addfriendtogroup', "GropupFreindsController@store");
Route::get('getGroupFriends/{id}', "GropupFreindsController@index");
Route::get('allorders', "OrderController@allOrders");
Route::resource('orders', 'OrderController');
Route::get('meals', "MealController@index");
Route::fallback(function () {
    return response([
        'message' => 'hhhmmm so sorry you are requesting a wrong page'
    ], 404);
});
