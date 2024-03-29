<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PesertaSeminar;
use App\SeminarModel;
use App\Peserta;
use App\LogBlasting;
use App\ReportBlasting;
use App\User;
use Carbon\Carbon;
use Validator;

class StatistikSeminarController extends Controller
{
    // statistik seminar
    public function index($id){
        $seminar = SeminarModel::where('id',$id)->first();
        $id_peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereDate('created_at', Carbon::today() )->pluck('id_peserta');
        // $id_peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )>pluck('id');

        $more = '';

        $peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereDate('created_at', Carbon::today() )->get();
        $peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )->get();
        // $peserta = Peserta::whereIn('id', $id_peserta_seminar_baru)->get();
        // dd($pesertabaru);

        $data_peserta_seminar = [0];
        $data_user_baru = [0];
        $data_user_lama = [0];
        // $total_user_baru = [0];
        $total_user_keseluruhan = [ $user_jam_ini =  User::where('created_at', '<=', Carbon::today() )->count() ];
        $counter_user = $total_user_keseluruhan[0];

        for($i = 0 ; $i < 24 ; $i++){
            $from = Carbon::today()->addHours($i);
            $to = Carbon::today()->addHours($i+1);

            $jumlah_pesertaseminar_jam_ini = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$from, $to])->count();
            $jumlah_pesertabaru_jam_ini = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereBetween('created_at', [$from, $to])->count();
            $pesertaseminar = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$from, $to])->pluck('id_peserta')->toArray();
            $jumlah_user_lama = Peserta::whereIn('id', $pesertaseminar)->whereNotBetween('created_at', [$from, $to])->count();

            // $user_jam_ini =  User::all()->count();
            $user_baru_jam_ini = User::whereBetween('created_at', [$from, $to])->count();

            $counter_user = $counter_user + $user_baru_jam_ini;

            array_push($data_peserta_seminar, $jumlah_pesertaseminar_jam_ini);
            array_push($data_user_baru, $jumlah_pesertabaru_jam_ini);
            array_push($data_user_lama, $jumlah_user_lama);

            // array_push($total_user_baru, $user_baru_jam_ini);
            array_push($total_user_keseluruhan, $counter_user);
        }

        if(Carbon::parse($seminar->tgl_akhir) >= Carbon::today()){
            $more = '';
        } else {
            $more = Carbon::parse($seminar->tgl_akhir)->format('d/m/Y');
        }
        return view('seminar.statistik')->with(compact('seminar','peserta_seminar_baru',
            'peserta_baru','data_peserta_seminar','data_user_lama','data_user_baru','id',
            'total_user_keseluruhan', 'more'//'total_user_baru',
        ));
    }

    public function filter(Request $request, $id) {

        $rules = [
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required'
        ];

        $messages = [
            'tgl_awal.required' => 'Mohon isi Tanggal Awal filter',
            'tgl_akhir.required' => 'Mohon isi Tanggal Awal filter',
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        if($validation->fails()) {
            return response()->json([
                'errors' => $validation->messages()->first(),
            ], 401);
        }

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
        $request->merge([
            // 'tgl_awal' => Carbon::parse($request->tgl_awal)->format('d/M/Y'),
            // 'tgl_akhir' => Carbon::parse($request->tgl_akhir)->format('d/m/Y'),
            'tgl_awal' =>  Carbon::createFromFormat( "d/m/Y" , $request->tgl_awal )->format("d/m/Y"),
            'tgl_akhir' => Carbon::createFromFormat( "d/m/Y" , $request->tgl_akhir )->format("d/m/Y")
        ]);

        // return $request;
        $rules = [
            'tgl_awal' => 'required|date_format:"d/m/Y"|before_or_equal:tgl_akhir',
            'tgl_akhir' => 'required|date_format:"d/m/Y"'
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

        if($request->tgl_awal == $request->tgl_akhir) {
            $type = 1;

            $dari =   Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_awal." 0:00:00");
            $sampai = Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_akhir." 0:00:00")->addHours(24);

            $id_peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari, $sampai] )->pluck('id_peserta');
            // $id_peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereDate('created_at', Carbon::today() )>pluck('id');


            $peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari, $sampai] )->get();
            $peserta_baru = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereBetween('created_at', [$dari, $sampai] )->get();
            // $peserta = Peserta::whereIn('id', $id_peserta_seminar_baru)->get();
            // dd($pesertabaru);

            $data_peserta_seminar = [0];
            $data_user_baru = [0];
            $data_user_lama = [0];
            $total_user_keseluruhan = [  User::where('created_at', '<=', $dari )->count() ];

            $counter_user = $total_user_keseluruhan[0];


            for($i = 0 ; $i < 24 ; $i++){
                $from = Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_awal." 0:00:00")->addHours($i)->format("Y-m-d H:i:s");
                $to =   Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_awal." 0:00:00")->addHours($i+1)->format("Y-m-d H:i:s");

                $jumlah_pesertaseminar_jam_ini = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$from, $to])->count();
                $jumlah_pesertabaru_jam_ini = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereBetween('created_at', [$from, $to])->count();
                $pesertaseminar = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$from, $to])->pluck('id_peserta')->toArray();
                $jumlah_user_lama = Peserta::whereIn('id', $pesertaseminar)->whereNotBetween('created_at', [$from, $to])->count();


                // $user_jam_ini =  User::all()->count();
                $user_baru_jam_ini = User::whereBetween('created_at', [$from, $to])->count();
                $counter_user = $counter_user + $user_baru_jam_ini;
                // dump($from);
                // dump($to);
                array_push($data_peserta_seminar, $jumlah_pesertaseminar_jam_ini);
                array_push($data_user_baru, $jumlah_pesertabaru_jam_ini);
                array_push($data_user_lama, $jumlah_user_lama);

                array_push($total_user_keseluruhan, $counter_user );
            }
            // dd($id_peserta_seminar_baru );

            $detail = [];

            $peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari, $sampai])->get();
            foreach($peserta_seminar_baru as $key){
                array_push($detail, [$key->peserta->nama, $key->peserta->email, $key->peserta->no_hp, Carbon::parse($key->created_at)->format('d F Y h:m')]);
            }

        } else {

            $type = 2;
            $dari_temp = Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_awal." 0:00:00");
            $dari =   Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_awal." 0:00:00");
            $sampai_temp = Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_awal." 23:59:00");
            $sampai = Carbon::createFromFormat( "d/m/Y H:i:s" , $request->tgl_akhir." 23:59:00");

            $id_peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari, $sampai] )->pluck('id_peserta');

            $detail = [];
            $peserta_seminar_baru = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari, $sampai] )->get();
            foreach($peserta_seminar_baru as $key){
                array_push($detail, [$key->peserta->nama, $key->peserta->email, $key->peserta->no_hp, Carbon::parse($key->created_at)->format('d F Y h:m')]);
            }

            $data_jumlah = [];
            $label = [];
            $peserta = [];
            $user = [];
            $user_lama = [];
            $user_total = [];

            $counter_user = User::where('created_at', '<=', $dari )->count();

            while(!$dari_temp->gt($sampai)) {
                //
                // dump($sampai);
                $pesertaseminar = PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari_temp, $sampai_temp])->pluck('id_peserta')->toArray();
                $jumlah_pesertabaru_hari_ini = Peserta::whereIn('id', $id_peserta_seminar_baru)->whereBetween('created_at', [$dari_temp, $sampai_temp])->count();
                $jumlah_user_lama = Peserta::whereIn('id', $pesertaseminar)->whereNotBetween('created_at', [$dari_temp, $sampai_temp])->count();
                $jumlah_pesertaseminar_hari_ini =  PesertaSeminar::where('id_seminar',$id)->whereBetween('created_at', [$dari_temp, $sampai_temp])->count();

                $user_baru_jam_ini = User::whereBetween('created_at', [$dari_temp, $sampai_temp])->count();
                $counter_user = $counter_user + $user_baru_jam_ini;

                array_push($data_jumlah,[ $dari_temp->format('d-M-Y') => [ $jumlah_pesertaseminar_hari_ini,  $jumlah_pesertabaru_hari_ini]]);
                array_push($label,$dari_temp->format('d-M-Y'));
                array_push($peserta,$jumlah_pesertaseminar_hari_ini);
                array_push($user,$jumlah_pesertabaru_hari_ini);
                array_push($user_lama, $jumlah_user_lama);
                array_push($user_total, $counter_user);

                $sampai_temp->addDay();
                $dari_temp->addDay();
            }
            // dd($user_lama);

            return response()->json([
                'success' => true,
                'type' => $type,
                'data_jumlah' => $data_jumlah,
                'label' => $label,
                'peserta' => $peserta,
                'user' => $user,
                'user_lama' => $user_lama,
                'user_total' => $user_total,
                'tgl' => [$dari->format('d F Y'),  $sampai->format('d F Y')],
                'detail' => $detail,
            ]);

        }

        return response()->json([
            'success' => true,
            'type' => $type,
            'peserta' => $data_peserta_seminar,
            'user' => $data_user_baru,
            'user_lama' => $data_user_lama,
            'total_user' => $total_user_keseluruhan,
            'tgl' => Carbon::createFromFormat( "d/m/Y" , $request->tgl_awal )->format('d F Y'),
            'detail' => $detail,
        ]);
    }

    public function treeview() {
        $blasting = LogBlasting::orderByDesc('created_at')->get();
        return view('statistik.index')->with(compact('blasting'));
    }
    public function detail($id) {
        $blasting = LogBlasting::where('id', $id)->first();
        $detail = ReportBlasting::where('id_blasting', $id)->get();
        $seminar = SeminarModel::where('id', $blasting->id_seminar)->first();
        $tanggal_blasting = Carbon::parse($blasting->created_at);

        $is_mulai = False;

        if(Carbon::today() > Carbon::parse($seminar->tgl_awal) ){
            $is_mulai = True;
        }

        $dari_temp = Carbon::parse($seminar->created_at)->startOfDay();
        $dari =   Carbon::parse($seminar->created_at)->startOfDay();
        $sampai_temp = Carbon::parse($seminar->created_at)->endOfDay();
        if($is_mulai){
            $sampai = Carbon::parse($seminar->tgl_awal)->endOfDay();
        } else {
            $sampai = Carbon::today()->endOfDay();
        }

        $label = [];
        $peserta = [];
        $user = [];
        $detail_blasting = [];
        $dikirim = [];
        $gagal = [];
        while(!$dari_temp->gt($sampai)) {

            $pesertaseminar = PesertaSeminar::where('id_seminar',$seminar->id)->where('created_at', '<=' ,$sampai_temp)->count();
            $usertotal = User::where('created_at', '<=', $sampai_temp)->count();

            array_push($label,$dari_temp->format('d-F-Y'));
            array_push($peserta,$pesertaseminar);
            array_push($user,$usertotal);

            if($tanggal_blasting->startOfDay() == $dari_temp){
                // dump(cuy);
                array_push($detail_blasting, $blasting->jumlah_target);// [$blasting->target, $blasting->jumlah_kirim, $blasting->kirim_ulang]);
                array_push($dikirim, (int)$blasting->jumlah_kirim);
                array_push($gagal, (int)$blasting->jumlah_target - (int)$blasting->jumlah_kirim);
            } else {
                array_push($detail_blasting, 0);
                array_push($dikirim, 0);
                array_push($gagal, 0);
            }

            $sampai_temp->addDay();
            $dari_temp->addDay();
        }

        $report = ReportBlasting::where('id_blasting', $id)->get();
        $blasting_diklik = ReportBlasting::where('id_blasting', $id)->whereNotNull('first_click')->count();
        $blasting_diklik2 = ReportBlasting::where('id_blasting', $id)->whereColumn('first_click','!=','last_click')->count();
        $blasting_didaftar = ReportBlasting::where('id_blasting', $id)->whereNotNull('is_daftar')->count();

        $user_total = User::all()->count();
        $peserta_total = PesertaSeminar::where('id_seminar',$seminar->id)->count();
        $peserta_hari_ini = PesertaSeminar::where('id_seminar',$seminar->id)->whereDate('created_at', Carbon::today()->format('Y-m-d'))->count();
        return view('statistik.detail')->with(compact('blasting', 'detail', 'seminar', 'blasting_diklik','blasting_diklik2', 'gagal',
        'blasting_didaftar','report', 'label', 'user', 'peserta', 'detail_blasting', 'dikirim', 'user_total', 'peserta_hari_ini', 'peserta_total'));
    }
}
