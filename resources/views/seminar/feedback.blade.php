@extends('templates.header')

@section('content')
<style>

  .line {
    height:250px;
    overflow-y: auto;
  }

  .box-body {
      counter-reset: listCounter;
  }

  .continuous-list .nomor {
        list-style: none;
        font-size: 25px;
        margin: 25px 0;
  }

  .continuous-list .nomor::before {
        content: counter(listCounter) " . ";
        counter-increment: listCounter;
  }
  canvas{

    /* width:700px !important; */
    /* height:500px !important; */

  }
  .chart-container{
    position: relative;
    height:40vh;
  }
  .custom-label{
      display: inline-block;
      height: 15px;
      width: 50px;
      content: '.';
        /* visibility: hidden; */
    }
    .custom-label-container{
    font-size: 20px;
    }
    .custom-label-container::after{
        content: "";
        border: 1px inset;
        box-sizing: border-box;
        color: gray;
        display: block;
        height: 2px;
        margin: 0.5em auto;
    }
    .to-padd{
        padding: 25px 0 ;
    }
    .start-div{
        display: inline-block;
        width: 150px;
    }
    .legend-div{
        display: inline-block;
        width: 150px;
    }
    .persen-div{
        display: inline-block;
        width: 300px;
    }
    .persen-div::before{
        content: 'Persentase : ';
        display: inline-block;
        width: 208px;
    }
    .jumlah-div{
        display: inline-block;
        width: 300px;
    }
    .jumlah-div::before{
        content: 'Jumlah : ';
        display: inline-block;
        width: 210px;
    }
    .jumlah-div::after{
        content: ' Peserta';
        display: inline-block;
        padding-left: 1rem;
    }

    /* bar */
    .start-div-bar{
        display: inline-block;
        width: 50px;
    }
    .legend-div-bar{
        display: inline-block;
        width: 350px;
    }
    .persen-div-bar{
        display: inline-block;
        width: 400px;
    }
    .persen-div-bar::before{
        content: 'Persentase : ';
        display: inline-block;
        width: 110px;
    }
    .jumlah-div-bar{
        display: inline-block;
        width: 300px;
    }
    .jumlah-div-bar::before{
        content: 'Jumlah : ';
        display: inline-block;
        width: 110px;
    }
    .jumlah-div-bar::after{
        content: ' Peserta';
        display: inline-block;
        padding-left: 1rem;
    }
    .groupping {
        border: 2px solid black;
        padding: 50px;
        margin: 50px;
        margin-top: 75px;
    }
    /* FULL BINTANG */
    .ratings {
    position: relative;
    vertical-align: middle;
    display: inline-block;
    color: #b1b1b1;
    overflow: hidden;
    margin-top:-5px;
    }

    .full-stars{
    position: absolute;
    left: 0;
    top: 0;
    white-space: nowrap;
    overflow: hidden;
    color: #fde16d;
    }

    .empty-stars:before,
    .full-stars:before {
    content: "\2605\2605\2605\2605\2605";
    font-size: 14pt;
    }

    .empty-stars:before {
    -webkit-text-stroke: 1px #848484;
    }

    .full-stars:before {
    -webkit-text-stroke: 1px orange;
    }

    /* Webkit-text-stroke is not supported on firefox or IE */
    /* Firefox */
    @-moz-document url-prefix() {
    .full-stars{
        color: #ECBE24;
    }
    }
    /* IE */
    <!--[if IE]>
    .full-stars{
        color: #ECBE24;
    }
    <![endif]-->


</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Feedback Seminar
    </h1>
    {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Feedback</a></li>
    </ol> --}}
