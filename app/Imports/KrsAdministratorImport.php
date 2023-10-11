<?php

namespace App\Imports;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\KrsFinalModel;
use App\Models\KrsAdminTemplateModel;
class KrsAdministratorImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $id;private $id_krs_awal;

    public function __construct($id,$id_krs_awal)
    {
        $this->id = $id;
        $this->id_krs_awal = $id_krs_awal;
    }
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $getHeader=KrsFinalModel::whereId_krs($this->id_krs_awal)->whereNip($row[1])->first();
        return new KrsAdminTemplateModel([
            'id_krs'=>$this->id,
            'nip'=>$row[1],
            'id_krs_awal'=>$this->id_krs_awal,
            'jenis'=>'isi',
            'pegawai'=>($getHeader->pegawai != NULL) ? $getHeader->pegawai : json_encode(array()),
            'potensial'=>($getHeader->potensial != NULL) ? $getHeader->potensial : json_encode(array()),
            'kinerja'=>($getHeader->kinerja != NULL) ? $getHeader->kinerja : json_encode(array()),
            'nilai'=>($getHeader->nilai != NULL) ? $getHeader->nilai : json_encode(array()),
            'nomor_surat_usul'=>$row[3],
            'tgl_surat'=> $row[4],
            'gelombang_1'=>$row[5],
            'dicalonkan_gelombang_2'=>$row[6],
            'kotak_talent_pool'=>$row[7],
            'created_by'=>Auth::user()->userid,
        ]);


    }
}
