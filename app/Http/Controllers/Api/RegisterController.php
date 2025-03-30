<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use App\Mail\User\PasswordMail;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'child_name' => 'required|string|max:100',
            'child_age' => 'required|integer|min:1|max:18',
            'child_status' => 'required|string|max:50',
            'child_pmpk_code' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email')) {
                return response()->json([
                    'message' => 'Пользователь с таким email уже существует.',
                    'code' => 400,
                    'errors' => $errors
                ]);
            }
            return response()->json([
                'message' => 'Ошибка валидации',
                'code' => 402,
                'errors' => $errors
            ]);
        }
        $password = Str::random(8);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => encrypt($password),
            'phone_number' => $request->phone_number,
        ]);
        $child = Child::create([
            'user_id' => $user->id,
            'name' => $request->child_name,
            'age' => $request->child_age,
            'status' => $request->child_status,
            'pmpk_code' => $request->child_pmpk_code,
        ]);

        event(new Registered($user));

        return response()->json([
            'code' => 201,
            'message' => 'Пользователь создан, подтверьте свою почту',
        ]);
    }
}
