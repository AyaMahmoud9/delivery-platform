<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseService
{
    protected Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendNotification(
        string $fcmToken,
        string $title,
        string $message
    ): void {
        try {
            $notification = Notification::create($title, $message);

            $cloudMessage = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification);

            $this->messaging->send($cloudMessage);

            Log::info('Firebase notification sent successfully.', [
                'title' => $title,
                'message' => $message,
            ]);
        } catch (\Throwable $exception) {
            Log::error('Firebase notification failed.', [
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function sendNotificationToUsers(
        iterable $users,
        string $title,
        string $message
    ): void {
        foreach ($users as $user) {
            if ($user->fcm_token) {
                $this->sendNotification(
                    $user->fcm_token,
                    $title,
                    $message
                );
            }
        }
    }
}

