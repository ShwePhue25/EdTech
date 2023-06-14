<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\GoogleAuthController;

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

/**create google meeting */
Route::get('/auth/google', [GoogleAuthController::class,'redirectToGoogle'])->name('google.auth');
Route::get('/auth/google/callback', [GoogleAuthController::class,'handleGoogleCallback']);
Route::get('/meeting/create', [MeetingController::class,'create'])->name('meeting.create');
Route::get('/meeting', function(){
    return view('meeting');
})->name('view-meeting');
//Route::post('google/event', [MeetingController::class,'createEvent']);

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Google Social Login */
// Route::get('auth/google', [GoogleController::class,'redirect'])->name('google.auth');
// Route::get('auth/google/callback', [GoogleController::class,'callback']);

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/auth/google', [GoogleAuthController::class,'redirectToGoogle'])->name('google.auth');
// Route::get('/auth/google/callback', [GoogleAuthController::class,'handleGoogleCallback']);
// Route::get('/create-meeting', [MeetingController::class,'create'])->name('meeting.create');
