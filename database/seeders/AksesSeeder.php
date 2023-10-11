<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AksesModel;

class AksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ["id"=>1,"nama"=>"Super Admin","id_form"=>json_encode(array("21","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20")),"isdeleted"=>0,"created_by"=>"superadmin"],
            ["id"=>2,"nama"=>"Admin","isdeleted"=>0,"created_by"=>"superadmin","id_form"=>json_encode(array("21"))],
            ["id"=>3,"nama"=>"Manajemen Kinerja","isdeleted"=>0,"created_by"=>"superadmin","id_form"=>json_encode(array("21"))],
            ["id"=>4,"nama"=>"Supervisor","isdeleted"=>0,"created_by"=>"superadmin","id_form"=>json_encode(array("21"))],
            ["id"=>5,"nama"=>"User","isdeleted"=>0,"created_by"=>"superadmin","id_form"=>json_encode(array("21"))],

        ];
        foreach($data as $rw){
            AksesModel::create($rw);
        }
    }
}
