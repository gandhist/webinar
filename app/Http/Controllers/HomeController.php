<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\PesertaSeminar;
use App\Peserta;
use App\SeminarModel;
use App\TargetBlasting;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        // handle sementara aja biar user ga kesini
        if(Auth::user()->role_id == 2){
            return redirect(url('infoseminar'));
        }
        else {
            $total_user = User::all()->count();
            $total_peserta = PesertaSeminar::all()->count();
            $user_login = User::whereNotNull('is_login')->count();
            $user_hari_ini = User::whereDate('created_at', Carbon::today()->format('Y-m-d'))->count();
            $peserta_hari_ini = PesertaSeminar::whereDate('created_at', Carbon::today()->format('Y-m-d'))->count();
            $seminar_berjalan = SeminarModel::where('status','published')->count();
            $seminar_selesai = SeminarModel::where('is_mulai','=','2')->count();
            $target = TargetBlasting::pluck('email');
            // $calon = TargetBlasting::whereNotIn('email', TargetBlasting::whereIn('email', Peserta::whereNotNull('email')->pluck('email')->unique() )->whereNotNull('email')->pluck('email') )
            // ->whereNotIn('no_hp', TargetBlasting::whereIn('no_hp', Peserta::whereNotNull('no_hp')->pluck('no_hp')->unique() )->whereNotNull('no_hp')->pluck('no_hp') )->count();
            // $calon =
            $email = Peserta::all()->pluck('email')->unique()->toArray();
            $no_hp = Peserta::all()->pluck('no_hp')->unique()->toArray();
            // $email = array_map(function ($el){return strtolower($el);},$email);
            // dd($no_hp);
            $calon = TargetBlasting::whereNotIn('email', TargetBlasting::whereIn('email',$email)->pluck('email')->unique())
                    ->whereNotIn('no_hp', TargetBlasting::whereIn('no_hp',$no_hp)->pluck('no_hp')->unique())->count();
            return view('home')->with(compact('total_user', 'total_peserta', 'user_login', 'user_hari_ini', 'peserta_hari_ini', 'calon','seminar_selesai', 'seminar_berjalan'));
        }
        return view('sert.dashboard')->with(compact('data'));
    }
}
