<?php error_reporting(E_ALL ^ E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat {{ $data->no_srtf }}</title>
    
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
            background-image: url("/certificate-bg.jpeg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }
    
        p {
            line-height: 150%;
        }
    
        td {
            height: 15px;
        }
    
        .footer{
            position: fixed;
        }

    </style>
</head>
<body>
    <div class="">
        <div class="container">
            <div class="header">
                <table style="table-layout:fixed;" width=780 cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="14"></td>                   
                        <td colspan="10"><span style="background-color: #000; vertical-align: middle; font-weight: bold; text-align: center;color: #fff; padding:15px">{{ $data->no_srtf }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="14"></td>                   
                        <td colspan="10" style="padding-left:20px;"><img src="{{ public_path($data->qr_code)}}" height=110px></td>
                    </tr>
                    <tr>
                        <td colspan="19" style="text-align: center;padding:10px 0">
                            @foreach ($instansi as $index => $key)
                                @if($key->is_tampil == 1)
                                    @if ($index == 1)
                                        <img src="{{ public_path($key->bu_instansi->logo)  }}" alt="Logo Instansi" style="margin-right:13px; width:50px; height:50px">
                                    @elseif ($index == 6) 
                                    <br><img src="{{ public_path($key->bu_instansi->logo)  }}" alt="Logo Instansi" style="margin-right:13px; width:50px; height:50px; margin-top:10px">
                                    @else
                                        <img src="{{ public_path($key->bu_instansi->logo)  }}" alt="Logo Instansi" style="margin-right:13px; width:50px; height:50px">
                                    @endif
                                @else
                                @endif
                            @endforeach
                        </td>
                    </tr>    
                </table>
            </div>
            
            <div class="box-body">
                <table style="table-layout:fixed;" width=520 cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle; color: brown;">
                            {{-- <p style="margin-top: -27px; margin-bottom: 4px; font-size: 54px; font-weight: bold;">SERTIFIKAT</p> --}}
                            <img src="{{ public_path("srtf.jpg")  }}"  style="width:250px; height:100px">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            diberikan kepada :<br>
                            <h2 style="margin-top: 6px;margin-bottom: 6px; color:blue; text-transform: uppercase;">{{ $data->peserta_r->nama }}</h2>
                        </td> 
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            atas partisipasinya sebagai :<br>
                            <h3 style="margin-top: 6px;margin-bottom: 6px; ">@if ($data->status == 1) Peserta @elseif ($data->status == 2) Narasumber @elseif ($data->status == 3) Panitia @else Moderator @endif</h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            <span style="font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; margin-top: -2px; margin-bottom:-3px; color: crimson;">{{ $data->seminar_p->nama_seminar }} (Seminar)</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="font-size: 25px; margin-top: -2px; margin-bottom: -20px;"><strong>***</strong></p>
                            <p style="margin-bottom: -15px;">
                                <span style="font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; color: crimson;">
                                    {{-- MEMPERSIAPKAN BUSINESS CONTINUITY
                                    MANAGEMENT MENUJU ERA SOCIETY 5.0
                                    (POST COVID-19) DI INDONESIA</span><br></p> --}}
                                    {{ strip_tags(html_entity_decode($data->seminar_p->tema)) }}</span><br></p>
                                    <p tyle="margin-top: -25px;"> <strong>Nilai SKPK : {{ $data->seminar_p->skpk_nilai }} ({{terbilang($data->seminar_p->skpk_nilai)}})</strong></p>
                            {{-- </p> --}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: -8px; margin-bottom: 9px;"><strong>Penyelenggara :</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 2px; margin-bottom:9px ">
                                <span style="font-size: 24px;font-weight: bold;">
                                    {{-- ASTEKINDO * GATAKI * DK3N * WASKITA * PPK * K3 * UNAND * LPJKP KEPRI  --}}
                                    @foreach ($instansi as $index => $key) 
                                        @if(count($instansi) > $index + 1) 
                                        {{ $key->bu_instansi->singkat_bu }} *
                                        @else
                                        {{ $key->bu_instansi->singkat_bu }} 
                                        @endif
                                    @endforeach
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle; padding-bottom: 25px; ">
                            <b>{{ $data->seminar_p->lokasi_penyelenggara }}, {{ isset($data->seminar_p) ? \Carbon\Carbon::parse($data->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                        @foreach ($ttd as $key)
                        <td colspan="18" style="margin-top: 3px; text-align: center; vertical-align: top; margin-bottom: -3px;">
                            <img src="{{ public_path($key->qr_code) }}" style="width:80px; height:80px"><br>
                            <b>{{ $key->bu_ttd->nama }} </b><br>            
                            {{ $key->jabatan }} 
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        {{-- <td colspan="6"></td>
                        <td colspan="48" style="font-size: small; vertical-align: bottom;"><br>
                            <b>Catatan:</b><br>
                            SKPK sebesar 25 untuk kegiatan Pembelajaran Mandiri dapat <br>
                            diperoleh setelah Peserta menyusun <strong><i>Executive Summary</i></strong></td> --}}
                    </tr>
                </table>
                
            </div>
            <div class="footer" style="padding-left:95px;padding-top:962px;">
                <b>Catatan:</b><br>
                    SKPK sebesar 25 untuk kegiatan Pembelajaran Mandiri dapat <br>
                    diperoleh setelah Peserta menyusun <strong><i>Executive Summary</i></strong>
            </div>

        </div>
    </div>
    
</body>

</html>