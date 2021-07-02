<?php

use App\Http\Controllers\Api\ImagesController;
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

Route::view('/', 'images');

Route::post('images', [ImagesController::class, 'store']);
Route::get('images', [ImagesController::class, 'index']);
Route::delete('images/{index}', [ImagesController::class, 'destroy']);
