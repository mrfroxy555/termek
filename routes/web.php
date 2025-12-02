<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatisztikakController;
use App\Http\Controllers\TermekController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;


// Publikus útvonalak
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Védett útvonalak
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Főoldal és adatok megtekintése
    Route::get('/', [TermekController::class, 'index'])->name('termekek.index');
    Route::get('/adatok', [TermekController::class, 'adatok'])->name('termekek.adatok');
    Route::get('/show', [TermekController::class, 'showList'])->name('termekek.show-list');
    Route::get('/show/{id}', [TermekController::class, 'show'])->name('termekek.show');
    
    // Statisztikák - mindenki láthatja
    Route::get('/statisztikak', [StatisztikakController::class, 'index'])->name('statisztikak.index');
    
    // Szerkesztési jogok
    Route::middleware(['editor'])->group(function () {
        Route::get('/create', [TermekController::class, 'create'])->name('termekek.create');
        Route::post('/store', [TermekController::class, 'store'])->name('termekek.store');
        Route::get('/edit', [TermekController::class, 'edit'])->name('termekek.edit');
        Route::get('/edit/{id}', [TermekController::class, 'editForm'])->name('termekek.edit-form');
        Route::put('/update/{id}', [TermekController::class, 'update'])->name('termekek.update');
        Route::get('/delete', [TermekController::class, 'deleteList'])->name('termekek.delete');
        Route::delete('/destroy/{id}', [TermekController::class, 'destroy'])->name('termekek.destroy');
    });
    
    // Admin panel
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::put('/users/{id}/role', [AdminController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });

    Route::get('/export', [PdfController::class, 'exportPage'])->name('export.page');
    Route::get('/export/all', [PdfController::class, 'exportAll'])->name('export.all');
    Route::post('/export/selected', [PdfController::class, 'exportSelected'])->name('export.selected');
    Route::get('/export/statistics', [PdfController::class, 'exportStatistics'])->name('export.statistics');
    Route::get('/export/single/{id}', [PdfController::class, 'exportSingle'])->name('export.single');
});