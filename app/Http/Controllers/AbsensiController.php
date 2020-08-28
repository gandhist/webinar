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
        if(strlen($id) > 10) {
            $id_decrypt = Crypt::decrypt($id);
        } else {
            $id_decrypt =  \Hashids::decode($id);
        }
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
        
        $seminar = PesertaSeminar::select('id_seminar')->where('id','=',$id)->first();
        $status = SeminarModel::select('is_mulai')->where('id','=',$seminar['id_seminar'])->first();
        
        if ($status['is_mulai'] == 0){
            return response()->json([
                'status' => false,
                'message' => 'Seminar belum dimulai',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil Absen Masuk',
            ]);
        }   
    }

    // absen keluar
    public function pulang(Request $request, $id){
        $status = AbsensiModel::select('is_review')->where('id_peserta_seminar', $id)->first();
        $keluar = AbsensiModel::where('id_peserta_seminar',$id)->orderBy('id','desc')->first();
        $keluar->is_review = 1;
        $keluar->save();

        if ($status['is_review'] == 0){
            return response()->json([
                'status' => false,
            ]);
        } else {
            $keluar->id_peserta_seminar = $id;
            $keluar->jam_cek_out = Carbon::now()->toDateTimeString();
            $keluar->updated_at = Carbon::now()->toDateTimeString();
            $keluar->save();

            $id_encrypt = Crypt::encrypt($id);
            $peserta_seminar = PesertaSeminar::where('id',$id)->first();
            $cek_in = $this->cek_in($peserta_seminar->id);
            $cek_out = $this->cek_out($peserta_seminar->id);
            $data = AbsensiModel::where('id_peserta_seminar', $peserta_seminar->id)->get();

            return view('presensi.index')->with(compact('data', 'cek_in', 'cek_out', 'peserta_seminar','id_encrypt'));
        }
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

    public function penilaian($id){
        if(strlen($id) > 10) {
            $id_decrypt = Crypt::decrypt($id);
        } else {
            $id_decrypt =  \Hashids::decode($id);
        }
        $peserta_seminar = PesertaSeminar::where('id',$id_decrypt)->first();
        

        // $keluar = AbsensiModel::where('id_peserta_seminar',$id_decrypt)->orderBy('id','desc')->first();
        // $keluar->id_peserta_seminar = $id_decrypt;
        // $keluar->jam_cek_out = Carbon::now()->toDateTimeString();
        // $keluar->updated_at = Carbon::now()->toDateTimeString();
        // $keluar->is_review = 1;
        // $keluar->save();

        return view('presensi.penilaian')->with(compact('peserta_seminar'));;
    }
}
