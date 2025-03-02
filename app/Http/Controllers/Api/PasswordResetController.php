<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\User\PasswordResetMail;

class PasswordResetController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $newPassword = Str::random(8);

        $user->password = Hash::make($newPassword);
        $user->save();

        Mail::to($user->email)->send(new PasswordResetMail($newPassword,$user->full_name ));

        return response()->json(['message' => 'Новый пароль отправлен на вашу почту.']);
    }
}
