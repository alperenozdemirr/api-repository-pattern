<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\UserType;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        $users = [
            [
                'name' => 'Alp Eren Özdemir',
                'email' => 'alp@gmail.com',
                'password' => bcrypt('alp123456'),
                'type' => UserType::USER,
            ],
            [
                'name' => 'administrator',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'type' => UserType::ADMIN,
            ],
        ];
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

    }
}
