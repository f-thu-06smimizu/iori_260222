<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LocationController; // 1つにまとめました
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 初期画面
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボード（認証済みユーザー用）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール・ログ機能（ログインが必要な機能）
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('logs', LogController::class);
});

// --- IORI 聖地探査セクション ---

// 探査画面の表示
Route::get('/iori', function () {
    return view('iori.index');
});

// 現在地と聖地の距離計算（API通信用）
Route::post('/check-distance', [LocationController::class, 'check']);

// 認証関連のルート読み込み
require __DIR__.'/auth.php';