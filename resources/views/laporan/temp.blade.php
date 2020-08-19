<?php error_reporting(E_ALL ^ E_DEPRECATED); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Audit</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/script.js"></script>

    <style>
      
      /* .auto_height {
        width: 100%;
        } */

      textarea {
          outline:0;
          border: none;

          background-color: transparent;
          resize: none;
          overflow: hidden;
      }

      #watermark {
        position: fixed;
        top: 30%;
        left: 20%;
        width: 100%;
        text-align: center;
        opacity: .4;
        font-size: 60px;
        transform: rotate(25deg);
        transform-origin: 5% 5%;
        z-index: -1000;
      }
      
      body {
        margin: 0;
        padding: 0;
        background-color:white;
        /* font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ; */
        font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ;
        font-size: 14px;
      }

      select{
        font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif ;
        font-size: 20px;
        font-weight: bold;
        border: none;
        /* for Firefox */
        -moz-appearance: none;
        /* for Chrome */
        -webkit-appearance: none;
      }

      * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
      }



      .page {
          position: relative;
          overflow: hidden;
          width: 21cm;
          min-height: 29.7cm;
          padding: 0cm;
          margin: 0cm auto;
          border: 0px #D3D3D3 solid;
          border-radius: 0px;
          margin-top:20px;
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
          background-image: url("/iso/images/wm_iso_biru_2.png");
          /* background-image: url("/iso/images/logo_iso.png"); */
          background-size: contain;
          background-repeat: no-repeat;
      }

      .bg {
        display:block;
        background-image: url("/iso/images/wm_iso_biru_2.png");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        margin-left: auto;
        margin-right: auto;
    }
    
      .footer {
        position: absolute;
        right: 60px;
        bottom: 20px;
        width: 100%;
        text-align: right;
    }

      td{
          line-height: 150%;
      }

      table{
          table-layout: fixed;
          width: 690px;
      }
      .pagebreak{
              page-break-before: always;
          }
      
      @page {
          size: A4;
          margin-top: 50px;
      }



      [contenteditable=true]:empty:before {
      content: attr(placeholder);
      color:gray;
      }
      /* found this online --- it prevents the user from being able to make a (visible) newline */
      [contenteditable=true] br{
      display:none;
    }



  </style>

