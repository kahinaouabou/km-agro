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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});
Route::resource('blocks', 'App\Http\Controllers\BlockController')->middleware('auth');
Route::resource('warehouses', 'App\Http\Controllers\WarehouseController')->middleware('auth');	
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::resource('rooms', 'App\Http\Controllers\RoomController')->middleware('auth');
Route::resource('products', 'App\Http\Controllers\ProductController')->middleware('auth');
Route::resource('parcelCategories', 'App\Http\Controllers\ParcelCategoryController')->middleware('auth');
Route::resource('parcels', 'App\Http\Controllers\ParcelController')->middleware('auth');
Route::resource('marks', 'App\Http\Controllers\MarkController')->middleware('auth');
Route::resource('trucks', 'App\Http\Controllers\TruckController')->middleware('auth');
Route::resource('thirdParties', 'App\Http\Controllers\ThirdPartyController')->middleware('auth');
Route::get('thirdParty/{isSupplier}', 'App\Http\Controllers\ThirdPartyController@index')->name('thirdParties')->middleware('auth');
Route::get('thirdParties/{isSupplier}/create', 'App\Http\Controllers\ThirdPartyController@create')->name('thirdParties.create')->middleware('auth');
Route::get('thirdParties/{thirdParty}/{isSupplier}/edit', 'App\Http\Controllers\ThirdPartyController@edit')->name('thirdParties.edit')->middleware('auth');
Route::resource('bills', 'App\Http\Controllers\BillController')->middleware('auth');
Route::get('bill/{type}', 'App\Http\Controllers\BillController@index')->name('bills')->middleware('auth');
Route::get('bills/{type}/create', 'App\Http\Controllers\BillController@create')->name('bills.create')->middleware('auth');
Route::get('bills/{bill}/{type}/edit', 'App\Http\Controllers\BillController@edit')->name('bills.edit')->middleware('auth');
Route::get('bills/{blockId}/getRoomsByBlockId', 'App\Http\Controllers\BillController@getRoomsByBlockId')->name('bills.getRoomsByBlockId')->middleware('auth');
Route::get('bills/{origin}/getSelectByOrigin', 'App\Http\Controllers\BillController@getSelectByOrigin')->name('bills.getSelectByOrigin')->middleware('auth');
Route::get('bills/{thirdPartyId}/getParcelsByThirdPartyId', 'App\Http\Controllers\BillController@getParcelsByThirdPartyId')->name('bills.getParcelsByThirdPartyId')->middleware('auth');
Route::get('generate-pdf', 'App\Http\Controllers\PDFController@generatePDF')->name('generatePDF')->middleware('auth');
Route::get('bills/{thirdParty}/{type}/printBill', 'App\Http\Controllers\BillController@printBill')->name('bills.printBill')->middleware('auth');
Route::get('bills/{thirdParty}/print', 'App\Http\Controllers\BillController@print')->name('bills.print')->middleware('auth');
Route::get('bill/addPaymentContent', 'App\Http\Controllers\BillController@addPaymentContent')->name('bills.addPaymentContent')->middleware('auth');
Route::resource('transactionBoxes', 'App\Http\Controllers\TransactionBoxController')->middleware('auth');
Route::get('transactionBox', 'App\Http\Controllers\TransactionBoxController@filter')->name('transactionBoxes.filter')->middleware('auth');
Route::get('transactionBox/print', 'App\Http\Controllers\TransactionBoxController@print')->name('transactionBoxes.print')->middleware('auth');

Route::get('transactionBoxes/test', 'App\Http\Controllers\TransactionBoxController@test')->name('transactionBoxes.test')->middleware('auth');
Route::resource('payments', 'App\Http\Controllers\PaymentController')->middleware('auth');
Route::get('payments/{payment}/print', 'App\Http\Controllers\PaymentController@print')->name('payments.print')->middleware('auth');
Route::resource('companies', 'App\Http\Controllers\CompanyController')->middleware('auth');



Route::get('articles/filter', 'App\Http\Controllers\ArticleController@filter')->name('articles.filter')->middleware('auth');