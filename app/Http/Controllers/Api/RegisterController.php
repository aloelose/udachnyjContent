<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\PasswordMail;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'full_name' => 'required|string|max:100',
            'email' => 'required|string|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'educational_organization' => 'nullable|string|max:255',
    
            // Данные ребенка
            'child_full_name' => 'required|string|max:100',
            'child_age' => 'required|integer|min:1|max:18',
            'child_gender' => 'required|in:М,Ж',
            'child_status' => 'required|in:Ребёнок-инвалид,Ребёнок с ОВЗ',
            'child_pmpk_code' => 'nullable|string|max:50',
        ]);
    
        if ($validator->fails()) {
            $errors = $validator->errors();
        
            if ($errors->has('email')) {
                return response()->json([
                    'message' => 'Пользователь с таким email уже существует.',
                    'errors' => $errors
                ], 400);
            }
        
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $errors
            ], 422);
        }
    
        // Генерация случайного пароля
        $password = Str::random(8);
    
        // Создание нового пользователя
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'phone_number' => $request->phone_number,
            'educational_organization' => $request->educational_organization,
        ]);
    
        // Создание ребенка
        $child = Child::create([
            'user_id' => $user->id,
            'full_name' => $request->child_full_name,
            'age' => $request->child_age,
            'gender' => $request->child_gender,
            'status' => $request->child_status,
            'pmpk_code' => $request->child_pmpk_code,
        ]);
    
        // Отправка письма с паролем
        Mail::to($user->email)->send(new PasswordMail($password, $user->full_name, $child->full_name));
    
        // Создание токена для аутентификации
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Пользователь и ребенок успешно зарегистрированы. Проверьте ваш email для получения пароля.',
            'token' => $token,
        ], 201);
    }    
}
