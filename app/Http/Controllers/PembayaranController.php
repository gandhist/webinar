<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\LogTransaksi;
use App\Pembayaran;
use App\Peserta;
use App\PesertaSeminar;
use App\User;
use App\Seminar;
use App\Traits\GlobalFunction;

use Carbon\Carbon;

class PembayaranController extends Controller
{
    use GlobalFunction;
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


    public function callback(Request $request) {

        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

        $notify = new \Midtrans\Notification();
        $transaction_time = $notify->transaction_time;
        $status = $notify->transaction_status;
        $type = $notify->payment_type;
        $fraud = $notify->fraud_status;
        $order_id = $notify->order_id;
        $gross_amount = $notify->gross_amount;


        $data = Pembayaran::where('no_transaksi',$order_id)->first();
        if(is_null($data)) {
            return abort(404);
        }
        $peserta_s = PesertaSeminar::findOrFail($data->id_peserta_seminar);
        $seminar = Seminar::findOrFail($peserta_s->id_seminar);

        if ($status == 'capture') {
            // jika credit card
            if($type == 'credit_card'){
                if ($fraud == 'challenge') {
                    $data->status = 2; // Pending
                    $peserta_s->is_paid = 2; // Pending
                    // TODO Set payment status in merchant's database to 'challenge'
                }
                else {
                    $data->status = 1; // Success
                    $peserta_s->is_paid = 1; // Success

                    $gen_no_sert = $this->generateNoSert($peserta_s->id_seminar, $peserta_s->id);
                    $peserta_s->no_srtf = $gen_no_sert[0];
                    $peserta_s->no_urut_peserta = $gen_no_sert[1];
                    $peserta_s->skpk_nilai = $seminar->skpk_nilai;
                    $peserta_s->qr_code = $this->generateQrSertPeserta($gen_no_sert[0]);

                    // TODO Set payment status in merchant's database to 'success'
                }
            }

        }
        else if($status == 'settlement'){
            $data->status = 1; // Success
            $peserta_s->is_paid = 1; // Success

            $gen_no_sert = $this->generateNoSert($peserta_s->id_seminar, $peserta_s->id);
            $peserta_s->no_srtf = $gen_no_sert[0];
            $peserta_s->no_urut_peserta = $gen_no_sert[1];
            $peserta_s->skpk_nilai = $seminar->skpk_nilai;
            $peserta_s->qr_code = $this->generateQrSertPeserta($gen_no_sert[0]);

            // send notification to marketing customer peserta
        }
        else if($status == 'pending'){
            $data->status = 2; // Pending
            $peserta_s->is_paid = 2; // Pending
        }
        else if($status == 'expire'){
            $data->status = 4; // expire
            $peserta_s->is_paid = 4; // expire
        }
        else if ($transaction == 'cancel') {
            $data->status = 5; // cancel
            $peserta_s->is_paid = 5; // cancel
        }
        else if ($transaction == 'deny') {
            $data->status = 3; // deny
            $peserta_s->is_paid = 3; // deny
              // TODO Set payment status in merchant's database to 'failure'
        }
        $data->updated_at = Carbon::now()->toDateTimeString();
        $peserta_s->updated_at = Carbon::now()->toDateTimeString();
        // get account midtrans
        $usr = User::where('username','midtran_notifications')->first();
        $data->updated_by = $usr->id;
        $peserta_s->update_by = $usr->id;
        $data->save();
        $peserta_s->save();

        $log_data = [
            'no_transaksi' => $order_id,
            'keterangan' => json_encode($notify),
            'subjek' => 'callback dari midtrans',
            'status' => $data->status,
            'created_by' => $usr->id,
            'created_at' => Carbon::now()->toDateTimeString()
        ];

        LogTransaksi::create($log_data);
    }


    // handle halaman finish
    public function finish(Request $request){
        $data = Pembayaran::where('no_transaksi',$request->query('order_id'))->first();
        return view('pembayaran.finish')->with(compact('data'));
    }