</section>
<section class="content-header">
  <h1>
      Feedback Seminar ({{ $daftar }} daftar - {{ $absen }} absen - {{ $respons }} responses)
  </h1>
  {{-- <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#"> Daftar</a></li>
      <li class="active"><a href="#"> Seminar</a></li>
      <li class="active"><a href="#"> Feedback</a></li>
  </ol> --}}
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-tools pull-right" style="margin-top:25px; margin-right:35px;">
            <div class="row">
                <div class="col-12">
                    <div style="margin-bottom:10px">
                        <a href="{{ url('seminar/download-feedback/'.$id) }}" class="btn btn-success">
                            <i class="fa fa-save"></i> Download Data Feedback to Excel</a>
                    </div>
                </div>
            </div>
        </div>
      <div class="box-body" style="padding:0 25px">
        <br>
        <ol class="continuous-list">
        <div class="groupping">
            <div class="row">
                <div class="col-lg-12 card">
                    <label for="seminar" class="label-control" style="color:brown;
                    font-size: 25px;
                    margin: 25px 0;"><b>Statistik Kehadiran Peserta</b></label>
                </div>
            </div>
            <div class="row to-padd">
                <div class="col-md-6 chart-container" height="500px">
                    <canvas id="myBar"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(54, 162, 235, 1) "></div>  <div class="start-div-bar"></div> <div class="legend-div-bar">Peserta Terdaftar </div> <div class="jumlah-div-bar">{{$daftar}}</div></div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(75, 192, 192, 1) "></div>  <div class="start-div-bar"></div> <div class="legend-div-bar">Kehadiran Peserta</div> <div class="persen-div-bar">({{$absen_persen}} %) Dari Jumlah Peserta</div> <div class="jumlah-div-bar">{{$absen}}</div></div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 206, 86, 1) "></div>  <div class="start-div-bar"></div> <div class="legend-div-bar">Feedback (Kuisioner)</div> <div class="persen-div-bar">({{$respons_persen}} %) Dari Kehadiran Peserta</div> <div class="jumlah-div-bar">{{$respons}}</div></div>
                </div>
            </div>
        </div>

        <div class="groupping">
            <div class="row">
                <div class="col-lg-12 card">
                    <label for="seminar" class="label-control nomor"><b>Penilaian untuk penyelenggara secara keseluruhan?</b></label>
                </div>
            </div>
            <div class="row to-padd">
                <div class="col-md-6 chart-container" height="500px">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(54, 162, 235, 1) "></div>  <div class="start-div">&starf;&starf;&starf;&starf;&starf;(5)</div> <div class="legend-div">Sangat Baik </div> <div class="persen-div">({{$feedback_seminar['persen_5']}} %)</div> <div class="jumlah-div">{{$feedback_seminar['5']}}</div>   </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(75, 192, 192, 1) "></div>  <div class="start-div">&starf;&starf;&starf;&starf;       (4)</div> <div class="legend-div">Baik        </div> <div class="persen-div">({{$feedback_seminar['persen_4']}} %)</div> <div class="jumlah-div">{{$feedback_seminar['4']}}</div></div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 206, 86, 1) "></div>  <div class="start-div">&starf;&starf;&starf;              (3)</div> <div class="legend-div">Cukup Baik  </div> <div class="persen-div">({{$feedback_seminar['persen_3']}} %)</div> <div class="jumlah-div">{{$feedback_seminar['3']}}</div>        </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(153, 102, 255, 1)"></div>  <div class="start-div">&starf;&starf;                     (2)</div> <div class="legend-div">Buruk       </div> <div class="persen-div">({{$feedback_seminar['persen_2']}} %)</div> <div class="jumlah-div">{{$feedback_seminar['2']}}</div>       </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 99, 132, 1) "></div>  <div class="start-div">&starf;                            (1)</div> <div class="legend-div">Sangat Buruk</div> <div class="persen-div">({{$feedback_seminar['persen_1']}} %)</div> <div class="jumlah-div">{{$feedback_seminar['1']}}</div>               </div>
                    <div class="custom-label-container">Rata-rata Nilai:
                        <div class="ratings">
                            <div class="empty-stars"></div>
                            <div class="full-stars" style="width:{{ (($feedback_seminar["rata_rata"]/5)*100).'%' }}"></div>
                        </div> {{'('.($feedback_seminar["rata_rata"]." / 5").')'}}
                    </div>
                </div>
            </div>
            <hr>

            @foreach($narasumber as $n)
            <div class="row">
                <div class="col-lg-12 card">
                    <label for="seminar" class="label-control nomor"><b>Penilaian untuk {{$n->peserta_r->nama}} secara keseluruhan?</b></label>
                </div>
            </div>
            <div class="row to-padd">
                <div class="col-md-6 chart-container" height="500px">
                    <canvas id="narasumber-{{$n->id_peserta}}"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(54, 162, 235, 1) "></div>  <div class="start-div">&starf;&starf;&starf;&starf;&starf;(5)</div> <div class="legend-div">Sangat Baik </div>  <div class="persen-div">({{$feedback_personal[$n->id_peserta]['persen_5']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$n->id_peserta]['5']}}</div>   </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(75, 192, 192, 1) "></div>  <div class="start-div">&starf;&starf;&starf;&starf;       (4)</div> <div class="legend-div">Baik        </div>  <div class="persen-div">({{$feedback_personal[$n->id_peserta]['persen_4']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$n->id_peserta]['4']}}</div></div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 206, 86, 1) "></div>  <div class="start-div">&starf;&starf;&starf;              (3)</div> <div class="legend-div">Cukup Baik  </div>  <div class="persen-div">({{$feedback_personal[$n->id_peserta]['persen_3']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$n->id_peserta]['3']}}</div>        </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(153, 102, 255, 1)"></div>  <div class="start-div">&starf;&starf;                     (2)</div> <div class="legend-div">Buruk       </div>  <div class="persen-div">({{$feedback_personal[$n->id_peserta]['persen_2']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$n->id_peserta]['2']}}</div>       </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 99, 132, 1) "></div>  <div class="start-div">&starf;                            (1)</div> <div class="legend-div">Sangat Buruk</div>  <div class="persen-div">({{$feedback_personal[$n->id_peserta]['persen_1']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$n->id_peserta]['1']}}</div>               </div>
                    <div class="custom-label-container">Rata-rata Nilai:
                        <div class="ratings">
                            <div class="empty-stars"></div>
                            <div class="full-stars" style="width:{{ (($feedback_personal[$n->id_peserta]["rata_rata"]/5)*100).'%' }}"></div>
                        </div> {{'('.($feedback_personal[$n->id_peserta]["rata_rata"]." / 5").')'}}
                    </div>
                </div>
            </div>
            <hr>
            @endforeach

            @foreach($moderator as $m)
            <div class="row">
                <div class="col-lg-12 card">
                    <label for="seminar" class="label-control nomor"><b>Penilaian untuk {{$m->peserta_r->nama}} secara keseluruhan?</b></label>
                </div>
            </div>
            <div class="row to-padd">
                <div class="col-md-6 chart-container" height="500px">
                    <canvas id="moderator-{{$m->id_peserta}}"></canvas>
                </div>
                <div class="col-md-4">
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(54, 162, 235, 1) "></div>  <div class="start-div">&starf;&starf;&starf;&starf;&starf;(5)</div> <div class="legend-div">Sangat Baik </div>  <div class="persen-div">({{$feedback_personal[$m->id_peserta]['persen_5']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$m->id_peserta]['5']}}</div>   </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(75, 192, 192, 1) "></div>  <div class="start-div">&starf;&starf;&starf;&starf;       (4)</div> <div class="legend-div">Baik        </div>  <div class="persen-div">({{$feedback_personal[$m->id_peserta]['persen_4']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$m->id_peserta]['4']}}</div></div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 206, 86, 1) "></div>  <div class="start-div">&starf;&starf;&starf;              (3)</div> <div class="legend-div">Cukup Baik  </div>  <div class="persen-div">({{$feedback_personal[$m->id_peserta]['persen_3']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$m->id_peserta]['3']}}</div>        </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(153, 102, 255, 1)"></div>  <div class="start-div">&starf;&starf;                     (2)</div> <div class="legend-div">Buruk       </div>  <div class="persen-div">({{$feedback_personal[$m->id_peserta]['persen_2']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$m->id_peserta]['2']}}</div>       </div>
                    <div class="custom-label-container"><div class="custom-label" style="background-color:rgba(255, 99, 132, 1) "></div>  <div class="start-div">&starf;                            (1)</div> <div class="legend-div">Sangat Buruk</div>  <div class="persen-div">({{$feedback_personal[$m->id_peserta]['persen_1']}} %)</div> <div class="jumlah-div">{{$feedback_personal[$m->id_peserta]['1']}}</div>               </div>
                    <div class="custom-label-container">Rata-rata Nilai:
                        <div class="ratings">
                            <div class="empty-stars"></div>
                            <div class="full-stars" style="width:{{ (($feedback_personal[$m->id_peserta]["rata_rata"]/5)*100).'%' }}"></div>
                        </div>  {{'('.($feedback_personal[$m->id_peserta]["rata_rata"]." / 5").')'}}
                    </div>
                </div>
            </div>
            <hr>
            @endforeach

            <div class="row">
            <div class="col-lg-12 card">
            <label for="kesan_pesan"blade.php class="label-control nomor"><b>Kesan & Pesan untuk Penyelenggara, Pengantar Diskusi, Narasumber, dan Moderator?</b></label>

            <div class="row">
                <div class="col-md-12 line">
                <ul>
                    @foreach($feedback as $key)
                    <li>
                    {{ $key->peserta_s->peserta_r->nama }} - <b>{{ $key->kesan_pesan }}</b>
                    </li>
                    @endforeach
                </ul>
                </div>
            </div>

            </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-lg-12 card">
            <label for="keterangan" class="label-control nomor"><b>Apakah ada topik yang dipandang penting dan perlu untuk diangkat dalam webinar selanjutnya? </b></label>

            <div class="row">
                <div class="col-md-12 line">
                <ul>
                    @foreach($feedback as $key)
                    <li>
                    {{ $key->peserta_s->peserta_r->nama }} - <b>{{ $key->keterangan }}</b>
                    </li>
                    @endforeach
                </ul>
                </div>
            </div>

            </div>
            </div>
        </div>
      </ol>
      </div>

    </div> {{-- Box-Content --}}


