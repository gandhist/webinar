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
use App\Seminar;

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

        // $nohp = $this->detail['nope'];
        // $pesan = "Selamat ".$this->detail['nama']."! Anda berhasil terdaftar di P3S Mandiri. \nUsername : ".$this->detail['email']."\nPassword : ".$this->detail['password']."\nAnda bisa login melalui :\nhttps://srtf.p3sm.or.id/login\nMohon segera mengganti password Anda.";
        // $status =  $this->kirimPesanWA($nohp,$pesan);
        
            $seminar = Seminar::where('status','=','published')->orderByDesc('tgl_awal')->get();

            $no_hp =  $this->detail['nope'];
            $nama =  $this->detail['nama'];
            $email =  $this->detail['email'];
            $pass =  $this->detail['password'];
            $username = "dengan Username : ".$email;
            $password = "dan Password : ".$pass;
            $login = 'https://srtf.p3sm.or.id/login';

            $seminar_1 = '-';
            $seminar_2 = '-';
            $seminar_3 = '-';

            if(isset($seminar[0])){
                $tema_1 = strip_tags(html_entity_decode($seminar[0]['tema']));
                $tgl_1 = \Carbon\Carbon::parse($seminar[0]['tgl_awal'])->isoFormat("DD MMMM YYYY");
                $link_1 = $seminar[0]['slug'];
                $seminar_1 = $tema_1.' pada tanggal '.$tgl_1.' dengan link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$link_1;
            }
            if(isset($seminar[1])){
                $tema_2 = strip_tags(html_entity_decode($seminar[1]['tema']));
                $tgl_2 = \Carbon\Carbon::parse($seminar[1]['tgl_awal'])->isoFormat("DD MMMM YYYY");
                $link_2 = $seminar[1]['slug'];
                $seminar_2 = $tema_2.' pada tanggal '.$tgl_2.' dengan link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$link_2;
            }
            if(isset($seminar[2])){
                $tema_3 = strip_tags(html_entity_decode($seminar[2]['tema']));
                $tgl_3 = \Carbon\Carbon::parse($seminar[2]['tgl_awal'])->isoFormat("DD MMMM YYYY");
                $link_3 = $seminar[2]['slug'];
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
