<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailRegistAkun extends Mailable
{
    use Queueable, SerializesModels;

    public $pesan;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pesan)
    {
        $this->pesan = $pesan;
        dd($pesan);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@p3sm.or.id','Registrasi Akun App PPKB ONLINE')->subject('Registrasi Akun App PPKB ONLINE')->view('mail.regist-akun');
    }
}
