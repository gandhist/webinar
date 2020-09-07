<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\SeminarModel;
use App\Mail\EmailLinkSert as MailSertifikat;
use Carbon\Carbon;
use DB;
use App\Traits\GlobalFunction;

class FrontendController extends Controller
{
    use GlobalFunction;

    public function index()
    {
        $date = Carbon::now()->toDateTimeString();
        $data = SeminarModel::where('status','=','published')->orderBy('id','desc')->get();
        if(Auth::check())
        if(Auth::user()->role_id == 2){
            return view('homeUI')->with(compact('data'));
        }
        else {
            return view('home');
        }
        return view('homeUI')->with(compact('data'));
    }
    public function reset()
    {
        return view('reset');
    }

    public function update()
    {
        $emails = PesertaSeminar::where('no_srtf',$id)->first();
        $email = Peserta::where('id',$emails['id_peserta'])->first();
        $emails->no_sertf = Crypt::encrypt($id);
        \Mail::to($email->email)->send(new MailSertifikat($emails));

        return redirect()->back()->with('alert',"Sertifikat Berhasil dikirim ke $email->email");

    }

    public function fetch(Request $request)
    {
        if($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('users')->where('username', 'LIKE', "%{$query}%")->whereNotNull('password')->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative; width:100%;">';
            foreach($data as $row) {
                $output .= '<li><a href="#">'.$row->username.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    public function berita()
    {
        return view('blogs.berita');
    }

    public function galeri()
    {
        return view('blogs.galeri');
    }

    public function kirimWA()
    {    
        $seminar = SeminarModel::where('status','=','published')->orderByDesc('tgl_awal')->get();

        $no_hp = '081294868833';
        $nama = 'Nanda';
        $username = 'noernanda@gmail.com';
        $pass = '123456';
        $link = '\nhttps://srtf.p3sm.or.id/login\n';

        // $detail_seminar = "Nama : ".$nama."\nPassword : ".$pass."\nNomor Hp (WA) : ".$no_hp."\nEmail : ".$username."\ndengan Username : ".$username."\ndan Password : ".$pass."\nSilahkan mendaftar di seminar sebagai berikut,\n";
        $detail = '';
        $nomor = 1;
        foreach($seminar as $key){
            $tema = strip_tags(html_entity_decode($key->tema));
            $tgl_awal = \Carbon\Carbon::parse($key->tgl_awal)->isoFormat("DD MMMM YYYY");
            $det = $nomor.'. '.$tema.' tanggal '.$tgl_awal.' link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$key->slug;
            $detail .= "\n".$det;

            $nomor++;
        }
        
        $detail_seminar = "Nama : ".$nama."\nPassword : ".$pass."\nNomor Hp (WA) : ".$no_hp."\nEmail : ".$username."\ndengan Username : ".$username."\ndan Password : ".$pass."\nSilahkan mendaftar di seminar sebagai berikut,".$detail."";
        $pesan = "Halo ".$nama.", \nSelamat, Anda Sudah terdaftar sebagai pengguna App PPKB ONLINE dari P3S Mandiri. Dengan data sebagai berikut.\n\nNama : ".$nama."\nPassword : ".$pass."\nNomor Hp (WA) : ".$no_hp."\nEmail : ".$username."\ndengan Username : ".$username."\ndan Password : ".$pass."\nSilahkan mendaftar di seminar sebagai berikut,".$detail."\n\nKegiatan ini di selengarakan secara Online dengan App PPKB Online dari P3S Mandiri Pastikan Nomor Whatsapp P3S Mandiri ini telah tersimpan sebagai kontak HP Saudara/i, Agar link yang terdapat di dalamnya bisa langsung aktif dan dapat di “klik”. \n\nSetelah Nomor WA tersebut tersimpan, Silakan login dengan klik tombol login berikut ini https://srtf.p3sm.or.id/registrasi/login . \n\nTerima kasih sudah mendaftar App PPKB ONLINE dari P3S Mandiri.";


        return $this->kirimPesanWA($no_hp,$pesan);

        $token = $this->getToken(); 
        $channel = '65038597-0de1-47e2-adcf-c7fd15acf0ea';
        $template = $this->setupTemplate($token['access_token']);
        
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
            "value" => "detail_seminar",
            "value_text" => $detail_seminar,
        ];
        $var3 = [
            "key" => "3",
            "value" => "link",
            "value_text" => $link,
        ];

        $isiBody = [$var1,$var2, $var3];

        $param = [
            "body" => $isiBody
        ];

        $body = [
            'to_number' => $no_hp,
            'to_name' => $nama,
            'message_template_id' => $template['data'][1]['id'],
            'channel_integration_id' => $channel,
            'language' => $lang,
            'parameters' => $param,
        ];
    
        $pesan = $this->sendMessage($token['access_token'],$body);

        // $disc = $this->discChannel($token['access_token'],$channel['data'][0]['id']);
        
        return $pesan;
      
        
    }
}
