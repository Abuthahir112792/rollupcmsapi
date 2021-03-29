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


Route::get('/admin', function () {
    return redirect()->route('admin.login');
});
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function(){
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('home', 'HomeController@index')->name('home');
	Route::get('users', 'Admin\UserController@usersListView')->name('users');
	Route::get('/users-list', 'Admin\UserController@usersList');
	Route::get('delete/user/{id}', 'Admin\UserController@deleteUser');


	Route::get('cms', 'Admin\CmsController@cmsDetailsView')->name('cms');
	Route::post('images-upload', 'Admin\CmsController@imagesUploadPost')->name('images.upload');
	Route::post('video-upload', 'Admin\CmsController@videoUploadPost')->name('video.upload');
	Route::get('delete/media/{id?}', 'Admin\CmsController@deleteMedia');
	Route::post('privacy-update', 'Admin\CmsController@privacyUpdatePost')->name('privacy.update');
	Route::post('term-update', 'Admin\CmsController@termUpdatePost')->name('term.update');
	Route::post('logo-upload', 'Admin\CmsController@logoUploadPost')->name('logo.upload');
    Route::post('shopkeeper-update', 'Admin\CmsController@shopkeeperUpdatePost')->name('shopkeeper.update');


	Route::get('orders', 'Admin\OrderController@ordersListView')->name('orders');
	Route::get('incoming-orders', 'Admin\OrderController@incomingOrders');
	Route::get('out-for-delivery', 'Admin\OrderController@outForDeliveryOrders');
	Route::get('self-pickup', 'Admin\OrderController@selfPickupOrders');

	Route::post('incoming-order-update', 'Admin\OrderController@incomingOrderUpdate')->name('incomingOrderUpdate');
	Route::post('out-for-order-update', 'Admin\OrderController@outForOrderUpdate')->name('outforOrderUpdate');
	Route::get('order/details/{id?}', 'Admin\OrderController@getOrderDetails');
    Route::get('neworder/{id?}', 'Admin\OrderController@neworderAllow');
    Route::get('neworderchecking', 'Admin\OrderController@neworderChecking');

	Route::get('history', 'Admin\HistoryController@historyListView')->name('history');
	Route::get('historyorderitem/details/{id?}', 'Admin\HistoryController@getHistoryorderitemDetails');
	Route::get('/export_excel/excel', 'Admin\HistoryController@orderexcel')->name('export_excel.excel');
    Route::get('/history_list', 'HistoryController@index');

	Route::get('/history_list/fetch_data', 'HistoryController@fetch_data');
	Route::get('pagination/fetch_data', 'Admin\HistoryController@fetch_data');
   
	Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');
    
    Route::get('adminfeedback', 'Admin\FeedbackController@feedbackListView')->name('adminfeedback');
	Route::get('/feedback-list', 'Admin\FeedbackController@feedbackList');
	Route::get('delete/feedback/{id}', 'Admin\FeedbackController@deleteFeedback');

	Route::get('referral', 'Admin\ReferralController@referralListView')->name('referral');
	Route::get('/referral-list', 'Admin\ReferralController@referralList');
	

	Route::get('order-allow/{id?}', 'HomeController@orderAllow');

	Route::get('userchart', 'HomeController@userchart');

	Route::get('sales/details/{id?}', 'HomeController@getSalesDetails');

	Route::get('category', 'Admin\CategoryController@categoryListView')->name('category');
	Route::get('all-category-list', 'Admin\CategoryController@getCategorylist');
   	Route::post('add-category-update', 'Admin\CategoryController@addCategoryUpdate')->name('addCategoryUpdate');
   	Route::get('category/details/{id?}', 'Admin\CategoryController@getCategoryDetails');
   	Route::get('category-status-check/{id?}/{status?}', 'Admin\CategoryController@categoryStatuscheck');
   	Route::get('delete/category/{id?}', 'Admin\CategoryController@deleteCategory');
   	Route::get('multicategory/{id?}', 'Admin\CategoryController@deletemultiCategory');

	Route::get('product', 'Admin\ProductController@productListView')->name('product');
	Route::get('all-product-list', 'Admin\ProductController@getproductlist');
   	Route::post('add-product-update', 'Admin\ProductController@addProductUpdate')->name('addProductUpdate');
   	Route::get('product/details/{id?}', 'Admin\ProductController@getproductDetails');
   	Route::get('product-status-check/{id?}/{status?}', 'Admin\ProductController@productStatuscheck');
   	Route::get('productcategory/details', 'Admin\ProductController@getproductcategoryDetail');
   	Route::get('delete/product/{id?}', 'Admin\ProductController@deleteProduct');
   	Route::get('multiproduct/{id?}', 'Admin\ProductController@deletemultiProduct');

   	Route::get('statuslist', 'Admin\StatuslistController@statusListView')->name('statuslist');
	Route::get('all-statuslist-list', 'Admin\StatuslistController@getStatuslist');
   	Route::post('add-statuslist-update', 'Admin\StatuslistController@addStatuslistUpdate')->name('addStatuslistUpdate');
   	Route::get('statuslist/details/{id?}', 'Admin\StatuslistController@getStatuslistDetails');
   	Route::get('statuslist-status-check/{id?}/{status?}', 'Admin\StatuslistController@statuslistStatuscheck');
   	Route::get('delete/statuslist/{id?}', 'Admin\StatuslistController@deleteStatuslist');
   	Route::get('multistatuslist/{id?}', 'Admin\StatuslistController@deletemultiStatuslist');
    
    Route::get('branch/details/{id?}', 'Admin\OrderController@getBranchDetail');

    Route::post('swift-order-update', 'Admin\OrderController@swiftOrderUpdate')->name('swiftOrderUpdate');

    Route::get('home', 'HomeController@index')->name('home');

	Route::get('branchmanage','Admin\BranchManageController@branchmanageListView')->name('branchmanage');
    Route::get('/branchmanage-list', 'Admin\BranchManageController@branchmanageList');
    Route::get('branchmanage/details/{id?}', 'Admin\BranchManageController@getBranchManageDetails');
    Route::get('branchuser/details/{id?}', 'Admin\BranchManageController@getBranchManageDetails');
    Route::get('userbranch-status-check/{id?}/{status?}', 'Admin\BranchManageController@branchStatuscheck');
    Route::get('editorder/{id?}', 'Admin\EditorderController@editOrderView');
    Route::get('all-orders-list/{editorderid?}', 'Admin\EditorderController@getallOrderlist');
  Route::get('get_userorderlist_list/details/{editorderid?}', 'Admin\EditorderController@getuserorderlist');
  Route::get('updateallorderdetails/{editorderid?}/{itemid?}/{qty?}', 'Admin\EditorderController@getupdateallorderdetails');
	//Route::get('delete/user/{id}', 'Admin\UserController@deleteUser');
    Route::get('orderitem/details/{id?}', 'Admin\OrderController@getOrderitemDetails');
Route::post('all-orderdetails-update', 'Admin\EditorderController@OrderdetailsUpdate')->name('allOrderdetailsUpdate');
    Route::post('add-user-update', 'Admin\BranchManageController@addUserUpdate')->name('addUserUpdate');
    Route::get('orderstatus/{id?}/{status?}', 'Admin\OrderController@orderStatuschange');
});




