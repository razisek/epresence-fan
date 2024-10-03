<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama' => 'Ananda Bayu',
                'email' => 'bayu@email.com',
                'npp' => '12345',
                'npp_supervisor' => '11111',
                'password' => bcrypt('password'),
            ],
            [
                'nama' => 'Supervisor',
                'email' => 'spv@email.com',
                'npp' => '11111',
                'npp_supervisor' => null,
                'password' => bcrypt('password'),
            ]
        ]);
    }
}