</section>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> --}}
<script>
var ctx = document.getElementById('myBar').getContext('2d');
var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Peserta Terdaftar',
                 'Kehadiran Peserta',
                 'Jumlah Feedback (Kuisioner)',],
        datasets: [{
            // label: '# of Votes',
            data: [
                {{$daftar}},
                {{$absen}},
                {{$respons}},
            ],
            backgroundColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(255, 206, 86, 1)',

            ],
            borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(255, 206, 86, 1)',

            ],
            borderWidth: 1
        }]
    },
    options:  {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },

        legend: {
            display: false
         },
    }
});

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['\u2605\u2605\u2605\u2605\u2605 Sangat Baik    ',
                 '\u2605\u2605\u2605\u2605    Baik',
                 '\u2605\u2605\u2605       Cukup Baik',
                 '\u2605\u2605          Buruk',
                 '\u2605             Sangat Buruk',],
        datasets: [{
            label: '# of Votes',
            data: [
                {{$feedback_seminar['5']}},
                {{$feedback_seminar['4']}},
                {{$feedback_seminar['3']}},
                {{$feedback_seminar['2']}},
                {{$feedback_seminar['1']}},
            ],
            backgroundColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 99, 132, 1)'

            ],
            borderColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(153, 102, 255, 1)',
              'rgba(255, 99, 132, 1)'

            ],
            borderWidth: 1
        }]
    },
    options: {

        responsive: true,
        maintainAspectRatio: false,
         legend: {
            display: false
         },
    }
});

