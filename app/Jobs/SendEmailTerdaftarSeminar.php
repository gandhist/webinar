<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SeminarBaru as MailSeminar;
use App\LogImportErr;
use App\Traits\GlobalFunction;
use Mail;

class SendEmailTerdaftarSeminar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalFunction;

    protected $detail;

    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        //
        $this->detail = $detail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->detail['email'])->send(new MailSeminar($this->detail));
        // $nohp = $this->detail['nope'];
        // // print_r($this->detail);
        // $pesan = "Selamat ".$this->detail['nama']."! Anda berhasil terdaftar di seminar P3S Mandiri, dengan tema *".strip_tags($this->detail['tema'])."*";
        // $status =  $this->kirimPesanWA($nohp,$pesan);
        // // print_r($status);

        // if($status['status'] == '1'){
        //     $log = LogImportErr::where('id',$this->detail['im_id'])->first();
        //     $log->status = '1';
        //     $log->save();
        // } elseif ($status['status'] =='0') {
        //     $log = LogImportErr::where('id',$this->detail['im_id'])->first();
        //     $log->status = '0';
        //     $log->save();
        // }
    }
}
