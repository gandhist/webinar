@extends('templates.header')

@section('content')
<section class="content-header">
    <h1>
        Import Peserta
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"> Daftar</a></li>
        <li><a href="#"> Peserta</a></li>
        <li class="active"><a href="#"> Import</a></li>
    </ol>
</section>

<!-- Main content -->
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-content">
        <div class="box-tools pull-right" style="margin-top:32px; margin-right:35px;">

            <div class="row">
                <div class="col-12">
                    <div style="margin-bottom:10px">
                        <a href="{{ url('import-p3sm.xlsx') }}" class="btn btn-info">
                            <i class="fa fa-save"></i> Download Template Import</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body"style="margin:25px;">

            <div class="row">
                <h1 style="margin-bottom:50px;">Upload File Import</h1>

                <div class="col-12">
                    @if(session()->get('pesan'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session()->get('pesan') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>

                <form method="POST" action="{{ url('import') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- Seminar --}}
                    <div class="col-md-6">
                        <div class="form-group {{ ($errors->first('seminar')) ? ' has-error' : '' }}">
                            <label class="label-control required" for="seminar">Pilih Seminar</label>

                            <select required
                            class="form-control" id="seminar" name="seminar">
                                @if(old('seminar'))
                                    @foreach($seminar as $key)
                                        <option value="{{$key->id}}"
                                            {{old('seminar') == $key->id ? 'selected' : ''}}>
                                            {{$key->nama_seminar}}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" selected hidden>Pilih Seminar</option>
                                    @foreach($seminar as $key)
                                        <option value="{{$key->id}}">
                                            {{$key->nama_seminar}}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <div id="seminar" class="invalid-feedback text-danger">
                                {{ $errors->first('seminar') }}
                            </div>
                        </div>
                    </div>
                    {{-- Akhir Seminar --}}

                    {{-- File Import --}}
                    <div class="col-md-6">
                        <div class="form-group  {{ ($errors->first('file')) ? ' has-error' : '' }}">
                            <div class="custom-file">
                                <label class="label-control required" for="file">File Import</label>
                                <div class="custom-file">
                                    <input type="file" id="file" name="file" class="custom-file-input" id="file" required>
                                    <div id="file" class="invalid-feedback text-danger">
                                        {{ $errors->first('file') }}
                                    </div>
                                </div>
                            </div>
                            <small class="form-text text-muted">Upload Max: 2MB</small><br/>
                            <small class="form-text text-danger">Upload file (.xlsx) sesuai template yang disediakan</small><br/>
                        </div>
                    </div>
                    {{-- Akhir File Import --}}

                </div>

                <div class="small text-danger">*) Wajib diisi</div>
                <button type="submit" class="btn btn-success" style="margin-top:20px;">Import</button>

                </form>
            </div>
        </div>
    </div>
</section>

@endsection
{{-- XLSX --}}

@push('script')
    <script>
        $('#seminar').select2();
    </script>
@endpush
