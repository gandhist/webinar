<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlastingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $detail;
    public $link;
    public $hari;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detail, $link, $hari)
    {
        $this->detail = $detail;
        $this->link = $link;
        $this->hari = $hari;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@p3sm.or.id','Sertifikat Seminar P3SM')->subject('Undangan Seminar PKB P3S Mandiri')
                    ->view('mail.blasting');
    }
}
