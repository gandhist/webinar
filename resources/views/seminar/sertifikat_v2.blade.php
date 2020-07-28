<?php error_reporting(E_ALL ^ E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>
    
    <style>

        .header{
            padding-top: 5px;
            margin-top: 1px;
            margin-bottom: 10px;
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
        }
    
        input[type="text"] {
            border: none;
        }
    
        @media print {
            
            .noprint {
                display: none;
            }
    
            .nobg {
                box-shadow: 0px 0px 5px 0px rgb(255, 255, 255);
            }
    
            .addheader {
                padding-top: 5px;
            }
    
            .pagebreak {
                page-break-before: always;
            }
    
            ::-webkit-input-placeholder {
                /* WebKit browsers */
                color: transparent;
            }
    
            :-moz-placeholder {
                /* Mozilla Firefox 4 to 18 */
                color: transparent;
            }
    
            ::-moz-placeholder {
                /* Mozilla Firefox 19+ */
                color: transparent;
            }
    
            :-ms-input-placeholder {
                /* Internet Explorer 10+ */
                color: transparent;
            }
        }
    
        p {
            line-height: 150%;
        }
    
        td {
            height: 15px;
        }
    
        input {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    
        }
    
        textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            resize: none;
            border: none;
        }
        .p3sm-image {
            background-image: url("p3sm1.png");
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
    <div align=center>

        <div class="">

            <div class="header">
                <table style="table-layout: fixed;" width=780  cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="5"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_1->logo  }}" alt="gambar" ></td>
                        <td colspan="5"><img height="50" width="50" src="{{ public_path('uploads/'). $key->seminar_p->instansi_2->logo  }}" alt="gambar" ></td>
                        <td colspan="5"></td>
                        <td colspan="5"></td>
                        <td colspan="5"></td>
                        <td colspan="5"></td>
                        <td colspan="5"></td>
                        <td colspan="5"></td>
                        <td colspan="10"><span style="background-color: #000; vertical-align: middle; font-weight: bold; text-align: center;color: #fff; padding:20px">{{ $key->no_srtf }}</span></td>
                    </tr>
                    
                </table>
            </div>
            @if($key->seminar_p->inisiator == 1)
                <div class="p3sm-image">
            @else 
                <div class="mb-image">
            @endif
                <table style="table-layout: fixed;" width=780  cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="6" style="text-align: center;vertical-align: middle;">
                            {{-- <a href="https://astekindo.or.id" target="_blank"><img src="astekindo.jpeg" height="60px"></a> --}}
                        </td>
                        <td colspan="36" style="text-align: center; vertical-align: middle; color: brown;">
                            <p style="margin-top: 20px; margin-bottom: 10px; font-size: 36px; font-weight: bold;">SERTIFIKAT</p>
                        </td>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            {{-- <a href="https://www.mercubuana.ac.id" target="_blank"><img src="mercubu.png" height="75px"></a> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            {{-- <a href="https://gataki.or.id" target="_blank"><img src="gataki.jpeg" width="60px"></a> --}}
                        </td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            diberikan kepada:<br>
                            <h2 style="margin-top: 0px; color:blue; text-transform: uppercase;">{{ $key->peserta_r->nama }}</h2>
                        </td>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            {{-- <a href="#" target="_blank"><img src="ppk_k3.jpeg" height="60px"></a> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            {{-- <a href="https://aspeknas.or.id" target="_blank"><img src="aspeknas.jpeg" height="60px"></a> --}}
                        </td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            atas partisipasinya sebagai:<br>
                            <h2 style="margin-top: -2px; ">@if ($key->status == 1) Peserta @elseif ($key->status == 2) Narasumber @elseif ($key->status == 3) Panitia @else Moderator @endif</h2>
                        </td>
                        <td colspan="6" style="text-align: center; vertical-align: middle;"></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center;"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            <h1 style="margin-top: -2px; margin-bottom:-3px; color: crimson;">{{ $key->seminar_p->nama_seminar }}</h1>
                        </td>
                        <td colspan="6" style="text-align: center;"></td>
                    </tr>
                    <tr>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: -2px; margin-bottom: -10px;"><strong>dengan tema:</strong></p>
                            <p style="margin-bottom: -3px;">
                                <span style="font-size: 20px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; color: crimson;">{{ strip_tags(html_entity_decode($key->seminar_p->tema)) }}</span><br>
                                <strong>dengan Nilai SKPK : {{ $key->seminar_p->skpk_nilai }} ({{terbilang($key->seminar_p->skpk_nilai)}})</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 2px; margin-bottom: 0px;"><strong>Diselenggarakan bersama oleh:</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 2px; margin-bottom:2px ">
                                <span style="font-size: 24px;font-weight: bold;">
                                    {{ $key->seminar_p->instansi_1->nama_bu }}  - {{ $key->seminar_p->instansi_2->nama_bu }}
                                {{-- PROGRAM STUDI MAGISTER TEKNIK SIPIL UNIVERSITAS MERCU BUANA - DPP ASTEKINDO - DPP GATAKI - DPP ASPEKNAS - DPN PPK-K3 --}}
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            
                                <b>{{ $key->seminar_p->lokasi_penyelenggara }}, {{ isset($key->seminar_p) ? \Carbon\Carbon::parse($key->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }}</b>
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="16" style="margin-top: -3px; text-align: center; vertical-align: top; margin-bottom: -3px;">
                            {{-- <img src= "QR_adji_n.png" height=60px><br> --}}
                            <b>Elfin Adji Nasution</b><br>
                            Pembina Asosiasi 
                        </td>
                        <td colspan="16" style=" margin-top: -3px; text-align: center; vertical-align: top;">
                            
                        </td>
                        <td colspan="16" style="margin-top: -3px;text-align: center; vertical-align:top; margin-bottom: -3px;">
                            {{-- <img src= "QR_budi_susetyo.png" height=60px><br> --}}
                            <b>Dr. Ir. Budi Susetyo, M.T.</b><br>
                            Ketua Program Studi Magister Teknik Sipil Universitas Mercu Buana
                        </td>
                    </tr>
                      
                    <tr>
                        <td colspan="48" style="font-size: small; vertical-align: bottom;"><br>Catatan: SKPK sebesar 25 untuk kegiatan Pembelajaran Mandiri dapat diperoleh setelah Peserta menyusun <strong><i>Executive Summary</i></strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>