<?php

namespace Database\Seeders;

use App\Models\KonfigurasiModel;
use Illuminate\Database\Seeder;

class KonfigurasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [
                "nama"=>"Skoring Pendidikan",
                "jenis"=>"skoring_pendidikan",
                "deskripsi"=>"",
                "created_by"=>"admin",
                "created_at"=>now()
            ],
            [
                "nama"=>"Bobot Riwayat Jabatan",
                "jenis"=>"bobot_rj",
                "deskripsi"=>"",
                "created_by"=>"admin",
                "created_at"=>now()
            ],
            [
                "nama"=>"Bobot Diklat Struktural",
                "jenis"=>"bobot_ds",
                "deskripsi"=>"",
                "created_by"=>"admin",
                "created_at"=>now()
            ],
            [
                "nama"=>"Bobot Diklat Teknis",
                "jenis"=>"bobot_dt",
                "deskripsi"=>"",
                "created_by"=>"admin",
                "created_at"=>now()
            ],
            [
                "nama"=>"Skoring Pangkat",
                "jenis"=>"skoring_pangkat",
                "deskripsi"=>"",
                "created_by"=>"admin",
                "created_at"=>now()
            ]
        ];
        foreach($data as $rw){
            KonfigurasiModel::create($rw);
        }
       
    }
}
