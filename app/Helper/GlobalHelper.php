<?php
namespace App\Helpers;

use App\Models\KonfigurasiModel;
use App\Models\KrsModel;
use App\Models\User;
use App\Models\PenkomModel;
use App\Models\RwdiklatModel;
use App\Models\PegawaiTalentaModel;
use App\Models\SkpModel;
use App\Models\TikpodDetailModel;
use App\Models\UrlKonfigModel;
use App\Models\View_Penilaian_Perilaku;
use Illuminate\Support\Facades\DB;
use App\Models\AksesModel;
ini_set('max_execution_time', 0); //0=NOLIMIT
ini_set('memory_limit', '-1');
set_time_limit(0);

class GlobalHelper {

    public static function getNipNama($param) {
        $kueri= DB::connection('pgsql2')->table('pegawai')
                ->select('nip','nama')
                ->where('nip','like','%'.$param.'%')
                ->orWhere(DB::connection('pgsql2')->raw('lower(nama)'), "LIKE", "%".strtolower($param)."%")
                ->get();

        $list = array();
        $key=0;

        if($kueri->count()>0){
            foreach ($kueri as $key=>$row) {
                $list[$key]['id'] = $row->nip;
                $list[$key]['text'] = $row->nip.' - '.$row->nama;
            }
            echo json_encode($list);
        }else{
            echo 'tidak ada data';
        }

    }
    public static function getNipPegawai($param) {
        $kueri= DB::table('talenta_pegawai')
                ->select('nip','nama_lengkap')
                ->where('nip','like','%'.$param.'%')
                ->orWhere(DB::raw('lower(nama_lengkap)'), "LIKE", "%".strtolower($param)."%")
                ->get();

        $list = array();
        $key=0;

        if($kueri->count()>0){
            foreach ($kueri as $key=>$row) {
                $list[$key]['id'] = $row->nip;
                $list[$key]['text'] = $row->nip.' - '.$row->nama_lengkap;
            }
             return json_encode($list);
        }else{
            return 'tidak ada data';
        }

    }

    public static function getNamaByNip($param) {
        $kueri= DB::connection('pgsql2')->table('pegawai')
                ->select('nip','nama')
                ->where('nip','like','%'.$param.'%')
                ->first();

        return $kueri;
    }
    public static function getNamaNipPegawai($param) {
        $kueri= DB::table('talenta_pegawai')
                ->select('nip','nama_lengkap')
                ->where('nip','like','%'.$param.'%')
                ->first();

        return $kueri;
    }

    public static function getNamaRWByNip($param) {
        $kueri= DB::table('talenta_rwdiklat')
                ->select('nip','nama')
                ->where('nip','like','%'.$param.'%')
                ->first();

        return $kueri;
    }

    public static function getNamaRWJByNip($param) {
        $kueri= DB::table('talenta_rwjabatan')
                ->select('nip','nama')
                ->where('nip','like','%'.$param.'%')
                ->first();

        return $kueri;
    }
    public static function getNIPRW($param) {
        $kueri= DB::table('talenta_rwdiklat')
        ->select('nip','nama')
        ->distinct('nip')
        ->where('nip','like','%'.$param.'%')
        ->orWhere(DB::raw('lower(nama)'), "LIKE", "%".strtolower($param)."%")
        ->get();

        $list = array();
        $key=0;

        if($kueri->count()>0){
            foreach ($kueri as $key=>$row) {
                $list[$key]['id'] = $row->nip;
                $list[$key]['text'] = $row->nip.' - '.$row->nama;
            }
            return json_encode($list);
        }else{
            return 'tidak ada data';
        }


    }

    public static function getNIPRWJ($param) {
        $kueri= DB::table('talenta_rwjabatan')
        ->select('nip','nama')
        ->distinct('nip')
        ->where('nip','like','%'.$param.'%')
        ->orWhere(DB::raw('lower(nama)'), "LIKE", "%".strtolower($param)."%")
        ->get();

        $list = array();
        $key=0;

        if($kueri->count()>0){
            foreach ($kueri as $key=>$row) {
                $list[$key]['id'] = $row->nip;
                $list[$key]['text'] = $row->nip.' - '.$row->nama;
            }
            return json_encode($list);
        }else{
            return 'tidak ada data';
        }


    }

