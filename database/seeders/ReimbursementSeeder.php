<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReimbursementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reimbursement')->insert([
            [
                'user_id' => 3,
                'nama_reimbursement' => 'Perjalanan',
                'tanggal_reimbursement' => '2024-05-01',
                'deskripsi_reimbursement' => 'perjalanan dinas',
                'nominal_reimbursement' => 100000,
                'file_reimbursement' => '',
                'status' => 'DITERIMA DIREKTUR',
                'keterangan' => null
            ],
            [
                'user_id' => 3,
                'nama_reimbursement' => 'Perjalanan dua',
                'tanggal_reimbursement' => '2024-05-06',
                'deskripsi_reimbursement' => 'perjalanan dinas dua',
                'nominal_reimbursement' => 200000,
                'file_reimbursement' => '',
                'status' => 'PENGAJUAN',
                'keterangan' => null
            ],
            [
                'user_id' => 4,
                'nama_reimbursement' => 'Belanja satu',
                'tanggal_reimbursement' => '2024-05-02',
                'deskripsi_reimbursement' => 'belanja dinas satu',
                'nominal_reimbursement' => 150000,
                'file_reimbursement' => '',
                'status' => 'PENGAJUAN',
                'keterangan' => null
            ],
            [
                'user_id' => 4,
                'nama_reimbursement' => 'Belanja dua',
                'tanggal_reimbursement' => '2024-05-05',
                'deskripsi_reimbursement' => 'belanja dinas dua',
                'nominal_reimbursement' => 250000,
                'file_reimbursement' => '',
                'status' => 'DITERIMA FINANCE',
                'keterangan' => null
            ]
        ]);
    }
}
