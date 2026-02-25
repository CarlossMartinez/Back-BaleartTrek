<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Trek;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TrekController;
use App\Http\Controllers\Api\MeetingController;  
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\AuthController;

// login Frontend
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Treks públicos (el frontend los necesita sin login)
Route::get('/treks', [TrekController::class, 'index']);
Route::get('/treks/destacados', [TrekController::class, 'destacados']); 
Route::get('/treks/{trekShow}', [TrekController::class, 'show']);       
Route::get('/treks/{id}/meetings', [MeetingController::class, 'FporTrek']); 
Route::get('/meetings/{id}', [MeetingController::class, 'show']);          

Route::get('/islands', [TrekController::class, 'islands']); 
Route::get('/zones', [TrekController::class, 'zones']);    

Route::bind('trekShow', function ($value) {
    return is_numeric($value)
        ? Trek::with(['interestingPlaces.placeType', 'municipality.island', 'municipality.zone', 'meetings'])->findOrFail($value)
        : Trek::with(['interestingPlaces.placeType', 'municipality.island', 'municipality.zone', 'meetings'])->where('regNumber', $value)->firstOrFail();
});

// RUTAS PRIVADAS (con login)
Route::middleware('MULTI-AUTH')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Usuario
    Route::get('/user', [UserController::class, 'me']);           // ← nueva, devuelve el usuario logueado
    Route::put('/user', [UserController::class, 'update']);       // ← editar perfil propio
    Route::put('/user/password', [UserController::class, 'updatePassword']); // ← nueva

    Route::get('/user/{userShow}', [UserController::class, 'show']);
    Route::bind('userShow', function ($value) {
        return is_numeric($value)
            ? User::with(['meeting', 'meetings', 'comments.images'])->findOrFail($value)
            : User::with(['meeting', 'meetings', 'comments.images'])->where('email', $value)->firstOrFail();
    });

    Route::put('/user/{userUpdateDestroy}', [UserController::class, 'update']);
    Route::patch('/user/{userUpdateDestroy}', [UserController::class, 'update']);
    Route::delete('/user/{userUpdateDestroy}', [UserController::class, 'destroy']);
    Route::bind('userUpdateDestroy', function ($value) {
        return is_numeric($value)
            ? User::findOrFail($value)
            : User::where('email', $value)->firstOrFail();
    });

    // Meetings del usuario logueado
    Route::get('/user/meetings', [MeetingController::class, 'misMeetings']); // ← nueva

    // Inscripciones
    Route::post('/meetings/{id}/inscribirse', [MeetingController::class, 'inscribirse']);       // ← nueva
    Route::delete('/meetings/{id}/desinscribirse', [MeetingController::class, 'desinscribirse']); // ← nueva

    // Comentarios
    Route::post('/meetings/{id}/comentarios', [MeetingController::class, 'addComment']); // ← nueva

    // Admin
    Route::middleware('CHECK-ROLEADMIN')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/trek', [TrekController::class, 'store']);
    });
});