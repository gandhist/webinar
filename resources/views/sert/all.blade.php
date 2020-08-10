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
            /* background-image: url("{{asset('p3sm1.png')}}"); */
            background-image: url("p3sm1.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size:250px;
            position: relative;
        }

    </style>
</head>
<body>
    {{-- @foreach($data as $key) --}}

    <div align=center>

        <div class="">

            <div class="header">
                <table style="table-layout: fixed;" width=780 border=0 cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="42"></td>
                        <td colspan="6" style="background-color: #000; vertical-align: middle; font-weight: bold; text-align: center;color: #fff;">{{ $data->no_srtf }}</td>
                    </tr>
                    
                </table>
            </div>
            <div class="p3sm-image">
            
                <table style="table-layout: fixed;" width=780 border=0 cellspacing=0 cellpadding=0>
                    <tr>
                        <td colspan="6" style="text-align: center;vertical-align: middle;">
                            <img src="ppk_k3.jpeg" height="60px">
                        </td>
                        <td colspan="36" style="text-align: center; vertical-align: middle; color: brown;">
                            <p style="margin-top: 20px; margin-bottom: 10px; font-size: 36px; font-weight: bold;">SERTIFIKAT</p>
                        </td>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            <img src="aspeknas.jpeg" height="60px">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            <img src="astekindo.jpeg" width="60px">
                        </td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            diberikan kepada:<br>
                            <h2 style="margin-top: 0px; color:blue; text-transform: uppercase;">{{ $data->peserta_r->nama }}</h2>
                        </td>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            <img src="hjki.jpeg" height="60px">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            <img src="gataki.jpeg" height="60px">
                        </td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            atas partisipasinya sebagai:<br>
                            @switch($data->status)
                                @case(1)
                                    <h2 style="margin-top: -2px; ">PESERTA</h2>
                                    @break
                                @case(2)
                                    <h2 style="margin-top: -2px; ">NARASUMBER</h2>
                                    @break
                                    @case(3)
                                    <h2 style="margin-top: -2px; ">PANITIA</h2>
                                    @break
                                    @case(4)
                                    <h2 style="margin-top: -2px; ">MODERATOR</h2>
                                    @break
                                @default
                                    
                            @endswitch
                        </td>
                        <td colspan="6" style="text-align: center; vertical-align: middle;">
                            <img src="perkonindo - Copy.jpeg" height="60px">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: center;"><img src="petakindo.jpeg" height="60px"></td>
                        <td colspan="36" style="text-align: center; vertical-align: middle;">
                            <h1 style="margin-top: -2px; margin-bottom:-3px; color: crimson;">PERTEMUAN PROFESI (SEMINAR)</h1>
                        </td>
                        <td colspan="6" style="text-align: center;"><img src="pakti.jpeg" height="60px"></td>
                    </tr>
                    <tr>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            <p style="margin-top: -2px; margin-bottom: -10px;"><strong>dengan tema:</strong></p>
                            <p style="margin-bottom: -3px;">
                                <div style="margin-top:-8px; font-size: 20px; font-family: Verdana, Geneva, Tahoma, sans-serif; color: crimson;">KNOWLEDGE SHARING & DISCUSSION:</div>
                                <div style="margin-top:-8px; font-size: 32px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-weight: bold; color: crimson;">SISTEM DAN STANDAR PENJAMIN KINERJA</div>
                                <div style="margin-top:-8px; font-size: 32px; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-weight: bold; color: crimson;">PROYEK KONSTRUKSI DI INDONESIA</div>
                            </p>
                            <strong>dengan Nilai SKPK : 5 (lima)</strong>
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
                                DPP PPK-K3, DPP ASTEKINDO, DPP GATAKI, DP PETAKINDO<br>
                                DPP ASPEKNAS, DPN HJKI, DPN PERKONINDO, DP PAKTI
                            </span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="48" style="text-align: center; vertical-align: middle;">
                            
                                <b>Jakarta, 13 Juni 2020</b>
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="16" style="margin-top: -3px; text-align: center; vertical-align: top; margin-bottom: -3px;">
                            <img src= "QR_adji.png" height=60px><br>
                            <b>Elfin Adji Nasution</b><br>
                            Ketua Pengarah 
                        </td>
                        <td colspan="16" style=" margin-top: -3px; text-align: center; vertical-align: top;">
                            {{-- <img src= "qr.png" width=60px><br>
                            scan<br>
                            QR code --}}
                        </td>
                        <td colspan="16" style="margin-top: -3px;text-align: center; vertical-align:top; margin-bottom: -3px;">
                            <img src= "QR_iman.png" height=60px><br>
                            <b>Iman Purwoto, ST, MT, IPM</b><br>
                            Ketua Panitia
                        </td>
                    </tr>
                    <tr>
                        <td colspan="48" style="font-size: small; vertical-align: bottom;"><br>Catatan: SKPK sebesar 25 untuk kegiatan Pembelajaran Mandiri dapat diperoleh setelah Peserta menyusun <strong><i>Executive Summary</i></strong></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
        
    {{-- @endforeach --}}
    
    
</body>
</html>