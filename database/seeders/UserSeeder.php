<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'Admin',
            'mobile' => '+233200000010',
            'password' => 'Password123!',
            'type' => 'admin',
            'latitude' => 5.6037,
            'longitude' => -0.1870,
            'profile_image' => 'admin.jpg',
            'profile_thumbnail' => 'admin-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        // Normal users
        User::create([
            'username' => 'User 1',
            'mobile' => '+233200000011',
            'password' => 'Password123!',
            'type' => 'user',
            'latitude' => 5.6037,
            'longitude' => -0.1870,
            'profile_image' => 'user-1.jpg',
            'profile_thumbnail' => 'user-1-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        User::create([
            'username' => 'User 2',
            'mobile' => '+233200000012',
            'password' => 'Password123!',
            'type' => 'user',
            'latitude' => 5.5800,
            'longitude' => -0.1700,
            'profile_image' => 'user-2.jpg',
            'profile_thumbnail' => 'user-2-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        User::create([
            'username' => 'User 3',
            'mobile' => '+233200000013',
            'password' => 'Password123!',
            'type' => 'user',
            'latitude' => 5.6200,
            'longitude' => -0.2000,
            'profile_image' => 'user-3.jpg',
            'profile_thumbnail' => 'user-3-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        // Delivery representatives
        User::create([
            'username' => 'Delivery 1',
            'mobile' => '+233200000014',
            'password' => 'Password123!',
            'type' => 'delivery',
            'latitude' => 5.6100,
            'longitude' => -0.1800,
            'profile_image' => 'delivery-1.jpg',
            'profile_thumbnail' => 'delivery-1-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        User::create([
            'username' => 'Delivery 2',
            'mobile' => '+233200000015',
            'password' => 'Password123!',
            'type' => 'delivery',
            'latitude' => 5.5900,
            'longitude' => -0.1900,
            'profile_image' => 'delivery-2.jpg',
            'profile_thumbnail' => 'delivery-2-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        User::create([
            'username' => 'Delivery 3',
            'mobile' => '+233200000016',
            'password' => 'Password123!',
            'type' => 'delivery',
            'latitude' => 5.6300,
            'longitude' => -0.1600,
            'profile_image' => 'delivery-3.jpg',
            'profile_thumbnail' => 'delivery-3-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        User::create([
            'username' => 'Delivery 4',
            'mobile' => '+233200000017',
            'password' => 'Password123!',
            'type' => 'delivery',
            'latitude' => 5.5700,
            'longitude' => -0.2100,
            'profile_image' => 'delivery-4.jpg',
            'profile_thumbnail' => 'delivery-4-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);

        User::create([
            'username' => 'Delivery 5',
            'mobile' => '+233200000018',
            'password' => 'Password123!',
            'type' => 'delivery',
            'latitude' => 5.6500,
            'longitude' => -0.2200,
            'profile_image' => 'delivery-5.jpg',
            'profile_thumbnail' => 'delivery-5-thumb.jpg',
            'mobile_verified_at' => now(),
        ]);
    }
}