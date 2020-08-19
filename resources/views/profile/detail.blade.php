@extends('frontend.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container" id="content">
    <div class="box box-content">
        <div class="box-body">
            <h2 text-align="center">Detail Seminar</h2>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Title</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->nama_seminar }}">
                    </div>
                </div>										
            </div>   

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Tema</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ strip_tags(html_entity_decode($data->tema)) }}">
                    </div>
                </div>										
            </div> 

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Narasumber</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly 
                        value="@foreach($data->seminar_r as $index => $key)@if(count($data->seminar_r) > $index + 1){{ $key->peserta_r->nama }} -@else{{ $key->peserta_r->nama }}@endif @endforeach">
                    </div>
                </div>										
            </div> 

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Nilai SKPK</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->skpk_nilai }}">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Biaya</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="@if ($data->is_free == '0') Gratis @else Rp {{ format_uang($data->biaya)}} @endif">
                    </div>
                </div>										
            </div> 

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Tempat</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->lokasi_penyelenggara }}">
                    </div>
                </div>	
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Tanggal & Waktu</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ isset($data->tgl_awal) ? \Carbon\Carbon::parse($data->tgl_awal)->isoFormat("DD MMMM YYYY") : '' }} / {{ $data->jam_awal }} - {{ $data->jam_akhir }}">
                    </div>
                </div>										
            </div> 

      
            {{-- <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Contact Person 1</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->cp_1_nama }} ({{ $data->cp_1_no }})">
                    </div>
                </div>	
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Contact Person 2</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->cp_2_nama }} ({{ $data->cp_2_no }})">
                    </div>
                </div>	
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="inputSuccess"> Contact Person 3</label>
                        <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $data->cp_3_nama }} ({{ $data->cp_3_no }})">
                    </div>
                </div>										
            </div>  --}}

            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ url('profile') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
                </div>										
            </div> 

        </div> 
    </div> 
</div>

@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
<script>

</script>
@endpush