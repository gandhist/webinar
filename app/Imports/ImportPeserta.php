<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Mail\PesertaBaru as MailPeserta;
use App\Mail\SeminarBaru as MailSeminar;
use App\Peserta;
use App\PesertaSeminar;
use App\Seminar;
use App\LogImport;
use App\LogImportErr;
use App\User;

class ImportPeserta implements ToCollection,WithHeadingRow
{
    public function  __construct($id)
    {
        $this->id= $id;
    }

    public function collection(Collection $rows)
    {
        $import = new LogImport;
        $import->save();
        $jumlah = 0;
        $seminar = Seminar::where('id', $this->id)->first();
        foreach ($rows as $row)
        {
            $err = [];
            $userAda = 0;
            $import_err = new LogImportErr;
            $import_err->save();
            $user = User::where('email',$row['email'])->first();
            $user_id = NULL;
            $id_peserta_seminar = NULL;

            if(!isset($user)) {
                $user                               = new User;
                $user->username                     = $row['email'];
                $user->email                        = $row['email'];
                $user->password                     = Hash::make($row['nomor_handphone']);
                $user->name                         = $row['nama'];
                $user->role_id                      = '2';
                $user->save();

                $user_id = $user->id;

                $password = $row['nomor_handphone'];

                // $detail = ['nama' => $row['nama'], 'password' => $row['nomor_handphone'], 'nope' => $row['nomor_handphone'] , 'email' => $row['email'], 'im_id' => $import_err->id];
                // dispatch(new \App\Jobs\SendEmailUserBaru($detail));
                // \Mail::to($row['email'])->send(new MailPeserta($detail));

            }
            if(isset($user->peserta->no_hp)){
                if ($user->email ==  $row['email'] && $user->peserta->no_hp != $row['nomor_handphone']) {

                    $user->grup_id = $user->id;
                    $user->save();

                    $duplicate_user                               = new User;
                    $duplicate_user->username                     = $row['email'];
                    $duplicate_user->email                        = $row['email'];
                    $duplicate_user->password                     = Hash::make($row['nomor_handphone']);
                    $duplicate_user->name                         = $row['nama'];
                    $duplicate_user->role_id                      = '2';
                    $duplicate_user->grup_id                      = $user->id;
                    $duplicate_user->save();


                    $user_id = $duplicate_user->id;

                    $password = $row['nomor_handphone'];

                    // $detail = ['nama' => $row['nama'], 'password' => $row['nomor_handphone'], 'nope' => $row['nomor_handphone'] ,'email' => $row['email'], 'im_id' => $import_err->id];
                    // dispatch(new \App\Jobs\SendEmailUserBaru($detail));

                    array_push($err, 'Membuat user ganda');

                } elseif ($user->email ==  $row['email'] && $user->peserta->no_hp == $row['nomor_handphone']) {
                    array_push($err, 'User sudah ada');
                    $userAda = 1;
                    $user_id = $user->id;
                }
            }

            $peserta = Peserta::where('user_id',$user->id)->first();

            if(!isset($peserta)) {

                $peserta                            = new Peserta;
                $peserta->user_id                   = $user->id;
                $peserta->nama                      = $row['nama'];
                $peserta->no_hp                     = $row['nomor_handphone'];
                $peserta->email                     = $row['email'];
                $peserta->pekerjaan                 = $row['pekerjaan'];
                $peserta->instansi                  = $row['instansi'];
                $peserta->save();

            } else {
                array_push($err, 'Peserta sudah ada');
            }

            $udahAda = PesertaSeminar::where('id_seminar',$this->id)->where('id_peserta',$peserta->id)->first();

            if(!isset($udahAda)) {

                $peserta_seminar                    = new PesertaSeminar;
                $peserta_seminar->id_seminar        = $this->id;
                $peserta_seminar->id_peserta        = $peserta->id;
                $peserta_seminar->is_paid           = '1';
                $peserta_seminar->status            = '1';
                $peserta_seminar->skpk_nilai        = $seminar->skpk_nilai;

                $tanggal = Seminar::select('tgl_awal')->where('id', '=',$this->id)->first();
                $urutan_seminar = Seminar::select('no_urut')->where('id', '=',$this->id)->first();
                $urut = PesertaSeminar::where('id_seminar',$this->id)->max('no_urut_peserta'); //Counter nomor urut for peserta
                if($urut == null) {
                    $peserta_seminar->no_urut_peserta = '1';
                } else {
                    $peserta_seminar->no_urut_peserta = $urut + 1;
                }// generate no sertifikat
                $inisiator = '88';
                $status = '1';
                $tahun = substr($tanggal['tgl_awal'],2,2);
                $bulan = substr($tanggal['tgl_awal'],5,2);

                $no_sert = $inisiator."-".$status."-".$tahun."-".$bulan."-".$urutan_seminar->no_urut.str_pad($peserta_seminar->no_urut_peserta, 3, "0", STR_PAD_LEFT);


                $peserta_seminar->no_srtf = $no_sert;

                // generate qr code
                $url = url("sertifikat/".Crypt::encrypt($no_sert));
                $nama = "QR_Sertifikat_".$no_sert.".png";
                $qrcode = \QrCode::margin(100)->format('png')->errorCorrection('L')->size(150)->generate($url, base_path("public/file_seminar/".$nama));

                $dir_name = "file_seminar";
                $peserta_seminar->qr_code = $dir_name."/".$nama;
                $peserta_seminar->save();

                $id_peserta_seminar = $peserta_seminar->id;

                $kurangi_kuota = Seminar::where('id',$this->id)->first();
                $kurangi_kuota->kuota_temp = $kurangi_kuota->kuota_temp - 1;
                $kurangi_kuota->save();

                $nama_seminar = Seminar::select('nama_seminar', 'tema')->where('id', '=',$this->id)->first();


                // $detail = ['nama' => $row['nama'],
                // 'tema' => $nama_seminar->tema,
                // 'email' => $row['email'], 'nope' => $row['nomor_handphone'] , 'im_id' => $import_err->id];
                // dispatch(new \App\Jobs\SendEmailTerdaftarSeminar($detail));

                // \Mail::to($row['email'])->send(new MailSeminar($detail));
                // Mail::to($this->detail['email'])->send(new MailSeminar($this->detail));
                $tema = strip_tags(html_entity_decode($seminar->tema));
                $tanggal = \Carbon\Carbon::parse($seminar->tgl_awal)->translatedFormat('d F Y');
                $jam = $seminar->jam_awal;

                if($userAda == 0){


                    $detail = [
                        'username' => $user->username,
                        'password' => $password,
                        'email' =>$peserta->email,
                        'nama' => $peserta->nama,
                        'nope' => $peserta->no_hp,
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'tema' => $tema,
                        'im_id' => $import_err->id,
                    ];
                    dispatch(new \App\Jobs\SendEmailUserBaru($detail));
                } else {

                    $detail = [
                        'username' => $user->username,
                        // 'password' => $password,
                        'email' =>$peserta->email,
                        'nama' => $peserta->nama,
                        'nope' => $peserta->no_hp,
                        'tanggal' => $tanggal,
                        'jam' => $jam,
                        'tema' => $tema,
                        'im_id' => $import_err->id,
                    ];

                    dispatch(new \App\Jobs\SendEmailTerdaftarSeminar($detail));
                }

            } else {
                array_push($err, 'sudah mengikuti seminar');
                $id_peserta_seminar = $udahAda->id;
            }


            $import_err->import_id = $import->id;
            $import_err->user_id = $user_id;
            $import_err->id_peserta_seminar = $id_peserta_seminar;
            $import_err->note = implode(', ', $err);
            $import_err->save();

            $jumlah = $jumlah+1;

        }

        $import->jumlah = $jumlah;
        $import->save();
    }

}
