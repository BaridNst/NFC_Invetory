<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Items
    Route::get('/items', [AdminController::class, 'items'])->name('admin.items');
    Route::get('/items/create', [AdminController::class, 'createItem'])->name('admin.items.create');
    Route::post('/items', [AdminController::class, 'storeItem'])->name('admin.items.store');
    Route::delete('/items/{id}', [AdminController::class, 'deleteItem'])->name('admin.items.delete');
    
    // History & Report
    Route::get('/history', [AdminController::class, 'history'])->name('admin.history');
    Route::get('/report', [AdminController::class, 'report'])->name('admin.report');
    
    // Approval
    Route::post('/peminjaman/{id}/approve', [AdminController::class, 'approve'])->name('admin.peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [AdminController::class, 'reject'])->name('admin.peminjaman.reject');
});

// User Routes
Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/tapping', [UserController::class, 'tapping'])->name('user.tapping');
    Route::post('/process-tap', [UserController::class, 'processTap'])->name('user.process-tap');
});