</head>
<body class="bg">
    
    <div class="">

        <div align=center >
            <div id="watermark">
                @if($data->status == 1)
                  <h1>{{ $data->status_r->nama }}</h1>
                @endif
              </div>
            <table>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
    
            </table> 
            <div style="  text-align: justify;">
                <p style="text-align: center; font-size: 20px; font-weight:bolder; text-decoration: underline;">LAPORAN AUDIT</p>
                <p style="font-weight: bold; font-size: 20px; text-align:'left'">
                    <label for="sistem_iso">{{ $data->iso_r->nama_id }}</label>
                </p>
                <p style="margin-top:-10px; margin-bottom: 10px; font-weight: bold; font-size: 30px;">Audit Report</p>
            </div>        
            <table border=1 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="6" style="padding:10px; background-color:#206f9c; color: white; font-weight: bold;">Organization</td>
                    <td colspan="14" style="padding:10px; background-color: #206f9c; color: white; font-weight: bold; ">
                    {{ $data->bu_r->nama_bu }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Address</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->bu_r->alamat }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Standard</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->iso_r->kode }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">ID Number</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->id_number }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Audit Date</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ \Carbon\Carbon::parse($data->audit_date)->isoFormat('DD MMMM YYYY') }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Visit Number</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->visit_number }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Visit Type</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->visit_type }}</td>
                </tr>
        
            </table>
            <table>
                <tr>
                    <td>
                        <p></p>
                    </td>
                </tr>
                
            </table>

            <table border=1 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Company Representative</td>
                    <td colspan="14" style="vertical-align: top; padding:10px; font-weight: bold;">{{ $data->bu_r->bu_p_r->nama_pimp }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Site Audited</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->site_audited }}</td>
                </tr>
                <tr>
                    <td colspan="20" style="vertical-align: top; padding:10px; text-align: center;"><i>* Untuk multi-situs audit, semua situs diaudit akan tercantum dalam lingkup audit<br> atau dalam lampiran</i></td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Lead Auditor</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->lead_auditor }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="vertical-align: top; padding:10px;">Additional Team Member</td>
                    <td colspan="14" style="vertical-align: top; padding:10px;">{{ $data->additional_member }}</td>
                </tr>
                <tr>
                    <td colspan="20" style="vertical-align: top; padding:10px; text-align: center;"><i>Laporan ini bersifat rahasia dan didistribusikan terbatas kepada tim audit, perwakilan klien dan kantor Mandiri Certification</i></td>
                </tr>
            </table> 

        </div>
        <div class="footer">
            <table>
                <td colspan="24" >Page 1 of 5</td>
            </table>
        </div>

    </div>
    
    

    <div class="pagebreak"></div>

    <div class="">
        <div align=center >
            <table>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
    
            </table> 
            <p style="text-align: center; font-size: 20px; font-weight:bolder; text-decoration: underline;">LAPORAN AUDIT</p>   
            <table border=0 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="1"><b>1.</b></td>
                    <td colspan="23"><b>Tujuan Audit</b></td>
                </tr>
                <tr>
                    <td colspan="24">Tujuan dari audit ini:</td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify;">
                        <ul>
                            <li>Memberikan informasi sekaligus mengkonfirmasi Perusahaan bahwa sistem manajemen yang diterapkan telah sesuai standard.</li>
                            <li>Mengkonfirmasi Perusahaan bahwa sistem manajemen yang direncanakan berjalan secara efektif dan efisien dalam pengelolaannya. </li>
                            <li>Mengkonfirmasi sistem manjemen yang dijalankan mampu mencapai tujuan kebijakan Perusahaan. </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><b>2.</b></td>
                    <td colspan="23"><b>Ruang Lingkup Sertifikasi</b></td>
                </tr>
                <tr>
                    <td colspan="24">Audit mencakup :
                        <p style="font-weight: bold; text-align: justify;">
                            "Provision of
                           @foreach($data->scope_r as $key)
                           @if($loop->last) And @endif{{ $key->scope_r->nama_en }}@if(!$loop->last), @endif
                           @endforeach
                            "</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify; font-weight: bold; ">
                        
                            <span id="scope" contenteditable="true" placeholder=". . . . . . . . . . . . . . . . . . . . . ."></span>

                    </td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify; "><span><small>Ini adalah audit multi-situs dan lampiran daftar semua situs yang relevan dan / atau lokasi terpencil telah ditetapkan (terlampir) dan setuju dengan klien</small></span> 
                        {{-- &nbsp &nbsp --}}
                        <input {{ $data->scope_multi_situs == "ya" ? "checked" : "" }}  type="checkbox" class="Radio" name="cb1[1][]">Yes 
                        {{-- &nbsp &nbsp  --}}
                        <input {{ $data->scope_multi_situs == "tidak" ? "checked" : "" }} type="checkbox" class="Radio" name="cb1[1][]">No</td>
                </tr>
                <tr>
                    <td>
                        <p></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><b>3.</b></td>
                    <td colspan="23"><b>Temuan Audit Saat Ini Dan Solusi</b></td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify;">Tim audit melakukan audit proses  berfokus pada aspek penting / resiko / tujuan diperlukan oleh standar. Metode audit yang dilakukan adalah wawancara, observasi kegiatan dan review dokumentasi.</td>
                </tr>
                
                <tr>
                    <td colspan="24" style="text-align: justify;">Struktur audit sudah sesuai dengan rencana audit dan matriks perencanaan audit yang disertakan sebagai lampiran laporan ringkasan.</td>
                </tr>

                <tr>
                    <td colspan="24" style="text-align: justify;">Tim audit menyimpulkan bahwa organisasi 
                        <input {{ $data->tas_1 == 'telah' ? 'checked' : '' }} type="checkbox" class="Radio">telah 
                        <input {{ $data->tas_1 == 'belum' ? 'checked' : '' }} type="checkbox" class="Radio">belum 
                        ditetapkan dan dipelihara sistem manajemen sesuai dengan persyaratan standar dan menunjukkan kemampuan sistem untuk secara sistematis mencapai persyaratan yang disepakati untuk produk atau jasa dalam lingkup dan kebijakan organisasi dan tujuan.</td>
                </tr>
    
                <tr>
                    <td colspan="24" style="text-align: justify;">
                        Jumlah ketidak sesuaian diidentifikasi: <b>{{ strtoupper($data->tas_2) }}</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify;">
                        Oleh karena itu tim audit merekomendasikan bahwa, berdasarkan hasil dari audit dan keadaan sistem menunjukkan perkembangan dan kematangan, sertifikasi sistem manajemen menjadi:
                    </td>
                </tr>
                <tr>
                    <td colspan="24"><input {{ $data->tas_3 == 'diberikan' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb3[1][]"> Diberikan</td>
                </tr>
                <tr>
                    <td colspan="24"><input {{ $data->tas_3 == 'lanjut' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb3[1][]"> Lanjut</td>
                </tr>
                <tr>
                    <td colspan="24"><input {{ $data->tas_3 == 'rahasia' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb3[1][]"> Dirahasiakan</td>
                </tr>
                <tr>
                    <td colspan="24"><input {{ $data->tas_3 == 'tangguh' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb3[1][]"> Ditangguhkan sampai tindakan korektif yang memuaskan</td>
                </tr>
        
            </table>
        </div>
        <div class="footer">
            <table>
                <td colspan="24" >Page 2 of 5</td>
            </table>
        </div>


    </div>

    <div class="pagebreak"></div>
    
    <div class="">
        
        <div align=center >
            <table>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
    
            </table> 
            <p style="text-align: center; font-size: 20px; font-weight:bolder; text-decoration: underline;">LAPORAN AUDIT</p>   
            <table border=0 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="1"><b>4.</b></td>
                    <td colspan="23"><b>Hasil Audit Sebelumnya (N/A)</b></td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify;">Hasil audit terakhir dari sistem ini telah ditinjau, khususnya untuk memastikan koreksi yang sesuai.</td>
                </tr>
                <tr>
                    <td colspan="1" style="vertical-align: top;"><input {{ $data->audit_sebelumnya == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb4[1][]"></td>
                    <td colspan="23" style="vertical-align: top; text-align: justify;">Setiap ketidaksesuaian yang diidentifikasi selama audit sebelumnya telah diperbaiki dan tindakan perbaikan terus menjadi efektif.</td>
                </tr>
                <tr>
                    <td colspan="1" style="vertical-align: top;"><input {{ $data->audit_sebelumnya == '2' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb4[1][]"></td>
                    <td colspan="23" style="vertical-align: top; text-align: justify;">Sistem manajemen belum ditangani ketidaksesuaian yang diidentifikasi selama kegiatan audit sebelumnya dan isu tertentu telah kembali didefinisikan dalam bagian ketidaksesuaian laporan ini.</td>
                </tr>
                <tr>
                    <td colspan="1" style="vertical-align: top;"><input {{ $data->audit_sebelumnya == '3' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb4[1][]"></td>
                    <td colspan="23" style="vertical-align: top; text-align: justify;">Tidak ada Corrective Action Request (CAR) dari kunjungan sebelumnya untuk ditindaklanjuti.</td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td colspan="1"><b>5.</b></td>
                    <td colspan="23"><b>Temuan Audit</b></td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify;">
                        Tim audit melakukan proses audit berfokus pada aspek yang signifikan / resiko / tujuan. Metode audit yang digunakan adalah wawancara, observasi kegiatan dan review dokumentasi.
                    </td>
                </tr>
                <tr>
                    <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Dokumentasi sistem manajemen memperlihatkan kesesuaian dengan persyaratan standar audit dan memberikan struktur yang memadai untuk mendukung implementasi dan pemeliharaan sistem manajemen.</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_1 == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb5[1][]">Yes</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_1 == '0' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb5[1][]">No</td>
                </tr>
                <tr>
                    <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Organisasi telah menunjukkan implementasi yang efektif dan pemeliharaan / perbaikan sistem manajemen.</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_2 == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb6[1][]">Yes</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_2 == '0' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb6[1][]">No</td>
                </tr>
                <tr>
                    <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Organisasi telah menunjukkan dan menjalankan sistem  yang mampu telusur, tepat sasaran dengan tujuan untuk kemajuan yang dipantau dan terdokumentasi terhadap prestasi mereka.</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_3 == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb7[1][]">Yes</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_3 == '0' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb7[1][]">No</td>
                </tr>
                <tr>
                    <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Program audit internal telah sepenuhnya dilaksanakan dan menunjukkan efektifitas sebagai alat untuk mempertahankan dan meningkatkan sistem manajemen.</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_4 == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb8[1][]">Yes</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_4 == '0' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb8[1][]">No</td>
                </tr>
                <tr>
                    <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Proses tinjauan manajemen memperlihatkan kemampuan untuk memastikan kesesuaian, kecukupan dan efektifitas sistem manajemen.</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_1 == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb9[1][]">Yes</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_1 == '0' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb9[1][]">No</td>
                </tr>
                <tr>
                    <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Selama proses audit, sistem manajemen keseluruhan memperlihatkan kesesuaian dengan persyaratan standar audit.</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_1 == '1' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb10[1][]">Yes</td>
                    <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input {{ $data->ta_1 == '0' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb10[1][]">No</td>
                </tr>

               
            </table>
        </div>
        <div class="footer">
            <table>
                <td colspan="24" >Page 3 of 5</td>
            </table>
        </div>

    </div>

    <div class="pagebreak"></div>

    <div class="">

        <div align=center >
            <table>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
    
            </table> 
            <p style="text-align: center; font-size: 20px; font-weight:bolder; text-decoration: underline;">LAPORAN AUDIT</p>   
            <table border=0 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="1"><b>6.</b></td>
                    <td colspan="23"><b>Significant Audit Trails Followed</b></td>
                </tr>
                <tr>
                    <td colspan="24" style="text-align: justify;">Proses spesifik, kegiatan dan fungsi yang rinci dalam Matrix Perencanaan Audit dan Audit Plan. Dalam melakukan audit dan keterkaitan berbagai audit yang dikembangkan. Jalur audit diikuti, termasuk bukti obyektif dan pengamatan terhadap keseluruhan proses dan kontrol yang dicatat dalam "Catatan Audit" yang merupakan bagian dari paket sertifikasi permanen tetapi tidak disampaikan kepada klien.<br>
                    Peluang untuk perbaikan serta pengamatan positif atau negatif khusus yang dijelaskan dibawah bagian 8 sementara ketidaksesuaian dicatat dalam lampiran "Permintaan Tindakan Korektif (CAR)"</td>
                </tr>
                <tr>
                    <td>
                        <p></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="1"><b>7.</b></td>
                    <td colspan="23"><b>Ketidaksesuaian</b></td>
                </tr>
                <tr>
                    <td colspan="24" style=" text-align: justify;">Ketidaksesuaian rinci dalam lampiran "Permintaan Tindakan Korektif (CAR)" harus ditangani melalui proses tindakan korektif organisasi, sesuai dengan persyaratan yang relevan tindakan korektif dan pencegahan dari standar audit dan catatan lengkap dipelihara.</td>
                </tr>

                <tr>
                    <td colspan="2" style=" border:1px solid black; padding:2px; vertical-align: top; text-align: center; line-height: normal;"><input {{ $data->tikor == 'major' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb11[1][]"></td>
                    <td colspan="22" style=" border:1px solid black; padding: 2px; text-align: justify; vertical-align: top;line-height: normal;">
                    Tindakan korektif untuk mengatasi ketidaksesuaian <b>MAJOR</b> diidentifikasi harus segera dilakukan dan <b>MANDIRI CERTIFICATION diberitahu tentang tindakan yang diambil dalam waktu 30 hari.</b> Auditor MANDIRI CERTIFICATION akan melakukan <b>tindak lanjut kunjungan</b> dalam waktu 90 hari untuk mengkonfirmasi tindakan yang diambil, evaluasi terhadap keefektifan mereka, dan menentukan apakah sertifikasi dapat diberikan atau dilanjutkan.</td>
                </tr>
                <tr>
                    <td colspan="2" style=" border:1px solid black; padding:2px; vertical-align: top; text-align: center; line-height: normal;"><input {{ $data->tikor == 'minor' ? 'checked' : '' }} type="checkbox" class="Radio" name="cb11[1][]"></td>
                    <td colspan="22" style=" border:1px solid black; padding: 2px; text-align: justify; vertical-align: top; line-height: normal;">
                    Tindakan korektif untuk mengatasi ketidaksesuaian <b>MINOR</b> harus segera dilakukan dan diidentifikasi dan <b>catatan dengan bukti pendukung yang dikirim ke auditor MANDIRI CERTIFICATION untuk close-out dalam waktu 90 hari.</b> Pada kunjungan Audit jadwal berikutnya, tim audit MANDIRI CERTIFICATION akan menindaklanjuti semua ketidaksesuaian diidentifikasi untuk mengkonfirmasi efektifitas tindakan perbaikan dan pencegahan yang diambil.</td>
                </tr>
            </table>
            <table border=0 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="1"><b>8.</b></td>
                    <td colspan="23"><b>Observasi Dan Peluang Peningkatan</b></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 2px solid salmon; text-align: justify; line-height: normal;">
                        <ol type="1">
                            @foreach($data->obs_r as $key)
                                                <li><span id="obs_1" contenteditable="true" placeholder=". . . . . . . . . ">{{ $key->nilai }}</span></li>
                            @endforeach

                        </ol>
                    </td>
                </tr>

               
            </table>
        </div>
        <div class="footer">
            <table>
                <td colspan="24" >Page 4 of 5</td>
            </table>
        </div>


    </div>

    <div class="pagebreak"></div>

    <div class="">

        <div align=center >
            <table>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
                <tr>
                    <td><p></p></td>
                </tr>
    
            </table> 
            <p style="text-align: center; font-size: 20px; font-weight:bolder; text-decoration: underline;">LAPORAN AUDIT</p>   
            <table border=1 cellspacing=0 cellpadding=0 style="border-collapse:collapse;border:1;">
                <tr>
                    <td colspan="24"><b>Corrective Action Request</b></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: justify;"><input {{ $data->car == '1' ? 'checked' : '' }}  type="checkbox" class="Radio" name="car[1][]"> <b>Major</b></td>
                    <td colspan="3" style="text-align: justify;"><input {{ $data->car == '0' ? 'checked' : '' }}  type="checkbox" class="Radio" name="car[1][]"> <b>Minor</b></td>
                    <td colspan="18"></td>

                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black;"><b>Organisasi : <span id="nama_perusahaan" contenteditable="true" placeholder="Nama Perusahaan" style="text-transform: uppercase;">{{ $data->bu_r->nama_bu }}</span></b></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px;  text-align: justify; border: 1px solid black;"><b>Lokasi Audit :<br>
                        <span id="alamat" contenteditable="true" placeholder="Alamat">{{ $data->bu_r->alamat }}</span></b></td>
                </tr>
                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Auditor(s) : <span id="auditors" contenteditable="true" placeholder=". . . . . . . .">{{ $data->lead_auditor }} & {{ $data->additional_member }} </span></td>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Date(s) of audit(s) : <span id="aud_date" contenteditable="true" placeholder="DD-MM-YYYY">{{ \Carbon\Carbon::parse($data->audit_date)->isoFormat('DD MMMM YYYY') }}</span></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black;">Standar(s) : <span id="id_iso" contenteditable="true" placeholder=". . . . . . . .">{{ $data->iso_r->kode }}</span></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black;">Organization Representative : <span id="comp_rep" contenteditable="true" placeholder=". . . . . . . .">{{ $data->or1 }}</span> </td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black;">Area/Department/Process : <span id="area" contenteditable="true" placeholder=". . . . . . . .">{{ $data->dept }}</span> </td>
                </tr>
                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Document Ref.: <span id="doc_reff" contenteditable="true" placeholder=". . . . . . . .">{{ $data->doc_ref }}</span></td>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Standard Ref.: <span id="std_reff" contenteditable="true" placeholder=". . . . . . . .">{{ $data->standard_ref }}</span></td>
                </tr>
                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">No. CAR : <span id="car_no" contenteditable="true" placeholder=". . . . . . . .">{{ $data->car_no }}</span></td>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">CAR Close-Out date : <span id="co_date" contenteditable="true" placeholder="DD-MM-YYYY">{{ \Carbon\Carbon::parse($data->car_date)->isoFormat('DD MMMM YYYY') }}</span></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black; text-align: justify;"><b>Detail of Non-Conformity :<br>
                        <span id="det_non_conf" contenteditable="true" placeholder=". . . . . . . .">{{ $data->doc_r->nama }}</span></b></td>
                </tr>

                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;"><b>Organization Representative : <span id="comp_rep" contenteditable="true" placeholder=". . . . . . . .">{{ $data->or2 }}</span></b></td>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;"><b>Auditor : <span id="auditors" contenteditable="true" placeholder=". . . . . . . .">{{ $data->auditor1 }}</span></b></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black; text-align: justify;">Untuk mencegah terulangnya temuan maka tindakan korektif yang dilakukan adalah :<br>
                        <span id="pencegahan" contenteditable="true" placeholder=". . . . . . . .">{{ $data->pencegahan }}</span></td>
                </tr>
                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Organization Representative: <span id="org_rep" contenteditable="true" placeholder=". . . . . . . . . .">{{ $data->or3 }}</span></td>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Date: <span id="org_rep_date" contenteditable="true" placeholder="DD-MM-YYYY">{{  \Carbon\Carbon::parse($data->date_or)->isoFormat('DD MMMM YYYY') }}</span></td>
                </tr>
                <tr>
                    <td colspan="24" style="padding: 2px; border: 1px solid black; text-align: justify;">Penerimaan Corrective Action / Komentar (gunakan lembar tambahan jika perlu):<br>
                        <span id="penerimaan" contenteditable="true" placeholder=". . . . . . . .">{{ $data->penerimaan }}</span></td>
                </tr>
                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Auditor: <span id="auditor" contenteditable="true" placeholder=". . . . . . . .">{{ $data->auditor2 }}</span></td>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;">Date: <span id="aud_date" contenteditable="true" placeholder="DD-MM-YYYY">{{ \Carbon\Carbon::parse($data->auditor_date)->isoFormat('DD MMMM YYYY') }}</span></td>
                </tr>
                <tr>
                    <td colspan="12" style="padding: 2px; border: 1px solid black;"><b>Response required (in months)</b></td>
                    <td colspan="6" style="padding: 2px; border: 1px solid black; text-align: center;"><b>Major</b></td>
                    <td colspan="6" style="padding: 2px; border: 1px solid black; text-align: center;"><b>Minor</b></td>
                </tr>
                <tr>
                    <td colspan="12" rowspan="2" style="padding: 2px; border: 1px solid black; text-align: justify;">Corrective Action harus ditangani dalam jangka waktu yang dinyatakan. Verifikasi tindakan akan terjadi pada kunjungan berikutnya. Tindak lanjut tambahan mungkin diperlukan seperti yang ditunjukkan.</td>
                    <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Define</b></td>
                    <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Close Out</b></td>
                    <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Define</b></td>
                    <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Close Out</b></td>
                </tr>
                <tr>

                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>1 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>Next Visit</b></td>
                </tr>
                {{-- <tr>

                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>1 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>Next Visit</b></td>
                </tr>
                <tr>

                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>1 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                    <td colspan="3" rowspan="1" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>Next Visit</b></td>
                </tr> --}}
                
               
            </table>

            <div class="footer">
                <table>
                    <td colspan="24" >Page 5 of 5</td>
                </table>
            </div>


    </div>

    </div>

    <script>
        function auto_height(elem) {  /* javascript */
    elem.style.height = "1px";
    elem.style.height = (elem.scrollHeight)+"px";
}
        function btnReset(){
            var checkboxes = document.querySelectorAll("input[type=checkbox]")
                for (var i = 0; i < checkboxes.length; i++)
                 {
                     checkboxes[i].checked = false;
                 }
        }
        $("input:checkbox").on('click', function() {
      // in the handler, 'this' refers to the box clicked on
      var $box = $(this);
      if ($box.is(":checked")) {
        // the name of the box is retrieved using the .attr() method
        // as it is assumed and expected to be immutable
        var group = "input:checkbox[name='" + $box.attr("name") + "']";
        // the checked state of the group/box on the other hand will change
        // and the current value is retrieved using .prop() method
        $(group).prop("checked", false);
        $box.prop("checked", true);
      } else {
        $box.prop("checked", false);
      }
      });

        
    </script>

</body>
</html>