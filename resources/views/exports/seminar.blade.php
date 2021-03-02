<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

    <table>
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
    <br style="mso-data-placement:same-cell;" />
    <table>
        <tr>
            <td colspan="2">
                Nama_Kgt:
            </td>
            <td colspan="8">
                {{ $seminar->nama_seminar }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Tema :
            </td>
            <td colspan="8">
                {{ strip_tags($seminar->tema) }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Tgl_Awal :
            </td>
            <td colspan="8">
                {{ \Carbon\Carbon::parse($seminar->tgl_awal)->translatedFormat('l, d M Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Tgl_Akhir :
            </td>
            <td colspan="8">
                {{ \Carbon\Carbon::parse($seminar->tgl_akhir)->translatedFormat('l, d M Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Jam_Awal :
            </td>
            <td colspan="8">
                {{ $seminar->jam_awal }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Jam_Akhir :
            </td>
            <td colspan="8">
                {{ $seminar->jam_akhir }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                SKPK :
            </td>
            <td colspan="8">
                {{ $seminar->skpk_nilai }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Kuota :
            </td>
            <td colspan="8">
                {{ $seminar->kuota }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Peserta Terdaftar :
            </td>
            <td colspan="8">
                {{ $seminar->jumlah_peserta_terdaftar }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Peserta Membayar :
            </td>
            <td colspan="8">
                {{ $seminar->jumlah_peserta_membayar }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Biaya :
            </td>
            <td colspan="8">
                {{ $seminar->biaya }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Tipe  :
            </td>
            <td colspan="8">
                {{ isset($seminar->is_online) ? ( $seminar->is_online == 1 ? "Online" : "Offline" ) : "" }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Provinsi  :
            </td>
            <td colspan="8">
                {{ isset($seminar->provinsi_r) ? ( $seminar->provinsi_r->nama_singkat ) : "" }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Kota  :
            </td>
            <td colspan="8">
                {{ isset($seminar->kota_r) ? ( $seminar->kota_r->nama ) : "" }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                TUK  :
            </td>
            <td colspan="8">
                {{ isset($seminar->tuk_r) ? ( $seminar->tuk_r->nama_tuk ) : "" }}
            </td>
        </tr>
    </table>

</body>
</html>
