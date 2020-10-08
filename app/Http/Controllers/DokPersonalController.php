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
use App\SkpPjk3;
use App\SkpAk3;
use App\JenisUsaha;
use App\BuModel;
use App\JenisDok;
use App\JenisDokSertifikat;


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

        return view('dokpersonil.index')
                ->with(compact('data','personil','prov','kota','bank','sekolah','sklh','pjk3','instansi','jenisusaha','jenisdok','bidang','jenisdoksrtf','instansidok','penyelenggara','negara'));

    }

}
