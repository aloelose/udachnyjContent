<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\User\PasswordMail;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json([
                'message' => 'Invalid verification link.',
                'code' => 403
            ], 403);
        }
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified.',
                'code' => 200
            ], 200);
        }
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            $password = Str::random(8);
            $user->update(['password' => Hash::make($password)]);
            $name = $user->name;
            Mail::to($user->email)->send(new PasswordMail($password, $name));
        }
        return response()->json([
            'message' => 'Email verified successfully.',
            'code' => 200
        ], 200);
    }

    public function resend(Request $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified.',
                'code' => 200
            ], 200);
        }
        $user->sendEmailVerificationNotification();
        return response()->json([
            'message' => 'Verification email resent.',
            'code' => 200
        ], 200);
    }
}
