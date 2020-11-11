<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use App\BuModal;
use App\BidangModel;
use App\JenisDokSertifikat;
use App\JenisDok;
use App\TempSkpAk3;

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
        $data = BuModal::where('singkat_bu','LIKE',"%$param%")->get();
        return $data;
    }


    public function selectbidangskpak3(Request $request){
        $id_user = Auth::id();
        $jnsusaha = BidangModel::select('id_jns_usaha')->where('id','=', $request->id_bidang)->first();
        if($jnsusaha['id_jns_usaha'] == 1 ){
            return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->get(['id_srft_alat as id','nama_srft_alat as text']);
        }
        if($jnsusaha['id_jns_usaha'] == 2 ){
            return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->whereIn('rik_uji',['1'])->get(['id_srft_alat as id','nama_srft_alat as text']);
        }
        if($jnsusaha['id_jns_usaha'] == 3 ){
            return $data = JenisDokSertifikat::distinct('nama_srft_alat')->where('id_bidang','=',$request->id_bidang)->whereNotIn('id_srft_alat',['0'])->get(['id_srft_alat as id','nama_srft_alat as text']);
        }
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

}
