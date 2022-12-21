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
Route::resource('users', 'App\Http\Controllers\UserController')->middleware('auth');
Route::resource('blocks', 'App\Http\Controllers\BlockController')->middleware('auth');
Route::resource('drivers', 'App\Http\Controllers\DriverController')->middleware('auth');
Route::get('block/all', 'App\Http\Controllers\BlockController@all')->name('blocks.all');
Route::group(['middleware'=>['admin']], function(){
});
Route::post('block/editBloc/{id}', 'App\Http\Controllers\BlockController@editBloc')->name('blocks.editBloc')->middleware('admin');
Route::get('warehouse/all', 'App\Http\Controllers\WarehouseController@all')->name('warehouses.all');

Route::resource('warehouses', 'App\Http\Controllers\WarehouseController')->middleware('auth');	
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::resource('rooms', 'App\Http\Controllers\RoomController')->middleware('auth');
Route::get('rooms/getRoomsByBlock/{blockId}', 'App\Http\Controllers\RoomController@getRoomsByBlock')->name('rooms.getRoomsByBlock')->middleware('auth');
Route::get('room/print', 'App\Http\Controllers\RoomController@print')->name('rooms.print')->middleware('auth');

Route::resource('products', 'App\Http\Controllers\ProductController')->middleware('auth');
Route::resource('parcelCategories', 'App\Http\Controllers\ParcelCategoryController')->middleware('auth');
Route::resource('parcels', 'App\Http\Controllers\ParcelController')->middleware('auth');
Route::resource('marks', 'App\Http\Controllers\MarkController')->middleware('auth');
Route::resource('trucks', 'App\Http\Controllers\TruckController')->middleware('auth');
Route::resource('thirdParties', 'App\Http\Controllers\ThirdPartyController')->middleware('auth');
Route::get('thirdParty/searchName', 'App\Http\Controllers\ThirdPartyController@searchName')->name('thirdParties.searchName')->middleware('auth');
Route::get('thirdParty/{isSupplier}/{isSubcontractor}', 'App\Http\Controllers\ThirdPartyController@index')->name('thirdParties')->middleware('auth');

Route::get('thirdParties/{isSupplier}/{isSubcontractor}/create', 'App\Http\Controllers\ThirdPartyController@create')->name('thirdParties.create')->middleware('auth');
Route::get('thirdParties/{thirdParty}/{isSupplier}/{isSubcontractor}/edit', 'App\Http\Controllers\ThirdPartyController@edit')->name('thirdParties.edit')->middleware('auth');
Route::resource('bills', 'App\Http\Controllers\BillController')->middleware('auth');
Route::get('bill/{type}', 'App\Http\Controllers\BillController@index')->name('bills')->middleware('auth');
Route::get('bills/{type}/create', 'App\Http\Controllers\BillController@create')->name('bills.create')->middleware('auth');
Route::get('bills/{bill}/{type}/edit', 'App\Http\Controllers\BillController@edit')->name('bills.edit')->middleware('auth');
Route::get('bills/{bill}/{type}/show', 'App\Http\Controllers\BillController@show')->name('bills.show')->middleware('auth');

Route::get('bills/{blockId}/getRoomsByBlockId', 'App\Http\Controllers\BillController@getRoomsByBlockId')->name('bills.getRoomsByBlockId')->middleware('auth');
Route::get('bills/{origin}/getSelectByOrigin', 'App\Http\Controllers\BillController@getSelectByOrigin')->name('bills.getSelectByOrigin')->middleware('auth');
Route::get('bills/{thirdPartyId}/getParcelsByThirdPartyId', 'App\Http\Controllers\BillController@getParcelsByThirdPartyId')->name('bills.getParcelsByThirdPartyId')->middleware('auth');
Route::get('generate-pdf', 'App\Http\Controllers\PDFController@generatePDF')->name('generatePDF')->middleware('auth');
Route::get('bills/{thirdParty}/{type}/printBill', 'App\Http\Controllers\BillController@printBill')->name('bills.printBill')->middleware('auth');
Route::get('bills/{thirdParty}/print', 'App\Http\Controllers\BillController@print')->name('bills.print')->middleware('auth');
Route::get('bill/addPaymentContent', 'App\Http\Controllers\BillController@addPaymentContent')->name('bills.addPaymentContent')->middleware('auth');
Route::get('billSituation/printSituation', 'App\Http\Controllers\BillController@printSituation')->name('bills.printSituation')->middleware('auth');
Route::get('billSituation/printDetailedSituation', 'App\Http\Controllers\BillController@printDetailedSituation')->name('bills.printDetailedSituation')->middleware('auth');
Route::get('billSituation/printDeliveryBill', 'App\Http\Controllers\BillController@printDeliveryBill')->name('bills.printDeliveryBill')->middleware('auth');


Route::resource('transactionBoxes', 'App\Http\Controllers\TransactionBoxController')->middleware('auth');
Route::get('transactionBox', 'App\Http\Controllers\TransactionBoxController@filter')->name('transactionBoxes.filter')->middleware('auth');
Route::get('transactionBox/print', 'App\Http\Controllers\TransactionBoxController@print')->name('transactionBoxes.print')->middleware('auth');
Route::get('transactionBox/printGlobal', 'App\Http\Controllers\TransactionBoxController@printGlobal')->name('transactionBoxes.printGlobal')->middleware('auth');


Route::get('transactionBoxes/test', 'App\Http\Controllers\TransactionBoxController@test')->name('transactionBoxes.test')->middleware('auth');
Route::resource('payments', 'App\Http\Controllers\PaymentController')->middleware('auth');
Route::get('payments/{payment}/print', 'App\Http\Controllers\PaymentController@print')->name('payments.print')->middleware('auth');
Route::get('payment/getReference', 'App\Http\Controllers\PaymentController@getReference')->name('payments.getReference')->middleware('auth');
Route::get('payments/{type}/create', 'App\Http\Controllers\PaymentController@create')->name('payments.create')->middleware('auth');
Route::get('payments/getReceiptsByThirdPartyId/{thirdParty}', 'App\Http\Controllers\PaymentController@getReceiptsByThirdPartyId')->name('payments.getReceiptsByThirdPartyId')->middleware('auth');
Route::post('payment/associatePaymentsBills', 'App\Http\Controllers\PaymentController@associatePaymentsBills')->name('payments.associatePaymentsBills')->middleware('auth');

Route::resource('discharges', 'App\Http\Controllers\DischargeController')->middleware('auth');
Route::get('discharges/{discharge}/print', 'App\Http\Controllers\DischargeController@print')->name('discharges.print')->middleware('auth');


Route::resource('companies', 'App\Http\Controllers\CompanyController')->middleware('auth');

Route::resource('programs', 'App\Http\Controllers\ProgramController')->middleware('auth');
Route::post('program/makeProgramCurrent', 'App\Http\Controllers\ProgramController@makeProgramCurrent')->name('programs.isCurrent')->middleware('auth');


Route::get('articles/filter', 'App\Http\Controllers\ArticleController@filter')->name('articles.filter')->middleware('auth');