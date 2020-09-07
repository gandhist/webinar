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

    public function kirimWA() // daftar only
    {    
        $seminar = SeminarModel::where('status','=','published')->orderByDesc('tgl_awal')->get();

        $no_hp = '081294868833';
        $nama = 'Noer Herinnanda Putra';
        $email = 'noernanda@gmail.com';
        $pass = '123456';
        $username = "dengan Username : ".$email;
        $password = "dan Password : ".$pass;
        $login = 'https://srtf.p3sm.or.id/login';

        $tema = strip_tags(html_entity_decode($seminar[0]['tema']));
        $tgl = \Carbon\Carbon::parse($seminar[0]['tgl_awal'])->isoFormat("DD MMMM YYYY");
        $link = $seminar[0]['slug'];
        $seminar_1 = $tema.' pada tanggal '.$tgl.' dengan link '.'https://srtf.p3sm.or.id/registrasi/daftar/'.$link;
        $seminar_2 = '-';
        $seminar_3 = '-';

        $token = $this->getToken(); 
        $channel = $this->setupChannel($token['access_token']);
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
            'message_template_id' => '1f3a5e17-d51d-44a7-97c6-452afe122a38',
            'channel_integration_id' => $channel['data'][0]['id'],
            'language' => $lang,
            'parameters' => $param,
        ];

        $pesan = $this->sendMessage($token['access_token'],$body);
        
        return $pesan;   
    }

    public function kirimWA2() // blasting
    {    
        $seminar = SeminarModel::where('status','=','published')->orderByDesc('tgl_awal')->get();

        $no_hp = '081294868833';
        $nama = 'Noer Herinnanda Putra';
        $login = 'https://srtf.p3sm.or.id/login';
        $website = 'https://srtf.p3sm.or.id';

        $title = $seminar[0]['nama_seminar'];
        $tema = strip_tags(html_entity_decode($seminar[0]['tema']));
        $tgl = \Carbon\Carbon::parse($seminar[0]['tgl_awal'])->isoFormat("DD MMMM YYYY");
        $jam = $seminar[0]['jam_awal'];
      
        $detal_seminar = 'Free Webinar : '.$title.' dengan tema *'.$tema.'* yang akan diselenggarakan pada tanggal '.$tgl.' jam '.$jam.' WIB sampai selesai';
        
        $link = $seminar[0]['slug'];
        $link_seminar = 'https://srtf.p3sm.or.id/registrasi/daftar/'.$link;

        $token = $this->getToken(); 
        $channel = $this->setupChannel($token['access_token']);
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
            'message_template_id' => '487cd15b-8d66-4126-881c-c75cf14229a1',
            'channel_integration_id' => $channel['data'][0]['id'],
            'language' => $lang,
            'parameters' => $param,
        ];

        $pesan = $this->sendMessage($token['access_token'],$body);
        
        return $pesan;    
    }

    public function kirimWA3() // daftar + join seminar
    {    
        $seminar = SeminarModel::where('status','=','published')->orderByDesc('tgl_awal')->get();

        $no_hp = '081294868833';
        $nama = 'Noer Herinnanda Putra';
        $email = 'noernanda@gmail.com';
        $pass = '123456';
        $username = "dengan Username : ".$email;
        $password = "dan Password : ".$pass;
        $login = 'https://srtf.p3sm.or.id/login';

        $tema = strip_tags(html_entity_decode($seminar[0]['tema']));
        $tgl = \Carbon\Carbon::parse($seminar[0]['tgl_awal'])->isoFormat("DD MMMM YYYY");
        $jam = $seminar[0]['jam_awal'];

        $token = $this->getToken(); 
        $channel = $this->setupChannel($token['access_token']);
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
            'message_template_id' => '212f9ecc-52d5-4a98-b1bd-5e10d0a59804',
            'channel_integration_id' => $channel['data'][0]['id'],
            'language' => $lang,
            'parameters' => $param,
        ];

        $pesan = $this->sendMessage($token['access_token'],$body);
        
        return $pesan;
         
    }
}
