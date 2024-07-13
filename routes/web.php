<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\FileExplorerController;

Route::get('/file-explorer', [FileExplorerController::class, 'index'])->name('file.explorer.index');
Route::post('/file-explorer/upload', [FileExplorerController::class, 'upload'])->name('file.explorer.upload');
Route::post('/file-explorer/create-folder', [FileExplorerController::class, 'createFolder'])->name('file.explorer.createFolder');
Route::get('/file-explorer/folder/{path}', [FileExplorerController::class, 'folder'])->name('file.explorer.folder');
Route::post('/file-explorer/rename', [FileExplorerController::class, 'rename'])->name('file.explorer.rename');
Route::post('/file-explorer/delete', [FileExplorerController::class, 'delete'])->name('file.explorer.delete');


use App\Http\Controllers\FileController;

Route::resource('files', FileController::class);

// ============================================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
