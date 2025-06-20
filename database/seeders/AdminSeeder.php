<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cek dulu apakah admin sudah ada
        $adminEmail = 'admin@gmail.com';

        if (User::where('email', $adminEmail)->doesntExist()) {
            User::create([
                'name' => 'Administrator',
                'email' => $adminEmail,
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'is_approved' => true,
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin user created.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
