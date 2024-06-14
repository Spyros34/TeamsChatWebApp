<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/load', [UserController::class, 'loadUsers'])->name('users.load');
Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
Route::post('/chats/show', [ChatController::class, 'showChats'])->name('chats.show');