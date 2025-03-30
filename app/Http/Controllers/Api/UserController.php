<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Child;

class UserController extends Controller
{
    public function getUser()
    {
        return response()->json(Auth::user());
    }

    public function getChild()
    {
        $user = Auth::user();
        $child = Child::where('user_id', $user->id)->first();

        if (!$child) {
            return response()->json([
                'message' => 'Ребенок не найден.',
            ], 404);
        }

        return response()->json($child);
    }
    public function getInfo()
    {
        $user = Auth::user();
        $child = Child::where('user_id', $user->id)->first();
        $info = [
            'user' => $user,
            'child' => $child ? $child : null,
        ];
        return response()->json($info);
    }

}
