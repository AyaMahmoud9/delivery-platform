<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $client;

    protected string $verificationSid;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.account_sid'),
            config('services.twilio.auth_token')
        );

        $this->verificationSid = config('services.twilio.verification_sid');
    }

    public function sendVerificationCode(string $mobile): void
    {
        $this->client
            ->verify
            ->v2
            ->services($this->verificationSid)
            ->verifications
            ->create($mobile, 'sms');
    }

    public function verifyCode(string $mobile, string $code): bool
    {
        $verification = $this->client
            ->verify
            ->v2
            ->services($this->verificationSid)
            ->verificationChecks
            ->create([
                'to' => $mobile,
                'code' => $code,
            ]);

        return $verification->status === 'approved';
    }
}