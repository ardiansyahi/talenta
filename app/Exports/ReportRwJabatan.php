<?php

namespace App\Exports;
use App\Models\RwJabatanModel;
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

class ReportRwJabatan  extends DefaultValueBinder implements FromCollection, WithCustomValueBinder,WithHeadings,WithMapping,ShouldAutoSize
{
    protected $id;

    function __construct($nip) {
            $this->nip = $nip;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       $rw= RwJabatanModel::where('id','!=',0);
        if($this->nip != "-"){
            $rw->where('nip','=',$this->nip);
        }

        return $rw->orderBy('nip','asc')->get();

    }

    public function headings(): array
    {
        return ["NIP","Nama","TMT Eselon","Nama Jabatan","TMT Jabatan","TGL SK","Satker"];
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

    public function map($RwJabatanModel): array
    {
        return [
            $RwJabatanModel->nip,
            $RwJabatanModel->nama,
            $RwJabatanModel->tmteselon,
            $RwJabatanModel->namajabatan,
            $RwJabatanModel->tmtjabatan,
            $RwJabatanModel->tglsk,
            $RwJabatanModel->satker,
        ];
    }


}
