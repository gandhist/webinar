@extends('templates.header')

@section('content')
<style>
  .line {
  height:250px;
  overflow-y: auto;
}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Feedback Seminar
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li class="active"><a href="#"> Seminar</a></li>
        <li class="active"><a href="#"> Feedback</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">

      <div class="box-body">
        <h3>{{ $respons }} responses</h3>
        {{-- {{ $feedback_rating }} --}}
        <br>
        <div class="row">
          <div class="col-lg-12 card">
          <label for="seminar" class="label-control"><b>Penilaian untuk penyelenggara secara keseluruhan?</b></label>

          <div class="row">
            <canvas id="myChart" width="400" height="400"></canvas>
          </div>

          </div>
        </div>
        <hr>
        @foreach($narasumber as $n)
        <div class="row">
          <div class="col-lg-12 card">
          <label for="seminar" class="label-control"><b>Penilaian untuk {{$n->peserta_r->nama}} secara keseluruhan?</b></label>

          <div class="row">
            <canvas id="narasumber-{{$n->id_peserta}}" width="400" height="400"></canvas>
          </div>

          </div>
        </div>
        @endforeach
        <hr>
        @foreach($moderator as $m)
        <div class="row">
          <div class="col-lg-12 card">
          <label for="seminar" class="label-control"><b>Penilaian untuk {{$m->peserta_r->nama}} secara keseluruhan?</b></label>

          <div class="row">
            <canvas id="moderator-{{$m->id_peserta}}" width="400" height="400"></canvas>
          </div>

          </div>
        </div>
        @endforeach
        <hr>
        <div class="row">
          <div class="col-lg-12 card">
          <label for="kesan_pesan" class="label-control"><b>Kesan & Pesan untuk Penyelenggara, Pengantar Diskusi, Narasumber, dan Moderator?</b></label>

          <div class="row">
            <div class="col-md-6 line">
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
          <label for="keterangan" class="label-control"><b>Apakah ada topik yang dipandang penting dan perlu untuk diangkat dalam webinar selanjutnya? </b></label>

          <div class="row">
            <div class="col-md-6 line">
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

    </div> {{-- Box-Content --}}


</section>

@endsection

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk'],
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
              'rgba(54, 162, 235, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(255, 99, 132, 0.2)'

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
        scales: {

        }
    }
});

@foreach($narasumber as $n)
    var ctx = document.getElementById('narasumber-'+{{$n->id_peserta}}).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk'],
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
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 99, 132, 0.2)',

                ],
                borderColor: [
                  'rgba(54, 162, 235, 0.2)',
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
            scales: {

            }
        }
    });
@endforeach

@foreach($moderator as $m)
    var ctx = document.getElementById('moderator-'+{{$m->id_peserta}}).getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Sangat Baik', 'Baik', 'Cukup Baik', 'Buruk', 'Sangat Buruk'],
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
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 99, 132, 0.2)'

                ],
                borderColor: [
                  'rgba(54, 162, 235, 0.2)',
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
            scales: {

            }
        }
    });
@endforeach
</script>
@endpush
