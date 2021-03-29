<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api.check','auth:api'])->group(function (){
    Route::get('get/user/detail/{lang?}', 'Api\UserController@getUserDetail');
    Route::post('user/update/{lang?}', 'Api\UserController@userDetailUpdate');
    Route::post('place/order/{lang?}', 'Api\OrderController@placeOrder');
    Route::post('cancel/order/{lang?}', 'Api\OrderController@cancelOrder');
    Route::get('order/history/{lang?}', 'Api\OrderController@orderHistory');
    Route::get('order/details/{orderidid?}/{lang?}', 'Api\OrderController@orderDetails');
    Route::get('logout/{lang?}', 'Api\AuthController@logout');
    Route::post('feedback/{lang?}', 'Api\UserController@feedbackCreate');
    Route::get('get/feedback/detail/{lang?}', 'Api\UserController@getfeedbackDetail');
    Route::get('get/pendingpage/{lang?}', 'Api\UserController@getPendingPage');
    Route::get('branch/details/{lang?}','Api\ShopController@branchDetails');
});


Route::post('register/{lang?}', 'Api\AuthController@register');
Route::post('login/{lang?}', 'Api\AuthController@login');
Route::post('forgot/{lang?}', 'Api\AuthController@forgot');
Route::post('validateOTP/{lang?}', 'Api\AuthController@validateOTP');
Route::post('resetpassword/{lang?}', 'Api\AuthController@resetPassword');
Route::get('get/homepage/{lang?}', 'Api\UserController@getHomePage');
Route::get('category/{lang?}', 'Api\ShopController@categoryList');
Route::get('product/{lang?}', 'Api\ShopController@productList');
Route::get('productlist/{lang?}', 'Api\ShopController@categoryproductList');
Route::get('productcategorylist/{categoryid?}/{lang?}', 'Api\ShopController@categoryviaproductList');
Route::get('productdetails/{productdetailsid?}/{lang?}', 'Api\ShopController@productdetailsList');
Route::get('category/{categoryId?}/productList/{lang?}', 'Api\UserController@getProductsByCategory');
Route::get('productsearch/{productword?}/{lang?}', 'Api\ShopController@productsearchList');
Route::get('get/feedback/list/{lang?}', 'Api\UserController@getfeedbackList');



