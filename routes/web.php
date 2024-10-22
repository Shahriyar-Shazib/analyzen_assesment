<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('user')->group(function(){
        Route::get('/user-list', [UserController::class, 'userList'])->name("user.list");
        Route::get('/user-create', [UserController::class, 'userCreate'])->name("user.create");
        Route::post('/user-save', [UserController::class, 'userSave'])->name("user.save");
        Route::post('/user-edit', [UserController::class, 'userEdit'])->name("user.edit");
        Route::get('/user-delete/{id}', [UserController::class, 'userDelete'])->name("user.delete");
        Route::get('/deleted-user-list', [UserController::class, 'deletedUserList'])->name("deleted.user.list");
        Route::get('/restore-user/{id}', [UserController::class, 'restoreUser'])->name("restore.user");
        Route::get('/user/force-delete/{id}', [UserController::class, 'userForceDelete'])->name('user.forceDelete');
    });
});

require __DIR__.'/auth.php';
