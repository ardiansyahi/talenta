<?php

namespace Database\Seeders;

use App\Models\RwDiklatKonfigModel;
use Illuminate\Database\Seeder;

class KonfigurasiRwDiklat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ["nama"=>"DIKLAT ADUM",],
            ["nama"=>"DIKLAT ADUM LANJUTAN",],
            ["nama"=>"DIKLAT KEPEMIMPINAN PENGAWAS",],
            ["nama"=>"DIKLAT PIM",],
            ["nama"=>"DIKLAT PIM  TK. IV",],
            ["nama"=>"DIKLAT PIM IV",],
            ["nama"=>"PIM IV KEL. DISKUSI 2",],
            ["nama"=>"PIM IV KEL.3",],
            ["nama"=>"PIM IV KEL.DISKUSI 4",],
            ["nama"=>"SEPALA/ADUM/DIKLAT PIM TK. IV",],
            ["nama"=>"SEPALAADUMDIKLAT PIM TK. IV",]

           
        ];
        foreach($data as $rw){
            RwDiklatKonfigModel::create($rw);
        }
    }
}
