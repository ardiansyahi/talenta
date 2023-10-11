<?php

namespace App\Imports;

use App\Helpers\GlobalHelper;
use App\Models\KrsBobot;
use App\Models\KrsFinalModel;
use App\Models\KrsModel;
use App\Models\KrsHeaderModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TalentMappingImport implements ToModel,WithStartRow
{
    /**
    * @param Collection $collection
    */
    private $id;

    public function __construct($id)
    {
        $this->id = $id;


    }
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        //echo  $row[1].'<br>';
        //echo '<br><br>';
        $kotak=0;
        $data=KrsHeaderModel::whereId_krs($this->id)->first();
        $dataKRS=KrsModel::find($this->id)->first();
        $dtBobot=KrsBobot::whereId_krs($this->id)->whereJenis('isi')->first();
        $pegawai=$potensial=$kinerja=$nilai=array();
        $jsonPegawai=json_decode($data->pegawai);
        $nip=$row[0];
        $totalPotensial=$totalKinerja=0;
        if($dataKRS->id_krs_awal != null){
            KrsFinalModel::whereId_krs($dataKRS->id_krs_awal)->whereNip($nip)->update([
                'status'=>'non_publish'
            ]);
        }
        for($i = 0; $i < count($jsonPegawai); $i++){
            $tp=explode('^',$jsonPegawai[$i]);
            array_push($pegawai,$row[$tp[0]]);
        }

        $jsonPotensial=json_decode($data->potensial);
        $dtBP=json_decode($dtBobot->potensial);
        for($i = 0; $i < count($jsonPotensial); $i++){
            $tp=explode('^',$jsonPotensial[$i]);
            array_push($potensial,$row[$tp[0]]);
            $hitung=($row[$tp[0]] / 100) * $dtBP[$i];
            array_push($potensial,$hitung);
            $totalPotensial=$totalPotensial + $hitung;
        }

        $jsonKinerja=json_decode($data->kinerja);
        $dtBK=json_decode($dtBobot->kinerja);
        for($i = 0; $i < count($jsonKinerja); $i++){
            $tp=explode('^',$jsonKinerja[$i]);
            array_push($kinerja,$row[$tp[0]]);
            $hitung=($row[$tp[0]] / 100) * $dtBK[$i];
            array_push($kinerja,$hitung);
            $totalKinerja=$totalKinerja + $hitung;
            //echo $row[$tp[0]].'-'.$hitung.'<br>';

        }

        $kotak=GlobalHelper::getKotak(round($totalPotensial),round($totalKinerja),$dataKRS->id_tikpot);
        $nilai=array($totalPotensial,$totalKinerja,$kotak);




        return new KrsFinalModel([
            'id_krs'=>$this->id,
            'nip'=>$nip,
            'pegawai'=>json_encode($pegawai),
            'potensial'=>json_encode($potensial),
            'kinerja'=>json_encode($kinerja),
            'nilai'=>json_encode($nilai),
            'jenis'=>'isi',
            'status'=>'non_publish',
            'created_at'=>now(),
            'created_by'=>Auth::user()->userid,
        ]);


    }


}
