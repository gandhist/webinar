<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use App\BuModel;
use App\BidangModel;
use App\JenisDokSertifikat;
use App\JenisDok;
use App\TempSkpAk3;
use App\SkpAk3;
use App\KotaModel;
use App\masterBidang;
use App\JenisUsaha;
use App\TimProduksi;

use Auth;

class ChainedController extends Controller
{
    //
    public function searchPersonilByName(Request $request){
        $param = $request->input('query');
        $data = Personal::where('nama','LIKE',"%$param%")->get();
        return $data;
    }

    public function searchInstansiByName(Request $request){
        $param = $request->input('query');
        $data = BuModel::where('singkat_bu','LIKE',"%$param%")->get();
        return $data;
    }

    public function changepjk3(Request $request){
        $data = BuModel::find($request->id_pjk3);
        return $data;
    }


    public function changelevelatas(Request $request){
        return $data = TimProduksi::where('level_p','=',$request->leveltimprod-1)->get(['id','nama_tim_p as text']);
    }

    public function selectbidangskpak3(Request $request){
        $id_user = Auth::id();
        $jnsusaha = BidangModel::select('id_jns_usaha')->where('id','=', $request->id_bidang)->first();
        // return $jnsusaha['id_jns_usaha'];
        if($jnsusaha['id_jns_usaha'] == 1 ){
            return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->get(['id_srft_alat as id','nama_srft_alat as text']);
        }
        if($jnsusaha['id_jns_usaha'] == 2 ){
            return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->whereIn('rik_uji',['1'])->get(['id_srft_alat as id','nama_srft_alat as text']);
        }
        if($jnsusaha['id_jns_usaha'] == 3 ){
            return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->get(['id_srft_alat as id','nama_srft_alat as text']);
        }
        // return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->get(['id_srft_alat as id','nama_srft_alat as text']);

    }


    public function selectnamasrtfskpak3(Request $request){
        $id_user = Auth::id();
        $tmp_skp_ak3 = TempSkpAk3::select('jenis_dok')->where('bidang_dok','=',$request->id_bidang)->where('nama_srtf','=',$request->id_namasrtf)->where('id_user','=',$id_user)->get();
        $jnsdoksrtf = JenisDokSertifikat::select('id_jns_dok')->where('id_srft_alat','=',$request->id_namasrtf)->where('id_bidang','=',$request->id_bidang);
        return $data = JenisDok::whereIn('id',$jnsdoksrtf)->whereNotIn('id',$tmp_skp_ak3)->get(['id','Nama_jns_dok as text']);
    }

    public function selectjnsdokskpak3(Request $request){
        $id_user = Auth::id();
        return $data = JenisDokSertifikat::where('id_jns_dok','=',$request->id_jnsdok)->where('id_srft_alat','=',$request->id_namasrtf)->get(['id','nama_srft_alat as text']);
    }

    public function addskpak3(Request $request){
        $data['bidang_dok'] = $request->bidang_dok;
        $data['nama_srtf'] = $request->nama_srtf;
        $data['jenis_dok'] = $request->jenis_dok;
        $id_user = Auth::id();
        $data['id_user'] = $id_user;
        TempSkpAk3::create($data);
        return "Sukses";
    }

    public function deleteskpak3(Request $request){
        TempSkpAk3::where('id_user', '=', Auth::id())->where('bidang_dok','=',$request->bidang_dok)->where('nama_srtf','=',$request->nama_srtf)->where('jenis_dok','=',$request->jenis_dok)->delete();
        return "Sukses";
    }

    public function deleteallskpak3(Request $request){
        TempSkpAk3::where('id_user', '=', Auth::id())->delete();
        return "Sukses";
    }


    public function selectjnsusahaskpak3(Request $request){
        $id_user = Auth::id();
        $jnsusaha = JenisUsaha::select('id', 'kode_jns_usaha')->where('id','=', $request->id_jnsusaha)->first();
        $idbid = SkpAk3::select('id_bid_skp')->groupBy('id_bid_skp')->get()->toArray();
        if (isset($jnsusaha['id'])) {
            $bid = masterBidang::where('id_jns_usaha',$jnsusaha['id'])->whereIn('id',$idbid)->get(['id','nama_bidang as text']);
            return response()->json(['dataJnsUsaha' => $jnsusaha,'dataBidang' => $bid]);
        } else {
            return response()->json(['dataJnsUsaha' => false,'dataBidang' => false]);
        }
        $bid = masterBidang::where('id_jns_usaha',$jnsusaha['id'])->whereIn('id',$idbid)->get(['id','nama_bidang as text']);
        return response()->json(['dataJnsUsaha' => $jnsusaha,'dataBidang' => $bid]);
    }

    public function filterprovdokperson(Request $req){
        $id_personil = SkpAk3::select('id_personal')->groupBy('id_personal')->get()->toArray();
        $idkota = Personal::select('kota_id')->groupBy('kota_id')->whereIn('id',$id_personil)->get()->toArray();
        $kota = KotaModel::whereIn('id',$idkota)->where('provinsi_id',$req->prov)->get(['id','nama as text']);
        return $kota;
    }


    public function selectbidangdokkpak3(Request $request){
        $id_user = Auth::id();
        $idjnsdok = SkpAk3::select('jns_dok')->where('id_bid_skp','=', $request->id_bidangdok)->groupBy('jns_dok')->get()->toArray();

        $data1 = JenisDok::whereIn('id',$idjnsdok)->get(['id','kode_jns_dok as text']);
        $data2 = JenisDok::whereIn('id',$idjnsdok)->get(['id','Nama_jns_dok as text']);

        return response()->json(['data1' => $data1,'data2' => $data2]);

        // $data1 = masterBidSertifikatAlat::select('id', 'kode_srtf_alat')->where('id_bid','=',$request->id_bidang);
        // $data2 = masterBidSertifikatAlat::select('id', 'kode_srtf_alat as text')->where('id_bid','=',$request->id_bidang)->union($data1)->get();
        // return $data2;
    }

    public function selectnamadokskpak3(Request $request){
        $id_user = Auth::id();
        $bidang = JenisDokSertifikat::select('id_bidang')->where('id', '=', $request->id_namadok);
        return $data = masterBidang::whereIn('id',$bidang)->get(['id','nama_bidang as text']);
    }

    public function selectbidangdokskpak3(Request $request){
        $id_user = Auth::id();
        $jnsdoksrtf = JenisDokSertifikat::select('id_srft_alat')->where('id','=',$request->id_namadok)->first();
        $jnsdok = JenisDokSertifikat::select('id_jns_dok')->where('id_srft_alat','=',$jnsdoksrtf['id_srft_alat']);
        return $data = JenisDok::whereIn('id',$jnsdok)->get(['id','Nama_jns_dok as text']);
    }

}
