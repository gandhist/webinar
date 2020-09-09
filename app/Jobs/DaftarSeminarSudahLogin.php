<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SeminarBaru as MailSeminar;
use App\Traits\GlobalFunction;
use Illuminate\Support\Facades\Mail;

class DaftarSeminarSudahLogin implements ShouldQueue
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

        //
        Mail::to($this->detail['email'])->send(new MailSeminar($this->detail));
        // $nohp = $this->detail['nope'];
        // print_r($this->detail);
        // $pesan = "Selamat ".$this->detail['nama']."! Anda berhasil terdaftar di seminar P3S Mandiri, dengan tema *".strip_tags($this->detail['tema'])."*";
        // $status =  $this->kirimPesanWA($nohp,$pesan);
        // print_r($status);

        $no_hp = $this->detail['nope'];
        $nama = $this->detail['nama'];
        $email = $this->detail['email'];
        $pass = '-';

        $username = "dengan Username : ".$email;
        $password = '-';
        $login = 'https://srtf.p3sm.or.id/login';

        $tema = $this->detail['tema'];
        $tgl = $this->detail['tanggal'];
        $jam = $this->detail['jam'];

        $token = $this->getToken();
        $channel = $this->setupChannel($token['access_token']);
        $template = '212f9ecc-52d5-4a98-b1bd-5e10d0a59804';

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
            "value" => "tema",
            "value_text" => $tema,
        ];
        $var7 = [
            "key" => "7",
            "value" => "tanggal",
            "value_text" => $tgl,
        ];
        $var8 = [
            "key" => "8",
            "value" => "jam",
            "value_text" => $jam,
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
        
        $status = $this->sendMessage($token['access_token'],$body);

    }
}
