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
                $report_blasting = new ReportBlasting;
                $report_blasting->id_target = $this->detail['target']['id'];
                $report_blasting->id_seminar = $this->detail['seminar']['id'];
                $report_blasting->is_email_sent = 1;
                $report_blasting->magic_link = $this->detail['magic'];
                $report_blasting->created_at = \Carbon\Carbon::now();
                $report_blasting->save();
            } else {
                $report_blasting->is_email_sent = 1;
                $report_blasting->save();
            }
        }

        // Fungsi blasting untuk wa
        if( !(isset($report_blasting->is_wa_sent))  ){
            $no_hp = $this->detail['target']['no_hp'];
            $nama = $this->detail['target']['nama'];
            $login = 'https://srtf.p3sm.or.id/login';
            $website = 'https://srtf.p3sm.or.id';

            $title = $this->detail['seminar']['nama_seminar'];
            $tema = strip_tags(html_entity_decode($this->detail['seminar']['tema']));
            $tgl = \Carbon\Carbon::parse($this->detail['seminar']['tgl_awal'])->isoFormat("DD MMMM YYYY");
            $jam = $this->detail['seminar']['jam_awal'];

            $detal_seminar = 'Free Webinar : '.$title.' dengan tema *'.$tema.'* yang akan diselenggarakan pada tanggal '.$tgl.' jam '.$jam.' WIB sampai selesai';

            $link = $this->detail['magic'];
            $link_seminar = 'https://srtf.p3sm.or.id/blast/'.$link;

            $token = $this->getToken();
            $channel = $this->setupChannel($token['access_token']);
            $template = '487cd15b-8d66-4126-881c-c75cf14229a1';

            $lang = [
                'code' => 'id'
            ];
            $var1 = [
                "key" => "1",
                "value" => "full_name",
                "value_text" => $nama,
            ];
            $var2 = [
                "key" => "2",
                "value" => "seminar",
                "value_text" => $detal_seminar,
            ];
            $var3 = [
                "key" => "3",
                "value" => "link_seminar",
                "value_text" => $link_seminar,
            ];
            $var4 = [
                "key" => "4",
                "value" => "login",
                "value_text" => $login,
            ];
            $var5 = [
                "key" => "5",
                "value" => "website",
                "value_text" => $website,
            ];

            $isiBody = [$var1,$var2,$var3,$var4,$var5];

            $param = [
                "body" => $isiBody
            ];

            $body = [
                'to_number' => $no_hp,
                'to_name' => $nama,
                'message_template_id' => $template,
                'channel_integration_id' => $channel['data'][0]['id'],
                'language' => $lang,
                'parameters' => $param,
            ];

            $pesan = $this->sendMessage($token['access_token'],$body);

            if(empty($report_blasting)){
                $report_blasting = new ReportBlasting;
                $report_blasting->id_target = $this->detail['target']['id'];
                $report_blasting->id_seminar = $this->detail['seminar']['id'];
                $report_blasting->is_wa_sent = 1;           // Kondisi kalo sukses
                $report_blasting->magic_link = $this->detail['magic'];
                $report_blasting->created_at = \Carbon\Carbon::now();
                $report_blasting->save();
            } else {
                $report_blasting->is_wa_sent = 1;       // Kondisi kalo sukses
                $report_blasting->save();
            }
        }

    }
}
