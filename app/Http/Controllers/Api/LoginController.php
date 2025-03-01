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
        // Валидация входных данных
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Если валидация не пройдена, возвращаем ошибку 422
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }

        // Поиск пользователя по email
        $user = User::where('email', $request->email)->first();

        // Если пользователь не найден, возвращаем ошибку
        if (!$user) {
            return response()->json([
                'message' => 'Пользователь с таким email не найден.',
                'errors' => ['email' => ['Неверный email.']]
            ], 401);
        }

        // Если пароль неверный, возвращаем соответствующую ошибку
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Неверный пароль.',
                'errors' => ['password' => ['Неверный пароль.']]
            ], 401);
        }

        // Генерация токена
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Вход выполнен успешно',
            'token' => $token,
        ], 200);
    }
}
