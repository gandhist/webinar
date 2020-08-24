<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peserta;
use App\Seminar;
use App\User;
use App\PesertaSeminar;
use App\InstansiModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailRegist;
use App\Mail\EmailRegist2;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Traits\GlobalFunction;

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
            // 'email' => 'unique:srtf_peserta',
            // 'no_hp' => 'unique:srtf_peserta',
            'email' => 'unique:users',
        ],[
            'foto.mimes' => 'Format Foto Harus JPG atau PNG',
            'foto.max' => 'Maksimal Ukuran Foto 2MB',
            'foto.image' => 'Hanya Upload foto',
            'email.unique' => 'Email Sudah terdaftar!!',
            'no_hp.unique' => 'No Hp Sudah terdaftar!!'
        ]);
        // simpan data peserta
        // $data = new Peserta;
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
            $data['foto'] = $destinationPath."/".$file;
        }
        $peserta = Peserta::create($data);
        $password = str_random(8);
        // $password = '123456'; // buat test masih hardcode

        if ($peserta) {
            $data['username'] = strtolower($request->email); // mengganti username menjadi email
            $data['email'] = strtolower($request->email);
            $data['password'] = Hash::make($password);
            $data['name'] = $request->nama;
            $data['role_id'] = 2;
            $data['is_active'] = 1;
            $user = User::create($data);

            $peserta_id['user_id'] = $user->id;

            Peserta::find($peserta->id)->update($peserta_id);

            $pesan = [
                'username' => strtolower($request->email),
                'password' => $password
            ];
            $email = strtolower($request->email);
            Mail::to($email)->send(new EmailRegist($pesan));
        }

        return redirect('registrasi')->with('success', 'Registrasi berhasil, silahkan konfirmasi email');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function daftar($id)
    {
        $data = Seminar::find($id);

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
        $kode_inisiator = Seminar::select('inisiator')->where('id',$id)->first();
        $kode_instansi = InstansiModel::select('kode_instansi')->where('id',$kode_inisiator['inisiator'])->first();

        $cekPeserta = Peserta::selectRaw('COUNT(id) as jumlah,id')->where('email','=',$request->email)->orWhere('no_hp','=',$request->no_hp)->first();
        // $cekPeserta2 = Peserta::selectRaw('COUNT(id) as jumlah,id')->where('no_hp','=',$request->no_hp)->first();
            // dd($cekPeserta);
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
            // validasi jika sudah pernah terdaftar
            if($cek > 0){
                return redirect('')->with('warning', 'Anda Sudah Mendaftar Seminar');
            } else{
                $peserta_seminar = $peserta_seminar->save();

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

            $peserta = Peserta::find($cekPeserta->id);
            $tema = strip_tags(html_entity_decode($detailseminar['tema']));

            //kirim email
            $pesan = [
                'tema' => $tema,       
            ];
            Mail::to($peserta['email'])->send(new EmailRegist2($pesan));

            //kirim wa
            $nohp = $request->no_hp;
            $pesan = "Selamat $request->nama! Anda telah berhasil mendaftar di seminar P3SM dengan tema '$tema'";
            $this->kirimPesanWA($nohp,$pesan);

            return redirect('')->with('success', 'Pendaftaran Seminar berhasil');
     
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
            // validasi jika sudah pernah terdaftar
            if($cek > 0){
                return redirect('')->with('warning', 'Anda Sudah Mendaftar Seminar');
            } else{
                $peserta_seminar = $peserta_seminar->save();

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
                $data['username'] = $request->nama; 
                $data['email'] = strtolower($request->email);
                $data['password'] = Hash::make($password);
                $data['name'] = $request->nama;
                $data['role_id'] = 2;
                $data['is_active'] = 1;
                $user = User::create($data);

                $peserta_id['user_id'] = $user->id;

                Peserta::find($peserta->id)->update($peserta_id);
                $tema = strip_tags(html_entity_decode($detailseminar['tema']));
                //kirim email
                $pesan = [
                    'username' => $request->nama,
                    'password' => $password,
                    'tema' => $tema,
                ];
                $email = strtolower($request->email);
                Mail::to($email)->send(new EmailRegist($pesan));

                //kirim wa
                $nohp = $request->no_hp;
                $pesan = "Selamat $request->nama! Anda telah berhasil mendaftar di seminar P3SM dengan tema '$tema'";
                $this->kirimPesanWA($nohp,$pesan);
            }
            return redirect('')->with('success', 'Pendaftaran Seminar berhasil, silahkan konfirmasi email untuk username dan password');
        }
    }

}
