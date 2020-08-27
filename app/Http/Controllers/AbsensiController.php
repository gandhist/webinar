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
use Vinkla\Hashids\Facades\Hashids;

class AbsensiController extends Controller
{
    public function index($id){
        if(strlen($id) > 10) {
            $id_decrypt = Crypt::decrypt($id);
        } else {
            $id_decrypt =  Hashids::decode($id);
        }
        return "<center><h1>halaman absensi belum bisa di akses untuk saat ini</h1></center>";
        dd($id_decrypt);
        $peserta_seminar = PesertaSeminar::where('id',$id_decrypt)->first();
        $cek_in = $this->cek_in();
        $cek_out = $this->cek_out();
        $data = AbsensiModel::where('id_peserta', $peserta_seminar->id_peserta)->get();
        // dd($data);

        return view('presensi.index')->with(compact('data', 'cek_in', 'cek_out', 'peserta_seminar'));
    }

    // absen masuk
    public function datang(Request $request, $id){
        $id_decrypt = Crypt::decrypt($id);
        $masuk = new AbsensiModel;
        $masuk->id_peserta = Peserta::where('id',$id_decrypt)->first();
        $masuk->jam_cek_in = Carbon::now()->toDateTimeString();
        $masuk->created_by = Auth::id();
        $masuk->created_at = Carbon::now()->toDateTimeString();
        $masuk->tanggal = Carbon::now()->isoFormat("YYYY-MM-DD");
        $masuk->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Absen',
        ]);
    }

    // absen keluar
    public function pulang(Request $request){
        $id_decrypt = Crypt::decrypt($id);
        $keluar = AbsensiModel::where('id_peserta',Peserta::where('user_id',Auth::id())->first()->id)->orderBy('id','desc')->first();
        $keluar->id_peserta = Peserta::where('user_id',Auth::id())->first()->id;
        $keluar->jam_cek_out = Carbon::now()->toDateTimeString();
        $keluar->updated_by = Auth::id();
        $keluar->updated_at = Carbon::now()->toDateTimeString();
        $keluar->save();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Absen',
        ]);
    }

    // function cek absen masuk
    public function cek_in(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $cek_cekin = AbsensiModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta', $peserta->id)->first();
        if($cek_cekin){
            $allow = false;
        }
        else {
            $allow = true;
        }
        return $allow;
    }

    // function cek absen keluar
    public function cek_out(){
        $peserta = Peserta::where('user_id',Auth::id())->first();
        $cek_cekin = AbsensiModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta', $peserta->id)->whereNotNull('jam_cek_out')->first();
        if($cek_cekin){
            $allow = false;
        }
        else {
            $allow = true;
        }
        return $allow;
    }
}
