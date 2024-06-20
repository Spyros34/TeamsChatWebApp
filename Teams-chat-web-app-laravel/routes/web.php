<?php

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;


Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/load-users', [UserController::class, 'fetchAndStoreUsers'])->name('load.users');

Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
Route::get('/load-chats', [ChatController::class, 'generateChats'])->name('load.chats');