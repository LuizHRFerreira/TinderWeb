<?php

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CharacteristicsController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\I_amController;
use App\Http\Controllers\I_seekController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TesteController;

// Rota para a tela inicial
Route::get('/', function () {return view('welcome');});

// Rota para a tela de login
Route::middleware([AuthMiddleware::class,])->group(function () {

// Verifica se o usuário está autenticado e se a sessão está ativa
Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

// Rota para a tela match
Route::get('/match', [MatchController::class, 'index']) -> name ('match.index');
Route::post('/match', [MatchController::class, 'store']) -> name ('match.store');

// Rota para a tela de usuários
Route::group(['prefix' => 'users'], function () {
Route::get('/',                [UserController::class,   'index'])->name('users.index');
Route::get('/profile',         [UserController::class, 'profile'])->name('users.profile');
Route::post('{user_id}/update',[UserController::class,  'update'])->name('users.update');});

// Rota para a tela de características
Route::get('/characteristics',         [CharacteristicsController::class, 'index'])->name('characteristics.index');
Route::get('/characteristics/create',  [CharacteristicsController::class, 'create'])->name('characteristics.create');
Route::post('/characteristics',        [CharacteristicsController::class, 'store'])->name('characteristics.store');

// Rota para a tela de opções
Route::get('/options',         [OptionController::class, 'index'])->name('options.index');
Route::get('/options/create',  [OptionController::class, 'create'])->name('options.create');
Route::post('/options',        [OptionController::class, 'store'])->name('options.store');

// Rota para a tela de I_am
Route::get('/i_am',         [I_amController::class, 'profile'])->name('i_am.profile');
Route::post('{user_id}/i_am_update',[I_amController::class,  'update'])->name('i_am.update');

// Rota para a tela de I_seek
Route::get('/i_seek',         [I_seekController::class, 'profile'])->name('i_seek.profile');
Route::post('{user_id}/i_seek_update',[I_seekController::class,  'update'])->name('i_seek.update');

Route::get('/dashboard',      [DashboardController::class, 'index'])->name('dashboard.index');
});});