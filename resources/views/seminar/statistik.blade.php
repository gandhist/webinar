@extends('templates.header')

@section('content')

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet">

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

<style>
    form label.required:after {
        color: red;
        content: " *";
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Statistik Seminar
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
                        <input type="text" style="padding-bottom:5px;" name="tgl_awal" id="tgl_awal" value="{{ request()->get('tgl_awal') }}" placeholder="Tanggal Awal">

                        <span style="margin: 10px;"> s/d </span>

                        <input type="text" style="padding-bottom:5px;" name="tgl_akhir" id="tgl_akhir" value="{{ request()->get('tgl_akhir') }}" placeholder="Tanggal Akhir">

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
                        <h2>Statistik pendaftaran seminar</h2>
                        <p> <b>{{$seminar->nama_seminar}} - {{strip_tags(html_entity_decode($seminar->tema))}}</b> </p>
                    </div>
                    <div class="col-md-12 chart-container" style="min-height:50vh;">
                        <canvas id="chart" style="height:50vh; ; width:100%"></canvas>
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
<script>
    var peserta_baru = @json($data_peserta_seminar);
    var user_baru = @json($data_user_baru);

    $(document).ready(function() {
        $('#pendaftar').DataTable( {
            // "scrollY":        "1000px",
            "scrollCollapse": true,
            "paging":         true,
            lengthMenu: [10,20,50,100]
        } );

        var data = {
            labels: [
                "00.00",
                "01.00", "02.00", "03.00", "04.00", "05.00", "06.00", "07.00", "08.00", "09.00", "10.00", "11.00", "12.00",
                "13.00", "14.00", "15.00", "16.00", "17.00", "18.00", "19.00", "20.00", "21.00", "22.00", "23.00", "24.00",
            ],
            datasets: [
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
                    label: "Pendaftar Seminar",
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
        var options = {
            scales: {
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
                    },
            title: {
                display: true,
                text: '{{\Carbon\Carbon::today()->format("d F Y")}}'
            }
        };

        var ctx = document.getElementById('chart').getContext('2d');
        myLineChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options,
        });


    } );

    $("#tgl_awal").datepicker();
    $("#tgl_akhir").datepicker();

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
        $.ajax({
            type: "GET",
            url: '{{url("/statseminarfunc")}}',
            data : {
                "_token": "{{ csrf_token() }}",
                "tgl_awal": $("#tgl_awal").val(),
                "tgl_akhir": $("#tgl_akhir").val(),
            },
            success: function (data) {
                // write your code
                console.log(data);
                myLineChart.destroy();
                $("#pendaftar").dataTable().fnClearTable();
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
</script>
@endpush
