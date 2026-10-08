<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\TwilioService;
use App\Events\UserRegistrationVerified;

class AuthService
{
    protected UserRepository $userRepository;

    protected TwilioService $twilioService;

    public function __construct(
        UserRepository $userRepository,
        TwilioService $twilioService
    ) {
        $this->userRepository = $userRepository;
        $this->twilioService = $twilioService;
    }

    public function register(array $data)
    {
        $user = $this->userRepository->createUser($data);

        $this->twilioService->sendVerificationCode($user->mobile);

        return $user;
    }

    public function verifyMobile(string $mobile, string $code): bool
    {
        $user = $this->userRepository->findByMobile($mobile);

        if (!$user) {
            return false;
        }

        $verified = $this->twilioService->verifyCode($mobile, $code);

        if (!$verified) {
            return false;
        }

        $user = $this->userRepository->updateUser($user, [
            'mobile_verified_at' => now(),
        ]);

        event(new UserRegistrationVerified($user));

        return true;
    }

    public function login(string $mobile, string $password)
    {
        $user = $this->userRepository->findByMobile($mobile);

        if (!$user) {
            return [
                'success' => false,
                'status' => 401,
                'message' => 'Invalid mobile number or password.',
            ];
        }

        if (!password_verify($password, $user->password)) {
            return [
                'success' => false,
                'status' => 401,
                'message' => 'Invalid mobile number or password.',
            ];
        }

        if (!$user->mobile_verified_at) {
            return [
                'success' => false,
                'status' => 403,
                'message' => 'Mobile number is not verified.',
            ];
        }

        if (
            empty($user->username) ||
            empty($user->mobile) ||
            is_null($user->latitude) ||
            is_null($user->longitude) ||
            empty($user->profile_image)
        ) {
            return [
                'success' => false,
                'status' => 403,
                'message' => 'Profile is incomplete.',
            ];
        }

        $token = JWTAuth::fromUser($user);

        return [
            'success' => true,
            'status' => 200,
            'user' => $user,
            'token' => $token,
        ];
    }
}