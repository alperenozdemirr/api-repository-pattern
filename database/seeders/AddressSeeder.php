<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Status;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addresses')->delete();
        $addresses= [
            [
                'user_id' => 1,
                'title' => 'Home',
                'address' => 'Sakarya/Akyazı Merkez',
                'city_code' => 54,
                'status' => Status::ACTIVE,
            ],
            [
                'user_id' => 1,
                'title' => 'Office',
                'address' => 'İstanbul Osmanbey Merkez',
                'city_code' => 34,
                'status' => Status::PASSIVE,
            ],
        ];
        foreach ($addresses as $address) {
            DB::table('addresses')->insert($address);
        }
    }
}
