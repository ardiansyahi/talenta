<?php

namespace App\Http\Controllers;

use App\Helpers\GlobalHelper;
use App\Models\KonfigurasiModel;
use App\Models\Krs_temp_model;
use App\Models\KrsModel;
use App\Models\KrsPegawaiTemplateModel;
use App\Models\PegawaiModel;
use App\Models\PegawaiTalentaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\talentMapping;
use App\Exports\talentMappingFinal;
use App\Exports\talentMappingFinalBatch2;
use App\Imports\TalentMappingImport;
use App\Models\KrsBobot;
use App\Models\KrsFinalModel;
use App\Models\KrsHeaderModel;
use App\Models\KrsAdminTemplateModel;
use App\Models\TikpodModel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use App\Imports\KrsAdministratorImport;
use Illuminate\Support\Str;
use Validator;

class KrsController extends Controller
{
    public function index(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $tahun='';
            $jenis='';
            $status='';
            return view('talent-mapping.krs',compact('tahun','jenis','status'));
        }else{
            return view('notfound');
        }
    }
    public function cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $tahun=$request->tahun;
            $jenis=$request->jenis;
            $status=$request->status;
            return view('talent-mapping.krs',compact('tahun','jenis','status'));
        }else{
            return view('notfound');
        }
    }

    public function add(){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $dt1=KrsModel::select('id','deskripsi')
                       //->whereJenis('administrator')
                       ->whereBatch('1')
                       ->whereStatus('publish')
                       ->orderBy('tahun','desc')
                       ->orderBy('id','desc')
                       ->get();
            return view('talent-mapping.krs-add',compact('dt1'));
        }else{
            return view('notfound');
        }
    }
    public function store(Request $request){
        if($request->batch=="2" && ($request->jenis=="administrator" || $request->jenis=="jpt")){
            $request->validate([
                'tahun'=>'required',
                'jenis'=>'required',
                'batch'=>'required',
                'id_krs_awal'=>'required',
                'deskripsi'=>'required',
            ]);
        }else{
            $request->validate([
                'tahun'=>'required',
                'jenis'=>'required',
                'batch'=>'required',
                'deskripsi'=>'required',
            ]);

        }

        //try{

            $id=KrsModel::insertGetId([
                'tahun'=>$request->tahun,
                'jenis'=>$request->jenis,
                'batch'=>$request->batch,
                'deskripsi'=>$request->deskripsi,
                'id_krs_awal'=>$request->id_krs_awal,
                'status'=>'in_progress',
                'created_at'=>now(),
                'created_by'=>Auth::user()->userid,
            ]);

            session()->flash('respon','success');
            session()->flash('message','Data berhasil ditambah');
            return redirect('/talent-mapping');

        // }catch (Throwable $e) {
        //     report($e);
        //     session()->flash('respon','failed');
        //     session()->flash('message','Data gagal diperbaharui, Ada format pengisian yang salah');
        //     return back();
        // }
    }

    public function destroy($id){
        KrsModel::find($id)->update([
           'status'=>'delete'
        ]);

        session()->flash('respon','success');
        session()->flash('message','Data berhasil dihapus');
        return redirect('/talent-mapping');
    }

    public function getDataKrs(Request $request){
        $action='';
        $data=KrsModel::select('id','tahun','deskripsi','jenis','batch','status')
                        ->where('status','!=','delete');
        if($request->status !=''){
            $data->whereStatus($request->status);
        }
        if($request->jenis !=''){
            $data->whereJenis($request->jenis);
        }
        if($request->tahun !=''){
            $data->whereTahun($request->tahun);
        }
        $data->orderBy('tahun','desc')->orderBy('id','desc')->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $totTemp=Krs_temp_model::select('id')->whereId_krs($data->id)->count();
                    $totData=KrsFinalModel::select('id')->whereId_krs($data->id)->whereJenis('isi')->count();

                    if($data->batch=="2" && ($data->jenis=="administrator" || $data->jenis=="jpt_pratama"|| $data->jenis=="jpt_madya")){
                        $action='';
                    }else{
                        $action='<a href="'.url('/talent-mapping/konfigurasi/'.$data->id.'').'" class="btn btn-dark btn-sm"  title="Setting Konfigurasi">Hitung</a>';
                    }
                    $action=$action.'<a href="'.url('/talent-mapping/upload/'.$data->id.'').'" class="btn btn-success btn-sm">Upload</a>';
                    // if($totTemp > 0 && $data->status=="in_progress"){
                    //     $action=$action." <a href='/talent-mapping/daftar-usulan/".$data->id."' class='btn btn-primary btn-sm'>Daftar Usulan</a>";
                    // }else if($data->batch=="2" && $data->jenis=="administrator" && $data->status=="in_progress"){
                    //     $action=$action." <a href='/talent-mapping/daftar-usulan/".$data->id."' class='btn btn-primary btn-sm'>Daftar Usulan</a>";
                    // }
                    if($totData > 0){
                        $action=$action. '<a href="'.url('/talent-mapping/detail/'.$data->id.'').'" class="btn btn-info btn-sm">Detail</a>';
                    }
                    $action=$action.' <a href="'.url('/talent-mapping/delete/'.$data->id.'').'" onclick="return confirm(`Yakin Anda Ingin Menghapus Data KRS : '.$data->deskripsi.'`)" class="btn btn-sm btn-danger">Hapus</a>';
                    return $action;

                })
                ->addColumn('status',function($data){
                    return str_ireplace("_"," ",$data->status);
                })
                ->addColumn('jenis',function($data){
                    return str_ireplace("_"," ",$data->jenis);
                })
                ->rawColumns(['action','status','jenis'])
                ->make(true);

    }


    public function konfigurasi($id){

        $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","fileupload","id_tikpot","status")
                        ->whereId($id)->first();
        $getPendidikan=GlobalHelper::getDTP('pendidikan');
        $getEselon=GlobalHelper::getDTP('eselon');
        $getGolongan=GlobalHelper::getDTP('golongan');
        $getPangkat=GlobalHelper::getDTP('pangkat');
        $getLvlJabatan=GlobalHelper::getDTP('level_jabatan');
        $getStatusPegawai=GlobalHelper::getDTP('statuspegawai');
        $getTipePegawai=GlobalHelper::getDTP('tipepegawai');
        $status=$data->status;
        $dataPenkom=KonfigurasiModel::whereId_krs($id)->whereJenis('penkom')->first();
        $dataKonfig=KonfigurasiModel::whereId_krs($id)->whereJenis('pegawai')->first();
        $bobot_diklat=GlobalHelper::getDataKonfig($id,'bobot_diklat','bobot');
        $bobot_rwjabatan=GlobalHelper::getDataKonfig($id,'bobot_rwjabatan','bobot');
        $skp2=GlobalHelper::getDataKonfig($id,'skp2','skp');
        $skp1=GlobalHelper::getDataKonfig($id,'skp1','skp');
        return view('talent-mapping.konfig',compact('data','getPendidikan','getEselon',
                'getGolongan','getPangkat','getLvlJabatan','getStatusPegawai','getTipePegawai','id',
                'dataPenkom','dataKonfig','bobot_diklat','bobot_rwjabatan','skp2','skp1','status'));

    }

    public function konfigurasiStep3($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $data=DB::select("select id, tahun, deskripsi, batch,jenis
                        FROM talenta_krs
                        WHERE id='".$id."'
                        Order By tahun,id desc
                        ");

            $datapenkom=KonfigurasiModel::whereJenis('penkom')
                        ->whereId_krs($id)->first();

            $dataSKP=KonfigurasiModel::whereJenis('skoring_pendidikan')
                        ->whereId_krs($id)->get();

            $dataRWJ=KonfigurasiModel::whereJenis('riwayat_jabatan')
                        ->whereId_krs($id)->get();

            $dataDT=KonfigurasiModel::whereJenis('diklat_teknis')
                        ->whereId_krs($id)->get();
            $dataSP=KonfigurasiModel::whereJenis('skoring_pangkat')
                        ->whereId_krs($id)->get();

            $dataDSS=KonfigurasiModel::whereJenis('diklat_struktural')
                        ->whereKriteria('Sesuai')
                        ->whereId_krs($id)->first();

            $dataDST=KonfigurasiModel::whereJenis('diklat_struktural')
                        ->whereKriteria('Tidak Sesuai')
                        ->whereId_krs($id)->first();
            $getPendidikan=GlobalHelper::getDTP('pendidikan');
            $getGolongan=GlobalHelper::getDTP('golongan');
            return view('talent-mapping.krs-step3',compact('data','id','datapenkom','dataSKP','dataRWJ','dataDT','dataSP','dataDSS','dataDST','getPendidikan','getGolongan'));
        }else{
            return view('notfound');
        }

    }

    public function storekonfig(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        $post=array();$data=null;
        if($request->jenis=='penkom'){
            KonfigurasiModel::whereJenis('penkom')->delete();
        }else if($request->jenis=='diklat_struktural'){
            KonfigurasiModel::whereJenis('diklat_struktural')->delete();
        }

        if($request->type=='add'){
            KonfigurasiModel::create([
                'id_krs'=>$request->id_krs,
                'jenis'=>$request->jenis,
                'kriteria'=>$request->kriteria,
                'isidata'=>$request->isidata,
                'created_by'=>$request->created_by,
                'created_at'=>now()]);

            if($request->jenis=='diklat_struktural'){
                KonfigurasiModel::create([
                    'id_krs'=>$request->id_krs,
                    'jenis'=>$request->jenis,
                    'kriteria'=>$request->kriteria_2,
                    'isidata'=>$request->isidata_2,
                    'created_by'=>$request->created_by,
                    'created_at'=>now()]);
            }
        }else{
            KonfigurasiModel::find($request->id)->delete();
        }

        $data=KonfigurasiModel::where('id_krs','=',$request->id_krs)
                      ->where('jenis','=',$request->jenis)->orderBy('id','asc')->get();

        $post=array('respon'=>'success','data'=>$data);

        echo json_encode($post);
    }

    public function prosesHitung($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $konfigPenkom=GlobalHelper::getKonfigKrsPenkom($id);
            $penkom=$konfigPenkom->kriteria;
            $minPenkom=$konfigPenkom->isidata;
            $master=GlobalHelper::getKrs($id);
            $tahun_krs=$master->tahun;
            $jenis_krs=$master->jenis;


            Krs_temp_model::whereId_krs($id)->delete();

            // $kueri=KrsPegawaiTemplateModel::select('talenta_krs_pegawai_template.nip','talenta_krs_pegawai_template.nama_lengkap',
            //                                 'talenta_krs_pegawai_template.tgl_lahir','talenta_krs_pegawai_template.pendidikan',
            //                                 'talenta_krs_pegawai_template.eselon','talenta_krs_pegawai_template.level_jabatan',
            //                                 'talenta_krs_pegawai_template.satker','talenta_krs_pegawai_template.nama_jabatan',
            //                                 'talenta_krs_pegawai_template.tmt_jabatan',
            //                                 'talenta_krs_pegawai_template.tahun_penkom',
            //                                 'talenta_krs_pegawai_template.mansoskul',
            //                                 'talenta_krs_pegawai_template.generik',
            //                                 'talenta_krs_pegawai_template.spesifik',
            //                                 'talenta_krs_pegawai_template.pangkat','talenta_krs_pegawai_template.golongan',
            //                                 'talenta_rwjabatan_hitung.total as ttl_jabatan',
            //                                 'talenta_rwdiklat_hitung.diklat_struktural',
            //                                 'talenta_rwdiklat_hitung.diklat_teknis')
            //         ->join('talenta_rwdiklat_hitung','talenta_rwdiklat_hitung.nip','=','talenta_krs_pegawai_template.nip')
            //         ->join('talenta_rwjabatan_hitung','talenta_rwjabatan_hitung.nip','=','talenta_krs_pegawai_template.nip')
            //         ->distinct('talenta_krs_pegawai_template.nip')
            //         ->where('talenta_krs_pegawai_template.id_krs','=',$id)->get();

            // $bobotJabatan=GlobalHelper::getDataKonfig($id,'bobot_rwjabatan','bobot');
            // $bobotDiklat=GlobalHelper::getDataKonfig($id,'bobot_diklat','bobot');
            // $skp2=GlobalHelper::getDataKonfig($id,'skp2','skp');
            // $skp1=GlobalHelper::getDataKonfig($id,'skp1','skp');

            $kueri=KrsPegawaiTemplateModel::select('talenta_krs_pegawai_template.nip','talenta_krs_pegawai_template.nama_lengkap',
                                            'talenta_krs_pegawai_template.tgl_lahir','talenta_krs_pegawai_template.pendidikan',
                                            'talenta_krs_pegawai_template.eselon','talenta_krs_pegawai_template.level_jabatan',
                                            'talenta_krs_pegawai_template.satker','talenta_krs_pegawai_template.nama_jabatan',
                                            'talenta_krs_pegawai_template.tmt_jabatan',
                                            'talenta_krs_pegawai_template.tahun_penkom',
                                            'talenta_krs_pegawai_template.mansoskul',
                                            'talenta_krs_pegawai_template.generik',
                                            'talenta_krs_pegawai_template.spesifik',
                                            'talenta_krs_pegawai_template.pangkat','talenta_krs_pegawai_template.golongan')
                    ->distinct('talenta_krs_pegawai_template.nip')
                    ->where('talenta_krs_pegawai_template.id_krs','=',$id)->get();

            $bobotJabatan=GlobalHelper::getDataKonfig($id,'bobot_rwjabatan','bobot');
            $bobotDiklat=GlobalHelper::getDataKonfig($id,'bobot_diklat','bobot');
            $skp2=GlobalHelper::getDataKonfig($id,'skp2','skp');
            $skp1=GlobalHelper::getDataKonfig($id,'skp1','skp');


            foreach($kueri as $key => $item){
                    $getTotJabatan=GlobalHelper::getTotJabatan($item->nip);
                    $getTotDT=GlobalHelper::getTotDT($item->nip);
                    $getTotDS=GlobalHelper::getTotDS($item->nip);
                    // $skor_jabatan=GlobalHelper::getSkorJabatan($id,$item->ttl_jabatan);
                    // $skor_DT=GlobalHelper::getSkorDT($id,$item->diklat_teknis);
                    // $total_skor_jabatan=($skor_jabatan/$bobotJabatan)*100;
                    // $bobotDS=GlobalHelper::getBobotDS($id,$item->diklat_struktural);
                    // $totalDS=$bobotDS + $skor_DT;
                    // $totalDSPersen=round(($totalDS / $bobotDiklat)*100,2);

                    $skor_jabatan=GlobalHelper::getSkorJabatan($id,$getTotJabatan);
                    $skor_DT=GlobalHelper::getSkorDT($id,$getTotDT);
                    $total_skor_jabatan=($skor_jabatan/$bobotJabatan)*100;
                    $bobotDS=GlobalHelper::getBobotDS($id,$getTotDS);
                    $totalDS=$bobotDS + $skor_DT;
                    $totalDSPersen=round(($totalDS / $bobotDiklat)*100,2);
                    $array=array(
                        'id_krs'=>$id,
                        'jenis'=>$jenis_krs,
                        'nip'=> $item->nip,
                        'nama'=>$item->nama_lengkap,
                        'tgl_lahir'=>$item->tgl_lahir,
                        'pendidikan'=>$item->pendidikan,
                        'eselon'=>$item->eselon,
                        'level_jabatan'=>$item->level_jabatan,
                        'provinsi'=>'',
                        'satker'=>$item->satker,
                        'nama_jabatan'=>$item->nama_jabatan,
                        'tmt_jabatan'=>$item->tmt_jabatan,
                        'pangkat'=>$item->pangkat,
                        'golongan'=>$item->golongan,
                        'cek_penkom'=>$item->tahun_penkom,
                        'skoring_mansoskul'=>$item->mansoskul,
                        'skoring_generik'=>$item->generik,
                        'skoring_spesifik'=>$item->spesifik,
                        'skoring_pendidikan'=>GlobalHelper::getSkorPendidikan($id,$item->pendidikan),
                        'total_rw_jabatan'=>$getTotJabatan,
                        'bobot_rw_jabatan'=>$skor_jabatan,
                        'bobot_rw_jabatan_total'=>round($total_skor_jabatan, 4),
                        'diklat_struktural'=>$getTotDS,
                        'bobot_ds'=>$bobotDS,
                        'diklat_teknis'=>$getTotDT,
                        'bobot_dt'=>$skor_DT,
                        'total_bobot'=>$totalDS,
                        'total_bobot_persen'=>$totalDSPersen,
                        'skoring_pangkat'=>GlobalHelper::getSkorPangkat($id,$item->golongan),
                        'year2'=>GlobalHelper::getSKP($item->nip,$skp2),
                        'year1'=>GlobalHelper::getSKP($item->nip,$skp1),
                        'penilaian_perilaku'=>GlobalHelper::getPerilaku($item->nip,$tahun_krs),
                        'created_by'=>Auth::user()->userid,
                    );
                    Krs_temp_model::create($array);

            }
            //print_r($array);
            return view('talent-mapping.krs-hitung',compact('id','penkom'));
        }else{
            return view('notfound');
        }
    }
    public function step4_cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaNipPegawai($request->nip);}
            else{$nip=$request->nip;}
            $penkom=$request->penkom;
            $id=$request->id;
            return view('talent-mapping.krs-hitung',compact('nip','id','penkom'));
        }else{
            return view('notfound');
        }
    }
    public function getUsulan($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","status","fileupload","id_tikpot")
              ->whereId($id)->first();
            if($data->batch=="2" && $data->jenis=="administrator"){
                $dtBobot=KrsBobot::whereId_krs($id)->whereJenis('header')->first();
                $dtBobotIsi=KrsBobot::whereId_krs($id)->whereJenis('isi')->first();
                return view('talent-mapping.krs-daftar-usulan',compact('id','data','dtBobot','dtBobotIsi'));
            }else{
                return view('talent-mapping.krs-hitung',compact('id'));
            }
        }else{
            return view('notfound');
        }
    }

    public function getListTemp(Request $request){
         $param='';
         //if ($request->ajax()) {
            $data= Krs_temp_model::where('id_krs','=',$request->id_krs);
            if($request->nip !=''){
                $data->whereNip($request->nip);
            }
            $data->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nip', function ($data) {
                    return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->nip."')>".$data->nip."</a>";
                })
                ->rawColumns(['nip','diklat_teknis'])
                ->make(true);
        //}
    }

    public function simpankonfig(Request $request){

        $request->validate([
            'jenis_penkom'=>'required',
            'skp1'=>'required',
            'skp2'=>'required',
        ]);
       
        $kueri=PegawaiTalentaModel::select('pegawaiID','talenta_pegawai.nip','talenta_pegawai.thnpns','talenta_pegawai.nama_lengkap',
                                        'talenta_pegawai.tgl_lahir','talenta_pegawai.pendidikan','talenta_pegawai.eselon','talenta_pegawai.tmteselon',
                                        'talenta_pegawai.pangkat','talenta_pegawai.golongan','talenta_pegawai.tmtpangkat','talenta_pegawai.level_jabatan',
                                        'talenta_pegawai.nama_jabatan','talenta_pegawai.tmt_jabatan','talenta_pegawai.satker','talenta_pegawai.tipepegawai',
                                        'talenta_pegawai.statuspegawai','talenta_pegawai.kedudukan','talenta_penkom.mansoskul',
                                        'talenta_penkom.teknis_generik','talenta_penkom.teknis_spesifik','talenta_penkom.tahun');


        $master=GlobalHelper::getKrs($request->id);
        $tahun_krs=$master->tahun;
        $jenis_krs=$master->jenis;

        KonfigurasiModel::whereId_krs($request->id)->whereJenis('penkom')->delete();
        KonfigurasiModel::create([
            'id_krs'=>$request->id,
            'jenis'=>'penkom',
            'kriteria'=>$request->jenis_penkom,
            'isidata'=>$request->tahun_penkom,
            'created_by'=>Auth::user()->userid,
            'created_at'=>now()
        ]);

        KonfigurasiModel::whereId_krs($request->id)->whereJenis('bobot')->delete();
        KonfigurasiModel::create([
            'id_krs'=>$request->id,
            'jenis'=>'bobot',
            'kriteria'=>'bobot_rwjabatan',
            'isidata'=>$request->bobot_rwjabatan,
            'created_by'=>Auth::user()->userid,
            'created_at'=>now()
        ]);

        KonfigurasiModel::create([
            'id_krs'=>$request->id,
            'jenis'=>'bobot',
            'kriteria'=>'bobot_diklat',
            'isidata'=>$request->bobot_diklat,
            'created_by'=>Auth::user()->userid,
            'created_at'=>now()
        ]);

        //simpan data skp
        KonfigurasiModel::whereId_krs($request->id)->whereJenis('skp')->delete();
        KonfigurasiModel::create([
            'id_krs'=>$request->id,
            'jenis'=>'skp',
            'kriteria'=>'skp2',
            'isidata'=>$request->skp2,
            'created_by'=>Auth::user()->userid,
            'created_at'=>now()
        ]);

        KonfigurasiModel::create([
            'id_krs'=>$request->id,
            'jenis'=>'skp',
            'kriteria'=>'skp1',
            'isidata'=>$request->skp1,
            'created_by'=>Auth::user()->userid,
            'created_at'=>now()
        ]);
        $data=array();
        foreach ($request->jenis as $key3=>$item3) {
            switch($request->jenis[$key3]){
                case "umur":
                case "pns":
                case "tmt_eselon":
                case "tmt_pangkat":
                case "tmt_jabatan":
                case "satker":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->isi[$key3]));
                    break;
                case "pendidikan":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_pendidikan_value));
                    break;
                case "eselon":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_eselon_value));
                    break;
                case "pangkat":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_pangkat_value));
                    break;
                case "golongan":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_golongan_value));
                    break;
                case "level_jabatan":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_lvl_jabatan_value));
                    break;
                case "tipe_pegawai":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_tipe_pegawai_value));
                    break;
                case "status_pegawai":
                    $data[]=array("jenis"=>$item3,"param"=>$request->param[$key3],"detail"=>$request->isi_det[$key3],"value"=>array("value"=>$request->ck_status_pegawai_value));
                    break;
            }
        }

        KonfigurasiModel::whereId_krs($request->id)->whereJenis('pegawai')->delete();
        KonfigurasiModel::create([
            'id_krs'=>$request->id,
            'jenis'=>'pegawai',
            'kriteria'=>'konfig',
            'isidata'=>json_encode($data),
            'created_by'=>Auth::user()->userid,
            'created_at'=>now()
        ]);

        foreach ($request->isi as $key=>$item) {
            if($item !=''){
                switch($request->jenis[$key]){
                    case "umur":
                        $date = strtotime(GlobalHelper::changeDate('1', $request->isi_det[$key]).' -'.$request->isi[$key].' year');
                        $newdate= date('Y-m-d', $date); // echoes '2009-01-01'
                        $kueri=$kueri->where('talenta_pegawai.tgl_lahir',$request->param[$key],$newdate);
                        break;
                    case "pns":
                        $date = strtotime(GlobalHelper::changeDate('1', $request->isi_det[$key]).' -'.$request->isi[$key].' year');
                        $newdate= date('Ym', $date); // echoes '2009-01-01'
                        $kueri=$kueri->where('talenta_pegawai.thnpns',$request->param[$key],$newdate) ;
                        break;
                    case "pendidikan":
                        $kueri->whereIn('talenta_pegawai.pendidikan',$request->ck_pendidikan_value);
                        break;
                    case "eselon":
                        $kueri->whereIn('talenta_pegawai.eselon',$request->ck_eselon_value);
                        break;
                    case "tmt_eselon":
                        $date = strtotime(GlobalHelper::changeDate('1', $request->isi_det[$key]).' -'.$request->isi[$key].' year');
                        $newdate= date('Y-m-d', $date); // echoes '2009-01-01'
                        $kueri=$kueri->where('talenta_pegawai.tmteselon',$request->param[$key],$newdate);
                        break;
                    case "pangkat":
                        $kueri->whereIn('talenta_pegawai.pangkat',$request->ck_pangkat_value);
                        break;
                    case "golongan":
                        $kueri->whereIn('talenta_pegawai.golongan',$request->ck_golongan_value);
                        break;
                    case "tmt_pangkat":
                        $date = strtotime(GlobalHelper::changeDate('1', $request->isi_det[$key]).' -'.$request->isi[$key].' year');
                        $newdate= date('Y-m-d', $date); // echoes '2009-01-01'
                        $kueri=$kueri->where('talenta_pegawai.tmtpangkat',$request->param[$key],$newdate);
                        break;
                    case "level_jabatan":
                        $kueri->whereIn('talenta_pegawai.level_jabatan',$request->ck_lvl_jabatan_value);
                        break;
                    case "tmt_jabatan":
                        $date = strtotime(GlobalHelper::changeDate('1', $request->isi_det[$key]).' -'.$request->isi[$key].' year');
                        $newdate= date('Y-m-d', $date); // echoes '2009-01-01'
                        $kueri=$kueri->where('talenta_pegawai.tmt_jabatan',$request->param[$key],$newdate);
                        break;
                    case "satker":
                        $date = strtotime(GlobalHelper::changeDate('1', $request->isi_det[$key]).' -'.$request->isi[$key].' year');
                        $newdate= date('Y-m-d', $date); // echoes '2009-01-01'
                        $kueri=$kueri->where('talenta_pegawai.satker',$request->param[$key],$newdate);
                        break;
                    case "tipe_pegawai":
                        $kueri->whereIn('talenta_pegawai.tipepegawai',$request->ck_tipe_pegawai_value);
                        break;
                    case "status_pegawai":
                        $kueri->whereIn('talenta_pegawai.statuspegawai',$request->ck_status_pegawai_value);
                        break;
                }
            }


        }
        $kueri->join('talenta_penkom','talenta_penkom.nip','=','talenta_pegawai.nip')
                ->distinct('talenta_pegawai.nip')
                ->where('talenta_penkom.tahun','>=',$request->tahun_penkom)
                ->where('talenta_penkom.tahun','<=',$tahun_krs)
                ->where('talenta_penkom.jenis','=',$request->jenis_penkom);
        $finalQ=$kueri->get();
        
        KrsPegawaiTemplateModel::where('id_krs','=',$request->id)->delete();
        

        foreach($finalQ as $key2=>$rw){
            $dtPenkom=GlobalHelper::getDataPenkom($rw->nip,$tahun_krs,$request->jenis_penkom);
            KrsPegawaiTemplateModel::create([
                'pegawaiID'=>$rw->pegawaiID,
                'nip'=>$rw->nip,
                'thnpns'=>$rw->thnpns,
                'nama_lengkap'=>$rw->nama_lengkap,
                'tgl_lahir'=>$rw->tgl_lahir,
                'pendidikan'=>$rw->pendidikan,
                'eselon'=>$rw->eselon,
                'tmteselon'=>$rw->tmteselon,
                'pangkat'=>$rw->pangkat,
                'golongan'=>$rw->golongan,
                'tmtpangkat'=>$rw->tmtpangkat,
                'level_jabatan'=>$rw->level_jabatan,
                'nama_jabatan'=>$rw->nama_jabatan,
                'tmt_jabatan'=>$rw->tmt_jabatan,
                'satker'=>$rw->satker,
                'tipepegawai'=>$rw->tipepegawai,
                'statuspegawai'=>$rw->statuspegawai,
                'kedudukan'=>$rw->kedudukan,
                'id_krs'=>$request->id,
                'tahun_krs'=>$tahun_krs,
                'jenis_krs'=>$jenis_krs,
                'tahun_penkom'=>$dtPenkom->tahun,
                'mansoskul'=>$dtPenkom->mansoskul,
                'generik'=>$dtPenkom->teknis_generik,
                'spesifik'=>$dtPenkom->teknis_spesifik,
                'created_by'=>Auth::user()->userid,
                'created_at'=>now(),

            ]);
        }
       return redirect('/talent-mapping/step2/'.$request->id.'/'.$request->jenis_penkom.'');

    }

    public function step2($id,$jenis){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            return view('talent-mapping.krs-step2',compact('id','jenis'));
        }else{
            return view('notfound');
        }

    }
    public function getDataStep2(Request $request){
        //echo 'req'.$request->id_krs;
        $param='';
        //if($request->ajax()) {
            $data= KrsPegawaiTemplateModel::where('id_krs','=',$request->id_krs)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        //}
    }

    public function export($id)
    {
        $konfigPenkom=GlobalHelper::getKonfigKrsPenkom($id);
        $penkom=$konfigPenkom->kriteria;
        return Excel::download(new talentMapping($id,$penkom), 'talent-mapping.xlsx');
    }

    public function upload($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","status")
                            ->whereId($id)->first();
            $status=$data->status;
            $dtTikpot=TikpodModel::select("id","nama")->whereStatus('a')->orderBy('id','desc')->get();
            return view('talent-mapping.upload',compact('data','id','dtTikpot','status'));
        }else{
            return view('notfound');
        }
    }

    public function prosesupload(Request $request){
        $request->validate([
            'fileupload'=>'required',
            'id_tikpot'=>'required',

        ]);

        $file = $request->file('fileupload');
        $ext = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $nama_file = 'Talent-mapping-'.$request->id.'.'.$ext;

        KrsModel::whereId($request->id)->update([
            'fileupload'=>$nama_file,
            'id_tikpot'=>$request->id_tikpot
        ]);

        $path = $file->storeAs('public/excel/imports/talent-mapping/',$nama_file);

        // import data
        return redirect('/talent-mapping/upload/step2/'.$request->id.'');
    }

    public function uploadStep2($id){
        $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","fileupload","id_tikpot","status")
                        ->whereId($id)->first();
        $status=$data->status;
        if($status=='delete'){
            return view('talent-mapping.upload-step2',[
                'id'=>$id,
                'headings'=>'',
                'data'=>$data,
                'status'=>$status
            ]);
        }else{
            $nama_file=$data->fileupload;
            HeadingRowFormatter::default('none');
            $headings = (new HeadingRowImport)->toArray(storage_path('app/public/excel/imports/talent-mapping/'.$nama_file)); // set csv path here or $request->file('upload_file');

            return view('talent-mapping.upload-step2',[
                'id'=>$id,
                'headings'=>$headings,
                'data'=>$data,
                'status'=>$status
            ]);

        }
    }
    public function prosesuploadStep2(Request $request){
        $request->validate([
            'pegawai'=>'required',
            'potensial'=>'required',
            'kinerja'=>'required',

        ]);

        $header=array();$bobotPotensial=array();$bobotKinerja=array();
        foreach($request->pegawai as $key=>$rw){
            array_push($header,$rw);
        }
        foreach($request->potensial as $key=>$rw){
            array_push($header,$rw);
            array_push($bobotPotensial,0);
            $tp=explode('^',$rw);
            array_push($header,'Bobot '.$tp[1].'');
        }
        foreach($request->kinerja as $key=>$rw){
            array_push($header,$rw);
            array_push($bobotKinerja,0);
            $tp=explode('^',$rw);
            array_push($header,'Bobot '.$tp[1].'');
        }

        array_push($header,'Potensial');
        array_push($header,'Kinerja');
        array_push($header,'Kotak Pemetaan');

        KrsHeaderModel::whereId_krs($request->id)->delete();
        KrsHeaderModel::create([
            'id_krs'=>$request->id,
            'pegawai'=>json_encode($request->pegawai),
            'potensial'=>json_encode($request->potensial),
            'kinerja'=>json_encode($request->kinerja),
            'header'=>json_encode($header),
            'created_at'=>now(),
            'created_by'=>Auth::user()->userid,
        ]);

        KrsBobot::whereId_krs($request->id)->delete();
        KrsBobot::create([
            'id_krs'=>$request->id,
            'potensial'=>json_encode($request->potensial),
            'kinerja'=>json_encode($request->kinerja),
            'jenis'=>'header',
            'created_at'=>now(),
            'created_by'=>Auth::user()->userid,
        ]);

        KrsBobot::create([
            'id_krs'=>$request->id,
            'potensial'=>json_encode($bobotPotensial),
            'kinerja'=>json_encode($bobotKinerja),
            'jenis'=>'isi',
            'created_at'=>now(),
            'created_by'=>Auth::user()->userid,
        ]);

        return redirect('/talent-mapping/konfigbobot/'.$request->id.'');

    }

    public function konfigBobot($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","fileupload","id_tikpot")
                        ->whereId($id)->first();
            $dtBobot=KrsBobot::whereId_krs($id)->whereJenis('header')->first();
            $dtBobotIsi=KrsBobot::whereId_krs($id)->whereJenis('isi')->first();
            return view('talent-mapping.konfigbobot',compact('id','data','dtBobot','dtBobotIsi'));
        }else{
            return view('notfound');
        }
    }

    public function calculateKRS(Request $request){
        //update bobot
        $arrPotensial=array();$arrKinerja=array();
        foreach($request->potensial as $key=>$val){
            array_push($arrPotensial,(int)$val);
        }
        foreach($request->kinerja as $key=>$val){
            array_push($arrKinerja,(int)$val);
        }
        KrsBobot::whereId_krs($request->id)->whereJenis('isi')->delete();
        KrsBobot::create([
            'id_krs'=>$request->id,
            'potensial'=>json_encode($arrPotensial),
            'kinerja'=>json_encode($arrKinerja),
            'jenis'=>'isi',
            'created_at'=>now(),
            'created_by'=>Auth::user()->userid,
        ]);

        //calculate and save krs
        KrsFinalModel::whereId_krs($request->id)->delete();
        $data=KrsHeaderModel::whereId_krs($request->id)->first();
        $dtPotensial=KrsBobot::whereId_krs($request->id);
        $pegawai=$potensial=$kinerja=$nilai=array();
        $jsonPegawai=json_decode($data->pegawai);
        for($i = 0; $i < count($jsonPegawai); $i++){
            array_push($pegawai,$jsonPegawai[$i]);
        }

        $jsonPotensial=json_decode($data->potensial);
        for($i = 0; $i < count($jsonPotensial); $i++){
            array_push($potensial,$jsonPotensial[$i]);
            array_push($potensial,'Bobot '.$jsonPotensial[$i].' ('.$request->potensial[$i].'%)');

        }
        $jsonKinerja=json_decode($data->kinerja);
        for($i = 0; $i < count($jsonKinerja); $i++){
            array_push($kinerja,$jsonKinerja[$i]);
            array_push($kinerja,'Bobot '.$jsonKinerja[$i].' ('.$request->kinerja[$i].'%)');

        }

        //echo $request->id;
        KrsFinalModel::create([
            'id_krs'=>$request->id,
            'nip'=>'00',
            'pegawai'=>json_encode($pegawai),
            'potensial'=>json_encode($potensial),
            'kinerja'=>json_encode($kinerja),
            'nilai'=>json_encode(array('Potensial','Kinerja','Peta Talenta')),
            'jenis'=>'header',
            'status'=>'non_publish',
            'created_at'=>now(),
            'created_by'=>Auth::user()->userid,
        ]);

        $dataUpload=KrsModel::select("fileupload")
                         ->whereId($request->id)->first();

        $nama_file=$dataUpload->fileupload;
        $import = Excel::import(new TalentMappingImport($request->id), storage_path('app/public/excel/imports/talent-mapping/'.$nama_file));
        if($import){
            KrsModel::find($request->id)->update(['status'=>'non_publish']);
            return redirect('talent-mapping/detail/'.$request->id);
        }
    }

    public function detail($id){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","status","fileupload","id_tikpot","status")
                        ->whereId($id)->first();
            $dtBobot=KrsBobot::whereId_krs($id)->whereJenis('header')->first();
            $dtBobotIsi=KrsBobot::whereId_krs($id)->whereJenis('isi')->first();
            $status=$data->status;
            return view('talent-mapping.krs-detail',compact('id','data','dtBobot','dtBobotIsi','status'));

        }else{
            return view('notfound');
        }
    }

    public function getDetailNilai(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        $dkrs=array();
        $dataKRS=KrsModel::select("id","tahun","deskripsi","batch","jenis","status","fileupload","id_tikpot")
        ->whereId($request->id_krs)->first();
        if($dataKRS){
            $dkrs=array($dataKrs);
        }

        $dataPegawai=PegawaiTalentaModel::select('nip','nama_lengkap')->whereNip($request->nip)->first();
        $data=KrsFinalModel::find($request->id);
        $dataHeader=KrsFinalModel::whereId_krs($request->id_krs)->whereJenis('header')->first();
        $posts=array(
            'dataKrs'=>$dkrs,
        );
        echo json_encode($posts,true);

    }

    public function detail_cari(Request $request){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            if($request->nip !=''){$nip= GlobalHelper::getNamaNipPegawai($request->nip);}
            else{$nip=$request->nip;}
            $id=$request->id;
            $data=KrsModel::select("id","tahun","deskripsi","batch","jenis","status","fileupload","id_tikpot")
                        ->whereId($request->id)->first();
            $dtBobot=KrsBobot::whereId_krs($request->id)->whereJenis('header')->first();
            $dtBobotIsi=KrsBobot::whereId_krs($request->id)->whereJenis('isi')->first();
            $status=$data->status;
            return view('talent-mapping.krs-detail',compact('id','data','dtBobot','dtBobotIsi','nip','status'));

        }else{
            return view('notfound');
        }
    }

    public function getdetailkrs(Request $request){
        $param='';
        if ($request->ajax()) {
            $data= KrsFinalModel::select('talenta_krs_final.id','talenta_krs_final.id_krs','talenta_krs_final.nip','talenta_krs_final.nilai','talenta_pegawai.pangkat','talenta_pegawai.golongan','talenta_pegawai.nama_lengkap')
                    ->join('talenta_pegawai','talenta_pegawai.nip','=','talenta_krs_final.nip')
                    ->where('id_krs','=',$request->id_krs)->whereJenis('isi');
            if($request->nip !=''){
                $data->where('talenta_krs_final.nip','=',$request->nip);
            }

            $data->orderBy('talenta_krs_final.id','asc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nip', function ($data) {
                    return "<a href='".url('/report/pegawai/detail-talent/pengawas/'.$data->id.'/'.$data->id_krs.'/'.$data->nip.'')."' target='_BLANK' class='text-primary'>".$data->nip."</a>";
                })
                ->addColumn('potensial',function($data){
                    $json=json_decode($data->nilai);
                    $potensial=$json[0];
                    return $potensial;
                })
                ->addColumn('kinerja',function($data){
                    $json=json_decode($data->nilai);
                    $kinerja=$json[1];
                    return $kinerja;
                })
                ->addColumn('kotak',function($data){
                    $json=json_decode($data->nilai);
                    $kotak=$json[2];
                    return $kotak;
                })
                ->rawColumns(['nip','potensial','kinerja','kotak'])
                ->make(true);
       }
    }

    public function updateStatus($id,$status){
        KrsFinalModel::whereId_krs($id)->update(['status'=>$status]);
        KrsModel::find($id)->update(['status'=>$status]);
        if($status=='publish'){
            $dt_awal=KrsModel::find($id);
            if($dt_awal->id_krs_awal != null){
                KrsModel::find($dt_awal->id_krs_awal)->update(['status'=>'non_publish']);
                KrsFinalModel::whereId_krs($dt_awal->id_krs_awal)->update(['status'=>'non_publish']);
            }

        }else{
            $dt_awal=KrsModel::find($id);
            if($dt_awal->id_krs_awal != null){
                KrsModel::find($dt_awal->id_krs_awal)->update(['status'=>'publish']);
                KrsFinalModel::whereId_krs($dt_awal->id_krs_awal)->update(['status'=>'publish']);
            }
        }

        return redirect('talent-mapping/detail/'.$id);
    }



    public function getDaftarUsulan(Request $request){
        $param='';
       // if ($request->ajax()) {
            $data= KrsAdminTemplateModel::select('talenta_krs_final.krs_pegawai_temp_admin.id_krs','talenta_krs_final.krs_pegawai_temp_admin.nip','talenta_krs_final.krs_pegawai_temp_admin.nilai','talenta_pegawai.pangkat','talenta_pegawai.golongan','talenta_pegawai.nama_lengkap')
                    ->join('talenta_pegawai','talenta_pegawai.nip','=','talenta_krs_final.krs_pegawai_temp_admin.nip')
                    ->where('id_krs','=',$request->id_krs)->whereJenis('isi')
                    ->orderBy('talenta_krs_final.krs_pegawai_temp_admin.id','asc')
                    ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nip', function ($data) {
                    return "<a href='#' class='text-primary' onclick=showGlobalModal('".$data->id_krs."','".$data->nip."')>".$data->nip."</a>";
                })
                ->addColumn('potensial',function($data){
                    $json=json_decode($data->nilai);
                    $potensial=$json[0];
                    return $potensial;
                })
                ->addColumn('kinerja',function($data){
                    $json=json_decode($data->nilai);
                    $kinerja=$json[1];
                    return $kinerja;
                })
                ->addColumn('kotak',function($data){
                    $json=json_decode($data->nilai);
                    $kotak=$json[2];
                    return $kotak;
                })
                ->rawColumns(['nip','potensial','kinerja','kotak'])
                ->make(true);
        //}
    }

    public function getDetailDaftarUsulan(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");

        $data=KrsAdminTemplateModel::whereId_krs($request->id_krs)->whereNip($request->nip)->first();
        $header=KrsAdminTemplateModel::whereId_krs($request->id_krs)->whereJenis('header')->first();
        if($data){
            $posts=array('response'=>'success','data'=>$data,'header'=>$header);
        }else{
            $posts=array('response'=>'success','data'=>array(),'header'=>$header);
        }

        return json_encode($posts);
    }

    public function getcekkrs(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");
        $kueri=KrsModel::select('id','deskripsi')
                ->where('jenis','=',$request->jenis)
                ->orderBy('tahun','desc')
                ->get();
        $posts=$kueri;

        return json_encode($posts);
    }

    public function getKRS(Request $request){
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json");


        if($data){
            $posts=array('response'=>'success','data'=>$data,'header'=>$header);
        }else{
            $posts=array('response'=>'success','data'=>array(),'header'=>$header);
        }

        return json_encode($posts);
    }

    public function export_krs($id)
    {
        return Excel::download(new talentMappingFinal($id), 'talent-mapping-export.xlsx');
    }
    public function export_krs_batch2($id)
    {
        return Excel::download(new talentMappingFinalBatch2($id), 'talent-mapping-export-kotak-789.xlsx');
    }

    public function dashboard_detail($jenis=null,$tahun=null,$status=null){
        if(GlobalHelper::cekAkses(Auth::user()->userid,"12")){
            return view('talent-mapping.krs',compact('tahun','jenis','status'));
        }else{
            return view('notfound');
        }
    }
}