    // handle pembayaran unfinish()
    public function unfinish(Request $request){
        $data = Pembayaran::where('no_transaksi',$request->query('order_id'))->first();
        return view('pembayaran.unfinish')->with(compact('data'));
    }

    // handle pembayaran error
    public function error(Request $request){
        $data = Pembayaran::where('no_transaksi',$request->query('order_id'))->first();
        return view('pembayaran.error')->with(compact('data'));
    }

    // Buat ulang snap
    public function regenerate(Request $request, $id_seminar){
        $detailseminar = Seminar::find($id_seminar);
        $peserta = Peserta::where('user_id', Auth::id())->first();
        $peserta_seminar = PesertaSeminar::where('id_seminar', $id_seminar)->where('id_peserta', $peserta->id)->first();

        $no_trans = "P3SM_SRTF-".$detailseminar->id."_".$peserta_seminar->id."_".Carbon::now()->timestamp."_RE";

        $start_pay_date = Carbon::now();
        $end_pay_date = Carbon::now()->addDays(7);
        // in minutes
        $exp_date = $start_pay_date->diffInMinutes($end_pay_date);

        $detail_snap = [
            "transaction_details" => [
                "order_id" => $no_trans,
                "gross_amount" => (int)$detailseminar->biaya ?? 0
            ],
            "item_details" => [
                [
                    "id" => $detailseminar->id,
                    "price" => (int)$detailseminar->biaya ?? 0,
                    "quantity" => 1,
                    "name" => "Biaya Investasi  ".strip_tags($detailseminar->tema),
                    "brand" => "P3SM",
                    "merchant_name" => "P3SM"
                ]
            ],
            "customer_details" => [
                "first_name" => $peserta->nama,
                "last_name" => '',
                "email" => $peserta->email,
                "phone" => $peserta->no_hp
            ],
            "expiry" => [
                "start_time"=> $start_pay_date->format('Y-m-d H:i:s').' +0700',
                "unit"=> "minutes",
                "duration"=> $exp_date
            ]
            // , "enabled_payments" => []
        ];
        // dd($detail_snap);

        try {
            $token = $this->generateSnap($detail_snap);

            Pembayaran::where('id_peserta_seminar', $peserta_seminar->id)->delete();

            $pembayaran = new Pembayaran;
            $pembayaran->no_transaksi = $no_trans;
            $pembayaran->id_peserta_seminar = $peserta_seminar->id;
            $pembayaran->token = $token;
            $pembayaran->jenis = '1';
            $pembayaran->status = 0;
            $pembayaran->created_by = Auth::id();
            $pembayaran->created_at = Carbon::now()->toDateTimeString();
            $pembayaran->save();

            $log_data = [
                'no_transaksi' => $no_trans,
                'keterangan' => json_encode($detail_snap),
                'subjek' => 'berhasil membuat ulang transaksi',
                'status' => 'WAITING',
                'created_by' => Auth::id(),
                'created_at' => Carbon::now()->toDateTimeString()
            ];

            // Pembayaran::where('id_peserta_seminar', $peserta_seminar->id)->delete();
            $peserta_seminar->is_paid = 0;
            $peserta_seminar->save();

            LogTransaksi::create($log_data);

            return response()->json([
                'status' => true,
                'message' => 'Pembuatan ulang pembayaran berhasil!',
            ]);
        } catch (Exception $e) {

            $log_data = [
                'no_transaksi' => $no_trans,
                'keterangan' => $e,
                'subjek' => 'gagal membuat ulang transaksi',
                'status' => 'FAIL',
                'created_by' => Auth::id(),
                'created_at' => Carbon::now()->toDateTimeString()
            ];

            $peserta_seminar->is_paid = 3;
            $peserta_seminar->save();

            LogTransaksi::create($log_data);

            return response()->json([
                'status' => true,
                'message' => 'Pembuatan ulang pembayaran gagal!',
            ]);
        }
    }

}


