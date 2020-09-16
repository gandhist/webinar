@extends('templates.header')

@section('content')
<style>
    .chart-container {
        /* border: 3px solid black; */
        margin-top : 3rem;
        margin-bottom: 6rem;
        box-shadow: 5px 5px 25px;
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
                    <h2>Statistik Blasting App PPKB P3SM Online</h2>
                    <p> <b>{{$seminar->nama_seminar}} - {{strip_tags(html_entity_decode($seminar->tema))}}</b> </p>
                </div>
                <div class="col-md-12 chart-container" style="height:50vh;">
                    <canvas id="blasting" style="height:50vh; ; width:100%"></canvas>
                </div>
                <div class="col-md-12 chart-container" style="height:50vh;">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="detail" style="height:50vh; ; width:100%"></canvas>
                        </div>
                        <div class="col-md-6">
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

var blasting_target = @json($blasting->jumlah_target);
var blasting_dikirim = @json($blasting->jumlah_kirim);
var blasting_diklik = @json($blasting_diklik);
var blasting_didaftar = @json($blasting_didaftar);

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

function DataBlasting(label, blasting, pendaftar, user, blasting_dikirim) {
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
          backgroundColor: "rgba(230, 77, 0, 0.9)",
          backgroundColorHover: "#3e95cd",
          data: blasting_dikirim
        },
    ]
}

function DataDetail(label, target, dikirim, diklik, didaftar) {
    this.labels = label,
    this.datasets = [
        {
          label: "Target Blasting",
          backgroundColor: "rgba(0,0,0,0.6)",
          data: target,
        },
        {
          label: "Blasting Dikirim",
          backgroundColor: "rgba(0,0,0,0.6)",
          data: dikirim,
        },
        {
          label: "Link Blasting Di-klik",
          backgroundColor: "rgba(0,0,0,0.6)",
          data: diklik,
        },
        {
          label: "Pendaftar Melalui Blasting",
          backgroundColor: "rgba(0,0,0,0.6)",
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
        data: new DataBlasting(label, detail_blasting, peserta, user, dikirim),
        options: new ChartOption( "Grafik Aktivitas Kegiatan" ),
    });
    var ctx2 = document.getElementById('detail').getContext('2d');
    chartDetail = new Chart(ctx2, {
        type: 'bar',
        data: new DataDetail(['Detail Blasting'],  [blasting_target], [blasting_dikirim] , [blasting_diklik.toString()],  [blasting_didaftar.toString()]),
        options: new ChartOption( "Grafik Pendaftar Kegiatan" ),
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
