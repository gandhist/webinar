<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\BlastingMail;
use App\Traits\GlobalFunction;

use App\TargetBlasting;
use App\LogBlasting;
use App\ReportBlasting;
use App\User;
use App\Peserta;
use App\PesertaSeminar;

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
        // $user = User::where('email', $this->detail['target']['email'])->first();

        $report_blasting = ReportBlasting::where('id_target', $this->detail['target']['id'])->where('id_seminar',$this->detail['seminar']['id'])->first();


        if( !(isset($report_blasting->is_email_sent))  ){
            // Fungsi blasting email
            Mail::to($this->detail['target']['email'])->send(new BlastingMail($this->detail, $this->link));

            if(empty($report_blasting)){
                $report = new ReportBlasting;
                $report->id_target = $this->detail['target']['id'];
                $report->id_seminar = $this->detail['seminar']['id'];
                $report->is_email_sent = 1;
                $report->magic_link = $this->detail['magic'];
                $report->created_at = \Carbon\Carbon::now();
                $report->save();
            } else {
                $report_blasting->is_email_sent = 1;
                $report_blasting->save();
            }
        }

        // Fungsi blasting untuk wa


    }
}