Route::get('/branch', function () {
    return redirect()->route('branch.login');
});
Route::prefix('branch')->name('branch.')->middleware('branch')->group(function(){
    Route::get('login', 'Branch\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Branch\LoginController@login');
    Route::post('logout', 'Branch\LoginController@logout')->name('logout');

  Route::get('home', 'Branch\HomeController@index')->name('home');

  Route::get('orders', 'Branch\OrderController@ordersListView')->name('orders');
  Route::get('incoming-orders', 'Branch\OrderController@incomingOrders');
  Route::get('out-for-delivery', 'Branch\OrderController@outForDeliveryOrders');
  Route::get('self-pickup', 'Branch\OrderController@selfPickupOrders');

  Route::post('incoming-order-update', 'Branch\OrderController@incomingOrderUpdate')->name('incomingOrderUpdate');
  Route::post('out-for-order-update', 'Branch\OrderController@outForOrderUpdate')->name('outforOrderUpdate');
  Route::get('order/details/{id?}', 'Branch\OrderController@getOrderDetails');
  Route::get('neworder/{id?}', 'Branch\OrderController@neworderAllow');
  Route::get('neworderchecking', 'Branch\OrderController@neworderChecking');

  
  Route::get('history', 'Branch\HistoryController@historyListView')->name('history');
  Route::get('/bexport_excel/bexcel', 'Branch\HistoryController@orderexcel')->name('bexport_excel.bexcel');
 // Route::get('/history_list/fetch_data', 'Branch\HistoryController@fetch_data');
  Route::get('pagination/fetch_data', 'Branch\HistoryController@fetch_data');
   
  Route::get('/live_search/action', 'LiveSearch@action')->name('live_search.action');

  Route::get('order-allow/{id?}', 'Branch\HomeController@orderAllow');

  Route::get('userchart', 'Branch\HomeController@userchart');

  Route::get('sales/details/{id?}', 'Branch\HomeController@getSalesDetails');

  Route::get('branch/details', 'Branch\OrderController@getBranchDetail');

  Route::post('swift-order-update', 'Branch\OrderController@swiftOrderUpdate')->name('swiftOrderUpdate');
  Route::get('editorder/{id?}', 'Branch\EditorderController@editOrderView');
  Route::get('orderitem/details/{id?}', 'Branch\OrderController@getOrderitemDetails');
  Route::get('orderstatus/{id?}/{status?}', 'Branch\OrderController@orderStatuschange');
  Route::get('all-orders-list/{editorderid?}', 'Branch\EditorderController@getallOrderlist');
  Route::get('get_userorderlist_list/details/{editorderid?}', 'Branch\EditorderController@getuserorderlist');
  Route::get('updateallorderdetails/{editorderid?}/{itemid?}/{qty?}', 'Branch\EditorderController@getupdateallorderdetails');
  Route::post('all-orderdetails-update', 'Branch\EditorderController@OrderdetailsUpdate')->name('allOrderdetailsUpdate');
  Route::get('historyorderitem/details/{id?}', 'Branch\HistoryController@getHistoryorderitemDetails');
});

