<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponseTrait;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile(Request $request)
    {
        $user = $this->userService->getProfile(
            $request->user()
        );

        return $this->successResponse(
            'Profile retrieved successfully.',
            [
                'id' => $user->id,
                'username' => $user->username,
                'mobile' => $user->mobile,
                'type' => $user->type,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'profile_image' => $user->profile_image,
                'mobile_verified' => !is_null($user->mobile_verified_at),
            ]
        );
    }
}