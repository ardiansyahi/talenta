<?php

namespace App\Exports;
use App\Models\Krs_temp_model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class talentMapping  extends DefaultValueBinder implements FromCollection, WithCustomValueBinder,WithHeadings,WithMapping,ShouldAutoSize
{
    protected $id;

    function __construct($id,$penkom) {
            $this->id = $id;
            $this->penkom = $penkom;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return Krs_temp_model::where('id_krs','=',$this->id)->get();
    }

    public function headings(): array
    {
        switch($this->penkom){
            case "pelaksana":
                return ["NIP", "Nama", "Tgl Lahir", "Pendidikan", "Eselon", "Level Jabatan",
                "Provinsi","Satker","Nama Jabatan", "TMT Jabatan","Pangkat", "Golongan",
                "Cek Penkom","Skoring Mansoskul","Skoring Generik","Skoring Spresifik",
                "Skoring Pendidikan","Total Riwayat Jabatan", "Bobot Riwayat Jabatan","Total Bobot Riwayat Jabatan",
                "Diklat Struktural","Bobot Diklat Struktural", "Diklat Teknis",
                "Bobot Diklat Teknis","Total Bobot", "Bobot Diklat", "Skoring Pangkat", "Year -2", "Year -1", "Penilaian Perilaku"
                ];
                break;
            case "pengawas":
                return ["NIP", "Nama", "Tgl Lahir", "Pendidikan", "Eselon", "Level Jabatan",
                "Provinsi","Satker","Nama Jabatan", "TMT Jabatan","Pangkat", "Golongan",
                "Cek Penkom","Skoring Mansoskul","Skoring Teknis",
                "Skoring Pendidikan","Total Riwayat Jabatan", "Bobot Riwayat Jabatan","Total Bobot Riwayat Jabatan",
                "Diklat Struktural","Bobot Diklat Struktural", "Diklat Teknis",
                "Bobot Diklat Teknis","Total Bobot", "Bobot Diklat", "Skoring Pangkat", "Year -2", "Year -1", "Penilaian Perilaku"
                ];
                break;
            case "administrator":
            case "jpt":
                return ["NIP", "Nama", "Tgl Lahir", "Pendidikan", "Eselon", "Level Jabatan",
                "Provinsi","Satker","Nama Jabatan", "TMT Jabatan","Pangkat", "Golongan",
                "Cek Penkom","Skoring Mansoskul",
                "Skoring Pendidikan","Total Riwayat Jabatan", "Bobot Riwayat Jabatan","Total Bobot Riwayat Jabatan",
                "Diklat Struktural","Bobot Diklat Struktural", "Diklat Teknis",
                "Bobot Diklat Teknis","Total Bobot", "Bobot Diklat", "Skoring Pangkat", "Year -2", "Year -1", "Penilaian Perilaku"
                ];
                break;
        }

    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'A') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function map($Krs_temp_model): array
    {
        switch($this->penkom){
            case "pelaksana":
                return [
                    $Krs_temp_model->nip,
                    $Krs_temp_model->nama,
                    $Krs_temp_model->tgl_lahir,
                    $Krs_temp_model->pendidikan,
                    $Krs_temp_model->eselon,
                    $Krs_temp_model->level_jabatan,
                    $Krs_temp_model->provinsi,
                    $Krs_temp_model->satker,
                    $Krs_temp_model->nama_jabatan,
                    $Krs_temp_model->tmt_jabatan,
                    $Krs_temp_model->pangkat,
                    $Krs_temp_model->golongan,
                    $Krs_temp_model->cek_penkom,
                    $Krs_temp_model->skoring_mansoskul,
                    $Krs_temp_model->skoring_generik,
                    $Krs_temp_model->skoring_spesifik,
                    $Krs_temp_model->skoring_pendidikan,
                    $Krs_temp_model->total_rw_jabatan,
                    $Krs_temp_model->bobot_rw_jabatan,
                    $Krs_temp_model->bobot_rw_jabatan_total,
                    $Krs_temp_model->diklat_struktural,
                    $Krs_temp_model->bobot_ds,
                    $Krs_temp_model->diklat_teknis,
                    $Krs_temp_model->bobot_dt,
                    $Krs_temp_model->total_bobot,
                    $Krs_temp_model->total_bobot_persen,
                    $Krs_temp_model->skoring_pangkat,
                    $Krs_temp_model->year2,
                    $Krs_temp_model->year1,
                    $Krs_temp_model->penilaian_perilaku
                ];
                break;
            case "pengawas":
                return [
                    $Krs_temp_model->nip,
                    $Krs_temp_model->nama,
                    $Krs_temp_model->tgl_lahir,
                    $Krs_temp_model->pendidikan,
                    $Krs_temp_model->eselon,
                    $Krs_temp_model->level_jabatan,
                    $Krs_temp_model->provinsi,
                    $Krs_temp_model->satker,
                    $Krs_temp_model->nama_jabatan,
                    $Krs_temp_model->tmt_jabatan,
                    $Krs_temp_model->pangkat,
                    $Krs_temp_model->golongan,
                    $Krs_temp_model->cek_penkom,
                    $Krs_temp_model->skoring_mansoskul,
                    $Krs_temp_model->skoring_generik,
                    $Krs_temp_model->skoring_pendidikan,
                    $Krs_temp_model->total_rw_jabatan,
                    $Krs_temp_model->bobot_rw_jabatan,
                    $Krs_temp_model->bobot_rw_jabatan_total,
                    $Krs_temp_model->diklat_struktural,
                    $Krs_temp_model->bobot_ds,
                    $Krs_temp_model->diklat_teknis,
                    $Krs_temp_model->bobot_dt,
                    $Krs_temp_model->total_bobot,
                    $Krs_temp_model->total_bobot_persen,
                    $Krs_temp_model->skoring_pangkat,
                    $Krs_temp_model->year2,
                    $Krs_temp_model->year1,
                    $Krs_temp_model->penilaian_perilaku
                ];
                break;
            case "administrator":
            case "jpt":
                return [
                    $Krs_temp_model->nip,
                    $Krs_temp_model->nama,
                    $Krs_temp_model->tgl_lahir,
                    $Krs_temp_model->pendidikan,
                    $Krs_temp_model->eselon,
                    $Krs_temp_model->level_jabatan,
                    $Krs_temp_model->provinsi,
                    $Krs_temp_model->satker,
                    $Krs_temp_model->nama_jabatan,
                    $Krs_temp_model->tmt_jabatan,
                    $Krs_temp_model->pangkat,
                    $Krs_temp_model->golongan,
                    $Krs_temp_model->cek_penkom,
                    $Krs_temp_model->skoring_mansoskul,
                    $Krs_temp_model->skoring_pendidikan,
                    $Krs_temp_model->total_rw_jabatan,
                    $Krs_temp_model->bobot_rw_jabatan,
                    $Krs_temp_model->bobot_rw_jabatan_total,
                    $Krs_temp_model->diklat_struktural,
                    $Krs_temp_model->bobot_ds,
                    $Krs_temp_model->diklat_teknis,
                    $Krs_temp_model->bobot_dt,
                    $Krs_temp_model->total_bobot,
                    $Krs_temp_model->total_bobot_persen,
                    $Krs_temp_model->skoring_pangkat,
                    $Krs_temp_model->year2,
                    $Krs_temp_model->year1,
                    $Krs_temp_model->penilaian_perilaku
                ];
                break;
        }

    }


}
