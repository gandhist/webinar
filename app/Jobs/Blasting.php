<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Mail\BlastingMail;
use App\Traits\GlobalFunction;

class Blasting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalFunction;

    protected $detail;

    protected $link;

    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($detail, $link)
    {
        //
        $this->detail = $detail;
        $this->link = $link;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Fungsi blasting email
        Mail::to($this->detail['email'])->send(new BlastingMail($this->detail, $this->link));

        // Fungsi blasting untuk wa


    }
}
