<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\PesertaBaru as MailPeserta;
use App\LogImportErr;
use App\Traits\GlobalFunction;
use Mail;

class SendEmailUserBaru implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalFunction;

    protected $detail;

    public $tries = 5;

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
        //
        $log = LogImportErr::where('id',$this->detail['im_id'])->first();

        if($log->is_email_sent != 1){
            Mail::to($this->detail['email'])->send(new MailPeserta($this->detail));
            $log->is_email_sent = 1;
            $log->save();
        }

        // $nohp = $this->detail['nope'];
        // // print_r($this->detail);
        // $pesan = "Selamat ".$this->detail['nama']."! Anda berhasil terdaftar di P3S Mandiri. \nUsername : ".$this->detail['email']."\nPassword : ".$this->detail['nope']."\nAnda bisa login melalui :\nhttps://srtf.p3sm.or.id/login\nMohon segera mengganti password Anda.";
        // $status =  $this->kirimPesanWA($nohp,$pesan);
        // // print_r($status);

        // if($status['status'] == '1'){
        //     $log = LogImportErr::where('id',$this->detail['im_id'])->first();
        //     $log->status_daftar = '1';
        //     $log->save();
        // } elseif ($status['status'] =='0') {
        //     $log = LogImportErr::where('id',$this->detail['im_id'])->first();
        //     $log->status_daftar = '0';
        //     $log->save();
        // }

    }
}
