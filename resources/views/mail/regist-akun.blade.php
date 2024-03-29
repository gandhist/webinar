<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>

    <style>
        /* This styles you should add to your html as inline-styles */
        /* You can easily do it with http://inlinestyler.torchboxapps.com/ */
        /* Copy this html-window code converter and click convert button */
        /* After that you can remove this style from your code */

        body {
            margin: 0;
            padding: 0;
            mso-line-height-rule: exactly;
            min-width: 100%;
        }

        .wrapper {
            display: table;
            table-layout: fixed;
            width: 100%;
            min-width: 620px;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        body,
        .wrapper {
            background-color: #ffffff;
        }

        /* Basic */
        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        table.center {
            margin: 0 auto;
            width: 602px;
        }

        td {
            padding: 0;
            vertical-align: top;
        }

        .spacer,
        .border {
            font-size: 1px;
            line-height: 1px;
        }

        .spacer {
            width: 100%;
            line-height: 16px
        }

        .border {
            background-color: #e0e0e0;
            width: 1px;
        }

        .padded {
            padding: 0 24px;
        }

        img {
            border: 0;
            -ms-interpolation-mode: bicubic;
        }

        .image {
            font-size: 12px;
        }

        .image img {
            display: block;
        }

        strong,
        .strong {
            font-weight: 700;
        }

        h1,
        h2,
        h3,
        p,
        ol,
        ul,
        li {
            margin-top: 0;
        }

        ol,
        ul,
        li {
            padding-left: 0;
        }

        a {
            text-decoration: none;
            color: #616161;
        }

        .btn {
            background-color: #2196F3;
            border: 1px solid #2196F3;
            border-radius: 2px;
            color: #ffffff;
            display: inline-block;
            font-family: Roboto, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 36px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            width: 200px;
            height: 36px;
            padding: 0 8px;
            margin: 0;
            outline: 0;
            outline-offset: 0;
            -webkit-text-size-adjust: none;
            mso-hide: all;
        }

        /* Top panel */
        .title {
            text-align: left;
        }

        .subject {
            text-align: right;
        }

        .title,
        .subject {
            width: 300px;
            padding: 8px 0;
            color: #616161;
            font-family: Roboto, Helvetica, sans-serif;
            font-weight: 400;
            font-size: 12px;
            line-height: 14px;
        }

        /* Header */
        .logo {
            padding: 16px 0;
        }

        /* Logo */
        .logo-image {}

        /* Main */
        .main {
            -webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
            -moz-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
        }

        /* Content */
        .columns {
            margin: 0 auto;
            width: 600px;
            background-color: #ffffff;
            font-size: 14px;
        }

        .column {
            text-align: left;
            background-color: #ffffff;
            font-size: 14px;
        }

        .column-top {
            font-size: 24px;
            line-height: 24px;
        }

        .content {
            width: 100%;
        }

        .column-bottom {
            font-size: 8px;
            line-height: 8px;
        }

        .content h1 {
            margin-top: 0;
            margin-bottom: 16px;
            color: #212121;
            font-family: Roboto, Helvetica, sans-serif;
            font-weight: 400;
            font-size: 20px;
            line-height: 28px;
        }

        .content p {
            margin-top: 0;
            margin-bottom: 16px;
            color: #212121;
            font-family: Roboto, Helvetica, sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
        }

        .content .caption {
            color: #616161;
            font-size: 12px;
            line-height: 20px;
        }

        /* Footer */
        .signature,
        .subscription {
            vertical-align: bottom;
            width: 300px;
            padding-top: 8px;
            margin-bottom: 16px;
        }

        .signature {
            text-align: left;
        }

        .subscription {
            text-align: right;
        }

        .signature p,
        .subscription p {
            margin-top: 0;
            margin-bottom: 8px;
            color: #616161;
            font-family: Roboto, Helvetica, sans-serif;
            font-weight: 400;
            font-size: 12px;
            line-height: 18px;
        }

        table#seminar,
        table#seminar>thead>tr>th,
        table#seminar>tbody>tr>td {
            border: 2px solid rgba(0, 0, 0, 0.24);
        }

        table#seminar {
            width: 100%;
            margin: 0 auto;
        }

        table#seminar>tbody>tr:nth-child(odd) {
            background-color: #bababa;
        }

        table#seminar>tbody>tr>td:nth-child(3),
        table#seminar>tbody>tr>td:nth-child(4),
        table#seminar>tbody>tr>td:nth-child(1) {
            text-align: center;
        }

        table#seminar>tbody>tr>td,
        table#seminar>thead>tr>th {
            padding: 5px;
        }

        table#seminar>thead>tr {
            background-color: #bdaf84;
            text-align: center;
        }
    </style>

