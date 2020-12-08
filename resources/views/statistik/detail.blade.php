@extends('templates.header')

@section('content')
<style>
    .chart-container {
        /* border: 3px solid black; */
        margin-top : 3rem;
        margin-bottom: 6rem;
        box-shadow: 5px 5px 25px;
    }
    .card {
        height: 200px;
        width: 200px;
        margin: 2rem auto;
        /* background-color: black; */
        border: 1 solid black;
        border-radius: 50%;
        box-shadow: black 1rem 1rem 2.5rem;
        font-size: 25px;
        text-align: center;
        padding: 1rem 3.5rem;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-content: center;
        background-color: darkgray;    }
    .card>span{
        display: inline-block;
        font-weight:600;
        height: 75px;
        margin-top: -2rem
    }
    .card>div{
        /* margin-top: -1rem; */
        font-weight: bold;
        font-size: 40px;
        border: 1px solid black
    }
    .d-flex-center {
        display: flex;
        justify-content: space-between;

    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Statistik Blasting Kegiatan PPKB
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Statistik</a></li>
        <li class="active"><a href="#"> Blasting</a></li>
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content" style="min-height: 100vh; padding-left: 0; padding-right :0">
    <!-- Default box -->
    <div class="box box-content" style="min-height:90vh">
        <div class="container-fluid" style="min-height:90vh">

            <div class="row" style="padding: 4rem 2rem">
                <div class="col-md-12" style="text-align: center; margin-top: -3rem">
                    <h2>Statistik Blasting App PPKB P<sub>3</sub>SM Online</h2>
                    <p> <b>{{$seminar->nama_seminar}} - {{strip_tags(html_entity_decode($seminar->tema))}}</b> </p>
                </div>
                <div class="col-md-12 chart-container" style="min-height:50vh;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row d-flex-center">
                                <div class="col-md-3">
                                    <div class="card card-shadow">
                                        <span>Peserta Kegiatan</span>
                                        <div>{{$peserta_total}}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-shadow">
                                        <span>Pengguna App PPKB</span>
                                        <div>{{$user_total}}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card card-shadow">
                                        <span>Pendaftar Hari Ini</span>
                                        <div>{{$peserta_hari_ini}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 2em">
                            <canvas id="blasting" style="height:50vh; ; width:100%"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 chart-container" style="height:60vh;">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="detail" style="height:50vh ; width:100%"></canvas>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card card-shadow"><span>Target Blasting:</span><div>{{$blasting->jumlah_target}}</div></div>
                                    <div class="card card-shadow"><span>Link Diklik:</span><div>{{$blasting_diklik}}</div></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-shadow"><span>Blasting Dikirim:</span><div>{{$blasting->jumlah_kirim}}</div></div>
                                    <div class="card card-shadow"><span>Klik Lebih dari Sekali:</span><div>{{$blasting_diklik2}}</div></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-shadow"><span>Tidak Dikirim:</span><div>{{(int)$blasting->jumlah_target - (int)$blasting->jumlah_kirim}}</div></div>
                                    <div class="card card-shadow"><span>Pendaftar dari Link:</span><div>{{$blasting_didaftar}}</div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- <div class="col-md-12 chart-container" style="height:50vh;">
                    <canvas id="info" style="height:50vh; ; width:100%"></canvas>
                </div> --}}
            </div>

        </div>
    </div> {{-- Box-Content --}}
</section>



@endsection

@push('script')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>


<script type="text/javascript">
var label = @json($label);
var peserta = @json($peserta);
var user = @json($user);
var detail_blasting = @json($detail_blasting);
var dikirim = @json($dikirim);
var gagal = @json($gagal);

var blasting_target = @json($blasting->jumlah_target);
var blasting_dikirim = @json($blasting->jumlah_kirim);
var blasting_diklik = @json($blasting_diklik);
var blasting_diklik2 = @json($blasting_diklik2);
var blasting_didaftar = @json($blasting_didaftar);
var blasting_gagal = parseInt(blasting_target) - parseInt(blasting_dikirim);

