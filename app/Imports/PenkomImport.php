<?php

namespace App\Imports;
use Throwable;
use Illuminate\Support\Facades\DB;
use App\Models\PenkomModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class PenkomImport implements ToModel,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $jenis;private $tahun;private $hashname;

    public function __construct($jenis,$tahun,$hashname)
    {
        $this->jenis = $jenis;
        $this->tahun = $tahun;
        $this->hashname = $hashname;
    }
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        switch ($this->jenis){
            case "pelaksana":
                return new PenkomModel([
                    'nip'     => $row[1],
                    'nama'    => $row[2],
                    'jenis' => $this->jenis,
                    'tahun' => $this->tahun,
                    'pangkat' => $row[3],
                    'golongan' => $row[4],
                    'jabatan' => $row[5],
                    'unit_kerja' => $row[6],
                    'mansoskul' => $row[7],
                    'teknis_generik' => $row[8],
                    'teknis_spesifik' => $row[9],
                    'created_by' => Auth::user()->userid,
                    'hashname'=>$this->hashname

                ]);
                break;
            case "pengawas":
                return new PenkomModel([
                    'nip'     => $row[1],
                    'nama'    => $row[2],
                    'jenis' => $this->jenis,
                    'tahun' => $this->tahun,
                    'pangkat' => $row[3],
                    'golongan' => $row[4],
                    'jabatan' => $row[5],
                    'unit_kerja' => $row[6],
                    'mansoskul' => $row[7],
                    'teknis_generik' => $row[8],
                    'created_by' => Auth::user()->userid,
                    'hashname'=>$this->hashname

                    ]);
                break;
            case "administrator":
            case "jpt":
            case "jpt_pratama":
            case "jpt_madya":
                return new PenkomModel([
                    'nip'     => $row[1],
                    'nama'    => $row[2],
                    'jenis' => $this->jenis,
                    'tahun' => $this->tahun,
                    'pangkat' => $row[3],
                    'golongan' => $row[4],
                    'jabatan' => $row[5],
                    'unit_kerja' => $row[6],
                    'mansoskul' => $row[7],
                    'created_by' => Auth::user()->userid,
                    'hashname'=>$this->hashname
                ]);
                break;

        }

    }



}
