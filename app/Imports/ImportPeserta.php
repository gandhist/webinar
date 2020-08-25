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
use App\User;

class ImportPeserta implements ToCollection,WithHeadingRow
{
    public function  __construct($id)
    {
        $this->id= $id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $user = User::where('email',$row['email'])->first();

            if(!isset($user)) {
                $user                               = new User;
                $user->username                     = $row['email'];
                $user->email                        = $row['email'];
                $user->password                     = Hash::make($row['nomor_handphone']);
                $user->name                         = $row['nama'];
                $user->role_id                      = '2';
                $user->save();

                $detail = ['nama' => $row['nama'], 'password' => $row['nomor_handphone'], 'email' => $row['email']];
                dispatch(new \App\Jobs\SendEmailUserBaru($detail));
                // \Mail::to($row['email'])->send(new MailPeserta($detail));

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

            }

            $udahAda = PesertaSeminar::where('id_seminar',$this->id)->where('id_peserta',$peserta->id)->first();

            if(!isset($udahAda)) {

                $peserta_seminar                    = new PesertaSeminar;
                $peserta_seminar->id_seminar        = $this->id;
                $peserta_seminar->id_peserta        = $peserta->id;
                $peserta_seminar->is_paid           = '1';
                $peserta_seminar->status            = '1';

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

                $nama_seminar = Seminar::select('nama_seminar')->where('id', '=',$this->id)->first();


                $detail = ['nama' => $row['nama'], 'nama_seminar' => $nama_seminar->nama_seminar, 'email' => $row['email']];
                dispatch(new \App\Jobs\SendEmailTerdaftarSeminar($detail));
                // \Mail::to($row['email'])->send(new MailSeminar($detail));

            }

        }
    }

}
