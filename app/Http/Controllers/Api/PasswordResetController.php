<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\User\PasswordResetMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PasswordResetController extends Controller
{
    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'Пользователь с таким email не найден.',
                'code' => 404
            ]);
        }
        $code = rand(100000, 999999);
        $name = $user->name;
        Cache::put('password_reset_' . $user->email, $code, now()->addMinutes(10));
        Mail::to($user->email)->send(new PasswordResetMail($code, $name));
        return response()->json([
            'message' => 'Код для сброса пароля отправлен на вашу почту.',
            'code' => 200,
            'reset_code' => $code
        ]);
    }

    public function verifyResetCode(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'code' => 'required|digits:6',
            ]);

            $cachedCode = Cache::get('password_reset_' . $request->email);
            if (!$cachedCode || $cachedCode != $request->code) {
                return response()->json([
                    'message' => 'Неверный или устаревший код.',
                    'code' => 400
                ]);
            }
            return response()->json([
                'message' => 'Код подтвержден, введите новый пароль.',
                'code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка, попробуйте позже.',
                'code' => 500
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'code' => 'required|digits:6',
                'password' => 'required|string|min:6',
            ]);
            $cachedCode = Cache::get('password_reset_' . $request->email);
            if (!$cachedCode || $cachedCode != $request->code) {
                return response()->json([
                    'message' => 'Неверный или устаревший код.',
                    'code' => 400
                ]);
            }
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            Cache::forget('password_reset_' . $request->email);
            return response()->json([
                'message' => 'Пароль успешно изменен.',
                'code' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Пользователь с таким email не найден.',
                'code' => 404
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка, попробуйте позже.',
                'code' => 500
            ]);
        }
    }
}
