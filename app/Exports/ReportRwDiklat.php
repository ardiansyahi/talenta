<?php

namespace App\Exports;
use App\Models\RwdiklatModel;
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

class ReportRwDiklat  extends DefaultValueBinder implements FromCollection, WithCustomValueBinder,WithHeadings,WithMapping,ShouldAutoSize
{
    protected $id;

    function __construct($nip,$jenis) {
            $this->nip = $nip;
            $this->jenis = $jenis;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $rw= RwdiklatModel::where('id','!=',0);
        if($this->nip != "-"){
            $rw->where('nip','=',$this->nip);
        }
        if($this->jenis != "-"){
            $rw->where('jenis','=',$this->jenis);
        }
        return $rw->orderBy('nip','asc')->get();

    }

    public function headings(): array
    {
        return ["Pegawai ID", "NIP", "Nama", "jenis", "Tanggal", "Nama Diklat","Diklat Struktural"];
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

    public function map($RwdiklatModel): array
    {
        return [
            $RwdiklatModel->pegawaiID,
            $RwdiklatModel->nip,
            $RwdiklatModel->nama,
            $RwdiklatModel->jenis,
            $RwdiklatModel->tgl,
            $RwdiklatModel->nama_diklat,
            $RwdiklatModel->diklat_struktural,
        ];
    }


}
