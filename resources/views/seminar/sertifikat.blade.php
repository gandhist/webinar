<?php error_reporting(E_ALL ^ E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat {{ $data->no_srtf }}</title>

    <style>
        @page {
            margin: 0;
        }

        @font-face {
            font-family: 'certificate';
            src: url({{ storage_path('fonts/Certificate-Regular.ttf') }}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'certificate2';
            src: url({{ storage_path('fonts/Adine-Kirnberg-Xdyj.ttf') }}) format("truetype");
            font-weight: 400;
            font-style: normal;
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, 'certificate2';
            font-size: 16px;
            -webkit-print-color-adjust: exact !important;
            background-image: url("/bg_srtf.jpg");
            /* background-image: url("/certificate-bg.jpeg"); */
            background-repeat: no-repeat;
            background-position: center;
        }

        p {
            font-family: 'certificate2';
            margin-top: -105px;
            margin-bottom: -5px;
            font-size: 80px;
            /* font-weight: bold; */
            /* line-height: 150%; */
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
        <div class="">
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
                                        <img src="{{ public_path($key->bu_instansi->logo)  }}" alt="Logo Instansi" style="margin-right:13px; width:auto; height:50px">
                                    @elseif ($index == 5)
                                    <br><img src="{{ public_path($key->bu_instansi->logo)  }}" alt="Logo Instansi" style="margin-right:13px; width:auto; height:50px; margin-top:10px">
                                    @else
                                        <img src="{{ public_path($key->bu_instansi->logo)  }}" alt="Logo Instansi" style="margin-right:13px; width:auto; height:50px">
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
                            <p id="judul">Sertifikat</p>
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
                            <span style="font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; margin-top: -2px; margin-bottom:-3px; color: crimson;">
                                {{ $data->seminar_p->nama_seminar }} (Seminar)</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="font-size: 25px; margin-top: 0px; margin-bottom: 100px;"><strong>***</strong></p>
                            <p style="margin-bottom: -15px; font-size: 25px; font-family: Verdana, Geneva, Tahoma, sans-serif; font-weight: bold; color: crimson;">
                                    {{ strip_tags(html_entity_decode($data->seminar_p->tema)) }}</p>
                            <p style="font-size: 15px;margin-top: 20px;margin-bottom: 3px;"><strong>Nilai SKPK : {{ $data->seminar_p->skpk_nilai }} ({{terbilang($data->seminar_p->skpk_nilai)}})</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="font-size: 15px;margin-top: 5px; margin-bottom: 5px;"><strong>Penyelenggara :</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: 0px; margin-bottom:9px ">
                                <span style="font-size: 24px;font-weight: bold;">
                                    @foreach ($instansi as $index => $key)
                                        @if(count($instansi) > $index + 1)
                                        {{ html_entity_decode(str_replace(" ","&nbsp;",$key->bu_instansi->singkat_bu)) }} *
                                        @else
                                        {{ html_entity_decode(str_replace(" ","&nbsp;",$key->bu_instansi->singkat_bu)) }}
                                        @endif
                                    @endforeach
                                </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td colspan="48" style="text-align: center; vertical-align: middle; padding-bottom: 15px; ">
                            <b style="font-family: DejaVu Sans;" >{{ html_entity_decode(mb_convert_encoding($data->seminar_p->lokasi_penyelenggara, 'HTML-ENTITIES', 'UTF-8') )}}, {{ isset($data->seminar_p) ? \Carbon\Carbon::parse($data->seminar_p->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }} </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                        @foreach ($ttd as $key)
                        <td colspan="18" style="margin-top: 3px; text-align: center; vertical-align: top; margin-bottom: -3px;">
                            <img src="{{ public_path($key->qr_code) }}" style="width:80px; height:80px"><br>
                            <b>{{ html_entity_decode(str_replace(" ","&nbsp;",$key->bu_ttd->nama)) }} </b><br>
                            {{ $key->jabatan }}
                        </td>
                        @endforeach
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
