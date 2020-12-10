@extends('frontend.main')

@section('content')
<style>
    .customTable thead {
        background-color: #b7d0ed;
    }

    th {
        text-align: center !important;
    }

    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        table.dataTable>tbody>tr.child {
            padding: 0px 0px;
        }
    }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<script>
    FontAwesomeConfig = {
        autoReplaceSvg: false
    }
</script>
<div class="container-fluid" id="content">
    @if(session()->get('success'))
    <div class="alert alert-success"> {{ session()->get('success') }}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    @endif
    @if(session()->get('warning'))
    <div class="alert alert-warning"> {{ session()->get('warning') }}
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    @endif
    <h2>Riwayat Pembayaran {{$peserta->nama}}</h2>
    <hr>
    <table class="table table-striped table-bordered dataTable datatable customTable" style="width:100%">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th style="width:65%;">Nama Kegiatan</th>
                <th style="width:20%;">Jenis Pembayaran</th>
                <th style="width:20%;">No Transaksi</th>
                <th style="width:10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran as $key)
            <tr>
                <input type="hidden" class="token" value="{{$key->token}}">
                <td style="text-align: center">{{ $loop->iteration}}</td>
                <td>
                    {{
                        strip_tags( isset($key->peserta_seminar_r) ?
                            ( isset($key->peserta_seminar_r->seminar_p) ?
                                $key->peserta_seminar_r->seminar_p->tema :
                            '' ) :
                        '' )
                    }}
                </td>
                <td>Fee Pendaftaran</td>
                <td style="text-align: center">{{ $key->no_transaksi}}</td>
                {{-- <td>{{ $key->status }}</td> --}}
                <td style="text-align: center">
                    <button class="btn btn-sm btn-outline-success payButton">
                        Menunggu Pembayaran
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script
      type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{config('services.midtrans.clientKey')}}"
></script>
<script>
    $(document).ready(function () {
        $('.datatable').DataTable();
    });
    $('.payButton').on('click', function(e) {
        e.preventDefault();
        let tr = $(this).closest('tr');
        let token = $(tr).find('.token')[0].value;
        // console.log(token);
        snap.pay(token);

    });
</script>
@endpush
