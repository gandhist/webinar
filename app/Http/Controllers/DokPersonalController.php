<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use App\ProvinsiModel;
use App\KotaModel;
use App\JenjangPendidikan;
use App\BankModel;
use App\NegaraModel;
use App\PersonalSekolah;
use App\Sekolah;
use App\SkpPjk3;
use App\SkpAk3;
use App\JenisUsaha;
use App\BuModel;
use App\JenisDok;
use App\JenisDokSertifikat;
use App\masterBidang;
use App\masterBidSertifikatAlat;

use Carbon\Carbon;
use Auth;

class DokPersonalController extends Controller
{

    public function index() {

        $data = SkpAk3::where('is_actived','>','0')->orWhereNull('is_actived')->get();
        $idpersonal = SkpAk3::select('id_personal')->where('is_actived','>','0')->orWhereNull('is_actived')->groupBy('id_personal')->get()->toArray();
        $x = Personal::join('ms_kota','personal.kota_id','ms_kota.id')->select('ms_kota.provinsi_id')->whereIn('personal.id',$idpersonal)->groupBy('ms_kota.provinsi_id')->get()->toArray();
        $prov = ProvinsiModel::whereIn('id',$x)->get();
        $personil = Personal::all();
        $kota =  KotaModel::where('id','=','~')->get();
        $negara = NegaraModel::all();
        $bank = BankModel::all();
        $sekolah = PersonalSekolah::all();
        $sklh = PersonalSekolah::select('id_personal','default','id_jenjang', 'jurusan','tahun','no_ijazah','tgl_ijasah','nama_sekolah')->orderBy('id_personal')->where('default','=','0')->get();
        $pjk3 = SkpPjk3::groupBy('kode_pjk3')->get();
        $idinstansi = SkpAk3::select('id_skp_pjk3')->groupBy('id_skp_pjk3')->get()->toArray();
        $instansi = BuModel::whereIn('id',$idinstansi)->get();
        $x = SkpAk3::join('ms_bidang','skp_ak3.id_bid_skp','ms_bidang.id')->select('ms_bidang.id_jns_usaha')->groupBy('ms_bidang.id_jns_usaha')->get()->toArray();
        $jenisusaha = JenisUsaha::whereIn('id',$x)->orderBy('id','asc')->get();
        $idjnsdok = SkpAk3::select('jns_dok')->groupBy('jns_dok')->get()->toArray();
        $jenisdok = JenisDok::whereIn('id',$idjnsdok)->get();
        $idbid = SkpAk3::select('id_bid_skp')->groupBy('id_bid_skp')->get()->toArray();
        $bidang = masterBidang::whereIn('id',$idbid)->get();
        $idjnsdoksrtf = SkpAk3::select('id_srtf_alat')->groupBy('id_srtf_alat')->get()->toArray();
        $jenisdoksrtf = JenisDokSertifikat::groupBy('id_srft_alat')->whereIn('id_srft_alat',$idjnsdoksrtf)->get();
        $instansidok = SkpAk3::select('instansi_skp')->whereNotNull('instansi_skp')->groupBy('instansi_skp')->get();
        $penyelenggara = SkpAk3::select('penyelenggara')->whereNotNull('penyelenggara')->groupBy('penyelenggara')->get();

        $idpers = SkpAk3::select('id_personal')->groupBy('id_personal')->get()->toArray();
        $idjenjang = Sekolah::select('id_jenjang')->whereIn('id_personal',$idpers)->groupBy('id_jenjang')->whereNotNull('id_jenjang');
        $person = Personal::select('id')->whereNotIn('id',$idpers)->get()->toArray();
        $person_jenjang = Sekolah::select('id_jenjang')->whereIn('id_personal',$person)->whereNotIn('id_jenjang',$idjenjang)->groupBy('id_jenjang')->whereNotNull('id_jenjang')->union($idjenjang)->get()->toArray();
        $jp = JenjangPendidikan::whereIn('id_jenjang',$person_jenjang)->get();
        $prodi = Sekolah::select('jurusan')->whereIn('id_personal',$idpers)->groupBy('jurusan')->get();

        return view('dokpersonal.index')
                ->with(compact('data','personil','prov','kota','bank','sekolah','sklh','pjk3','instansi','jenisusaha','jenisdok','bidang','jenisdoksrtf','instansidok','penyelenggara','negara','jp','prodi'));

    }