</head>

<body>


    <center class="wrapper">
        <table class="top-panel center" width="602" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="title" width="300">P3S Mandiri</td>
                    <td class="subject" width="300"><a class="strong" href="https://srtf.p3sm.or.id/"
                            target="_blank">www.srtf.p3sm.or.id</a></td>
                </tr>
                <tr>
                    <td class="border" colspan="2">&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <div class="spacer">&nbsp;</div>

        <table class="main center" width="602" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td class="column">
                        <div class="column-top">&nbsp;</div>
                        <table class="content" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td class="padded">
                                        <h1>Halo {{ $pesan['name'] }}!</h1>
                                        <p>Selamat, Anda Sudah terdaftar sebagai pengguna App PKB ONLINE dari P3S
                                            Mandiri. Dengan data sebagai berikut,</p>
                                        <p>Nama : {{ $pesan['name'] }}</p>
                                        <p>Nomor HP (WA) : {{ $pesan['no_hp'] }}</p>
                                        <p>Email : {{ $pesan['email'] }}</p>
                                        <p>Dengan Username : {{ $pesan['username'] }}</p>
                                        <p>Dan Password : {{ $pesan['password'] }}</p>

                                        @if(isset($seminar))
                                        <p>Silahkan mendaftar di seminar sebagai berikut,</p>
                                        <table id="seminar">
                                            <colgroup>
                                                <col style="width:10%">
                                                <col style="width:50%">
                                                <col style="width:20%">
                                                <col style="width:20%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tema</th>
                                                    <th>Tanggal</th>
                                                    <th>Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($seminar as $key)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$key->nama_seminar}}</td>
                                                    <td>{{\Carbon\Carbon::parse($key->tgl_awal)->format('d M Y')}}</td>
                                                    <td><a
                                                            href={{ isset($key->slug) ? url('/registrasi/daftar/'.$key->slug) : url('/regestrasi/daftar/'.$key->id)}}>
                                                            <div style="height:100%;width:100%">Daftar</div>
                                                        </a></td>
                                                    {{-- <td>{{$key->}}
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        @endif

                        <p>Kegiatan ini di selengarakan secara Online dengan App PKB Online dari P3S Mandiri</p>
                        <p style="text-align:center;"><a href="{{ url('notif', $pesan['magic_link']) }}"
                                class="btn">Halaman Login</a></p>
                        <p>Terima kasih sudah mendaftar App PKB ONLINE dari P3S Mandiri.</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="column-bottom">&nbsp;</div>
        </td>
        </tr>
        </tbody>
        </table>

        <div class="spacer">&nbsp;</div>

        <!-- <table class="footer center" width="602" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td class="border" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="signature" width="300">
                <p>
                    With best regards,<br>
                    Company Name<br>
                    +0 (000) 00-00-00, John Doe<br>
                    </p>
                <p>
                    Support: <a class="strong" href="mailto:#" target="_blank">support@support.ru</a>
                </p>
            </td>
            <td class="subscription" width="300">
                <div class="logo-image">
                    <a href="https://zavoloklom.github.io/material-design-iconic-font/" target="_blank"><img src="https://zavoloklom.github.io/material-design-iconic-font/icons/mstile-70x70.png" alt="logo-alt" width="70" height="70"></a>
                </div>
                <p>
                    <a class="strong block" href="#" target="_blank">
                        Unsubscribe
                    </a>
                    <span class="hide">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <a class="strong block" href="#" target="_blank">
                        Account Settings
                    </a>
                </p>
            </td>
        </tr>
        </tbody>
    </table> -->
    </center>
</body>

</html>
