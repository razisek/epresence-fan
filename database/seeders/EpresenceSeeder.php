<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EpresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('epresences')->insert([
            [
                'id_users' => 1,
                'type' => 'IN',
                'is_approve' => true,
                'waktu' => '2020-10-16 08:00:00',
            ],
            [
                'id_users' => 1,
                'type' => 'OUT',
                'is_approve' => false,
                'waktu' => '2020-10-16 17:00:00',
            ]
        ]);
    }
}
