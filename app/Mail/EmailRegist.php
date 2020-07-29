<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailRegist extends Mailable
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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.signup')->with(['username' => $this->pesan['username'],'password' => $this->pesan['password'] ])->subject('Verification Email P3SM');
    }
}
