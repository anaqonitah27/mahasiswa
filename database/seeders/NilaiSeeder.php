<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "mahasiswa_id" => "2041720118",
                "matakuliah_id" => "1",
                "nilai" => "A"

            ], [
                "mahasiswa_id" => "2041720120",
                "matakuliah_id" => "2",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "2041720100",
                "matakuliah_id" => "3",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "204172009",
                "matakuliah_id" => "4",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "2041721202",
                "matakuliah_id" => "3",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "2041721022",
                "matakuliah_id" => "4",
                "nilai" => "A"
            ],
            [
                "mahasiswa_id" => "2041720118",
                "matakuliah_id" => "4",
                "nilai" => "A"
            ],
        ];

        DB::table('mahasiswa_matakuliah')->insert($data);

    }
}