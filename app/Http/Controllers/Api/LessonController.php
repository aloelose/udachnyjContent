<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\LessonProgress;

class LessonController extends Controller
{
    public function getAvailableLessons(Request $request)
    {
        $user = $request->user();
        $availableLessons = Lesson::where('available_at', '<=', now())
            ->orderBy('order')
            ->get();
        return response()->json(['available_lessons' => $availableLessons]);
    }
    public function getCompletedLessons(Request $request)
    {
        $user = $request->user();
        $completedLessons = Lesson::whereIn(
            'id',
            LessonProgress::where('user_id', $user->id)->where('completed', true)->pluck('lesson_id')
        )->get();
        return response()->json(['completed_lessons' => $completedLessons]);
    }
    public function completeLesson(Request $request, $lessonId)
    {
        $user = $request->user();
        $lesson = Lesson::findOrFail($lessonId);
        if ($lesson->available_at > now()) {
            return response()->json([
                'message' => sprintf('Урок %d пока недоступен', $lessonId),
                'status' => 'lesson_not_available',
                'code' => 403,
            ]);
        }
        LessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lessonId],
            ['completed' => true]
        );
        return response()->json([
            'code' => 200,
            'message' => sprintf('Урок %d пройден', $lessonId),
            'status' => 'lesson_completed',
        ]);
    }
    public function getAllLessons()
    {
        $lessons = Lesson::orderBy('order')->get();
        return response()->json(['all_lessons' => $lessons]);
    }
}