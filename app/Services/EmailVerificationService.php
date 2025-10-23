<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationService
{

    public function generateVerificationToken(User $user): string
    {
        $token = Str::random(64);

        cache()->put("email_verification_{$user->id}", $token, now()->addHours(24));

        return $token;
    }


    public function sendVerificationEmail(User $user): bool
    {
        try {
            $token = $this->generateVerificationToken($user);
            $verificationUrl = route('email.verify', [
                'id' => $user->id,
                'token' => $token
            ]);

            Mail::send('emails.verification', [
                'user' => $user,
                'verificationUrl' => $verificationUrl,
                'token' => $token
            ], function ($message) use ($user) {
                $message->to($user->email, $user->full_name)
                        ->subject('Xác thực tài khoản - Vegetable Store');
            });

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email: ' . $e->getMessage());
            return false;
        }
    }


    public function verifyEmail(int $userId, string $token): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        if ($user->email_verified_at) {
            return true;
        }

        $storedToken = cache()->get("email_verification_{$userId}");

        if (!$storedToken || $storedToken !== $token) {
            return false;
        }

        $user->email_verified_at = now();
        $user->save();

        cache()->forget("email_verification_{$userId}");

        return true;
    }

    public function resendVerificationEmail(User $user): bool
    {
        if ($user->email_verified_at) {
            return false;
        }

        return $this->sendVerificationEmail($user);
    }

    public function isEmailVerified(User $user): bool
    {
        return !is_null($user->email_verified_at);
    }
}

