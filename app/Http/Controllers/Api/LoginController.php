<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Пользователь с таким email не найден.',
                'code' => 404,
                'errors' => ['email' => ['Неверный email.']]
            ]);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Неверный пароль.',
                'code' => 400,
                'errors' => ['password' => ['Неверный пароль.']]
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'code' => 200,
            'message' => 'Вход выполнен успешно',
            'token' => $token,
        ], 200);
    }
}
