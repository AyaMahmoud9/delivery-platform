<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    protected UserService $userService;

    protected FirebaseService $firebaseService;

    public function __construct(
        UserService $userService,
        FirebaseService $firebaseService
    ) {
        $this->userService = $userService;
        $this->firebaseService = $firebaseService;
    }

    public function send(): RedirectResponse
    {
        $users = $this->userService->getUsersWithFcmTokens();

        $this->firebaseService->sendNotificationToUsers(
            $users,
            'Delivery Platform',
            'Welcome to our Delivery Platform!'
        );

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Notification sent successfully.');
    }
}
