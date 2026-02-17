<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');



Route::group(['middleware' => ['auth']], function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('users', 'pages.users.index')
        ->name('users.index');
    Route::view('notes', 'pages.notes.index')
        ->name('notes.index');
});

require __DIR__ . '/settings.php';