    public function filter(Request $request)
    {
        $data = SkpAk3::orderBy('id','asc')->where('is_actived','>','0');
        $idpersonal = SkpAk3::select('id_personal')->where('is_actived','>','0')->orWhereNull('is_actived')->groupBy('id_personal')->get()->toArray();
        $x = Personal::join('ms_kota','personal.kota_id','ms_kota.id')->select('ms_kota.provinsi_id')->whereIn('personal.id',$idpersonal)->groupBy('ms_kota.provinsi_id')->get()->toArray();
        $prov = ProvinsiModel::whereIn('id',$x)->get();
        $sekolah = Sekolah::where('default','=','1')->get();
        $sklh = Sekolah::where('default','=','0')->get();
        $pjk3 = SkpPjk3::groupBy('kode_pjk3')->get();
        $personil = Personal::all();
        $instansi = BuModel::all();
        $jenisusaha = JenisUsaha::all();
        $idjnsdok = SkpAk3::select('jns_dok')->groupBy('jns_dok')->get()->toArray();
        $jenisdok = JenisDok::whereIn('id',$idjnsdok)->get();
        $idbid = SkpAk3::select('id_bid_skp')->groupBy('id_bid_skp')->get()->toArray();
        $bidang = masterBidang::whereIn('id',$idbid)->get();
        $idjnsdoksrtf = SkpAk3::select('id_srtf_alat')->groupBy('id_srtf_alat')->get()->toArray();
        $jenisdoksrtf = JenisDokSertifikat::groupBy('id_srft_alat')->whereIn('id_srft_alat',$idjnsdoksrtf)->get();
        $instansidok = SkpAk3::select('instansi_skp')->whereNotNull('instansi_skp')->groupBy('instansi_skp')->get();
        $penyelenggara = SkpAk3::select('penyelenggara')->whereNotNull('penyelenggara')->groupBy('penyelenggara')->get();
        $idpers = SkpAk3::select('id_personal')->groupBy('id_personal')->get()->toArray();
        $idjenjang = Sekolah::select('id_jenjang')->whereIn('id_personal',$idpers)->groupBy('id_jenjang')->whereNotNull('id_jenjang');
        $person = Personal::select('id')->whereNotIn('id',$idpers)->get()->toArray();
        $person_jenjang = Sekolah::select('id_jenjang')->whereIn('id_personal',$person)->whereNotIn('id_jenjang',$idjenjang)->groupBy('id_jenjang')->whereNotNull('id_jenjang')->union($idjenjang)->get()->toArray();
        $jp = JenjangPendidikan::whereIn('id_jenjang',$person_jenjang)->get();
        $prodi = Sekolah::select('jurusan')->whereIn('id_personal',$idpers)->groupBy('jurusan')->get();

        if($request->f_awal_terbit != null && $request->f_akhir_terbit != null){
            $data->whereBetween('tgl_skp', [Carbon::createFromFormat('d/m/Y',$request->f_awal_terbit), Carbon::createFromFormat('d/m/Y',$request->f_akhir_terbit)]);
        }
        if($request->f_awal_akhir != null && $request->f_akhir_akhir != null){
            $data->whereBetween('tgl_akhir_skp', [Carbon::createFromFormat('d/m/Y',$request->f_awal_akhir), Carbon::createFromFormat('d/m/Y',$request->f_akhir_akhir)]);
        }
        if (!$request->f_provinsi===NULL || !$request->f_provinsi==""){
            $kode_kota = Kota::where('provinsi_id',$request->f_provinsi)->get(['id'])->toArray();
            $personil = Personal::whereIn('kode_kota',$kode_kota)->get(['id'])->toArray();
            $data->whereIn('id_personal', $personil);

            $id_personil = SkpAk3::select('id_personal')->groupBy('id_personal')->get()->toArray();
            $idkota = Personil::select('kode_kota')->groupBy('kode_kota')->whereIn('id',$id_personil)->get()->toArray();
            $kota = KotaModel::whereIn('id',$idkota)->where('provinsi_id',$request->f_provinsi)->get();
        } else{
            $kota = KotaModel::where('id','=','~')->get();
        }
        if (!$request->f_kota===NULL || !$request->f_kota==""){
            $kode_kota = KotaModel::where('id', $request->f_kota)->get(['id'])->toArray();
            $personil = Personal::whereIn('kode_kota',$kode_kota)->get(['id'])->toArray();
            $data->whereIn('id_personal', $personil);
        }
        if (!$request->f_jenis_usaha===NULL || !$request->f_jenis_usaha==""){
            $jnsusaha = BuModel::where('jns_usaha', $request->f_jenis_usaha)->get(['id']);
            $data->whereIn('id_skp_pjk3', $jnsusaha);
        }
        if (!$request->f_pjk3===NULL || !$request->f_pjk3==""){
            $data->where('id_skp_pjk3', '=', $request->f_pjk3);
        }
        if (!$request->f_bidang_dok===NULL || !$request->f_bidang_dok==""){
            $idjnsdok = SkpAk3::select('jns_dok')->groupBy('jns_dok')->where('id_bid_skp','=', $request->f_bidang_dok)->get()->toArray();
            $jenisdok = JenisDok::whereIn('id',$idjnsdok)->get();
            $data->where('id_bid_skp', '=', $request->f_bidang_dok);
        }
        if (!$request->f_jenis_dok===NULL || !$request->f_jenis_dok==""){
            $data->where('jns_dok', '=', $request->f_jenis_dok);
        }
        if (!$request->f_nama_dok===NULL || !$request->f_nama_dok==""){
            $namasrtf = JenisDokSertifikat::where('id', $request->f_nama_dok)->get(['id_srft_alat'])->toArray();
            if($request->ck_nama_dok == "on"){
                $pers_y = SkpAk3::select('id_personal')->whereIn('id_srtf_alat', $namasrtf)->groupBy('id_personal')->get()->toArray();
                $pers_n = SkpAk3::select('id_personal')->whereNotIn('id_personal', $pers_y)->groupBy('id_personal')->get()->toArray();
                $data_pers = Personal::selectRaw('"" as id,"" as prov_naker,null as id_skp_pjk3,id as id_personal,null as id_srtf_alat,null as jns_dok,"" as penyelenggara,"" as no_skp,null as tgl_skp,
                                "x" as tgl_akhir_skp,"" as instansi_skp,null as id_bid_skp,"" as keterangan,"" as is_actived,"" as created_by,created_at as created_at,updated_by as updated_by,
                                updated_at as updated_at,deleted_by as deleted_by,deleted_at as deleted_at,null as pdf_skp_ak3')->whereNotIn('id',$pers_y)->whereNotIn('id',$pers_n);
                $data->whereNotIn('id_personal', $pers_y)->union($data_pers);
            } else{
                $data->whereIn('id_srtf_alat', $namasrtf);
            }
        }
        if (!$request->f_dok_ahli===NULL || !$request->f_dok_ahli==""){
            if ($request->f_dok_ahli == '2'){
                $jnsdok = JenisDokSertifikat::whereNotNull('bina')->get(['id_srft_alat']);
                $data->whereNotIn('id_srtf_alat', $jnsdok);
            } else{
                $jnsdok = JenisDokSertifikat::where('bina','=',$request->f_dok_ahli)->get(['id_srft_alat']);
                $data->whereIn('id_srtf_alat', $jnsdok);
            }
        }
        if (!$request->f_instansi_dok===NULL || !$request->f_instansi_dok==""){
            $data->where('instansi_skp', '=', $request->f_instansi_dok);
        }
        if (!$request->f_penyelenggara===NULL || !$request->f_penyelenggara==""){
            $data->where('penyelenggara', '=', $request->f_penyelenggara);
        }
        if (!$request->f_jenjang_pendidikan===NULL || !$request->f_jenjang_pendidikan==""){
            switch($request->f_jenjang_pendidikan){
                case('sma'):
                    $sekolah = Sekolah::whereIn('id_jenjang', ['8','9','10'])->get(['id_personal'])->toArray();
                    $personil = Personal::whereIn('id',$sekolah)->get(['id'])->toArray();
                    $data->whereIn('id_personal', $personil);
                break;
                case('d3'):
                    $sekolah = Sekolah::whereIn('id_jenjang', ['8','9','10'])->get(['id_personal'])->toArray();
                    $personil = Personal::whereIn('id',$sekolah)->get(['id'])->toArray();
                    $data->whereIn('id_personal', $personil);
                break;
                case('s1'):
                    $sekolah = Sekolah::whereIn('id_jenjang', ['8','9','10'])->get(['id_personal'])->toArray();
                    $personil = Personal::whereIn('id',$sekolah)->get(['id'])->toArray();
                    $data->whereIn('id_personal', $personil);
                break;
                default:
                    $sekolah = Sekolah::where('id_jenjang',$request->f_jenjang_pendidikan)->get(['id_personal'])->toArray();
                    $personil = Personal::whereIn('id',$sekolah)->get(['id'])->toArray();
                    $data->whereIn('id_personal', $personil);
                break;
            }
        }
        if (!$request->f_program_studi===NULL || !$request->f_program_studi==""){
            $sekolah = Sekolah::where('jurusan',$request->f_program_studi)->get(['id_personal'])->toArray();
            $personil = Personal::whereIn('id',$sekolah)->get(['id'])->toArray();
            $data->whereIn('id_personal', $personil);
        }

        $data->get();
        $data = $data->get();

        return view('dokpersonal.index')->with(compact('data','prov','kota','sekolah','pjk3','instansi','jenisusaha','jenisdok','bidang','sklh','personil','instansidok','penyelenggara','jenisdoksrtf','jp','prodi'));
    }

    public function create() {
        // TempSkpAk3::where('id_user', '=', Auth::id())->delete();

        $data = SkpAk3::all();
        $prov = ProvinsiModel::all();
        $kota = KotaModel::all();
        $bank = BankModel::all();
        $pjk3 = SkpPjk3::groupBy('kode_pjk3')->get();
        $jenisusaha = JenisUsaha::all();
        $personil = Personal::all();
        $instansi = BuModel::all();
        $bidang = masterBidang::orderBy('id_jns_usaha','asc')->where("sektor", "PPKB")->get();
        $sertifikatalat = masterBidSertifikatAlat::all();
        $jenisdok = JenisDok::all();
        $jenisdoksrtf = JenisDokSertifikat::all();

        return view('dokpersonal.create')
                ->with(compact('data','prov','kota','bank','pjk3','jenisusaha',
                                'personil','instansi','bidang','sertifikatalat',
                                'jenisdok','jenisdoksrtf'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nama_pjk3' => 'required',
            'id_personal'=> 'required'
        ],[
            'id_nama_pjk3.required'=>'Nama PJK3 harus di pilih!',
            'id_personal.required'=>'Nama Personil harus di pilih!'
        ]);

        $personil = Personal::find($request->id_personal);
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $personil->nama);

        $id_nama_pjk3 = $request->id_nama_pjk3;
        $id_personal = $request->id_personal;

        if (is_null($request->id_detail_dokpersonil) || $request->id_detail_dokpersonil=='' ) {
            return back();
        } else {
            $jumlah_detail = explode(',', $request->id_detail_dokpersonil);
            foreach($jumlah_detail as $jumlah_detail) {
                // $pjk3 = SkpPjk3::select('id')->where('kode_pjk3', '=',$id_nama_pjk3)->where('bid_sk', '=', $request->$x)->first();
                $dataDetail['id_skp_pjk3'] = $id_nama_pjk3;
                $dataDetail['id_personal'] = $id_personal;
                $dataDetail['prov_naker'] = '31';
                $dataDetail['created_by'] = Auth::id();
                $dataDetail['created_at'] = Carbon::now()->toDateTimeString();
                $dataDetail['is_actived'] = '1'; // data yg aktif dan ditampilkan
                $x = "id_bidang_".$jumlah_detail;
                $dataDetail['id_bid_skp'] = $request->$x;
                $x = "id_srtfalat_".$jumlah_detail;
                $dataDetail['id_srtf_alat'] = $request->$x;
                $x = "id_jenisdok_".$jumlah_detail;
                $dataDetail['jns_dok'] = $request->$x;
                $x = "id_instansidok_".$jumlah_detail;
                // if($request->$x == 'lain'){
                //     $x = "id_instansidok2_".$jumlah_detail;
                //     $dataDetail['instansi_skp'] = $request->$x;
                // } else{
                //     $dataDetail['instansi_skp'] = $request->$x;
                // }
                $dataDetail['instansi_skp'] = $request->$x;
                $x = "id_penyelenggara_".$jumlah_detail;
                // if($request->$x == 'lain'){
                //     $x = "id_penyelenggara2_".$jumlah_detail;
                //     $dataDetail['penyelenggara'] = $request->$x;
                // } else{
                //     $dataDetail['penyelenggara'] = $request->$x;
                // }
                $dataDetail['penyelenggara'] = $request->$x;
                $x = "id_nodokumen_".$jumlah_detail;
                $dataDetail['no_skp'] = $request->$x;
                $x = "id_tglterbit_".$jumlah_detail;
                if($request->$x=="" || $request->$x==null){
                    $tanggal = $request->$x;
                }else{
                    $tanggal = Carbon::createFromFormat('d/m/Y',$request->$x);
                }
                $dataDetail['tgl_skp'] = $tanggal;
                $x = "id_tglakhir_".$jumlah_detail;
                if($request->$x=="" || $request->$x==null){
                    $tanggal = $request->$x;
                }else{
                    $tanggal = Carbon::createFromFormat('d/m/Y',$request->$x);
                }
                $dataDetail['tgl_akhir_skp'] = $tanggal;
                if ($files = $request->file('id_pdfdok_'.$jumlah_detail)) {
                    $destinationPath = 'uploads/'.$dir_name;
                    $file = "dok_skp_ak3_".$jumlah_detail. "_" .$dir_name."_".Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $file);
                    $dataDetail['pdf_skp_ak3'] = $dir_name."/".$file;
                }
                SkpAk3::create($dataDetail);
            }
        }
        return redirect('dokpersonal')->with('success', 'Data Dok Personil berhasil ditambahkan');
    }

    public function getPersonal($idpjk3,$id)
    {
        $dataPersonil = Personal::where('id','=',$id)->with('kota_ktp')->with('kota_ktp.provinsi')->first();
        if (!$dataPersonil->kota_id===NULL || !$dataPersonil->kota_id==""){
            $dataPersonil->kota_id = $dataPersonil->kota->provinsi->nama;
        }
        if (!$dataPersonil->kota_id===NULL || !$dataPersonil->kota_id==""){
            $dataPersonil->kota_id = $dataPersonil->kota->nama;
        }
        if (!$dataPersonil->id_bank===NULL || !$dataPersonil->id_bank==""){
            $dataPersonil->id_bank = $dataPersonil->bank->Nama_Bank;
        }
        if (!$dataPersonil->temp_lahir===NULL || !$dataPersonil->temp_lahir==""){
            $dataPersonil->temp_lahir = $dataPersonil->tempLahir->ibu_kota;
        }
        if (!$dataPersonil->id_ptkp===NULL || !$dataPersonil->id_ptkp==""){
            $dataPersonil->id_ptkp = $dataPersonil->ptkp_r;
        }
        // dd($dataPersonil);
        $dataSekolah = Sekolah::with('personil.kota.provinsi')->with('personil.bank')->with('personil.tempLahir')->with('jp')->with('kota_s')->with('kota_s.provinsi')->with('negara_s')
                            ->where('id_personal','=',$id)->get();

        $dataSkpAk3 = SkpAk3::with('instansi_ak3')->with('bidang_ak3.jenis_usaha')->with('bid_sertifikat_alat')->with('jenisdok_ak3')->where('id_personal','=',$id)->where('id_skp_pjk3','=',$idpjk3)->get();

        return response()->json(['dataPersonil' => $dataPersonil,'dataSekolah' => $dataSekolah, 'dataSkpAk3' => $dataSkpAk3]);

    }
}
