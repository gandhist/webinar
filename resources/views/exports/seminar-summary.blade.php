<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

    <table border="2">
        <thead>
            <tr>
                <th colspan="16" rowspan="2" align="center" valign="middle">
                    <p>
                       <b>
                            SUMMARY REKAP DATA KEGIATAN PKB
                        </b>
                    </p>
                </th>
            </tr>
        </thead>
    </table>

    <br style="mso-data-placement:same-cell;" />
    <br style="mso-data-placement:same-cell;" />

    <table>
        <thead>
            <tr>
                <td>
                    <b>
                        No.
                    </b>
                </td>
                <td colspan="3">
                    <b>
                        Nama_Kgt
                    </b>
                </td>
                <td colspan="3">
                    <b>
                        Tema
                    </b>
                </td>
                <td colspan="2">
                    <b>
                        Tgl_Awal
                    </b>
                </td>
                <td colspan="2">
                    <b>
                        Tgl_Akhir
                    </b>
                </td>
                <td>
                    <b>
                        Peserta_Daftar
                    </b>
                </td>
                <td>
                    <b>
                        Peserta_Bayar
                    </b>
                </td>
                <td colspan="2">
                    <b>
                        Biaya
                    </b>
                </td>
                <td>
                    <b>
                        SKPK
                    </b>
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($seminar as $key)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td colspan="3">
                        {{ $key->nama_seminar}}
                    </td>
                    <td colspan="3">
                        {{ strip_tags($key->tema) }}
                    </td>
                    <td colspan="2">
                        @if ($key->tgl_awal && $key->jam_awal)
                            {{ \Carbon\Carbon::parse($key->tgl_awal." ".$key->jam_awal)->translatedFormat('l, d M Y H:i')}}
                        @elseif ($key->tgl_awal)
                            {{ \Carbon\Carbon::parse($key->tgl_awal." "."00:00")->translatedFormat('l, d M Y H:i')}}
                        @endif
                    </td>
                    <td colspan="2">
                        @if ($key->tgl_akhir && $key->jam_akhir)
                            {{ \Carbon\Carbon::parse($key->tgl_akhir." ".$key->jam_akhir)->translatedFormat('l, d M Y H:i')}}
                        @elseif ($key->tgl_akhir)
                            {{ \Carbon\Carbon::parse($key->tgl_akhir." "."00:00")->translatedFormat('l, d M Y H:i')}}
                        @endif
                    </td>
                    <td>
                        {{ $key->jumlah_peserta_terdaftar }}
                    </td>
                    <td>
                        {{ $key->jumlah_peserta_membayar }}
                    </td>
                    <td colspan="2">
                        {{ \Rupiah::RupiahRp($key->biaya) }}
                    </td>
                    <td>
                        {{ $key->skpk_nilai }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
