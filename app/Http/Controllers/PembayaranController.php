<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Pembayaran;
use App\Peserta;
use App\PesertaSeminar;
use App\User;

class PembayaranController extends Controller
{
    //
    public function index() {
        $user = User::findOrFail(Auth::id());
        $peserta = Peserta::where('user_id', $user->id)->first();
        $peserta_seminar = PesertaSeminar::where('id_peserta', $peserta->id)->get();
        $id_peserta_seminar = PesertaSeminar::where('id_peserta', $peserta->id)->pluck('id')->toArray();
        $pembayaran = Pembayaran::whereIn('id_peserta_seminar', $id_peserta_seminar)->orderBy('created_at', 'desc')->get();


        // if(isset($peserta_seminar)){
        //     //Set Your server key

        //     \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');

        //     // Uncomment for production environment
        //     // \Midtrans\Config::$isProduction = true;

        //     \Midtrans\Config::$isSanitized = true;
        //     \Midtrans\Config::$is3ds = true;
        //     $params = array(
        //         'transaction_details' => array(
        //             'order_id' => $data->id.$peserta->id.$peserta->user_id.time(),
        //             'gross_amount' => 10000,
        //         )
        //     );
        //     $snapToken = \Midtrans\Snap::getSnapToken($params);
        //     $clientKey = config('services.midtrans.clientKey');
        // } else {
        //     $snapToken = "";
        //     $clientKey = "";
        // }


        // dd($peserta_seminar, $id_peserta_seminar);
        return view('pembayaran.index')->with(compact('pembayaran', 'peserta'));
    }
}

