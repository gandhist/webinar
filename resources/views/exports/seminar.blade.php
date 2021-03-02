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
                <th colspan="10" rowspan="3" align="center" valign="top">
                    <p>
                       <b>
                            {{ $seminar->nama_seminar ." (". strip_tags( $seminar->tema ) .")"}}
                        </b>
                    </p>
                </th>
            </tr>
        </thead>
    </table>

    <br style="mso-data-placement:same-cell;" />
    <br style="mso-data-placement:same-cell;" />

    <table border="2">
        <tr>
            <td colspan="2">
                <b>Nama_Kgt:</b>
            </td>
            <td colspan="8">
                {{ $seminar->nama_seminar }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Tema :</b>
            </td>
            <td colspan="8">
                {{ strip_tags($seminar->tema) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Tgl_Awal :</b>
            </td>
            <td colspan="8">
                {{ \Carbon\Carbon::parse($seminar->tgl_awal)->translatedFormat('l, d M Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Tgl_Akhir :</b>
            </td>
            <td colspan="8">
                {{ \Carbon\Carbon::parse($seminar->tgl_akhir)->translatedFormat('l, d M Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Jam_Awal :</b>
            </td>
            <td colspan="8">
                {{ $seminar->jam_awal }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Jam_Akhir :</b>
            </td>
            <td colspan="8">
                {{ $seminar->jam_akhir }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>SKPK :</b>
            </td>
            <td colspan="8">
                {{ $seminar->skpk_nilai }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Kuota :</b>
            </td>
            <td colspan="8">
                {{ $seminar->kuota }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Peserta Terdaftar :</b>
            </td>
            <td colspan="8">
                {{ $seminar->jumlah_peserta_terdaftar }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Peserta Membayar :</b>
            </td>
            <td colspan="8">
                {{ $seminar->jumlah_peserta_membayar }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Biaya :</b>
            </td>
            <td colspan="8">
                {{ \Rupiah::RupiahRp($seminar->biaya) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Tipe  :</b>
            </td>
            <td colspan="8">
                {{ isset($seminar->is_online) ? ( $seminar->is_online == 1 ? "Online" : "Offline" ) : "" }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Provinsi  :</b>
            </td>
            <td colspan="8">
                {{ isset($seminar->provinsi_r) ? ( $seminar->provinsi_r->nama_singkat ) : "" }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Kota  :</b>
            </td>
            <td colspan="8">
                {{ isset($seminar->kota_r) ? ( $seminar->kota_r->nama ) : "" }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>TUK  :</b>
            </td>
            <td colspan="8">
                {{ isset($seminar->tuk_r) ? ( $seminar->tuk_r->nama_tuk ) : "" }}
            </td>
        </tr>
    </table>


    <br style="mso-data-placement:same-cell;" />
    <br style="mso-data-placement:same-cell;" />

    <table border="2">
        <thead>
            <tr>
                <th colspan="10" valign="middle" align="center">
                    <b>Instansi Terkait</b>
                </th>
            </tr>
            <tr>
                <th colspan="1" valign="middle" align="center">
                    <b>No</b>
                </th>
                <th colspan="3" valign="middle" align="center">
                    <b>Nama Instansi</b>
                </th>
                <th colspan="3" valign="middle" align="center">
                    <b>Peran</b>
                </th>
                <th colspan="3" valign="middle" align="center">
                    <b>Tampil di Sertifikat</b>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($instansi as $key)
                <tr>
                    <td align="center">
                        {{ $loop->iteration }}
                    </td>
                    <td colspan="3">
                        {{ isset($key->bu_instansi) ? $key->bu_instansi->singkat_bu : '' }}
                    </td>
                    <td colspan="3">
                        @if ($key->status == 1)
                            Penyelenggara
                        @elseif ($key->status == 2)
                            Pendukung
                        @endif
                    </td>
                    <td colspan="3">
                        {{ $key->is_tampil == 1 ? "Ya" : "Tidak"}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
