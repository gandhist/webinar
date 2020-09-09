<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\PesertaBaru as MailPeserta;
use App\Traits\GlobalFunction;
use Mail;

class UserBaruPersonal implements ShouldQueue
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
        Mail::to($this->detail['email'])->send(new MailPeserta($this->detail));

        $nohp = $this->detail['nope'];
        // print_r($this->detail);
        $pesan = "Selamat ".$this->detail['nama']."! Anda berhasil terdaftar di P3S Mandiri. \nUsername : ".$this->detail['email']."\nPassword : ".$this->detail['password']."\nAnda bisa login melalui :\nhttps://srtf.p3sm.or.id/login\nMohon segera mengganti password Anda.";
        $status =  $this->kirimPesanWA($nohp,$pesan);
        // print_r($status);
    }
}
