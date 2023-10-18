<?php

namespace Database\Seeders;

use App\Models\UrlKonfigModel;
use Illuminate\Database\Seeder;

class UrlKonfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data=[
        //     ["url"=>"https://simpeg.atrbpn.go.id/api_simpeg/service_itms/getToken","jenis"=>"token","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
        //     ["url"=>"https://simpeg.atrbpn.go.id/api_simpeg/service_itms/getPegawaiAll","jenis"=>"pegawai","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
        //     ["url"=>"https://simpeg.atrbpn.go.id/api_simpeg/service_itms/getRiwayatJabatan","jenis"=>"rwjabatan","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
        //     ["url"=>"https://simpeg.atrbpn.go.id/api_simpeg/service_itms/getRiwayatDiklat","jenis"=>"rwdiklat","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
        //     ["url"=>"https://simpeg.atrbpn.go.id/api_simpeg/service_itms/getSKP","jenis"=>"skp","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
        // ];
        $data=[
            ["url"=>"http://127.0.0.1:8082/apitalenta/gettoken.json","jenis"=>"token","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
            ["url"=>"http://127.0.0.1:8082/apitalenta/DataPegawai.json","jenis"=>"pegawai","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
            ["url"=>"http://127.0.0.1:8082/apitalenta/RiwayatJabatan.json","jenis"=>"rwjabatan","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
            ["url"=>"http://127.0.0.1:8082/apitalenta/RiwayatDiklat.json","jenis"=>"rwdiklat","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
            ["url"=>"http://127.0.0.1:8082/Data_SKP.json","jenis"=>"skp","method"=>"POST","uid"=>"api-simpeg","pass"=>"simpeg2021"],
        ];
        foreach($data as $rw){
            UrlKonfigModel::create($rw);
        }
    }
}
