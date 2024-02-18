<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect('/login');
});

// Auth Logic
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/dashboard/approved', [DashboardController::class, 'approved'])->name('approved');
    Route::get('/dashboard/pending', [DashboardController::class, 'pending'])->name('pending');
    Route::get('/dashboard/rejected', [DashboardController::class, 'rejected'])->name('rejected');


    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/requests', [DashboardController::class, 'store'])->name('requests.store');
    
    Route::PUT('/requests/{id}/approve', [DashboardController::class, 'approve']);
    Route::PUT('/requests/{id}/reject', [DashboardController::class, 'reject']);
    
    
    Route::get('/materials/{id}', [DashboardController::class, 'show']);
    
    Route::delete('/items/{id}', [DashboardController::class, 'destroy']);
    
    Route::post('/update-materials', [DashboardController::class, 'update']);

    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

});



