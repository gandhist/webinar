<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat MBC</title>

    <style>

    .page_bg {
      position:absolute;
      display: block;
      left:0;
      right:0;
      top:0;
      bottom:0;
      background-image: url("{{ public_path('iso/images/bg_srtf_mbc.jpg') }}");
      background-repeat: no-repeat;
      background-size: cover;
    }

    @font-face {
        font-family: 'ananda';
        src: url({{ base_path('resources/fonts/Ananda_B.ttf') }}) format("truetype");
        font-weight: 700;
        font-style: bold;
    }
    @page {
        margin: 0;
    }

    .nama{
        font-family: 'ananda';
        text-align:center;
        padding-top:9.8cm;
        color:rgb(254,177,35);
    }
    </style>


</head>
<body>
    <div class="page_bg">
        <h1 class="nama">{{$nama}}</h1>
    </div>


</body>
</html>
