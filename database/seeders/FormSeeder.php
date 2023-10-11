<?php

namespace Database\Seeders;
use App\Models\formModel;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ["id"=>1,"nama"=>"Data Master","jenis"=>"root","id_root"=>null,"created_by"=>"superadmin"],
            ["id"=>2,"nama"=>"Talent Mapping","jenis"=>"root","id_root"=>null,"created_by"=>"superadmin"],
            ["id"=>3,"nama"=>"Report","jenis"=>"root","id_root"=>null,"created_by"=>"superadmin"],
            ["id"=>4,"nama"=>"Setting","jenis"=>"root","id_root"=>null,"created_by"=>"superadmin"],
            ["id"=>5,"nama"=>"Titik Potong","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>6,"nama"=>"Pegawai","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>7,"nama"=>"Upload Penkom","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>8,"nama"=>"Riwayat Diklat","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>9,"nama"=>"Riwayat Jabatan","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>10,"nama"=>"SKP","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>11,"nama"=>"Penilaian Perilaku 360","jenis"=>"parent","id_root"=>1,"created_by"=>"superadmin"],
            ["id"=>12,"nama"=>"Talent Mapping","jenis"=>"parent","id_root"=>2,"created_by"=>"superadmin"],
            ["id"=>13,"nama"=>"Report Pegawai","jenis"=>"parent","id_root"=>3,"created_by"=>"superadmin"],
            ["id"=>14,"nama"=>"Report Penkom","jenis"=>"parent","id_root"=>3,"created_by"=>"superadmin"],
            ["id"=>15,"nama"=>"Report Riwayat Diklat","jenis"=>"parent","id_root"=>3,"created_by"=>"superadmin"],
            ["id"=>16,"nama"=>"Report Riwayat Jabatan","jenis"=>"parent","id_root"=>3,"created_by"=>"superadmin"],
            ["id"=>17,"nama"=>"Report SKP","jenis"=>"parent","id_root"=>3,"created_by"=>"superadmin"],
            ["id"=>18,"nama"=>"Report Penilaian Perilaku 360","jenis"=>"parent","id_root"=>3,"created_by"=>"superadmin"],
            ["id"=>19,"nama"=>"User","jenis"=>"parent","id_root"=>4,"created_by"=>"superadmin"],
            ["id"=>20,"nama"=>"Hak Akses","jenis"=>"parent","id_root"=>4,"created_by"=>"superadmin"],
            ["id"=>21,"nama"=>"Home","jenis"=>"parent","id_root"=>0,"created_by"=>"superadmin"],
        ];
        foreach($data as $rw){
            formModel::create($rw);
        }
    }
}
