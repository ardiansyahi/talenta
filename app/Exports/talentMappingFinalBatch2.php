<?php

namespace App\Exports;
use App\Models\KrsFinalModel;
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
use Illuminate\Database\Query\Builder;

class talentMappingFinalBatch2  extends DefaultValueBinder implements FromCollection, WithCustomValueBinder,WithHeadings,WithMapping,ShouldAutoSize
{
    protected $id;

    function __construct($id) {
            $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return KrsFinalModel::where('id_krs','=',$this->id)
                            ->where('jenis','=','isi')
                            ->Where(function ($query) {
                                $query->where('nilai','like','%Kotak 7%')
                                      ->orWhere('nilai','like','%Kotak 8%')
                                      ->orWhere('nilai','like','%Kotak 9%');
                            })->get();


    }

    public function headings(): array
    {
        $head=KrsFinalModel::where('id_krs','=',$this->id)->where('jenis','=','header')->first();
        $header=array();
        $data=json_decode($head);
        $jsonPegawai=json_decode($data->pegawai);
        for($i = 0; $i < count($jsonPegawai); $i++){
            $tp=explode('^',$jsonPegawai[$i]);
            array_push($header,$tp[1]);
        }

        $jsonPotensial=json_decode($data->potensial);
        for($i = 0; $i < count($jsonPotensial); $i++){
            $tp=explode('^',$jsonPotensial[$i]);
            array_push($header,$tp[1]);
        }

        $jsonKinerja=json_decode($data->kinerja);
        for($i = 0; $i < count($jsonKinerja); $i++){
            $tp=explode('^',$jsonKinerja[$i]);
            array_push($header,$tp[1]);
        }

        $jsonNilai=json_decode($data->nilai);
        for($i = 0; $i < count($jsonNilai); $i++){
            array_push($header,$jsonNilai[$i]);
        }

        return $header;

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

    public function map($KrsFinalModel): array
    {
            $isi=array();
            $data=json_decode($KrsFinalModel);
            $jsonPegawai=json_decode($data->pegawai);
            for($i = 0; $i < count($jsonPegawai); $i++){
                array_push($isi,$jsonPegawai[$i]);
            }

            $jsonPotensial=json_decode($data->potensial);
            for($i = 0; $i < count($jsonPotensial); $i++){
                array_push($isi,$jsonPotensial[$i]);
            }

            $jsonKinerja=json_decode($data->kinerja);
            for($i = 0; $i < count($jsonKinerja); $i++){
                array_push($isi,$jsonKinerja[$i]);
            }

            $jsonNilai=json_decode($data->nilai);
            for($i = 0; $i < count($jsonNilai); $i++){
                array_push($isi,$jsonNilai[$i]);
            }


        return $isi;

    }


}
