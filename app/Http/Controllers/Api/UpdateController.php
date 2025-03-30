<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        // Валидация входящих данных
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'required|string|max:20',
            'child_name' => 'required|string|max:100',
            'child_age' => 'required|integer|min:1|max:18',
            'child_status' => 'required|string|max:50',
            'child_pmpk_code' => 'required|string|max:100',
            'current_password' => 'required|string|min:6',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);
        if ($request->filled('new_password')) {
            if ($request->new_password !== $request->new_password_confirmation) {
                return response()->json([
                    'message' => 'Пароли не совпадают.',
                    'code' => 400
                ]);
            }
            $user->password = Hash::make($request->new_password);
        }
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'code' => 422,
                'errors' => $validator->errors()
            ]);
        }
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Текущий пароль введён неверно.',
                'code' => 400
            ]);
        }
        
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);
        if ($user->child) {
            $user->child->update([
                'name' => $request->child_name,
                'age' => $request->child_age,
                'status' => $request->child_status,
                'pmpk_code' => $request->child_pmpk_code,
            ]);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Данные успешно обновлены.',
        ]);
    }
}
