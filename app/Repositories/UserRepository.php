<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(array $data): User
    {
        return User::create($data);
    }
    public function findByMobile(string $mobile): ?User
    {
        return User::where('mobile', $mobile)->first();
    }
    public function findById(int $id): ?User
    {
        return User::find($id);
    }
    public function getUsers()
    {
        return User::all();
    }
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }
    public function deleteUser(User $user): bool
    {
        return $user->delete();
    }
    public function getDeliveryRepresentatives()
    {
        return User::where('type', 'delivery')->get();
    }
    public function countUsers(): int
    {
        return User::where('type', 'user')->count();
    }

    public function countDeliveryRepresentatives(): int
    {
        return User::where('type', 'delivery')->count();
    }

    public function countAdmins(): int
    {
        return User::where('type', 'admin')->count();
    }

    public function getUsersWithFcmTokens()
    {
        return User::whereNotNull('fcm_token')
            ->where('fcm_token', '!=', '')
            ->get();
    }
    
}