<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peserta;
use App\Seminar;
use App\TargetBlasting;
use App\User;
use App\PesertaSeminar;
use App\InstansiModel;
use App\ReportBlasting;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailRegist;
use App\Mail\EmailRegist2;
use App\Mail\EmailRegistAkun;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalFunction;
use Illuminate\Support\Facades\Http;
use Hashids\Hashids;
use Session;

class RegistController extends Controller
{
    use GlobalFunction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('registrasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi form
        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'unique:users',
        ],[
            'foto.mimes' => 'Format Foto Harus JPG atau PNG',
            'foto.max' => 'Maksimal Ukuran Foto 2MB',
            'foto.image' => 'Hanya Upload foto',
            'email.unique' => 'Email Sudah terdaftar!!',
            'no_hp.unique' => 'No Hp Sudah terdaftar!!'
        ]);
        $data['nama'] = $request->nama;
        $data['no_hp'] = $request->no_hp;
        $data['email'] = $request->email;
        $data['pekerjaan'] = $request->pekerjaan;
        $data['instansi'] = $request->instansi;
        // handle upload Foto
        $dir_name =  preg_replace('/[^a-zA-Z0-9()]/', '_', $request->nama);
        if ($files = $request->file('foto')) {
            $destinationPath = 'uploads/peserta/'.$dir_name; // upload path
            if (!is_dir($destinationPath)) {
                File::makeDirectory($destinationPath, $mode = 0777, true, true);
            }
            $file = "foto_".$dir_name.Carbon::now()->timestamp. "." . $files->getClientOriginalExtension();
            $destinationFile = $destinationPath."/".$file;
            $destinationPathTemp = 'uploads/tmp/'; // upload path temp
            $resize_image = Image::make($files);
            $resize_image->resize(354, 472)->save(public_path($destinationPathTemp.$file));
            $temp = $destinationPathTemp.$file;
            rename($temp, $destinationFile);
            $data['foto'] = $dir_name."/".$file;
        }
        $peserta = Peserta::create($data);
        $password = str_random(8);
        // $password = '123456'; // buat t\est masih hardcode

        if ($peserta) {
            $data['username'] = strtolower($request->email);
            $data['email'] = strtolower($request->email);
            $data['password'] = Hash::make($password);
            $data['name'] = $request->nama;
            $data['role_id'] = 2;
            $data['is_active'] = 1;
            $user = User::create($data);

            $target = new TargetBlasting;
            $target->nama  = $request->nama;
            $target->email  = $request->email;
            $target->no_hp  = $request->no_hp;
            $target->save();

            $peserta_id['user_id'] = $user->id;

            Peserta::find($peserta->id)->update($peserta_id);

            $seminar = Seminar::where('status','=','published')->orderByDesc('tgl_awal')->get();

            $pesan = [
                'username' => $request->email,
                'email' => $request->email,
                'password' => $password,
                'name' => $request->nama,
                'no_hp' => $request->no_hp,
            ];
            $email = strtolower($request->email);
            Mail::to($email)->send(new EmailRegistAkun(['pesan' => $pesan, 'seminar' => $seminar]));

            //kirim wa
            $seminar = Seminar::where('status','=','published')->orderByDesc('tgl_awal')->get();

            $no_hp = $request->no_hp;
            $nama = $request->nama;
            $email = $request->email;
            $pass = $password;
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

        return redirect('')->with('success', 'Selamat bergabung di App PPKB P3S Mandiri! Username dan Password telah dikirim melalui email dan Whatsapp.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function daftar($slug)
    {
        // dd($slug);
        // Handle seminar lama (nggak ada slug)
        if ((strpos($slug, '-') !== false) || (preg_match("/[a-z]/i", $slug)) ) {
            $data = Seminar::where('slug','=', $slug)->first();
        }
        elseif($slug == 11){
            return redirect('https://us02web.zoom.us/j/81564894026?pwd=K2hTVWdRQzk1M1BydERDSnE5aTlvUT09');
        } else {
            $data = Seminar::where('id','=', $slug)->first();
        }

        return view('registrasi.daftar')->with(compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $id)
    {
        // dd($request);

        // Create Peserta
        $request->validate([
            // 'email' => 'unique:srtf_peserta',
            // 'no_hp' => 'unique:srtf_peserta',
            // 'email' => 'unique:users',
        ],[
            // 'email.unique' => 'Email Sudah terdaftar!!',
            // 'no_hp.unique' => 'No Hp Sudah terdaftar!!'
        ]);

        $detailseminar = Seminar::where('id',$id)->first();
        $is_free = Seminar::select('is_free')->where('id',$id)->first();
        $tanggal = Seminar::select('tgl_awal')->where('id', '=',$id)->first();
        $jam = Seminar::select('jam_awal')->where('id', '=',$id)->first();
        $kode_inisiator = Seminar::select('inisiator')->where('id',$id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();

        $cekPeserta = Peserta::selectRaw('COUNT(id) as jumlah,id')->where('email','=',$request->email)->orWhere('no_hp','=',$request->no_hp)->first();
        $peserta = Peserta::find($cekPeserta->id);

        if($cekPeserta->jumlah > 0 ){
            $data['nama'] = $request->nama;
            $data['no_hp'] = $request->no_hp;
            $data['email'] = $request->email;
            $data['pekerjaan'] = $request->pekerjaan;
            $data['instansi'] = $request->instansi;

            $cek = PesertaSeminar::where('id_peserta',$cekPeserta->id)->where('id_seminar', $id)->count();

            $peserta_seminar = new PesertaSeminar;
            if($is_free['is_free'] == '0'){
                $urutan_seminar = Seminar::select('no_urut')->where('id', '=',$id)->first();
                $urut = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for peserta
                if($urut == null) {
                    $peserta_seminar->no_urut_peserta = '1';
                } else {
                    $peserta_seminar->no_urut_peserta = $urut + 1;
                }
                $urutan = PesertaSeminar::select('no_urut_peserta')->where('id', '=',$id)->first();
                // generate no sertifikat
                $inisiator = $kode_instansi['kode_instansi'];
                $status = '1';
                $tahun = substr($detailseminar['tgl_awal'],2,2);
                $bulan = substr($detailseminar['tgl_awal'],5,2);

                $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($peserta_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
            }
            $peserta_seminar->id_seminar = $id;
            $peserta_seminar->id_peserta = $cekPeserta->id;
            $peserta_seminar->skpk_nilai = $detailseminar['skpk_nilai'];
            if($is_free['is_free'] == '0'){
                $peserta_seminar->is_paid = '1';
                $peserta_seminar->no_srtf = $no_sert;

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert));
                $nama = "QR_Sertifikat_".$no_sert.".png";
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $peserta_seminar->qr_code = $dir_name."/".$nama;
            } else {
                $peserta_seminar->is_paid = '0';
                $peserta_seminar->no_srtf = '';
            }
            $peserta_seminar->status = '1';
            $peserta_seminar->created_by = Auth::id();
            $peserta_seminar->created_at = Carbon::now()->toDateTimeString();

            if($request->magic_link){
                $peserta_seminar->is_blasting = 1;

                $blast = ReportBlasting::where('magic_link',$request->magic_link)->first();
                $blast->is_daftar = 1;
                $blast->daftar = \Carbon\Carbon::now();

                $peserta_seminar->id_blasting = $blast->id;
            }
            // validasi jika sudah pernah terdaftar
            if($cek > 0){

                $user = User::find($peserta['user_id']);
                $user->is_login = 1;
                $user->save();

                Auth::login($user);

                return redirect()->route('profile.edit')->with('second', 'Anda Sudah Terdaftar Seminar');

            } else{
                $peserta_seminar = $peserta_seminar->save();

                if($request->magic_link){
                    $blast->save();
                }
                if($is_free['is_free'] == '0'){
                    // pengurangan kuota
                    // $kuota = DB::table('srtf_seminar')->update(['kuota_temp' => DB::raw('GREATEST(kuota_temp - 1, 0)')]);
                    $kuota = Seminar::find($id);
                    $kuota->kuota_temp = $kuota->kuota_temp - 1;
                    $kuota->update();

                    // get nilai_skpk lalu di total
                    $total_nilai = Peserta::find($cekPeserta->id);
                    $total_nilai->skpk_total = $total_nilai->skpk_total + $detailseminar['skpk_nilai'];
                    $total_nilai->update();
                }
            }

            $tema = strip_tags(html_entity_decode($detailseminar['tema']));
            $tanggal = \Carbon\Carbon::parse($detailseminar['tgl_awal'])->translatedFormat('d F Y');
            $jam = $detailseminar['jam_awal'];

            //kirim email
            $pesan = [
                'username' => $request->email,
                // 'password' => 'PASSWORD',
                'email' => $request->email,
                'nama' => $request->email,
                'nope' => $request->no_hp,
                'tanggal' => $tanggal,
                'jam' => $jam,
                'tema' => $tema,
            ];
            Mail::to($peserta['email'])->send(new EmailRegist2($pesan));

            //kirim wa
            // $nohp = $request->no_hp;
            // $pesan = "Selamat $request->nama! Anda telah berhasil mendaftar di seminar P3SM dengan tema '$tema'";
            // $this->kirimPesanWA($nohp,$pesan);
            $no_hp = $request->no_hp;
            $nama = $request->nama;
            $email = $request->email;
            $pass = '-';

            $username = "dengan Username : ".$email;
            $password = '-';
            $login = 'https://srtf.p3sm.or.id/login';

            $tema = $tema;
            $tgl_awal = $tanggal;
            $jam_awal = $jam;

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
                "value_text" => $tgl_awal,
            ];
            $var8 = [
                "key" => "8",
                "value" => "jam",
                "value_text" => $jam_awal,
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

            $user = User::find($peserta['user_id']);
            $user->is_login = 1;
            $user->save();

            Auth::login($user);

            return redirect()->route('profile.edit')
            ->with('first', 'Mendaftar seminar berhasil!');
            // ->with('second', 'Pastikan email dan nomor handphone telah sesuai!');

        } else{
            $data['nama'] = $request->nama;
            $data['no_hp'] = $request->no_hp;
            $data['email'] = $request->email;
            $data['pekerjaan'] = $request->pekerjaan;
            $data['instansi'] = $request->instansi;

            $peserta = Peserta::create($data);

            $cek = PesertaSeminar::where('id_peserta',$peserta['id'])->where('id_seminar', $id)->count();

            $peserta_seminar = new PesertaSeminar;
            if($is_free['is_free'] == '0'){
                $urutan_seminar = Seminar::select('no_urut')->where('id', '=',$id)->first();
                $urut = PesertaSeminar::where('id_seminar',$id)->max('no_urut_peserta'); //Counter nomor urut for peserta
                if($urut == null) {
                    $peserta_seminar->no_urut_peserta = '1';
                } else {
                    $peserta_seminar->no_urut_peserta = $urut + 1;
                }
                $urutan = PesertaSeminar::select('no_urut_peserta')->where('id', '=',$id)->first();
                // generate no sertifikat
                $inisiator = $kode_instansi['kode_instansi'];
                $status = '1';
                $tahun = substr($detailseminar['tgl_awal'],2,2);
                $bulan = substr($detailseminar['tgl_awal'],5,2);

                $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($peserta_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);
            }

            $peserta_seminar->id_seminar = $id;
            $peserta_seminar->id_peserta = $peserta['id'];
            $peserta_seminar->skpk_nilai = $detailseminar['skpk_nilai'];
            if($is_free['is_free'] == '0'){
                $peserta_seminar->is_paid = '1';
                $peserta_seminar->no_srtf = $no_sert;

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert));
                $nama = "QR_Sertifikat_".$no_sert.".png";
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $peserta_seminar->qr_code = $dir_name."/".$nama;
            } else {
                $peserta_seminar->is_paid = '0';
                $peserta_seminar->no_srtf = '';
            }
            $peserta_seminar->status = '1';
            $peserta_seminar->created_by = Auth::id();
            $peserta_seminar->created_at = Carbon::now()->toDateTimeString();

            if($request->magic_link){
                $peserta_seminar->is_blasting = 1;

                $blast = ReportBlasting::where('magic_link',$request->magic_link)->first();
                $blast->is_daftar = 1;
                $blast->daftar = \Carbon\Carbon::now();

                $peserta_seminar->id_blasting = $blast->id;
            }

            // validasi jika sudah pernah terdaftar
            if($cek > 0){
                return redirect()->route('login')->with('warning', 'Anda Sudah Terdaftar Seminar');
            } else{
                $peserta_seminar = $peserta_seminar->save();
                if($request->magic_link){
                    $blast->save();
                }
                if($is_free['is_free'] == '0'){
                    // pengurangan kuota
                    // $kuota = DB::table('srtf_seminar')->update(['kuota_temp' => DB::raw('GREATEST(kuota_temp - 1, 0)')]);
                    $kuota = Seminar::find($id);
                    $kuota->kuota_temp = $kuota->kuota_temp - 1;
                    $kuota->update();

                    // get nilai_skpk dari lalu di total
                    $total_nilai = Peserta::find($peserta['id']);
                    $total_nilai->skpk_total = $total_nilai->skpk_total + $detailseminar['skpk_nilai'];
                    $total_nilai->update();
                }
            }
            // Create User
            $password = str_random(8);
            // $nama = str_replace(" ","", strtolower($request->nama));
            // $nama = preg_replace("/[^a-zA-Z]/", "", $nama);
            // $password = '123456'; // buat test masih hardcode
            if ($peserta) {
                $data['username'] = strtolower($request->email); // di ubah menjadi email sebagai username by gandhi
                $data['email'] = strtolower($request->email);
                $data['password'] = Hash::make($password);
                $data['name'] = $request->nama;
                $data['role_id'] = 2;
                $data['is_active'] = 1;
                $user = User::create($data);

                $peserta_id['user_id'] = $user->id;

                Peserta::find($peserta->id)->update($peserta_id);
                $tema = strip_tags(html_entity_decode($detailseminar['tema']));
                //kirim email ikhi
                $pesan = [
                    'username' => $request->nama,
                    'password' => $password,
                    'email' => strtolower($request->email),
                    'nama' => $request->nama,
                    'nope' => $request->no_hp,
                    'tanggal' => \Carbon\Carbon::parse($tanggal->tgl_awal)->translatedFormat('d F Y'),
                    'jam' => $jam->jam_awal,
                    'tema' => $tema,
                ];
                $email = strtolower($request->email);
                Mail::to($email)->send(new EmailRegist($pesan));

                //kirim wa
                // $nohp = $request->no_hp;
                // $pesan = "Selamat $request->nama! Anda telah berhasil mendaftar di seminar P3SM dengan tema '$tema'";
                // $this->kirimPesanWA($nohp,$pesan);
                $no_hp = $request->no_hp;
                $nama = $request->nama;
                $email = $request->email;
                $pass = $password;

                $username = "dengan Username : ".$email;
                $password = "dan Password : ".$pass;;
                $login = 'https://srtf.p3sm.or.id/login';

                $tema = $tema;
                $tgl_awal = $tanggal->tgl_awal;
                $jam_awal = $jam->jam_awal;

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
                    "value_text" => $tgl_awal,
                ];
                $var8 = [
                    "key" => "8",
                    "value" => "jam",
                    "value_text" => $jam_awal,
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

            $user = User::find($peserta_id['user_id']);
            $user->is_login = 1;
            $user->save();

            Auth::login($user);

            return redirect()->route('profile.edit')
            ->with('first', 'Akun berhasil dibuat! Username dan Password telah dikirim melalui email dan Whatsapp.')
            ->with('second', 'Pastikan email dan nomor handphone telah sesuai!');

            // return redirect()->route('login')->with('success', 'Anda Berhasil Terdaftar! Silahkan coba login dengan username dan password yang telah dikirim melalui email dan Whatsapp');
            // return redirect('')->with('success', 'Pendaftaran Seminar berhasil, silahkan konfirmasi email untuk username dan password');
        }
    }

    public function wa_regist()
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

    public function test($test) {
        $hashids = new Hashids();
        $decode = $hashids->decode($test);
        dd($decode);
        // $body = {
        //     "to_number": "081586604381",
        //     "to_name": "Arief Purwoko",
        //     "message_template_id": "aaf1bfb3-0ec7-4891-957a-a9c413c4a0d2",
        //     "channel_integration_id": "65038597-0de1-47e2-adcf-c7fd15acf0ea",
        //     "language": {
        //       "code": "id"
        //     },
        //     "parameters": {
        //       "body": [
        //         {
        //           "key": "1",
        //           "value": "full_name",
        //           "value_text": "Arief Purwoko"
        //         },
        //         {
        //           "key": "2",
        //           "value": "lokasi",
        //           "value_text": "ini di kirim dari API lewat postman"
        //         },
        //         {
        //           "key": "3",
        //           "value": "link",
        //           "value_text": "https://laravel.com/docs/5.7/http-tests#introduction"
        //         },
        //         {
        //           "key": "4",
        //           "value": "cp",
        //           "value_text": "hubungin aja no admin nya"
        //         }
        //       ]
        //     }
        //   }


        // $token = "Etk6qmemyc6DgKdouMtPwjxnh-I2aExvX0tI0JNJ1_g";
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     // 'Authorization' => 'bar'
        // ])->withToken($token)->get('https://service.qontak.com/api/open/v1/templates/whatsapp');
        // // $response->header();
        // return $response;


        // $seminar = Seminar::where('status','=','published')->get();
        // // $seminar = null;
        // $pesan = [
        //     'username' => "USERNAME",
        //     'email' => 'EMAIL',
        //     'password' => "PASSWORD",
        //     'name' => "NAMA LENGKAP",
        //     'no_hp' => "HO HP",
        // ];


        // return view('mail.regist-akun')->with(compact('pesan', 'seminar'));

        // $pesan = [
        //             'username' => 'USERNAME',
        //             'password' => 'PASSWORD',
        //             'email' => 'EMAIL@GMAIL.COM',
        //             'nama' => 'NAMA LENGKAP',
        //             'nope' => '08228734843',
        //             'tanggal' => 'TANGGAL KEJADIAN',
        //             'jam' => 'JAM MULAI',
        //             'tema' => 'TEMA TEMA TEMA TEMA TEMA TEMA TEMA TEMATEMA TEMA TEMA TEMA TEMA TEMA TEMA TEMA',
        // ];

        // return view('mail.signup')->with(compact('pesan'));

    }


}
