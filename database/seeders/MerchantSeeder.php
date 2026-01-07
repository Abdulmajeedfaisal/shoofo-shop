<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم تاجر
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'merchant@shoofo.shop'],
            [
                'name' => 'Test Merchant',
                'password' => bcrypt('password'),
                'role' => 'merchant',
            ]
        );

        // إنشاء ملف التاجر
        \App\Models\Merchant::firstOrCreate(
            ['user_id' => $user->id],
            [
                'store_name' => 'Test Store',
                'store_name_ar' => 'متجر تجريبي',
                'description' => 'This is a test store for testing purposes.',
                'phone' => '0501234567',
                'address' => 'Riyadh, Saudi Arabia',
                'status' => 'approved',
                'approved_at' => now(),
            ]
        );
    }
}
