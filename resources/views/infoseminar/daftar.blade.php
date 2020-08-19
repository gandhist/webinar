@extends('frontend.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container-fluid" id="content">
    <div class="box box-content">
        <div class="row">
            <div class="col-lg-9">
                <form action="{{ url('infoseminar/store', $data->id) }}" class="form-horizontal" id="formAdd" name="formAdd" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <h2 text-align="center">Pendaftaran Seminar P3SM</h2>
                        <p>{{ strip_tags(html_entity_decode($data->tema)) }}</p>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> Nama</label>
                                <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->nama }}">
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> Email</label>
                                <input type="text" class="form-control" id="inputSuccess" readonly value="{{$user->peserta->email }}">
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> No HP</label>
                                <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->no_hp }}">
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> Pekerjaan</label>
                                <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->pekerjaan }}">
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> Instansi</label>
                                <input type="text" class="form-control" id="inputSuccess" readonly value="{{ $user->peserta->instansi }}">
                                </div>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> Biaya Investasi</label>
                                <input type="text" class="form-control" id="inputSuccess" readonly value="@if ($data->is_free == '0') Gratis @else Rp {{ format_uang($data->biaya)}} @endif">
                                </div>
                            </div>
            
                            @if ($data->is_free == '0')
                            @else
                            <div class="col-sm-6">
                                {{-- <div class="form-group">
                                    <label class="control-label" for="inputSuccess"> Metode Pembayaran</label>
                                    <select class="form-control select2" name="id_nama_bank" id="id_nama_bank" style="width: 100%;" placeholder="Nama Bank">
                                        <option value="" disabled selected>Nama Bank</option>
                                        @foreach($bank as $key)
                                        <option value="{{ $key->id_bank }}" {{ $key->id_bank == old('id_nama_bank') ? 'selected' : '' }}>{{ $key->Nama_Bank }} </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="custom-file">
                                    <label for="instansi">Upload Bukti Pembayaran</label>
                                    <div class="custom-file">
                                      <input accept=".jpeg,.jpg,.pdf,.png,.gif,.svg" type="file" id="bukti_bayar" name="bukti_bayar" class="custom-file-input {{ $errors->first('bukti_bayar') ? 'is-invalid' : '' }}" id="validatedCustomFile" required>
                                      <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                    </div>
                                  </div>
                            </div>
                            @endif
                        </div>
            
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ url('infoseminar') }}" class="btn btn-md btn-danger pull-left"><i class="fa fa-times-circle"></i> Batal</a>
                                <button type="submit" class="btn btn-info pull-right"> <i class="fa fa-check-circle"></i> Daftar</button>
                                <a target="_blank" href="{{ url($data->link) }}" class="btn btn-outline-primary my-2 my-sm-0" data-toggle="tooltip"
                                    data-placement="top" title="Lihat Brosur">Brosur</a>
                            </div>
                        </div>
                    </div>
                    </form>
            </div>
            <div class="col-lg-3">
                <div class="box-body">
                    <h2 text-align="center" onclick="location.href='{{ url($data->link) }}'">Brosur Seminar</h2>
                    <img src="{{ url($data->link) }}" onclick="location.href='{{ url($data->link) }}'" class="rounded img-fluid" alt="Brosur"> 
                </div>
            </div>
        </div>   
    </div>
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
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>
{{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{$clientKey}}"></script> --}}
<script>
    $(document).ready(function() {
        $('#btnDaftar').on('click', function(e) {
            e.preventDefault();

            // is_free = {{$data->is_free}};
            // console.log(is_free);
            snap.pay('{{$snapToken}}', {
                // Optional
                onSuccess: function(result){
                    console.log('sukses :');
                    console.log(result);
                    //* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result){
                    console.log('pending :');
                    console.log(result);
                    //* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result){
                    console.log('werror :');
                    console.log(result);
                    //* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        });
    });

</script>
@endpush
