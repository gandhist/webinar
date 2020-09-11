<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PesertaSeminar;
use App\SeminarModel;
use App\Peserta;
use Carbon\Carbon;
use Validator;

class StatistikSeminarController extends Controller
{
    // statistik seminar
    public function index($id){
        $seminar = SeminarModel::where('id',$id)->first();
        $id_peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereDate('created_at', Carbon::today() )->pluck('id_peserta');
        // $id_peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )>pluck('id');


        $peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereDate('created_at', Carbon::today() )->get();
        $peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )->get();
        // $peserta = Peserta::whereIn('id', $id_peserta_seminar_baru)->get();
        // dd($pesertabaru);

        $data_peserta_seminar = [0];
        $data_user_baru = [0];

        for($i = 0 ; $i < 24 ; $i++){
            $from = Carbon::today()->addHours($i);
            $to = Carbon::today()->addHours($i+1);
            $jumlah_pesertaseminar_jam_ini = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$from, $to])->count();
            $jumlah_pesertabaru_jam_ini = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereBetween('created_at', [$from, $to])->count();

            array_push($data_peserta_seminar, $jumlah_pesertaseminar_jam_ini);
            array_push($data_user_baru, $jumlah_pesertabaru_jam_ini);
        }

        return view('seminar.statistik')->with(compact('seminar','peserta_seminar_baru','peserta_baru','data_peserta_seminar','data_user_baru'));
    }

    public function filter(Request $request) {
        //
        // if(request()->ajax()){
        //     $match = Match::find($match_id);
        //     $validator = Validator::make($request->all(), [
        //        'start_time'=>'required',
        //     ]);

        //     if($validator->passes())
        //     {
        //       $match->start_time = $request->start_time;
        //       $match->save();

        //       return response()->json(['msg'=>'Updated Successfully', 'success'=>true]);
        //     }
        //     return response()->json(['msg'=>$validator->errors()->all()]);
        //   }

        $rules = [
            'tgl_awal' => 'required|date|before_or_equal:tgl_akhir',
            'tgl_akhir' => 'required|date'
        ];

        $messages = [
            'tgl_awal.required' => 'Mohon isi Tanggal Awal filter',
            'tgl_awal.date' => 'Mohon isi Tanggal Awal filter',
            'tgl_awal.before_or_equal' => 'Tanggal Awal harus sama dengan atau sebelum Tanggal Akhir',
            'tgl_akhir.required' => 'Mohon isi Tanggal Awal filter',
            'tgl_akhir.date' => 'Mohon isi Tanggal Awal filter',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()) {
            return response()->json([
                'errors' => $validation->messages()->first(),
            ], 401);
        }
        return response()->json([
            'success' => true,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
        ]);
    }
}
