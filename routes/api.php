<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest')
                ->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest')
                ->name('login');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->name('logout');
});
Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/project', [ProjectController::class, 'store']);
Route::get('/project/{project}', [ProjectController::class, 'show']);
Route::put('/project/{project}', [ProjectController::class, 'update']);
Route::delete('/project/{project}', [ProjectController::class, 'destroy']);


// Route::get('/boards', [BoardController::class, 'index']);
Route::post('/board', [BoardController::class, 'store']);
// Route::get('/boards', [BoardController::class, 'index']);
Route::post('/board/{board}', [BoardController::class, 'show']);
Route::put('/board/{board}', [BoardController::class, 'update']);
Route::delete('/board/{board}', [BoardController::class, 'destroy']);

Route::post('/ticket', [TicketController::class, 'store']);
Route::get('/ticket/{ticket}', [TicketController::class, 'show']);
Route::put('/ticket/{ticket}', [TicketController::class, 'update']);
Route::delete('/ticket/{ticket}', [TicketController::class, 'destroy']);


Route::post('/ticket/{ticket}/assign',[TicketController::class, 'assign']);
