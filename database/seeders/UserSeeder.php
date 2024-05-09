<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nip' => '1234',
                'name' => 'DONI',
                'email' => 'doni@example.com',
                'email_verified_at' => Carbon::now(),
                'jabatan' => 'DIREKTUR',
                'password' => Hash::make('123456')
            ],
            [
                'nip' => '1235',
                'name' => 'DONO',
                'email' => 'dono@example.com',
                'email_verified_at' => Carbon::now(),
                'jabatan' => 'FINANCE',
                'password' => Hash::make('123456')
            ],
            [
                'nip' => '1236',
                'name' => 'DONA',
                'email' => 'dona@example.com',
                'email_verified_at' => Carbon::now(),
                'jabatan' => 'STAFF',
                'password' => Hash::make('123456')
            ],
            [
                'nip' => '1237',
                'name' => 'DINA',
                'email' => 'dina@example.com',
                'email_verified_at' => Carbon::now(),
                'jabatan' => 'STAFF',
                'password' => Hash::make('123456')
            ]
        ]);
    }
}
