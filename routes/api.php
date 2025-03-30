<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\UpdateController;
use App\Http\Controllers\Auth\EmailVerificationController;



Route::post('/register', RegisterController::class); // Зарегистрировать пользователеля
Route::post('/login', LoginController::class); // Войти

Route::post('/password/forgot', [PasswordResetController::class, 'sendResetCode']); // Получение кода для сброса
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyResetCode']); // Подтверждение кода
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']); // ОБновить пароль

// Маршрут для обработки подтверждения
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

// Маршрут для повторной отправки ссылки подтверждения
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
    ->middleware(['throttle:6,1'])
    ->name('verification.resend');
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('/logout', LogoutController::class); // Выйти

    Route::get('/user', [UserController::class, 'getUser']); //Получить инфу о пользователе
    Route::get('/user/child', [UserController::class, 'getChild']); //Получить инфу о ребенка
    Route::get('/info', [UserController::class, 'getInfo']); //Получить общую инфу
    Route::put('/user/update', UpdateController::class); // Обновить данные пользователя
    Route::get('/courses', [CourseController::class, 'index']); //Получить инфу о курсах
    Route::get('/courses/{id}', [CourseController::class, 'show']); //Получить инфу об  определенном курсе
    Route::get('/lessons/available', [LessonController::class, 'getAvailableLessons']); //Получить доступные уроки
    Route::get('/lessons/completed', [LessonController::class, 'getCompletedLessons']); //Получить пройденные уроки
    Route::get('/lessons/all', [LessonController::class, 'getAllLessons']); // Получить все уроки
    Route::post('/lessons/{lesson}/complete', [LessonController::class, 'completeLesson']); //Сделать урок пройденным
});
