<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [\App\Http\Controllers\UsersController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\UsersController::class, 'login']);

Route::get('/event', [\App\Http\Controllers\EventsController::class, 'index']);
Route::get('/event/{event}', [\App\Http\Controllers\EventsController::class, 'show']);
Route::post('/event', [\App\Http\Controllers\EventsController::class, 'store'])
    ->middleware('admin.token');
Route::post('/event/update/{event}', [\App\Http\Controllers\EventsController::class, 'update'])
    ->middleware('admin.token');
Route::post('/event/delete/{id}', [\App\Http\Controllers\EventsController::class, 'destroy'])
    ->middleware('admin.token');

Route::post('/event/join', [\App\Http\Controllers\EventsController::class, 'join'])
    ->middleware('token');
Route::get('/event/user/{id}', [\App\Http\Controllers\EventsController::class, 'users'])
    ->middleware('admin.token');
Route::get('/event/member/{id}', [\App\Http\Controllers\UsersController::class, 'events'])
    ->middleware('token');
