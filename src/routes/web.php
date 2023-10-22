<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampingController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\AttendanceListController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LogoutController;

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

Route::get('/login', [AuthenticatedSessionController::class, 'index'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'destroy'])->middleware('auth');

Route::prefix('register')->name('verification.')->group (function() {
    Route::get('', [RegisteredUserController::class, 'index']);
    Route::post('', [RegisteredUserController::class, 'register']);
    Route::get('/verify', [RegisteredUserController::class, 'notice'])->name('notice');
    Route::post('/send', [RegisteredUserController::class, 'send'])
        ->middleware('throttle:6,1')->name('send');
    Route::get('/verification/{id}/{hash}', [RegisteredUserController::class, 'verification'])
        ->middleware(['signed', 'throttle:6,1'])->name('verify');
});

Route::get('/', [StampingController::class, 'index'])->middleware(['web', 'verified', 'auth']);
Route::post('/clockin', [StampingController::class, 'clockIn']);
Route::post('/clockout', [StampingController::class, 'clockOut']);
Route::post('/breakstart', [StampingController::class, 'breakStart']);
Route::post('/breakend', [StampingController::class, 'breakEnd']);

Route::prefix('attendance')->group (function() {
    Route::get('', [AttendanceListController::class, 'index']);
    Route::get('/before', [AttendanceListController::class, 'back']);
    Route::get('/after', [AttendanceListController::class, 'advance']);
    Route::get('/search', [AttendanceListController::class, 'search']);
    Route::get('/userlist', [AttendanceListController::class, 'userList']);
    Route::post('/personal', [AttendanceListController::class, 'personal']);
    Route::get('/personaltable', [AttendanceListController::class, 'personalTable']);
    Route::get('/usersearch', [AttendanceListController::class, 'userSearch']);
});