// console.log((blasting_target));
// console.log(blasting_dikirim);
// console.log((blasting_diklik));
// console.log(blasting_didaftar);


function ChartOption(title) {
    this.scales = {
                yAxes: [{
                    // stacked: true,
                    ticks: {
                        beginAtZero:true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'P3S Mandiri',
                        fontSize: 20
                    }
                }],
                xAxes: [{
                    // stacked: true,
                }]
            }
    this.title = {
        display: true,
        fontSize: 20,
        text: title
    }
};

function DataBlasting(label, blasting, pendaftar, user, blasting_dikirim, blasting_gagal) {
    this.labels = label,
    this.datasets = [
        {
          label: "Pendaftar Kegiatan",
          type: "line",
          borderColor: "#3e95cd",
        //   backgroundColor: "rgba(0,0,0,0.6)",
        pointBackgroundColor: "white",
          data: pendaftar,
          fill: false
        }, {
          label: "User",
          type: "line",
          borderColor: "rgba(0,0,0,1)",
          backgroundColor: "rgba(0,0,0,1)",
          data: user,
          fill: false
        }, {
          label: "Target Blasting",
          type: "bar",
          backgroundColor: "rgba(230, 77, 0, 0.5)",
          backgroundColorHover: "#3e95cd",
          data: blasting
        }, {
          label: "Blasting Dikirim",
          type: "bar",
          backgroundColor: "rgba(0, 0, 123, 0.9)",
          backgroundColorHover: "#3e95cd",
          data: blasting_dikirim
        }, {
          label: "Blasting Tidak Dikirim",
          type: "bar",
          backgroundColor: "rgba(255, 23, 0, 0.9)",
          backgroundColorHover: "#3e95cd",
          data: blasting_gagal
        },
    ]
}

function DataDetail(label, target, dikirim, diklik, diklik2, didaftar, gagal) {
    this.labels = label,
    this.datasets = [
        {
          label: "Target Blasting",
          backgroundColor: "blueviolet",
          data: target,
        },
        {
          label: "Blasting Dikirim",
          backgroundColor: "springgreen",
          data: dikirim,
        },
        {
          label: "Blasting Tidak Dikirim",
          backgroundColor: "red",
          data: gagal,
        },
        {
          label: "Link Blasting Di-klik",
          backgroundColor: "brown",
          data: diklik,
        },
        {
          label: "Klik Lebih dari Sekali",
          backgroundColor: "orange",
          data: diklik2,
        },
        {
          label: "Pendaftar dari Link",
          backgroundColor: "chrimson",
          data: didaftar,
        },
    ]
}


// function DataBlasting(label, blasting, pendaftar) {
//     this.labels = labels,
//     this.datasets = [
//         {}
//     ]
// }


$(document).ready(function () {
    //
    var ctx = document.getElementById('blasting').getContext('2d');
    chartBlasting = new Chart(ctx, {
        type: 'bar',
        data: new DataBlasting(label, detail_blasting, peserta, user, dikirim, gagal),
        options: new ChartOption( "Grafik Aktivitas Kegiatan" ),
    });
    var ctx2 = document.getElementById('detail').getContext('2d');
    chartDetail = new Chart(ctx2, {
        type: 'bar',
        data: new DataDetail(['Detail Blasting'],  [blasting_target], [blasting_dikirim] , [blasting_diklik.toString()],[blasting_diklik2.toString()],  [blasting_didaftar.toString()], [blasting_gagal.toString()]),
        options: new ChartOption( "Grafik Detail Blasting" ),
    });
    // var ctx = document.getElementById('info').getContext('2d');
    // chartInfo = new Chart(ctx, {
    //     type: 'line',
    //     data: new LineData(user_lama,user_baru, peserta_baru, jam),
    //     options: new lineoptions([ "Grafik Pendaftar Kegiatan", "{{\Carbon\Carbon::today()->format('d F Y')}}" ]),
    // });
});
</script>
@endpush
