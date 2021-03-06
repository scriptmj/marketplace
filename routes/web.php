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

Route::get('/', 'App\Http\Controllers\ItemController@home')->name('home');

Route::get('/view/{item}', 'App\Http\Controllers\ItemController@viewItem')->name('item.view');


Route::get('/profile/{user}', 'App\Http\Controllers\UserController@viewProfile')->name('profile.view');
Route::get('/profile/{user}/itemsposted', 'App\Http\Controllers\UserController@viewProfileItemsPosted')->name('profile.itemsposted');
Route::get('/profile/{user}/itemssold', 'App\Http\Controllers\UserController@viewProfileItemsSold')->name('profile.itemssold');


Route::get('/item/create', 'App\Http\Controllers\ItemController@create')->middleware('auth')->name('item.create');
Route::post('/item/create', 'App\Http\Controllers\ItemController@store')->middleware('auth')->name('item.store');

Route::get('/item/{item}/edit', 'App\Http\Controllers\ItemController@edit')->middleware('auth')->name('item.edit');
Route::put('/item/{item}/edit', 'App\Http\Controllers\ItemController@update')->middleware('auth')->name('item.update');

Route::get('/item/{item}/sold', 'App\Http\Controllers\ItemController@sold')->middleware('auth')->name('item.markassold');
Route::put('/item/{item}/sold', 'App\Http\Controllers\ItemController@updateSold')->middleware('auth')->name('item.updatesold');

Route::get('/item/{item}/makebid', 'App\Http\Controllers\ItemController@makebid')->middleware('auth')->name('item.makebid');
Route::post('item/{item}/makebid', 'App\Http\Controllers\ItemController@storebid')->middleware('auth')->name('item.storebid');

Route::get('/user/itemsposted', 'App\Http\Controllers\UserController@viewItemsPosted')->middleware('auth')->name('user.itemsposted');
Route::get('/user/bids', 'App\Http\Controllers\UserController@viewBids')->middleware('auth')->name('user.bids');

Route::get('/user/bids/{offer}', 'App\Http\Controllers\UserController@cancelBid')->middleware('auth')->name('user.cancelbid');
Route::delete('/user/bids/{offer}', 'App\Http\Controllers\UserController@destroyBid')->middleware('auth')->name('user.destroybid');

Route::get('/user/notifications', 'App\Http\Controllers\UserController@notifications')->middleware('auth')->name('user.notifications');

Route::get('/user/{user}/sendmessage/{item?}', 'App\Http\Controllers\UserController@composeMessage')->middleware('auth')->name('user.composemessage');
Route::post('/user/{user}/sendmessage/{item?}', 'App\Http\Controllers\UserController@sendMessage')->middleware('auth')->name('user.sendmessage');
Route::get('/user/messages', 'App\Http\Controllers\UserController@getMessages')->middleware('auth')->name('user.getmessages');
Route::get('/user/messages/{user}', 'App\Http\Controllers\UserController@viewMessage')->middleware('auth')->name('message.view');

Route::post('/category', 'App\Http\Controllers\CategoryController@store')->middleware('auth')->name('category.store');
Route::get('/category/{category}/items', 'App\Http\Controllers\CategoryController@getItemsByCategory')->name('item.bycategory');

Route::post('/distance', 'App\Http\Controllers\ItemController@searchByDistance')->name('item.searchbydistance');
Route::post('/keyword', 'App\Http\Controllers\ItemController@searchByKeyword')->name('item.searchbykeyword');


Route::get('/sendmail/{mail}', 'App\Http\Controllers\MailController@sendMail')->middleware('auth')->name('mail.send');

Route::get('/user/invoices', 'App\Http\Controllers\PaymentController@getInvoices')->middleware('auth')->name('user.invoices');
Route::get('/pay/{invoice}', 'App\Http\Controllers\PaymentController@payInvoice')->middleware('auth')->name('payment.invoice');
Route::post('/pay/{invoice}', 'App\Http\Controllers\PaymentController@storePayment')->middleware('auth')->name('payment.store');
Route::get('/promote/{item}', 'App\Http\Controllers\PaymentController@promote')->middleware('auth')->name('payment.promote');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
