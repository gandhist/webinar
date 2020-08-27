<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\EmailLink as MailLink;
use Mail;

class KirimLinkSeminar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $tries = 5;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email,$key)
    {
        //
        $this->key = $param['key'];
        $this->data = $param['data'];
        $this->link = $param['link'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->data->email)->send(new MailLink([$this->key,$this->link]));
    }
}
