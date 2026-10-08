<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Services\AuthService;
use App\Traits\ImageUploadTrait;

class AuthController extends Controller
{
    
    use ImageUploadTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['type'] = 'user';

        if ($request->hasFile('profile_image')) {
            $imagePaths = $this->uploadProfileImage(
                $request->file('profile_image')
            );

            $data = array_merge($data, $imagePaths);
        }

        $user = $this->authService->register($data);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful.',
            'data' => $user,
        ], 201);
    }

    public function verifyMobile(VerifyCodeRequest $request)
    {
        $verified = $this->authService->verifyMobile(
            $request->mobile,
            $request->code
        );

        if (!$verified) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified successfully.',
        ]);
    }
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->mobile,
            $request->password
        );

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], $result['status']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $result['token'],
            ],
        ]);
    }
}