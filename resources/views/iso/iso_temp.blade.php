<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat ISO {{ $data->nama_bu }}</title>

    <style>
      

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
        margin: 0px;
        padding: 0;
        background-color: #FAFAFA;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
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
          
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
          background-image: url("/iso/images/bg_sertf_2.png");
          background-size: contain;
          background-repeat: no-repeat;
      }

      .cert{
        width: 560px;
        border-collapse: collapse;
      }

      .cert, td, th {
        white-space:nowrap;
        }


      
      @page {
          size: A4;
          margin: 0;
      }
      
      [contenteditable=true]:empty:before {
      content: attr(placeholder);
      color:gray;
      }
      /* found this online --- it prevents the user from being able to make a (visible) newline */
      [contenteditable=true] br{
      display:none;
    }


      }

  </style>

</head>
<body>
    
      <div class="page">
        <div id="watermark">
          @if($data->status == 1)
            <h1>{{ $data->status_r->nama }}</h1>
          @endif
        </div>
        <div style="text-align: center; margin-top: 0px;">
        <img src="{{  public_path('iso/images/') }}/logoheader.png" style="text-align: center; margin-top: 30px;" width="200px"><BR>
        {{-- <span style="color: #206f9c; font-size: 18px;"><strong>{{ $data->iso_r->kode }}</strong></span> --}}
      </div>
      <div style="margin-top: 90px; margin-left: 115px; margin-right: 120px; text-align: justify;">
        <p style="text-align: center;">This is to certify that</p>
        <p style="font-size: 28px; margin-top:-10px; font-weight: bold; text-align: center;">{{ $data->nama_bu }}</p>
        <p style="margin-top: -20px; text-align: center;">{{ $data->alamat }} {{ $data->kota ? $data->kota_r->nama : '' }}</p>
        <p style="line-height: 150%; text-align: center;">&nbsp; has been assessed and registered <strong>PT. Sertifikasi Badan Usaha Mandiri</strong> 
          <br> as confirming to the requirements of :</p>
        <p style="font-size: 24px; font-weight: bold; color: #206f9c; text-transform: uppercase; text-align: center;">{{ $data->iso_r->nama_en }}</p>
        <p style="font-size: 42px; font-weight: bold; color: #206f9c; text-transform: uppercase; text-align: center; margin-top: -5PX;">{{ $data->iso_r->kode }}</p>
        <P style="margin-top: -10px; text-align: center;">For the following Scope :</P>
        <p style="font-size: 16px; font-weight: bold; text-align: justify; line-height: 150%;">
            "Provision of
           @foreach($data->lap_r->scope_r as $key)
           @if($loop->last) And @endif{{ $key->scope_r->nama_en }}@if(!$loop->last), @endif
           @endforeach
            "</p>
      </div>
      <div style="margin-left: 115px; margin-right: 120px;">
      <table class="cert" width="420px">
        <tr>
          <td colspan="3">Certificate No.</td>
          <td colspan="1">:</td>
          <td colspan="4"><u>{{ $data->no_sert }}</u></td>
          <td colspan="3">1<sup>st</sup> Survaillance</td>
          <td colspan="1">:</td>
          <td colspan="4"><u>{{ \Carbon\Carbon::parse($data->tgl_sert)->add('1','years')->isoFormat('DD-MM-YYYY') }}</u></td>
        </tr>
        <tr>
          <td colspan="3">Issued Date</td>
          <td colspan="1">:</td>
          <td colspan="4"><u>{{ \Carbon\Carbon::parse($data->tgl_sert)->isoFormat('DD-MM-YYYY') }}</u></td>
          <td colspan="3">2<sup>nd</sup> Survaillance</td>
          <td colspan="1">:</td>
          <td colspan="4"><u>{{ \Carbon\Carbon::parse($data->tgl_sert)->add('2','years')->isoFormat('DD-MM-YYYY') }}</u></td>
        </tr>
        <tr>
          <td colspan="3">Valid Date</td>
          <td colspan="1">:</td>
          <td colspan="4"><u>{{ \Carbon\Carbon::parse($data->tgl_sert)->add('3','years')->isoFormat('DD-MM-YYYY') }}</u></td>
          <td colspan="3">Recertification</td>
          <td colspan="1">:</td>
          <td colspan="4"><u>{{ \Carbon\Carbon::parse($data->tgl_sert)->add('3','years')->isoFormat('DD-MM-YYYY') }}</u></td>
        </tr>
        <tr>
          <td colspan="8" style="padding: 20px; vertical-align: bottom; text-align: left;">
            @if($data->status != 1)
              <img src="{{  public_path('qr/') }}/QR_{{ $data->id }}.png" height="100px">
            @else
            <span height="100px"></span>
            @endif
          </td>
          <td colspan="8" style="padding: 20px; vertical-align: bottom; text-align: center;"><img src="{{  public_path('iso/images/') }}/tt_dasril.png" width="140px" height="50px" ><br>Director</td>
        </tr>
        <tr>
          <td colspan="8" style="text-align: left;">
            <p style="font-size: 12px;">
              Mandiri Certification presented by :<br>
              <strong>PT. SERTIFIKASI BADAN USAHA MANDIRI</strong><BR>
                Jl. Pluit Raya, Kav. 12, Blok A5,<br>
                Penjaringan - Jakarta Utara<br>
                Phone : +62 21 6622 925 Ext. 105<br>
                Website :  {{ env('APP_URL') }}
            </p>
          </td>
          <td colspan="8" style="padding: 20px; text-align: center;"></td>

        </tr>
      </table>  
      
      
    </div>
    


</body>
</html>