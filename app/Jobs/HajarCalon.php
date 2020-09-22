<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Traits\GlobalFunction;
use Mail;
use Vinkla\Hashids\Facades\Hashids;
use App\Mail\EmailRegistAkun;

class HajarCalon implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GlobalFunction;

    public $email;
    public $nama;
    public $no_hp;
    public $pesan;
    public $seminar;
    public $tries = 1;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $nama, $no_hp, $pesan, $seminar)
    {
        //
        $this->email = $email;
        $this->nama = $nama;
        $this->no_hp = $no_hp;
        $this->pesan = $pesan;
        $this->seminar = $seminar;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            Mail::to($this->email)->send(new EmailRegistAkun(['pesan' => $this->pesan, 'seminar' => $this->seminar]));

            $no_hp = $this->no_hp;
            $nama = $this->nama;
            $email = $this->email;
            $pass = $this->password;
            $username = "dengan Username : ".$email;
            $password = "dan Password : ".$pass;
            $login = 'https://srtf.p3sm.or.id/login';

            $seminar_1 = '-';
            $seminar_2 = '-';
            $seminar_3 = '-';

            if(isset($this->seminar[0])){
                $tema_1 = strip_tags(html_entity_decode($this->seminar[0]['tema']));
                $tgl_1 = \Carbon\Carbon::parse($this->seminar[0]['tgl_awal'])->isoFormat("DD MMMM YYYY");
                $link_1 = $this->seminar[0]['slug'];
                $seminar_1 = $tema_1.' pada tanggal '.$tgl_1.' dengan link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$link_1;
            }
            if(isset($this->seminar[1])){
                $tema_2 = strip_tags(html_entity_decode($seminar[1]['tema']));
                $tgl_2 = \Carbon\Carbon::parse($seminar[1]['tgl_awal'])->isoFormat("DD MMMM YYYY");
                $link_2 = $this->seminar[1]['slug'];
                $seminar_2 = $tema_2.' pada tanggal '.$tgl_2.' dengan link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$link_2;
            }
            if(isset($this->seminar[2])){
                $tema_3 = strip_tags(html_entity_decode($seminar[2]['tema']));
                $tgl_3 = \Carbon\Carbon::parse($seminar[2]['tgl_awal'])->isoFormat("DD MMMM YYYY");
                $link_3 = $this->seminar[2]['slug'];
                $seminar_3 = $tema_3.' pada tanggal '.$tgl_3.' dengan link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$link_3;
            }

            $token = $this->getToken();
            $channel = $this->setupChannel($token['access_token']);
            $template = '1f3a5e17-d51d-44a7-97c6-452afe122a38';

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
                "value" => "nomor_hp",
                "value_text" => $no_hp,
            ];
            $var3 = [
                "key" => "3",
                "value" => "email",
                "value_text" => $email,
            ];
            $var4 = [
                "key" => "4",
                "value" => "user",
                "value_text" => $username,
            ];
            $var5 = [
                "key" => "5",
                "value" => "password",
                "value_text" => $password,
            ];
            $var6 = [
                "key" => "6",
                "value" => "tema_1",
                "value_text" => $seminar_1,
            ];
            $var7 = [
                "key" => "7",
                "value" => "tema_2",
                "value_text" => $seminar_2,
            ];
            $var8 = [
                "key" => "8",
                "value" => "tema_3",
                "value_text" => $seminar_3,
            ];
            $var9 = [
                "key" => "9",
                "value" => "login",
                "value_text" => $login,
            ];

            $isiBody = [$var1,$var2,$var3,$var4,$var5,$var6,$var7,$var8,$var9];

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
    }
}
