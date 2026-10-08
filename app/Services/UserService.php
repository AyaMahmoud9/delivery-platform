<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getProfile(User $user): User
    {
        return $user;
    }

    public function getUsers()
    {
        return $this->userRepository->getUsers();
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->createUser($data);
    }

    public function updateUser(User $user, array $data): User
    {
        return $this->userRepository->updateUser($user, $data);
    }

    public function deleteUser(User $user): bool
    {
        return $this->userRepository->deleteUser($user);
    }

    public function getUsersWithFcmTokens()
    {
        return $this->userRepository->getUsersWithFcmTokens();
    }

    public function getDashboardCounts(): array
    {
        return [
            'users' => $this->userRepository->countUsers(),
            'delivery' => $this->userRepository->countDeliveryRepresentatives(),
            'admins' => $this->userRepository->countAdmins(),
        ];
    }

    
}