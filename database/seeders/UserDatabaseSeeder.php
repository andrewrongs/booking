<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Andrew',
                'email' => 'fgrt9797@yahoo.com.tw',
                'phone' => '0912345678',
                'birthday' => '2001-01-01',
            ],
            [
                'name' => 'Ming',
                'email' => 'ming@example.com',
                'phone' => '0912345678',
                'birthday' => '2000-09-24',
            ]
        ];

        foreach ($admins as $admin) {
            User::factory()->create([
                ...$admin,
                'role' => 1,
                'level' => 2,
            ]);
        }
    }
}
