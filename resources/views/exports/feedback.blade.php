<html>
    <head>
        <link rel="stylesheet" href="./style.css">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th colspan="10" height="30px">
                        FEEDBACK SEMINAR <b>"{{$detail_seminar->nama_seminar}}"</b>
                    </th>
                </tr>
                <tr>
                    <th colspan="10" height="30px">
                        TEMA : <b>"{{strip_tags($detail_seminar->tema)}}"</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5">Jumlah Pendaftar</td>
                    <td colspan="5">{{$daftar}}</td>
                </tr>
                <tr>
                    <td colspan="5">Jumlah Peserta Absen</td>
                    <td colspan="5">{{$absen}}</td>
                </tr>
                <tr>
                    <td colspan="5">Jumlah Respon</td>
                    <td colspan="5">{{$respons}}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th colspan="10" height="30px">
                        <b>Feedback Untuk Seminar Secara Keseluruhan</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="5"><b>Nilai</b></th>
                    <th>★</th>
                    <th>★★</th>
                    <th>★★★</th>
                    <th>★★★★</th>
                    <th>★★★★★</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Jumlah</b></th>
                    <th>{{$feedback_seminar['1']}}</th>
                    <th>{{$feedback_seminar['2']}}</th>
                    <th>{{$feedback_seminar['3']}}</th>
                    <th>{{$feedback_seminar['4']}}</th>
                    <th>{{$feedback_seminar['5']}}</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Persentase</b></th>
                    <th>{{$feedback_seminar['persen_1']." %"}}</th>
                    <th>{{$feedback_seminar['persen_2']." %"}}</th>
                    <th>{{$feedback_seminar['persen_3']." %"}}</th>
                    <th>{{$feedback_seminar['persen_4']." %"}}</th>
                    <th>{{$feedback_seminar['persen_5']." %"}}</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Rata-rata</b></th>
                    <td colspan="5"><b>{{$feedback_seminar['rata_rata']}}</b></td>
                </tr>
            </tbody>
        </table>

        @foreach($narasumber as $key)
        <table>
            <thead>
                <tr>
                    <th colspan="10" height="30px">
                        <b>Feedback Untuk {{$key->peserta_r->nama}} Sebagai Narasumber</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="5"><b>Nilai</b></th>
                    <th>★</th>
                    <th>★★</th>
                    <th>★★★</th>
                    <th>★★★★</th>
                    <th>★★★★★</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Jumlah</b></th>
                    <th>{{$feedback_personal[$key->id_peserta]['1']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['2']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['3']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['4']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['5']}}</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Persentase</b></th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_1']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_2']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_3']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_4']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_5']." %"}}</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Rata-rata</b></th>
                    <td colspan="5"><b>{{$feedback_personal[$key->id_peserta]['rata_rata']}}</b></td>
                </tr>
            </tbody>
        </table>
        @endforeach

        @foreach($moderator as $key)
        <table>
            <thead>
                <tr>
                    <th colspan="10" height="30px">
                        <b>Feedback Untuk {{$key->peserta_r->nama}} Sebagai Moderator</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th colspan="5"><b>Nilai</b></th>
                    <th>★</th>
                    <th>★★</th>
                    <th>★★★</th>
                    <th>★★★★</th>
                    <th>★★★★★</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Jumlah</b></th>
                    <th>{{$feedback_personal[$key->id_peserta]['1']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['2']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['3']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['4']}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['5']}}</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Persentase</b></th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_1']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_2']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_3']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_4']." %"}}</th>
                    <th>{{$feedback_personal[$key->id_peserta]['persen_5']." %"}}</th>
                </tr>
                <tr>
                    <th colspan="5"><b>Rata-rata</b></th>
                    <td colspan="5"><b>{{$feedback_personal[$key->id_peserta]['rata_rata']}}</b></td>
                </tr>
            </tbody>
        </table>
        @endforeach

        <table>
            <thead>
                <tr>
                    <th colspan="10" height="30px">
                        <b>Respon Peserta</b>
                    </th>
                </tr>
                <tr>
                    <th colspan="1">
                        <b>ID Peserta Seminar</b>
                    </th>
                    <th colspan="6">
                        <b>Nama Peserta</b>
                    </th>
                    <th colspan="10">
                        <b>Pertanyaan</b>
                    </th>
                    <th>
                        <b>Nilai</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta as $key)
                    @foreach($feedback_seminar_raw as $s)
                        @if($s->id_peserta_seminar == $key->id)
                            <tr>
                                <td colspan="1">{{$key->id}}</td>
                                <td colspan="6">{{$key->peserta_r->nama}}</td>
                                <td colspan="10">Penilaian untuk penyelenggara secara keseluruhan?</td>
                                <td>{{$s->nilai}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach($feedback_personal_raw->where('id_peserta_seminar',$key->id)->whereIn('id_peserta',$id_nara) as $p)
                        <tr>
                            <td colspan="1">{{$key->id}}</td>
                            <td colspan="6">{{$key->peserta_r->nama}}</td>
                            <td colspan="10">Penilaian untuk {{$narasumber->where('id_peserta',$p->id_peserta)->first()->peserta_r->nama}} sebagai Narasumber?</td>
                            <td>{{$p->nilai}}</td>
                        </tr>
                    @endforeach
                    @foreach($feedback_personal_raw->where('id_peserta_seminar',$key->id)->whereIn('id_peserta',$id_mode) as $p)
                        <tr>
                            <td colspan="1">{{$key->id}}</td>
                            <td colspan="6">{{$key->peserta_r->nama}}</td>
                            <td colspan="10">Penilaian untuk {{$moderator->where('id_peserta',$p->id_peserta)->first()->peserta_r->nama}} sebagai Moderator?</td>
                            <td>{{$p->nilai}}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </body>
</html>
