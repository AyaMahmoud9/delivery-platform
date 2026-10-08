<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class DeliveryService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getNearestDeliveries(User $user)
    {
        $deliveries = $this->userRepository->getDeliveryRepresentatives();

        return $deliveries
            ->map(function ($delivery) use ($user) {
                $distance = $this->calculateDistance(
                    $user->latitude,
                    $user->longitude,
                    $delivery->latitude,
                    $delivery->longitude
                );

                return [
                    'username' => $delivery->username,
                    'distance' => round($distance, 2),
                ];
            })
            ->sortBy('distance')
            ->values();
    }

    private function calculateDistance(
        float $latitude1,
        float $longitude1,
        float $latitude2,
        float $longitude2
    ): float {
        $earthRadius = 6371;

        $latitudeDifference = deg2rad($latitude2 - $latitude1);
        $longitudeDifference = deg2rad($longitude2 - $longitude1);

        $a = sin($latitudeDifference / 2) ** 2
            + cos(deg2rad($latitude1))
            * cos(deg2rad($latitude2))
            * sin($longitudeDifference / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}