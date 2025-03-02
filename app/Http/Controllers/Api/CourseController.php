<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        return response()->json(Course::all());
    }

    public function show($id)
    {
        return response()->json(Course::with('lessons')->findOrFail($id));
    }
}