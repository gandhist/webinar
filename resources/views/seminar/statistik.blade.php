@extends('templates.header')

@section('content')

<div class="loading">Loading&#8230;</div>
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<style>
    form label.required:after {
        color: red;
        content: " *";
    }

    table.dataTable tbody td {
        padding: 0.2rem 0.5rem;
    }
    /* Absolute Center Spinner */
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: visible;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.3);
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
    /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

</style>

<!-- Content Header (Page header) -->

<section class="content-header">
    <h1>
        Statistik Kegiatan PPKB ({{ $seminar->nama_seminar." - ".\Carbon\Carbon::parse($seminar->tgl_awal)->format("d M Y")}})
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Detail</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">

        <div class="container-fluid" style="min-height:90vh;">
            <div class="jumbotron"  style='padding-top:15px; min-height:90vh;'>
                <div class="btn-group">
                    <span class="form-group">
                        <input type="text" style="padding-bottom:5px;" name="tgl_awal" id="tgl_awal" autocomplete="off" value="{{ request()->get('tgl_awal') }}" placeholder="Tanggal Awal">

                        <span style="margin: 10px;"> s/d </span>

                        <input type="text" style="padding-bottom:5px;" name="tgl_akhir" id="tgl_akhir" autocomplete="off" value="{{ request()->get('tgl_akhir') }}" placeholder="Tanggal Akhir">

                        <button class="btn btn-info btn-bermargin" id="btnFilter" name="btnFilter">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <button class="btn btn-success btn-bermargin" id="btnReset" name="btnReset">
                        <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                        </button>
                        {{-- <a href="{{ url('seminar') }}" class="btn btn-sm btn-default"> <i
                            class="fa fa-refresh"></i>
                        Reset</a> --}}

                        {{-- https://datatables.net/examples/plug-ins/range_filtering.html --}}

                    </span>
                </div>

                <div class="row">
                    <div class="col-md-12" style="text-align: center; margin-top:2rem">
                        <h2>Statistik pendaftaran App PPKB P3SM Online</h2>
                        <p> <b>{{$seminar->nama_seminar}} - {{strip_tags(html_entity_decode($seminar->tema))}}</b> </p>
                    </div>
                    <div class="col-md-6 chart-container" style="min-height:50vh;">
                        <canvas id="chart" style="height:50vh; ; width:100%"></canvas>
                    </div>
                    <div class="col-md-6 chart-container" style="min-height:50vh;">
                        <canvas id="chart2" style="height:50vh; ; width:100%"></canvas>
                    </div>
                </div>

                <div class="row" style="margin-top: 1rem">
                    <div class="col-md-12" style="text-align: center">
                        <h2>Tabel Pendaftar Seminar</h2>
                    </div>
                    <div class="col-md-12">
                        <table id="pendaftar" class="cell-border" style="width:100%; background-color: #BCBCBC; border: 1px solid black;">
                            <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Hp</th>
                                <th>Waktu Pendaftaran</th>
                            </thead>
                            <tbody>
                                @foreach($peserta_seminar_baru as $key)
                                    <tr>
                                        <td style='text-align:center;'>{{ $loop->iteration}}</td>
                                        <td>{{$key->peserta->nama}}</td>
                                        <td>{{$key->peserta->email}}</td>
                                        <td>{{$key->peserta->no_hp}}</td>
                                        <td>{{\Carbon\Carbon::parse($key->created_at)->format('d F Y h:m')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div> {{-- Jumbotron --}}
      </div> {{-- Container-fluid --}}
    </div> {{-- Box-Content --}}

</section>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.28.0/moment.min.js" integrity="sha512-Q1f3TS3vSt1jQ8AwP2OuenztnLU6LwxgyyYOG1jgMW/cbEMHps/3wjvnl1P3WTrF3chJUWEoxDUEjMxDV8pujg==" crossorigin="anonymous"></script>
<script>
    var peserta_baru = @json($data_peserta_seminar);
    var user_baru = @json($data_user_baru);
    var user_lama = @json($data_user_lama);

    var total_user_keseluruhan = @json($total_user_keseluruhan);
    var jam = [
            "00.00",
            "01.00", "02.00", "03.00", "04.00", "05.00", "06.00", "07.00", "08.00", "09.00", "10.00", "11.00", "12.00",
            "13.00", "14.00", "15.00", "16.00", "17.00", "18.00", "19.00", "20.00", "21.00", "22.00", "23.00", "24.00",
        ]

    function LineData(user_lama, user_baru, peserta_baru, labels) {
        this.labels = labels,
        this.datasets = [

            {
                label: "Pendaftar Dengan Akun",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(225,0,0,0.4)",
                borderColor: "blue", // The main line color
                borderCapStyle: 'square',
                borderDash: [], // try [5, 15] for instance
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "black",
                pointBackgroundColor: "green",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "white",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 4,
                pointHitRadius: 10,
                // notice the gap in the data and the spanGaps: true
                data: user_lama,
                spanGaps: true,
            },
            {
                label: "User Baru",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(225,0,0,0.4)",
                borderColor: "red", // The main line color
                borderCapStyle: 'square',
                borderDash: [], // try [5, 15] for instance
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "black",
                pointBackgroundColor: "white",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "yellow",
                pointHoverBorderColor: "brown",
                pointHoverBorderWidth: 2,
                pointRadius: 4,
                pointHitRadius: 10,
                // notice the gap in the data and the spanGaps: true
                data: user_baru,
                spanGaps: true,
            }, {
                label: "Pendaftar",
                fill: true,
                lineTension: 0.1,
                backgroundColor: "rgba(167,105,0,0.4)",
                borderColor: "rgb(167, 105, 0)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "white",
                pointBackgroundColor: "black",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "brown",
                pointHoverBorderColor: "yellow",
                pointHoverBorderWidth: 2,
                pointRadius: 4,
                pointHitRadius: 10,
                // notice the gap in the data and the spanGaps: false
                data: peserta_baru,
                spanGaps: true,
            }
        ]

    };
    function lineoptions(title) {
        this.scales = {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'P3S Mandiri',
                            fontSize: 20
                        }
                    }]
                }
        this.title = {
            display: true,
            text: title
        }
    };
    function LineData2( total, labels) { //user_baru,
        this.labels = labels,
        this.datasets = [
            // {
            //     label: "User Baru",
            //     fill: false,
            //     lineTension: 0.1,
            //     backgroundColor: "rgba(225,0,0,0.4)",
            //     borderColor: "red", // The main line color
            //     borderCapStyle: 'square',
            //     borderDash: [], // try [5, 15] for instance
            //     borderDashOffset: 0.0,
            //     borderJoinStyle: 'miter',
            //     pointBorderColor: "black",
            //     pointBackgroundColor: "white",
            //     pointBorderWidth: 1,
            //     pointHoverRadius: 8,
            //     pointHoverBackgroundColor: "yellow",
            //     pointHoverBorderColor: "brown",
            //     pointHoverBorderWidth: 2,
            //     pointRadius: 4,
            //     pointHitRadius: 10,
            //     // notice the gap in the data and the spanGaps: true
            //     data: user_baru,
            //     spanGaps: true,
            // },
            {
                label: "User Keseluruhan",
                fill: true,
                lineTension: 0.1,
                backgroundColor: "rgba(13, 122, 124, 0.4)",
                borderColor: "rgb(13, 122, 124)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "white",
                pointBackgroundColor: "black",
                pointBorderWidth: 1,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: "brown",
                pointHoverBorderColor: "yellow",
                pointHoverBorderWidth: 2,
                pointRadius: 4,
                pointHitRadius: 10,
                // notice the gap in the data and the spanGaps: false
                data: total,
                spanGaps: true,
            }
        ]

    };
    function lineoptions2(title) {
        this.scales = {
                    yAxes: [{
                        ticks: {
                            beginAtZero:false
                        },
                        scaleLabel: {
                            display: true,
                            labelString: 'P3S Mandiri',
                            fontSize: 20
                        }
                    }]
                }
        this.title = {
            display: true,
            text: title
        }
    };


    $(document).ready(function() {
        $(".loading").hide();
        $('#pendaftar').DataTable( {
            // "scrollY":        "1000px",
            "scrollCollapse": true,
            "paging":         true,
            lengthMenu: [100,200,500,1000,2000,5000,10000]
        } );

        var ctx = document.getElementById('chart').getContext('2d');
        myLineChart = new Chart(ctx, {
            type: 'line',
            data: new LineData(user_lama,user_baru, peserta_baru, jam),
            options: new lineoptions([ "Grafik Pendaftar Kegiatan", "{{\Carbon\Carbon::today()->format('d F Y')}}" ]),
        });

        var ctx2 = document.getElementById('chart2').getContext('2d');
        myLineChart2 = new Chart(ctx2, {
            type: 'line',
            data: new LineData2( total_user_keseluruhan, jam), // total_user_baru
            options: new lineoptions2([ "Grafik Pengguna App PPKB P3S Mandiri Online", "{{\Carbon\Carbon::today()->format('d F Y')}}" ]),
        });

    } );

    $("#tgl_awal").datepicker({
        format: 'dd/mm/yyyy',
        startDate: '{{\Carbon\Carbon::parse($seminar->created_at)->format("d/m/Y")}}',
        endDate: '+1d',
        datesDisabled: '+1d',
    });
    $("#tgl_akhir").datepicker({
        format: 'dd/mm/yyyy',
        startDate: '{{\Carbon\Carbon::parse($seminar->created_at)->format("d/m/Y")}}',
        endDate: '+1d',
        datesDisabled: '+1d',
    });


    // Cache Warna Filter
    if ("{{request()->get('tgl_awal')}}" != "") {
            inputFilterCache("tgl_awal");
        }
        if ("{{request()->get('tgl_akhir')}}" != "") {
            inputFilterCache("tgl_akhir");
    }

    // Rubah Warna Filter
    inputFilter("tgl_awal");
    inputFilter("tgl_akhir");

    // Fungsi Rubah warna filter
    function inputFilter(name) {
        $('#' + name).on('change', function () {
            idfilter = $(this).attr('id');
            if ($(this).val() == '') {
                $(this).css('background-color', 'transparent');
                $(this).css('font-weight', 'unset');
            } else {
                $(this).css('background-color', '#b6f38f');
                $(this).css('font-weight', 'bold');
            }
        });
    }

    // Fungsi merubah Cache warna filter input biasa
    function inputFilterCache(name){
        $('#'+name).css('background-color', '#b6f38f');
        $('#'+name).css('font-weight', 'bold');
    }

    // Fungsi Reset
    $('#btnReset').on('click', function() {
        $("#tgl_awal").val(null);
        $("#tgl_awal").css('background-color', 'unset');
        $("#tgl_awal").css('font-weight', 'unset');
        $("#tgl_akhir").val(null).css('background-color', 'unset').css('font-weight', 'unset');
        // myLineChart.clear();
    });

    $('#btnFilter').on('click', function() {
        // myLineChart.clear();
        // $("#pendaftar").dataTable().fnClearTable();
        // $('#chart').remove();
        // $('#chart-container').append('<canvas id="chart"></canvas>');
        var awal = $('#tgl_awal').val();
        var akhir = $('#tgl_akhir').val();
        $.ajax({
            type: "GET",
            url: '{{url("/statseminarfunc",$id)}}',
            data : {
                "_token": "{{ csrf_token() }}",
                "tgl_awal":  awal,
                "tgl_akhir":  akhir
            },
            success: function (data) {
                // write your code
                // console.log(data['user']);
                // console.log(data['peserta']);
                myLineChart.destroy();
                $("#pendaftar").dataTable().fnClearTable();
                $("#pendaftar>tbody").empty();
                if(data['type'] === 1){
                    var ctx = document.getElementById('chart').getContext('2d');
                    myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: new LineData(data['user_lama'],data['user'], data['peserta'], jam),
                        options: new lineoptions([ "Grafik Pendaftar Kegiatan", data['tgl'] ]),
                    });

                    $(function() {
                        $.each(data['detail'], function(i, item) {
                            var $tr = $('<tr>').append(
                                $('<td>').text(i+1),
                                $('<td>').text(item[0]),
                                $('<td>').text(item[1]),
                                $('<td>').text(item[2]),
                                $('<td>').text(item[3])
                            );
                            $tr.appendTo('#pendaftar');
                            // console.log($tr.wrap('<p>').html());
                        });
                    });
                } else if (data['type'] === 2) {
                    var ctx = document.getElementById('chart').getContext('2d');
                    myLineChart = new Chart(ctx, {
                        type: 'line',
                        data: new LineData(data['user_lama'], data['user'], data['peserta'], data['label']),
                        options: new lineoptions([ "Grafik Pengguna App PPKB P3S Mandiri", data['tgl'][0]+' - '+data['tgl'][1] ]),
                    });
                    $(function() {
                        $.each(data['detail'], function(i, item) {
                            var $tr = $('<tr>').append(
                                $('<td>').text(i+1),
                                $('<td>').text(item[0]),
                                $('<td>').text(item[1]),
                                $('<td>').text(item[2]),
                                $('<td>').text(item[3])
                            );
                            $tr.appendTo('#pendaftar');
                            // console.log($tr.wrap('<p>').html());
                        });
                    });
                }
            },
            error: function (data) {
                // write your code
                // console.log(data);
                Swal.fire({
                    title: data['responseJSON']['errors'],
                    type: 'warning',
                    confirmButtonText: 'Close',
                    confirmButtonColor: '#AAA'
                });
                // console.log(data['error'][0][0]);
            }
        });
    });

    $(document).ajaxStart(function(){
        // Show image container
        $(".loading").show();
    });
    $(document).ajaxComplete(function(){
        // Hide image container
        $(".loading").hide();
    });
</script>
@endpush
