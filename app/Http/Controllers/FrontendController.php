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

    public function kirimWA()
    {    
        $no_hp = '081294868833';
        $nama = 'Nanda';
        $username = 'noernanda@gmail.com';
        $pass = '123456';
        $detail_seminar = 'Tes Seminar';
        $detail_seminar = "Nama : ".$nama."\n
                  Password : ".$pass."\n
                  Nomor Hp (WA) : ".$no_hp."\n
                  Email : ".$username."\n
                  dengan Username : ".$username."\n
                  dan Password : ".$pass."\n
                  Silahkan mendaftar di seminar sebagai berikut,\n
                  ";
        $link = '\nhttps://srtf.p3sm.or.id/login\n';

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
