<?php

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CharacteristicsController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\I_amController;

Route::get('/', function () {return view('welcome');});

Route::middleware([AuthMiddleware::class,])->group(function () {

Route::group(['prefix' => 'users'], function () {
Route::get('/',                [UserController::class,   'index'])->name('users.index');
Route::get('/profile',         [UserController::class, 'profile'])->name('users.profile');
Route::post('{user_id}/update',[UserController::class,  'update'])->name('users.update');});

Route::get('/characteristics',         [CharacteristicsController::class, 'index'])->name('characteristics.index');
Route::get('/characteristics/create',  [CharacteristicsController::class, 'create'])->name('characteristics.create');
Route::post('/characteristics',        [CharacteristicsController::class, 'store'])->name('characteristics.store');

Route::get('/options',         [OptionController::class, 'index'])->name('options.index');
Route::get('/options/create',  [OptionController::class, 'create'])->name('options.create');
Route::post('/options',        [OptionController::class, 'store'])->name('options.store');

Route::get('/i_am',         [I_amController::class, 'profile'])->name('i_am.profile');
Route::post('{user_id}/i_am_update',[I_amController::class,  'update'])->name('i_am.update');});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

Route::get('/match', [MatchController::class, 'index']) -> name ('match.index');

;

});