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




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
