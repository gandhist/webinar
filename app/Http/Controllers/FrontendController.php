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
        $no_hp = '082169761759';
        $nama = 'Rama';
        $tema = 'Tes Seminar';
        $link = 'https://srtf.p3sm.or.id/';

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
            "value" => "full_name",
            "value_text" => $tema,
        ];
        $var3 = [
            "key" => "3",
            "value" => "full_name",
            "value_text" => $link,
        ];

        $isiBody = [$var1,$var2, $var3];

        $param = [
            "body" => $isiBody
        ];

        $body = [
            'to_number' => $no_hp,
            'to_name' => $nama,
            'message_template_id' => $template['data'][0]['id'],
            'channel_integration_id' => $channel['data'][0]['id'],
            'language' => $lang,
            'parameters' => $param,
        ];
    
        $pesan = $this->sendMessage($token['access_token'],$body);
        
        return $pesan;
      
        
    }
}
