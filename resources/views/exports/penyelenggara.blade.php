<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <table style="font-weight: bold">
        <tr>
            <td colspan=20 rowspan=3 style=" background-color: yellow;" align="center" valign="middle">
                KEGIATAN WEBINAR PPK K-3
            </td>
        </tr>
    </table>
    <br style="mso-data-placement:same-cell;" />
    <br style="mso-data-placement:same-cell;" />
    <br style="mso-data-placement:same-cell;" />
    <table>
        <tr>
            <th align="center"  style="background-color: cyan; font-weight: bold" rowspan=2 >No</th>
            <th align="center"  style="background-color: cyan; font-weight: bold" colspan=6 rowspan=2 >JENIS KEGIATAN</th>
            <th align="center"  style="background-color: cyan; font-weight: bold" colspan=8 rowspan=2 >JUDUL</th>
            <th align="center"  style="background-color: cyan; font-weight: bold" colspan=3 rowspan=2 >TANGGAL</th>
            <th align="center"  style="background-color: cyan; font-weight: bold" colspan=2 rowspan=2 >JUMLAH DAFTAR</th>
        </tr>
    </table>
    @foreach ($seminar as $key)
        <table>
            <tr>
                <td align="center" rowspan=2 >{{$loop->iteration}}</td>
                <td align="center" colspan=6 rowspan=2 >{{$key->nama_seminar}}</td>
                <td align="center" colspan=8 rowspan=2 >{{strip_tags($key->tema)}}</td>
                <td align="center" colspan=3 rowspan=2 >{{\Carbon\Carbon::parse($key->tgl_awal)->translatedFormat('d F Y')}}</td>
                <td align="center" colspan=2 rowspan=2 >{{$key->jumlah_peserta ?? '0'}} Peserta</td>
            </tr>
        </table>
    @endforeach
</body>
</html>

