<?php

namespace App\Exports;
use App\Models\SkpModel;
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

class ReportSkp  extends DefaultValueBinder implements FromCollection, WithCustomValueBinder,WithHeadings,WithMapping,ShouldAutoSize
{
    protected $id;

    function __construct($nip,$tahun) {
            $this->nip = $nip;
            $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $rw= SkpModel::where('id','!=',0);
        if($this->nip != "-"){
            $rw->where('nip','=',$this->nip);
        }
        if($this->tahun != "-"){
            $rw->where('tahunPenilaian','like','%'.$this->tahun.'%');
        }
        return $rw->orderBy('nip','asc')->orderBy('tahunPenilaian','asc')->get();

    }

    public function headings(): array
    {
        return ["Pegawai ID", "NIP","Nama","Tahun Penilaian","Tgl Penilaian","Nilai","Rangking"];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'A' || $cell->getColumn() == 'B') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function map($SkpModel): array
    {
        return [
            $SkpModel->pegawaiID,
            $SkpModel->nip,
            $SkpModel->nama,
            $SkpModel->tahunPenilaian,
            $SkpModel->tglPenilaian,
            $SkpModel->nilai_angka,
            $SkpModel->rangking,
        ];
    }


}
