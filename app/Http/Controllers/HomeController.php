<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\PesertaSeminar;
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
            $calon = TargetBlasting::whereNotIn('email', TargetBlasting::whereIn('email', User::whereNotNull('email')->pluck('email')->unique() )->whereNotNull('email')->pluck('email') )->count();
            return view('home')->with(compact('total_user', 'total_peserta', 'user_login', 'user_hari_ini', 'peserta_hari_ini', 'calon','seminar_selesai', 'seminar_berjalan'));
        }
        return view('sert.dashboard')->with(compact('data'));
    }
}
