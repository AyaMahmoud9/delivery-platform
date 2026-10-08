<?php

namespace App\Listeners;

use App\Events\UserRegistrationVerified;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;

class SendRegistrationNotification
{
    protected FirebaseService $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function handle(UserRegistrationVerified $event): void
    {
        $user = $event->user;

        if ($user->fcm_token) {
            $this->firebaseService->sendNotification(
            $user->fcm_token,
            'Welcome!',
            "Welcome {$user->username}! Your account has been successfully verified."
        );
        }

        Log::info('User registration verification notification processed.', [
            'user_id' => $user->id,
            'mobile' => $user->mobile,
        ]);
    }
}