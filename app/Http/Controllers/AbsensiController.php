<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\AbsensiModel;
use App\Peserta;
use App\Personal;
use App\SeminarModel;
use App\PesertaSeminar;
use Illuminate\Support\Facades\Crypt;
use Vinkla\Hashids\Facades\Hashids;
use App\FeedbackModel;
use App\RatingModel;

class AbsensiController extends Controller
{
    public function index($id){
        // $tes = Crypt::encrypt(3074);
        // dd($tes);
        $id_encrypt = $id;
        if(strlen($id) > 10) {
            $id_decrypt = Crypt::decrypt($id);
        } else {
            $id_decrypt =  Hashids::decode($id);
        }
        $peserta_seminar = PesertaSeminar::where('id',$id_decrypt)->first();
        // dd($peserta_seminar);
        $cek_in = $this->cek_in($peserta_seminar->id);
        $cek_out = $this->cek_out($peserta_seminar->id);
        $data = AbsensiModel::where('id_peserta_seminar', $peserta_seminar->id)->get();
        // dd($data);
        return view('presensi.index')->with(compact('data', 'cek_in', 'cek_out', 'peserta_seminar', 'id_encrypt'));
    }

    // absen masuk
    public function datang(Request $request, $id){
        $masuk = new AbsensiModel;
        $masuk->id_peserta_seminar = $id;
        $masuk->jam_cek_in = Carbon::now()->toDateTimeString();
        $masuk->created_at = Carbon::now()->toDateTimeString();
        $masuk->tanggal = Carbon::now()->isoFormat("YYYY-MM-DD");

        $cek_absen = AbsensiModel::where('id_peserta_seminar', $id)->first();


        $seminar = PesertaSeminar::select('id_seminar')->where('id','=',$id)->first();
        $status = SeminarModel::select('is_mulai')->where('id','=',$seminar['id_seminar'])->first();

        if ($status['is_mulai'] == 0){
            return response()->json([
                'status' => false,
                'message' => 'Seminar belum dimulai',
            ]);
        } else if($cek_absen){
            return response()->json([
                'status' => false,
                'message' => 'Anda sudah pernah absen',
            ]);
        } else {
            $masuk->save();
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
        $peserta_seminar = PesertaSeminar::select('id_seminar')->where('id',$id)->first();
        $status_seminar = SeminarModel::select('is_mulai')->where('id',$peserta_seminar['id_seminar'])->first();

        if ($status_seminar['is_mulai'] == 1) {
            return response()->json([
                'status' => true,
                'message' => 'Seminar belum selesai',
            ]);
        } elseif($peserta_seminar['is_review'] == 0 && $request->ajax()){
            return response()->json([
                'status' => true,
                'code' => 10,
                'message' => 'Mohon isi penilaian',
            ]);
        }else{
            if(isset($request->seminar)){
                foreach($request->seminar as $key => $value){
                    $narasumber = New RatingModel;
                    $narasumber->id_peserta_seminar = $id;
                    $narasumber->tipe = '0';
                    $narasumber->id_seminar = $key;
                    $narasumber->nilai = $value;
                    $narasumber->save();
                }
            }

            if(isset($request->narasumber)){
                foreach($request->narasumber as $key => $value){
                    $narasumber = New RatingModel;
                    $narasumber->id_peserta_seminar = $id;
                    $narasumber->tipe = '1';
                    $narasumber->id_peserta = $key;
                    $narasumber->nilai = $value;
                    $narasumber->save();
                }
            }

            if(isset($request->moderator)){
                foreach($request->moderator as $key => $value){
                    $moderator = New RatingModel;
                    $moderator->id_peserta_seminar = $id;
                    $moderator->tipe = '1';
                    $moderator->id_peserta = $key;
                    $moderator->nilai = $value;
                    $moderator->save();
                }
            }

            if(isset($request->kesan_pesan) && isset($request->keterangan))
            $feedback = new FeedbackModel;
            $feedback->id_peserta_seminar = $id;
            $feedback->kesan_pesan = $request->kesan_pesan;
            $feedback->keterangan = $request->keterangan;
            $feedback->save();

            $keluar->id_peserta_seminar = $id;
            $keluar->jam_cek_out = Carbon::now()->toDateTimeString();
            $keluar->updated_at = Carbon::now()->toDateTimeString();
            $keluar->save();

            $id_encrypt = Crypt::encrypt($id);
            $peserta_seminar = PesertaSeminar::where('id',$id)->first();
            $cek_in = $this->cek_in($peserta_seminar->id);
            $cek_out = $this->cek_out($peserta_seminar->id);
            $data = AbsensiModel::where('id_peserta_seminar', $peserta_seminar->id)->get();

            $keluar->is_review = 1;
            $keluar->save();

            // return response()->json([
            //     'status' => false,
            // ]);

            return redirect()->route('presensi', $id_encrypt)->with(compact('data', 'cek_in', 'cek_out', 'peserta_seminar','id_encrypt'))->with('alert', 'Berhasil Absen Keluar');
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
        // $cek_cekin = AbsensiModel::where('tanggal', Carbon::now()->isoFormat('YYYY-MM-DD'))->where('id_peserta_seminar', $id)->whereNotNull('jam_cek_out')->first();
        // if($cek_cekin){
        //     $allow = false;
        // }
        // else {
        //     $allow = true;
        // }
        // return $allow;
        return true;
    }

    public function penilaian($id){
        if(strlen($id) > 10) {
            $id_decrypt = Crypt::decrypt($id);
        } else {
            $id_decrypt =  \Hashids::decode($id);
        }
        $peserta_seminar = PesertaSeminar::where('id',$id_decrypt)->first();

        // $peserta_seminar = PesertaSeminar::where('id',$id)->first();

        $narasumber = PesertaSeminar::where('id_seminar',$peserta_seminar->id_seminar)->where('status','2')->get();
        $moderator = PesertaSeminar::where('id_seminar',$peserta_seminar->id_seminar)->where('status','4')->get();

        return view('presensi.penilaian')->with(compact('peserta_seminar','narasumber','moderator'));
    }
}
