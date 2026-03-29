<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ResonanceController;
use App\Http\Controllers\MonologueController; 
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| IORI: 2026-03-29 統合ルート
|--------------------------------------------------------------------------
| 
| 1. DashboardをMonologueControllerに接続し、データをVueに渡すように変更。
| 2. Monologueの保存(store)と削除(destroy)を認証済みグループに集約。
|
*/

// 1. HOME: 綴る・辿る・Admin一覧
// Dashboardを開いた際に、投稿リストを一緒に読み込みます
Route::get('/dashboard', [MonologueController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 2. SELECT: どの眼差しで、辿りますか？
Route::get('/explore', function () {
    return Inertia::render('Explore');
})->middleware(['auth'])->name('explore');

// 3. MAP: 視座の同期（漆黒の地図）
Route::get('/resonance/show/{id?}', [ResonanceController::class, 'show'])
    ->middleware(['auth'])
    ->name('resonance.show');

// --- 認証が必要なデータ操作 ---
Route::middleware('auth')->group(function () {
    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // ジャーナル（対話）関連
    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::post('/journal/chat', [JournalController::class, 'chat'])->name('journal.chat');

    // 🌟 Monologue（綴る・管理）関連
    // 保存処理
    Route::post('/monologues', [MonologueController::class, 'store'])->name('monologues.store');
    // 削除処理
    Route::delete('/monologues/{monologue}', [MonologueController::class, 'destroy'])->name('monologues.destroy');
});

require __DIR__.'/auth.php';