<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pegawai::create([
            "nik" => "1234",
            'password' => bcrypt('12345678'),
            "nama_lengkap" => "ADIT BIN udIn jamal bAAL ASeP",
            "no_hp" => "088835465738",
            "jabatan" => "ADMIN SLot",
        ]);

        Pegawai::create([
            "nik" => "12345",
            'password' => bcrypt('12345678'),
            "nama_lengkap" => "KHORI SUKA NGISEP BATANG",
            "no_hp" => "0888354638",
            "jabatan" => "ADMIN JUDI BOLA",
        ]);
    }
}