@foreach($narasumber as $n)
    var ctx = document.getElementById('narasumber-'+{{$n->id_peserta}}).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['\u2605\u2605\u2605\u2605\u2605 Sangat Baik    ',
                    '\u2605\u2605\u2605\u2605    Baik',
                    '\u2605\u2605\u2605       Cukup Baik',
                    '\u2605\u2605          Buruk',
                    '\u2605             Sangat Buruk',],
            datasets: [{
                label: '# of Votes',
                data: [
                    {{$feedback_personal[$n->id_peserta]['5']}},
                    {{$feedback_personal[$n->id_peserta]['4']}},
                    {{$feedback_personal[$n->id_peserta]['3']}},
                    {{$feedback_personal[$n->id_peserta]['2']}},
                    {{$feedback_personal[$n->id_peserta]['1']}},
                ],
                backgroundColor: [
                  'rgba(54, 162, 235, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 99, 132, 1)',

                ],
                borderColor: [
                  'rgba(54, 162, 235, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 99, 132, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {

            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
        }
    });
@endforeach

@foreach($moderator as $m)
    var ctx = document.getElementById('moderator-'+{{$m->id_peserta}}).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['\u2605\u2605\u2605\u2605\u2605 Sangat Baik    ',
                    '\u2605\u2605\u2605\u2605    Baik',
                    '\u2605\u2605\u2605       Cukup Baik',
                    '\u2605\u2605          Buruk',
                    '\u2605             Sangat Buruk',],
            datasets: [{
                label: '# of Votes',
                data: [
                    {{$feedback_personal[$m->id_peserta]['5']}},
                    {{$feedback_personal[$m->id_peserta]['4']}},
                    {{$feedback_personal[$m->id_peserta]['3']}},
                    {{$feedback_personal[$m->id_peserta]['2']}},
                    {{$feedback_personal[$m->id_peserta]['1']}},
                ],
                backgroundColor: [
                  'rgba(54, 162, 235, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 99, 132, 1)'

                ],
                borderColor: [
                  'rgba(54, 162, 235, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 99, 132, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {

            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
        }
    });
@endforeach
</script>
@endpush