Route::get('/', function () {
    return redirect()->route('front.home');
});
Route::namespace('Front')->group(function(){
    Route::get('register','LoginController@register')->name('front.register');
    Route::get('login','LoginController@show_login')->name('front.login.show');
    Route::get('login_otp/{mobile}/{is_login}','LoginController@login_otp')->name('front.login_otp');
    Route::get('forgot','LoginController@forgot')->name('front.forgot');
    Route::get('reset_password/{mobile}/{userids}','LoginController@reset_password')->name('front.reset_password'); 
    Route::get('home','HomeController@index')->name('front.home');
    Route::get('profile','HomeController@profile')->name('front.profile'); 
    
    Route::get('order-history','OrderController@order_history')->name('front.order.history');
    Route::get('order','OrderController@add_order')->name('front.order');
    Route::get('order-details/{orderid}','OrderController@order_details')->name('front.order.details');
    Route::get('privacy-policy','HomeController@privacy_policy')->name('front.privacy_policy');
    Route::get('terms-condition','HomeController@terms_condition')->name('front.terms_condition');
    Route::get('feedback','HomeController@feedback')->name('front.feedback');
	Route::get('language-change/{lang}','HomeController@language_change');
	
	Route::get('referral','HomeController@referral')->name('front.referral');

	Route::get('more','HomeController@more')->name('front.more');
	
    

    Route::get('test',function (){
        return view('test');
    });
});


