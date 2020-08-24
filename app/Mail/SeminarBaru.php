<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SeminarBaru extends Mailable
{
    use Queueable, SerializesModels;

    public $detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@p3sm.or.id','Sertifikat Seminar P3SM')->subject('Pendaftaran Seminar P3S Mandiri')
                    ->view('mail.terdaftar-seminar');
    }
}
