<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\AbsensiModel;
use App\Peserta;
use App\SeminarModel;
use App\PesertaSeminar;
use Illuminate\Support\Facades\Crypt;

class AbsensiController extends Controller
{
    public function index($id){
        $id_encrypt = $id;
        $id_decrypt = Crypt::decrypt($id);
        if(strlen($id) > 10) {
            $id_decrypt = Crypt::decrypt($id);
        } else {
            $id_decrypt =  \Hashids::decode($id);
        }
        dd($id_decrypt);
        $peserta_seminar = PesertaSeminar::where('id',$id_decrypt)->first();
        $cek_in = $this->cek_in($peserta_seminar->id);
        $cek_out = $this->cek_out($peserta_seminar->id);
        $data = AbsensiModel::where('id_peserta_seminar', $peserta_seminar->id)->get();

        return view('presensi.index')->with(compact('data', 'cek_in', 'cek_out', 'peserta_seminar', 'id_encrypt'));
    }

    // absen masuk
    public function datang(Request $request, $id){
        $masuk = new AbsensiModel;
        $masuk->id_peserta_seminar = $id;
        $masuk->jam_cek_in = Carbon::now()->toDateTimeString();
        $masuk->created_at = Carbon::now()->toDateTimeString();
        $masuk->tanggal = Carbon::now()->isoFormat("YYYY-MM-DD");
        $masuk->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Absen Masuk',
        ]);
    }

    // absen keluar
    public function pulang(Request $request, $id){
        $keluar = AbsensiModel::where('id_peserta_seminar',$id)->orderBy('id','desc')->first();
        $keluar->id_peserta_seminar = $id;
        $keluar->jam_cek_out = Carbon::now()->toDateTimeString();
        $keluar->updated_at = Carbon::now()->toDateTimeString();
        $keluar->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Absen Keluar',
        ]);
    }

    // function cek absen masuk
    public function cek_in($id){
        $cek_cekin = AbsensiModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta_seminar', $id)->first();
        if($cek_cekin){
            $allow = false;
        }
        else {
            $allow = true;
        }
        return $allow;
    }

    // function cek absen keluar
    public function cek_out($id){
        $cek_cekin = AbsensiModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta_seminar', $id)->whereNotNull('jam_cek_out')->first();
        if($cek_cekin){
            $allow = false;
        }
        else {
            $allow = true;
        }
        return $allow;
    }
}
