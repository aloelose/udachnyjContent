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

// Регистрация и аутентификация
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::post('/reset-password', PasswordResetController::class);
});

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUser']); //Получить инфу о пользователе
Route::middleware('auth:sanctum')->get('/user/child', [UserController::class, 'getChild']); //Получить инфу о ребенка

Route::get('/courses', [CourseController::class, 'index']); //Получить инфу о курсах
Route::get('/courses/{id}', [CourseController::class, 'show']); //Получить инфу об  определенном курсе

// Уроки (доступ только авторизованным пользователям)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/lessons/available', [LessonController::class, 'getAvailableLessons']); //Получить доступные уроки
    Route::get('/lessons/completed', [LessonController::class, 'getCompletedLessons']); //Получить пройденные уроки
    Route::post('/lessons/{lesson}/complete', [LessonController::class, 'completeLesson']); //Сделать урок пройденным
});