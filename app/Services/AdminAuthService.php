<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminAuthService
{
    public function login(string $mobile, string $password): bool
    {
        return Auth::guard('web')->attempt([
            'mobile' => $mobile,
            'password' => $password,
            'type' => 'admin',
        ]);
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();
    }

    public function isAdmin(): bool
    {
        $user = Auth::guard('web')->user();

        return $user instanceof User && $user->type === 'admin';
    }
}