    public static function getCURL($url,$type,$head,$paramBody){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST =>  false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 100,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_HTTPHEADER => $head,
            CURLOPT_POSTFIELDS => $paramBody,
        ));

        return $curl;
    }

    public static function getCURLwithAuth($url,$type,$head,$paramBody,$username,$password){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_USERPWD=> $username . ":" . $password,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST =>  false,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 100,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_HTTPHEADER => $head,
            CURLOPT_POSTFIELDS => $paramBody,
        ));

        return $curl;
    }

    public static function changeDate($tipe,$tgl){
        $newdate=null;
        switch($tipe){
            case "1":
                //14/01/2023
                if($tgl !='' || $tgl !=null){
                    $newdate=substr($tgl,6,4).'-'.substr($tgl,3,2).'-'.substr($tgl,0,2);
                }

                break;
            default:
                break;

        }
        return $newdate;
    }

    public static function getKonfigKrsPenkom($id){
        return KonfigurasiModel::whereId_krs($id)->whereJenis('penkom')->first();
    }
    public static function getKrs($id){
        return KrsModel::find($id);
    }

    public static function getAge($dateOfBirth,$today){
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');

    }

    public static function getDataPenkom($nip,$tahun,$jenis){
        return PenkomModel::whereNip($nip)
                        ->where('tahun','<=',$tahun)
                        ->whereJenis($jenis)
                        ->orderBy('tahun','DESC')
                        ->orderBy('id','DESC')
                        ->first();


    }
    public static function getDTP($tipe){
        return PegawaiTalentaModel::select("".$tipe."")->orderBy("".$tipe."","asc")->groupBy("".$tipe."")->get();
    }

    public static function getSkorPendidikan($id_krs,$kriteria){
        $kueri=KonfigurasiModel::select('isidata')->whereId_krs($id_krs)
                                 ->whereJenis('skoring_pendidikan')
                                 ->whereKriteria($kriteria)
                                 ->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }
    public static function getSkorPangkat($id_krs,$kriteria){
        $kueri=KonfigurasiModel::select('isidata')->whereId_krs($id_krs)
                                 ->whereJenis('skoring_pangkat')
                                 ->whereKriteria($kriteria)
                                 ->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }
    public static function getSkorJabatan($id_krs,$kriteria){
        // $kueri=KonfigurasiModel::select('isidata')
        //                         ->whereId_krs($id_krs)
        //                         ->whereJenis('riwayat_jabatan')
        //                         ->whereRaw('CAST(kriteria as INT) <= '.$kriteria)
        //                         ->orderBy('kriteria','desc')->first();

        //sql
        $kueri=KonfigurasiModel::select('isidata')
                                ->whereId_krs($id_krs)
                                ->whereJenis('riwayat_jabatan')
                                ->where('kriteria','<=',$kriteria)
                                ->orderBy('kriteria','desc')->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }

    public static function getBobotDS($id_krs,$kriteria){
        $kueri=KonfigurasiModel::select('isidata')
                                ->whereId_krs($id_krs)
                                ->whereJenis('diklat_struktural')
                                ->where('kriteria','=',$kriteria)
                                ->orderBy('kriteria','desc')->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }

    public static function getSkorDT($id_krs,$kriteria){
        // $kueri=KonfigurasiModel::select('isidata')
        //                         ->whereId_krs($id_krs)
        //                         ->whereJenis('diklat_teknis')
        //                         ->whereRaw('CAST(kriteria as INT) <= '.$kriteria)
        //                         ->orderBy('kriteria','desc')->first();
        //sql
        $kueri=KonfigurasiModel::select('isidata')
                                ->whereId_krs($id_krs)
                                ->whereJenis('diklat_teknis')
                                ->where('kriteria','<=',$kriteria)
                                ->orderBy('kriteria','desc')->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }

    public static function getDataKonfig($id_krs,$kriteria,$jenis){
        $kueri=KonfigurasiModel::select('isidata')
                                ->whereId_krs($id_krs)
                                ->whereJenis($jenis)
                                ->where('kriteria','=',$kriteria)
                                ->orderBy('kriteria','desc')->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }

    public static function getSKP($nip,$tahun){
        $kueri=SkpModel::select('nilai_angka')
                                ->whereNip($nip)
                                ->where('tahunPenilaian','=',$tahun)
                                ->orderBy('nourut','desc')->first();
        $total=0;
        if($kueri){
            $total=$kueri->nilai_angka;
        }
        return $total;
    }


    public static function getMaxValueKonfig($id_krs,$jenis){

        // $kueri=KonfigurasiModel::whereId_krs($id_krs)->whereJenis($jenis)->orderByRaw('CAST(isidata as INT) desc')->first();
        //sql
         $kueri=KonfigurasiModel::whereId_krs($id_krs)->whereJenis($jenis)->orderBy('isidata','desc')->first();
        $total=0;
        if($kueri){
            $total=$kueri->isidata;
        }
        return $total;
    }

    public static function getPerilaku($nip,$tahun){
        $total=0;
        $kueri=View_Penilaian_Perilaku::select('nilai_akhir')
                                ->wherePegawai_dinilai($nip)
                                ->whereTahun($tahun)
                                ->distinct('pegawai_dinilai')->first();
       // $total=80;
        if($kueri){
            $total=$kueri->nilai_akhir;
        }
        return $total;
    }

    public static function getKotak($potensial,$kinerja,$id_tikpot){
        $nama='-';
        $kueri= TikpodDetailModel::select('nama')
                        ->where('min_potensial','<=',$potensial)
                        ->where('max_potensial','>=',$potensial)
                        ->where('min_kinerja','<=',$kinerja)
                        ->where('max_kinerja','>=',$kinerja)
                        ->where('id_master','=',$id_tikpot)
                        ->first();
        if($kueri){
            $nama=$kueri->nama;
        }
        return $nama;
    }

    public static function getUrlKonfig($jenis){
        return UrlKonfigModel::whereJenis($jenis)->first();
    }

    public static function cekAkses($userid,$id){
        $akses=AksesModel::select('akses.id_form')->join('talenta_users','akses.id','=','talenta_users.id_akses')
                ->where('talenta_users.userid','=',$userid)->first();
        if (array_search($id, json_decode($akses->id_form))){
            return true;
        }else{
            return false;
        }
    }

    public static function cekUser($data,$nip){
        $kueri=User::whereUserid($nip)->first();
        if($kueri){
            User::whereUserid($nip)->update([
                'isActive'=>0,
            ]);
        }else{
            User::create($data);
        }
    }
}

?>
