<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\LessonProgress;

class LessonController extends Controller
{
    // Получение доступных уроков
    public function getAvailableLessons(Request $request)
    {
        $user = $request->user();
        
        // Доступные уроки - по времени и порядку
        $availableLessons = Lesson::where('available_at', '<=', now())
            ->orderBy('order')
            ->get();

        return response()->json(['available_lessons' => $availableLessons]);
    }

    // Получение пройденных уроков
    public function getCompletedLessons(Request $request)
    {
        $user = $request->user();

        $completedLessons = Lesson::whereIn(
            'id',
            LessonProgress::where('user_id', $user->id)->where('completed', true)->pluck('lesson_id')
        )->get();

        return response()->json(['completed_lessons' => $completedLessons]);
    }

    // Отметить урок как пройденный
    public function completeLesson(Request $request, $lessonId)
    {
        $user = $request->user();
        $lesson = Lesson::findOrFail($lessonId);

        // Проверяем, доступен ли урок
        if ($lesson->available_at > now()) {
            return response()->json([
                'message' => sprintf('Урок %d пока недоступен', $lessonId),
                'status' => 'lesson_not_available', // Маркер для фронтенда
            ], 403);
        }

        // Отмечаем урок как пройденный
        LessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lessonId],
            ['completed' => true]
        );

        // Ответ с маркером
        return response()->json([
            'message' => sprintf('Урок %d пройден', $lessonId),
            'status' => 'lesson_completed', // Маркер для фронтенда
        ]);
    }
}