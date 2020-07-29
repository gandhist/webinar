<?php error_reporting(E_ALL ^ E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    
    <style>
        @page {
            margin: 0;
        }

        .header{
            padding-top: 5px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .paper {
            width: 700px;
            height: 700px;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0px 0px 5px 0px #888;
            padding: 5px;    
        }
    
        table {
            table-layout: fixed;
        }
    
        td {
            vertical-align: top;
            overflow: hidden;
        }
    
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 16px;
            -webkit-print-color-adjust: exact !important;
            background-image: url("cerificate-bg.jpeg");
            background-repeat: no-repeat;
            background-position: center;
        }
    
        p {
            line-height: 150%;
        }
    
        td {
            height: 15px;
        }
     
        .p3sm-image {
            background-image: url("p3sm1.png");
            /* background-image: url("{{asset('p3sm1.png')}}"); */
            background-position: center;
            background-repeat: no-repeat;
            background-size:250px;
            position: relative;
        }
        .mb-image {
            background-image: url("mercubuana_fade.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size:250px;
            position: relative;
        }

    </style>
</head>
<body>
    @foreach($data as $key)
    <div class="">

        <div class="">

            <div class="header">
                <table style="table-layout:fixed;" width=780 cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="14"></td>                   
                        <td colspan="10"><span style="background-color: #000; vertical-align: middle; font-weight: bold; text-align: center;color: #fff; padding:15px">{{ $key->no_srtf }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="14"></td>                   
                        <td colspan="10" style="padding-left:20px;"><img src="qr.png" height=110px></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_1->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_1->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_1->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_1->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_1->logo  }}" alt="gambar"></td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_2->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_2->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_2->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_2->logo  }}" alt="gambar"></td>
                        <td colspan="2"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_2->logo  }}" alt="gambar"></td>
                    </tr>
                    
                </table>
            </div>
            
            <div class="box-body">
                <table style="table-layout:fixed;" width=520 cellspacing=0 cellpadding=0>
                    
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle; color: brown;">
                            <p style="margin-top: -5px; margin-bottom: 4px; font-size: 54px; font-weight: bold;">SERTIFIKAT</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            diberikan kepada:<br>
                            <h2 style="margin-top: 6px;margin-bottom: 6px; color:blue; text-transform: uppercase;">{{ $key->peserta_r->nama }}</h2>
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            atas partisipasinya sebagai:<br>
                            <h3 style="margin-top: 6px;margin-bottom: 6px; ">@if ($key->status == 1) Peserta @elseif ($key->status == 2) Narasumber @elseif ($key->status == 3) Panitia @else Moderator @endif</h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            <span style="font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; margin-top: -2px; margin-bottom:-3px; color: crimson;">{{ $key->seminar_p->nama_seminar }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 2px; margin-bottom: -5px;"><strong>dengan tema:</strong></p>
                            <p style="margin-bottom: -2px;">
                                <span style="font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; color: crimson;">{{ strip_tags(html_entity_decode($key->seminar_p->tema)) }}</span><br>
                                <strong>dengan Nilai SKPK : {{ $key->seminar_p->skpk_nilai }} ({{terbilang($key->seminar_p->skpk_nilai)}})</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 3px; margin-bottom: 4px;"><strong>Diselenggarakan bersama oleh:</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 2px; margin-bottom:4px ">
                                <span style="font-size: 24px;font-weight: bold;">
                                    {{-- {{ $key->seminar_p->instansi_1->nama_bu }}  - {{ in_array($key->seminar_p->instansi_2, array($key->seminar_p->instansi_2->nama_bu) ) }} --}}
                                PROGRAM STUDI MAGISTER TEKNIK SIPIL UNIVERSITAS MERCU BUANA - DPP ASTEKINDO - DPP GATAKI - DPP ASPEKNAS - DPN PPK-K3  DPP GATAKI - DPP ASPEKNAS - DPN PPK-K3  DPP GATAKI - DPP ASPEKNAS - DPN PPK-K3
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle; margin-bottom: 6px; ">
                            <b>{{ $key->seminar_p->lokasi_penyelenggara }}, {{ isset($key->seminar_p) ? \Carbon\Carbon::parse($key->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                        <td colspan="16" style="margin-top: 3px; text-align: center; vertical-align: top; margin-bottom: -3px;">
                            <img src= "QR_adji_n.png" height=60px><br>
                            <b>Elfin Adji Nasution</b><br>
                            Pembina Asosiasi 
                        </td>
                        <td colspan="8" style=" margin-top: -3px; text-align: center; vertical-align: top;">                           
                        </td>
                        <td colspan="16" style="margin-top: -3px;text-align: center; vertical-align:top; margin-bottom: -3px;">
                            <img src= "QR_budi_susetyo.png" height=60px><br>
                            <b>Dr. Ir. Budi Susetyo, M.T.</b><br>
                            Ketua Program Studi Magister Teknik Sipil Universitas Mercu Buana
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="font-size: small; vertical-align: bottom;"><br>
                            <b>Catatan:</b><br>
                            SKPK sebesar 25 untuk kegiatan Pembelajaran Mandiri dapat <br>
                            diperoleh setelah Peserta menyusun <strong><i>Executive Summary</i></strong></td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
    @endforeach
</body>
</html>