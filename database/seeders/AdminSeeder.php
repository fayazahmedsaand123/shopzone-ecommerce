<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin — Login: admin@shopzone.com / Admin@123456
        User::firstOrCreate(
            ['email' => 'admin@shopzone.com'],
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('Admin@123456'),
                'role'     => 'admin',
                'status'   => 'active',
            ]
        );

        // Test Customer — Login: customer@shopzone.com / Customer@123456
        User::firstOrCreate(
            ['email' => 'customer@shopzone.com'],
            [
                'name'     => 'Test Customer',
                'password' => Hash::make('Customer@123456'),
                'role'     => 'customer',
                'status'   => 'active',
            ]
        );

        $this->command->info('Admin and test customer created successfully.');
    }
}