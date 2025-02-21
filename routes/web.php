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
Route::group(['prefix' => 'match'], function () {
    Route::get('/', [MatchController::class, 'index']) -> name ('match.index');
    Route::post('/', [MatchController::class, 'store']) -> name ('match.store');
});

// Rota para a tela de usuários
Route::group(['prefix' => 'users'], function () {
    Route::get('/',                [UserController::class,   'index'])->name('users.index');
    Route::get('/profile',         [UserController::class, 'profile'])->name('users.profile');
    Route::post('{user_id}/update',[UserController::class,  'update'])->name('users.update');
});

// Rota para a tela de características
Route::group(['prefix' => 'characteristics'], function () {
    Route::get('/',         [CharacteristicsController::class, 'index'])->name('characteristics.index');
    Route::get('/create',  [CharacteristicsController::class, 'create'])->name('characteristics.create');
    Route::post('/',        [CharacteristicsController::class, 'store'])->name('characteristics.store');
});

// Rota para a tela de opções
Route::group(['prefix' => 'options'], function () {
    Route::get('/',                    [OptionController::class,  'index'])->name(   'options.index');
    Route::get('/create',              [OptionController::class,  'create'])->name( 'options.create');
    Route::get('{option}/edit', [OptionController::class, 'edit'])->name('options.edit');
    Route::post('{option_id}/destroy',  [OptionController::class, 'destroy'])->name('options.destroy');
    Route::post('/',                   [OptionController::class,   'store'])->name(  'options.store');
});

// Rota para a tela de I_am
Route::get('/i_am',         [I_amController::class, 'profile'])->name('i_am.profile');
Route::post('{user_id}/i_am_update',[I_amController::class,  'update'])->name('i_am.update');

// Rota para a tela de I_seek
Route::get('/i_seek',         [I_seekController::class, 'profile'])->name('i_seek.profile');
Route::post('{user_id}/i_seek_update',[I_seekController::class,  'update'])->name('i_seek.update');

Route::get('/dashboard',      [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::get('/teste',         [TesteController::class, 'index'])->name('teste.index');

});