<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Production 1',
                'badge_number' => '123451',
                'role' => 'Production',
                'password' => Hash::make('production'),
            ],
            [
                'name' => 'Production 2',
                'badge_number' => '123452',
                'role' => 'Production',
                'password' => Hash::make('production'),
            ],
            [
                'name' => 'Warehouse 1',
                'badge_number' => '11111',
                'role' => 'Warehouse',
                'password' => Hash::make('warehouse'),
            ],
          
        ]);
    }
}
