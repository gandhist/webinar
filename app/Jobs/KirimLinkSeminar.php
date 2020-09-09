<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\EmailLink as MailLink;
use App\PesertaSeminar;
use App\Traits\GlobalFunction;
use Mail;
use Vinkla\Hashids\Facades\Hashids;


class KirimLinkSeminar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalFunction;


    protected $data;

    protected $key;


    public $tries = 1;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$key)
    {
        //
        $this->data = $data;
        $this->key = $key;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->data->email)->send(new MailLink($this->key));

        $tgl = \Carbon\Carbon::parse($this->key->seminar_p->tgl_awal)->isoFormat('DD MMMM YYYY');
        $tema = strip_tags($this->key->seminar_p->tema);
        $jam = $this->key->seminar_p->jam_awal;
        $url =  url('presensi', Hashids::encode($this->key->id));

        // $nohp = $this->data->no_hp;
        // $nama = $this->data->nama;
        // // print_r($this->detail);
        // // $pesan = 'test';
        // $pesan = "Salam Sehat Bapak/Ibu $nama serta rekan-rekan semua bersama ini kami sampaikan Link Presensi untuk acara Webinar pada tanggal $tgl dengan topik *$tema*. \nAcara dimulai pukul $jam WIB, harap menggunakan nama dengan format *\"nama_institusi\"*.\ncontoh : Budi_P3S mandiri \nLink : $url \nTerimakasih";
        // $status = $this->kirimPesanWA($nohp,$pesan);
        // // print_r($status);

        // if($status['status'] == '1'){
        //     $log = PesertaSeminar::where('id',$this->key->id)->first();
        //     $log->status_wa = '1';
        //     $log->save();
        // } elseif ($status['status'] =='0') {
        //     $log = PesertaSeminar::where('id',$this->key->id)->first();
        //     $log->status_wa = '0';
        //     $log->save();
        // }
    }
}
