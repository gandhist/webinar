<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peserta Tidak Hadir</title>
</head>
<body>
    <table style="font-weight: bold">
        <thead>
            <tr>
                <th colspan="15" height="30px">
                    DAFTAR PESERTA TIDAK HADIR <b>"{{$detail_seminar->nama_seminar}}"</b>
                </th>
            </tr>
            <tr>
                <th colspan="15" height="30px">
                    TEMA : <b>"{{strip_tags($detail_seminar->tema)}}"</b>
                </th>
            </tr>
            <tr>
                <th colspan="15" height="30px">
                    TANGGAL : <b>"{{\Carbon\Carbon::parse($detail_seminar->tgl_awal)->translatedFormat('d F Y')}}"</b>
                </th>
            </tr>
        </thead>
    </table>

    <table style="font-weight: bold">
        <thead>
            <tr>
                <th>No</th>
                <th colspan="5">Nama</th>
                <th colspan="5">Email</th>
                <th colspan="3">Nomor Telepon</th>
                <th colspan="5">Waktu Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tidak_hadir as $key)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td colspan="5">{{$key->peserta_r->nama}}</td>
                    <td colspan="5">{{$key->peserta_r->email}}</td>
                    <td colspan="3">{{$key->peserta_r->no_hp}}</td>
                    <td colspan="5">{{\Carbon\Carbon::parse($key->created_at)->translatedFormat('d F Y h:i')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
