@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Buat Laporan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Laporan</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-content">
        <div class="box-body">
            @if(session()->get('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}  
            </div>
            @endif

            {{--  table data Seminar  --}}
            <div>
              <h3>Buat Laporan ISO</h3>
              <form id="formAdd" name="formAdd" method="POST">
              
              <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Laporan 1</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">Laporan 2</a></li>
                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Laporan 3</a></li>
                      </ul>
                      <div class="tab-content">

                        <div class="tab-pane active" id="tab_1">
                            <h3>Audit Report</h3>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                @foreach($status as $key)
                                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Reseller?</label>
                                            <select name="reseller" id="reseller" class="form-control">
                                                    <option value="0">Tidak </option>
                                                    <option value="1">Ya </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Organization</label>
                                            <input name="nama_bu" id="nama_bu" type="text" class="form-control" placeholder="Organization">
                                            <span id="nama_bu" class="help-block" >{{ $errors->first('nama_bu') }} </span> 
                                          </div>
                          
                                          <div class="form-group">
                                            <label>Address</label>
                                            <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Address"></textarea>
                                            <span id="alamat" class="help-block" >{{ $errors->first('alamat') }} </span> 

                                          </div>
                                          <div class="form-group">
                                                <select name="id_negara" class="form-control select2" id="id_negara" style="width: 100%;">
                                                    <option></option>
                                                    @foreach($negara as $key)
                                                    <option {{ $key->id == '102' ? 'selected' : '' }} value="{{ $key->id }}">{{ $key->country_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="id_negara" class="help-block customspan"> {{ $errors->first('id_negara') }}</span>
                                            </div>

                                          <div class="form-group">
                                                <select name="id_prov" class="form-control select2" id="id_prov" style="width: 100%;">
                                                    <option></option>
                                                    @foreach($provinsi as $key)
                                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="id_prov" class="help-block customspan"> {{ $errors->first('id_prov') }}</span>
                                            </div>

                                            <div class="form-group">
                                                <select name="id_kota" class="form-control select2" id="id_kota" style="width: 100%;">
                                                    <option></option>
                                                    @foreach($kota as $key)
                                                    <option value="{{ $key->id }}">{{ $key->nama }}</option>
                                                    @endforeach
                                                </select>
                                                <span id="id_kota" class="help-block customspan"> {{ $errors->first('id_kota') }}</span>
                                            </div>

                                          <div class="form-group">
                                            <label>ISO Standard</label>
                                            <select class="form-control" name="standard" id="standard">
                                                <option value="">Pilih ISO</option>
                                                @foreach($standard as $key)
                                                    <option value="{{ $key->id }}">{{ $key->kode }}</option>
                                                @endforeach
                                            </select>
                                            <span id="id_number" class="help-block" >{{ $errors->first('id_number') }} </span> 

                                        </div>
                                          
                                          {{-- <div class="form-group">
                                              <label>Id Number</label>
                                              <input name="id_number" id="id_number" type="text" class="form-control" placeholder="Id Number">
                                                <span id="id_number" class="help-block" >{{ $errors->first('id_number') }} </span> 

                                          </div> --}}
          
                                          <div class="form-group">
                                              <label>Visit Number</label>
                                              <input name="visit_number" id="visit_number" type="text" class="form-control" placeholder="Visit Number">
                                              <span id="visit_number" class="help-block" >{{ $errors->first('visit_number') }} </span> 
                                              
                                          </div>
          
                                          <div class="form-group">
                                              <label>Audit Date</label>
                                              <input name="tanggal" id="tanggal" type="date" class="form-control" placeholder="Audit Date">
                                              <span id="tanggal" class="help-block" >{{ $errors->first('tanggal') }} </span> 

                                          </div>
          
                                         
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Visit Type</label>
                                            <input name="visit_type" id="visit_type" type="text" class="form-control" placeholder="Visit Type">
                                            <span id="visit_type" class="help-block" >{{ $errors->first('visit_type') }} </span> 

                                        </div>

                                        <div class="form-group">
                                            <label>Company Representative</label>
                                            <input name="comp_rep" id="comp_rep" type="text" class="form-control" placeholder="Company Representative">
                                            <span id="comp_rep" class="help-block" >{{ $errors->first('comp_rep') }} </span> 

                                        </div>
        
                                        <div class="form-group">
                                            <label>Site Audited</label>
                                            <input name="site_audited" id="site_audited" type="text" class="form-control" placeholder="Site Audited">
                                            <span id="site_audited" class="help-block" >{{ $errors->first('site_audited') }} </span> 

                                        </div>
        
                                        <small>* <i>Untuk multi-situs audit, semua situs diaudit akan tercantum dalam lingkup audit atau dalam lampiran</i></small>
        
        
                                        <div class="form-group">
                                            <label>Lead Auditor</label>
                                            <input name="lead_auditor" id="lead_auditor" type="text" class="form-control" placeholder="Lead Auditor">
                                            <span id="lead_auditor" class="help-block" >{{ $errors->first('lead_auditor') }} </span> 
                                        </div>
        
                                        <div class="form-group">
                                            <label>Additional Team Members</label>
                                            <input name="additional_members" id="additional_members" type="text" class="form-control" placeholder="Site Audited">
                                            <span id="additional_members" class="help-block" >{{ $errors->first('additional_members') }} </span> 

                                        </div>
                                        <small>* <i>Untuk multi-situs audit, semua situs diaudit akan tercantum dalam lingkup audit atau dalam lampiran</i></small>
                        
                                    </div>
                                </div>
                                
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="tab_2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" >
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <b>1. Tujuan Audit</b> <br>
                                                Tujuan dari audit ini:
                                                <ul>
                                                    <li>Untuk mengkonfirmasi bahwa sistem manajemen sesuai dengan semua persyaratan standar.</li>
                                                    <li>Untuk mengkonfirmasi bahwa organisasi telah efektif menerapkan sistem manajemen yang telah direncanakan.</li>
                                                    <li>Untuk mengkonfirmasi bahwa manajemen mampu mencapai tujuan kebijakan organisasi</li>
                                                </ul>
                                            </li>
                                          <li class="list-group-item">
                                                <b>2. Ruang Lingkup Sertifikasi</b> <br>
                                                Audit mencakup : 

                                                <select style="width: 100%" class="form-control select2" id="scope" name="scope[]" multiple="multiple">
                                                    @foreach($scope as $key)
                                                    <option value="{{ $key->id }}">{{ $key->nama_id }}</option>
                                                    @endforeach
                                                </select> 

                                                <br>
                                                <small>Ini adalah audit multi-situs dan lampiran daftar semua situs yang relevan dan / atau lokasi terpencil telah ditetapkan (terlampir) dan setuju dengan klien</small></span> &nbsp &nbsp
                                                <select name="multi_situs" id="multi_situs">
                                                    <option value="ya">Yes</option>
                                                    <option value="tidak">No</option>
                                                </select>

                                          </li>
                                          <li class="list-group-item">
                                            <b>3. Temuan Audit Saat Ini Dan Solusi</b> <br>
                                            Tim audit melakukan audit proses berbasis berfokus pada aspek penting / resiko / tujuan diperlukan oleh standar. Metode audit yang dilakukan adalah wawancara, observasi kegiatan dan review dokumentasi catatan. <br>
                                            Struktur audit sudah sesuai dengan rencana audit dan matriks perencanaan audit yang disertakan sebagai lampiran laporan ringkasan. <br>
                                            Tim audit menyimpulkan bahwa organisasi 
                                            <select name="tas_1" id="tas_1">
                                                <option value="telah"> Telah</option>
                                                <option value="belum"> Belum</option>
                                            </select>
                                            ditetapkan dan dipelihara sistem manajemen sesuai dengan persyaratan standar dan menunjukkan kemampuan sistem untuk secara sistematis mencapai persyaratan yang disepakati untuk produk atau jasa dalam lingkup dan kebijakan organisasi dan tujuan. <br>
                                            Jumlah ketidak sesuaian diidentifikasi: 
                                            <b>
                                                <select name="tas_2" id="tas_2">
                                                    <option value="mayor"> Mayor</option>
                                                    <option value="minor"> Minor</option>
                                                </select>
                                            </b>
                                            <br>
                                            Oleh karena itu tim audit merekomendasikan bahwa, berdasarkan hasil dari audit dan keadaan sistem menunjukkan perkembangan dan kematangan, sertifikasi sistem manajemen menjadi: <br>
                                           
                                            <select name="tas_3" id="tas_3">
                                                <option value="diberikan"> Diberikan</option>
                                                <option value="lanjut"> Lanjut</option>
                                                <option value="rahasia"> Dirahasiakan</option>
                                                <option value="tangguh"> Ditangguhkan sampai tindakan korektif yang memuaskan</option>
                                            </select>
                                          </li>
                                          <li class="list-group-item">
                                            <b>4. Hasil Audit Sebelumnya (N/A)</b> <br>
                                            Hasil audit terakhir dari sistem ini telah ditinjau, khususnya untuk memastikan koreksi yang sesuai. <br>
                                            <select name="audit_sebelumnya" id="audit_sebelumnya">
                                                <option value="1"> Setiap ketidaksesuaian yang diidentifikasi selama audit sebelumnya telah diperbaiki dan tindakan perbaikan terus menjadi efektif.</option>
                                                <option value="2"> Sistem manajemen belum ditangani ketidaksesuaian yang diidentifikasi selama kegiatan audit sebelumnya dan isu tertentu telah kembali didefinisikan dalam bagian ketidaksesuaian laporan ini.</option>
                                                <option value="3"> Tidak ada Corrective Action Request (CAR) dari kunjungan sebelumnya untuk ditindaklanjuti.</option>
                                            </select>
                                            
                                          </li>
                                          <li class="list-group-item"> 
                                            <b>5. Temuan Audit</b> <br>
                                            Tim audit melakukan proses audit berdasarkan berfokus pada aspek yang signifikan / resiko / tujuan. Metode audit yang digunakan adalah wawancara, observasi kegiatan dan review dokumentasi dan catatan. <br>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Dokumentasi sistem manajemen memperlihatkan kesesuaian dengan persyaratan standar audit dan memberikan struktur yang memadai untuk mendukung implementasi dan pemeliharaan sistem manajemen.</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_1" value="1"><br>Yes</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_1" value="0"><br>No</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Organisasi telah menunjukkan implementasi yang efektif dan pemeliharaan / perbaikan sistem manajemen.</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_2" value="1"><br>Yes</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_2" value="0"><br>No</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Organisasi telah menunjukkan pembentukan dan pelacakan yang tepat sasaran dan terget kinerja kunci dan kemajuan dipantau terhadap prestasi mereka.</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_3" value="1"><br>Yes</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_3" value="0"><br>No</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Program audit internal telah sepenuhnya dilaksanakan dan menunjukkan efektifitas sebagai alat untuk mempertahankan dan meningkatkan sistem manajemen.</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_4" value="1"><br>Yes</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_4" value="0"><br>No</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Proses tinjauan manajemen memperlihatkan kemampuan untuk memastikan kesesuaian, kecukupan dan efektifitas sistem manajemen.</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_5" value="1"><br>Yes</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_5" value="0"><br>No</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="20" style=" padding:2px; border: 1px solid black; text-align: justify;">Selama proses audit, sistem manajemen keseluruhan memperlihatkan kesesuaian dengan persyaratan standar audit.</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_6" value="1"><br>Yes</td>
                                                        <td colspan="2" style=" border: 1px solid black; vertical-align: middle; text-align: center;"><input type="radio" class="Radio" name="ta_6" value="0"><br>No</td>
                                                    </tr>
                                                </table>
                                            </div>
                                          </li>
                                          <li class="list-group-item">
                                            <b>6. Significant Audit Trails Followed</b>  <br>
                                            Proses spesifik, kegiatan dan fungsi yang rinci dalam Matrix Perencanaan Audit dan Audit Plan. Dalam melakukan audit dan keterkaitan berbagai audit yang dikembangkan. Jalur audit diikuti, termasuk bukti obyektif dan pengamatan terhadap keseluruhan proses dan kontrol yang dicatat dalam "Catatan Audit" yang merupakan bagian dari paket sertifikasi permanen tetapi tidak disampaikan kepada klien.<br>
                                            Peluang untuk perbaikan serta pengamatan positif atau negatif khusus yang dijelaskan dibawah bagian 8 sementara ketidaksesuaian dicatat dalam lampiran "Permintaan Tindakan Korektif (CAR)"

                                          </li>
                                          <li class="list-group-item">
                                            <b>7. Ketidaksesuaian</b> <br>
                                            Ketidaksesuaian rinci dalam lampiran "Permintaan Tindakan Korektif (CAR)" harus ditangani melalui proses tindakan korektif organisasi, sesuai dengan persyaratan yang relevan tindakan korektif dan pencegahan dari standar audit dan catatan lengkap dipelihara. <br>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="2" style=" border:1px solid black; padding:2px; vertical-align: top; text-align: center; line-height: normal;"><input type="radio" class="Radio" name="tikor" value="major"></td>
                                                        <td colspan="22" style=" border:1px solid black; padding: 2px; text-align: justify; vertical-align: top;line-height: normal;">
                                                        Tindakan korektif untuk mengatasi ketidaksesuaian <b>MAJOR</b> diidentifikasi harus segera dilakukan dan <b>MANDIRI CERTIFICATION diberitahu tentang tindakan yang diambil dalam waktu 30 hari.</b> Auditor MANDIRI CERTIFICATION akan melakukan <b>tindak lanjut kunjungan</b> dalam waktu 90 hari untuk mengkonfirmasi tindakan yang diambil, evaluasi terhadap keefektifan mereka, dan menentukan apakah sertifikasi dapat diberikan atau dilanjutkan.</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style=" border:1px solid black; padding:2px; vertical-align: top; text-align: center; line-height: normal;"><input type="radio" class="Radio" name="tikor" value="minor"></td>
                                                        <td colspan="22" style=" border:1px solid black; padding: 2px; text-align: justify; vertical-align: top; line-height: normal;">
                                                        Tindakan korektif untuk mengatasi ketidaksesuaian <b>MINOR</b> harus segera dilakukan dan diidentifikasi dan <b>catatan dengan bukti pendukung yang dikirim ke auditor MANDIRI CERTIFICATION untuk close-out dalam waktu 90 hari.</b> Pada kunjungan Audit jadwal berikutnya, tim audit MANDIRI CERTIFICATION akan menindaklanjuti semua ketidaksesuaian diidentifikasi untuk mengkonfirmasi efektifitas tindakan perbaikan dan pencegahan yang diambil.</td>
                                                    </tr>
                                                </table>
                                            </div>

                                          </li>
                                          <li class="list-group-item">
                                            <b>8. Significant Audit Trails Followed</b> <button type="button" id="addRow" class="btn btn-success btn-xs"><span class="fa fa-arrow-circle-o-down"></span> Add</button><br>
                                            <form name="items_list" id="items_list">
                                                <div>
                                                    <table class="table" id="data-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" >No.</th>
                                                                <th scope="col" id="par_a">Nilai *</th>
                                                                <th scope="col" >Hapus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- KETUA -->
                                                            {{-- <tr class="tr_item" id="tr_item">
                                                                <td>1</td>
                                                                <td>
                                                                    <input type="text" data-id='1' class="item_ls form-control" name="nama_anggota_1" id="nama_anggota_1">
                                                                    <span id="nama_anggota_1" class="help-block" > {{ $errors->first('nama_anggota_1') }} </span>
                                                                </td>
                                                                <td>
                                                                    <button disabled type='button' onclick="$(this).closest('tr').remove(); removeItem();" class="btn btn-danger btn-sm" ><span class="fa fa-times-circle" ></span></button> 
                                                                </td>
                                                            </tr> --}}
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                            <ol type="1" class="satf">
                                                {{-- <li><input type="text" name="satf" id="satf" class="form-control"></li> --}}
                                            </ol>
                                          </li>
                                        </ul>
                                      </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                          <div class="row">
                              <div class="col-lg-12">
                                <div class="table-responsive">

                                  <table>
                                    <tr>
                                        <td colspan="24"><b>Corrective Action Request</b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="text-align: justify;"><input type="radio" class="Radio" name="car" value="1"> <b>Major</b></td>
                                        <td colspan="3" style="text-align: justify;"><input type="radio" class="Radio" name="car" value="0"> <b>Minor</b></td>
                                        
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black;"><b>Organisasi : <span id="nama_perusahaan" contenteditable="true" placeholder="Nama Perusahaan" style="text-transform: uppercase;"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="24" style="padding: 2px;  text-align: justify; border: 1px solid black;"><b>Lokasi Audit :<br>
                                            <span id="lokasi_audit" contenteditable="true" placeholder="lokasi_audit"></span></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Auditor(s) : <span id="auditors" contenteditable="true" placeholder=". . . . . . . ."></span></td>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Date(s) of audit(s) : <input name="date_audit" id="date_audit" type="date" class="form-control"></td>
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black;">Standar(s) : <span id="auditors" contenteditable="true" placeholder=". . . . . . . ."></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black;">Organization Representative : <input name="or1" id="or1" type="text" class="form-control"> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black;">Area/Department/Process : <input name="dept" id="dept" type="text" class="form-control"> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Document Ref.: <input name="doc_ref" id="doc_ref" type="text" class="form-control"></td>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Standard Ref.: <input name="std_ref" id="std_ref" type="text" class="form-control"></td>
                                    <tr>
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">No. CAR : <input name="car_no" id="car_no" type="text" class="form-control"></td>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">CAR Close-Out date : <input name="car_date" id="car_date" type="date" class="form-control"></td>
                                    <tr>
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black; text-align: justify;"><b>Detail of Non-Conformity : 
                                            <select name="doc" id="doc">
                                            </select>
                                            <br>
                                            <span id="det_non_conf" contenteditable="true" placeholder=". . . . . . . ."></span></b></td>
                                    </tr>
                    
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;"><b>Organization Representative : <input name="or2" id="or2" type="text" class="form-control"></b></td>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;"><b>Auditor : <input name="auditor1" id="auditor1" type="text" class="form-control"></b></td>
                                    <tr>
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black; text-align: justify;">Untuk mencegah terulangnya temuan maka tindakan korektif yang dilakukan adalah :<br>
                                            <input name="pencegahan" id="pencegahan" type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Organization Representative:<input name="or3" id="or3" type="text" class="form-control"></td>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Date: <input name="date_or" id="date_or" type="date" class="form-control"></td>
                                    <tr>
                                    <tr>
                                        <td colspan="24" style="padding: 2px; border: 1px solid black; text-align: justify;">Penerimaan Corrective Action / Komentar (gunakan lembar tambahan jika perlu):<br>
                                            <input name="penerimaan" id="penerimaan" type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Auditor: <input name="auditor2" id="auditor2" type="text" class="form-control"></td>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;">Date: <input name="auditor_date" id="auditor_date" type="date" class="form-control"></span></td>
                                    <tr>
                                    <tr>
                                        <td colspan="12" style="padding: 2px; border: 1px solid black;"><b>Response required (in months)</b></td>
                                        <td colspan="6" style="padding: 2px; border: 1px solid black; text-align: center;"><b>Major</b></td>
                                        <td colspan="6" style="padding: 2px; border: 1px solid black; text-align: center;"><b>Minor</b></td>
                                    <tr>
                                    <tr>
                                        <td colspan="12" rowspan="4" style="padding: 2px; border: 1px solid black; text-align: justify;">Corrective Action harus ditangani dalam jangka waktu yang dinyatakan. Verifikasi tindakan akan terjadi pada kunjungan berikutnya. Tindak lanjut tambahan mungkin diperlukan seperti yang ditunjukkan.</td>
                                        <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Define</b></td>
                                        <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Close Out</b></td>
                                        <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Define</b></td>
                                        <td colspan="3" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center; background-color: lightblue;"><b>Close Out</b></td>
                                    <tr>
                                    <tr>
                    
                                        <td colspan="3" rowspan="2" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>1 Bulan</b></td>
                                        <td colspan="3" rowspan="2" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                                        <td colspan="3" rowspan="2" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>3 Bulan</b></td>
                                        <td colspan="3" rowspan="2" style="padding: 2px; border: 1px solid black; vertical-align: top; text-align: center;"><b>Next Visit</b></td>
                                    <tr>
                                  </table>
                                </div>
                              </div>
                          </div>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                  </div>
              </div>
              </form>


              <div class="row">
                <div class="col-lg-12">
                    <div class="box-footer">
                        {{-- <button type="button" id="btn_prev" class="btn btn-default"> <i class="fa fa-toggle-left" ></i> Sebelumnya</button> --}}
                        <button type="button" class="btn btn-primary" id="btnSave"> <i class="fa fa-save" ></i> Simpan</button>
                        {{-- <button type="button" id="btn_next" class="btn btn-default"> <i class="fa fa-toggle-right" ></i> Selanjutnya</button> --}}
                    </div>
                </div>
            </div>
            </div>
            {{--  end of table seminar  --}}
            


        </div>
        <!-- /.box-body -->
        <div class="box-footer"></div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
@endsection

@push('script')
<script>
var counter = 1;
var satf = "";
var doc = "";

$(function(){

    $("#id_prov").select2({
        placeholder: "Pilih Provinsi",
    }).on('change', function(){
        var id_kota = 'id_kota';
        var id_prov = 'id_prov';
        var url = "{{ route('chained_prov') }}";
        chainedProvinsi(url, id_prov, id_kota, '-pilih kota-')
    });

    $("#id_kota").select2({
        placeholder: "Pilih Kota",
    });

    $("#id_negara").select2({
        placeholder: "Pilih Negara",
    });

    $('#btnSave').on('click',function(){
        counter = $('#satf li').length;
        store()
    });

    $('#nama_bu').on('change', function(){
        $('#nama_perusahaan').html($('#nama_bu').val());
    });
    $('#site_audited').on('change', function(){
        $('#lokasi_audit').html($('#site_audited').val());
    });

    $('#standard').on('change',function(){
        var iso = $('#standard').val();
        $("#doc").empty();
        $('.satf').empty();
        chained_scope(iso)
    });

    $('#addRow').on('click',function(){
        counter = $('#data-table tr').length;
        add_row();
    });

    $("#scope").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });




});

// add row anggota
function add_row()
{
    $('#data-table > tbody:last').append(`
    <tr class="tr_item" id="tr_item">
        <td>`+counter+`</td>
        <td>
            <input type="text" data-id='`+counter+`' class="item_ls form-control" name="satf_val_`+counter+`" id="satf_val_`+counter+`">
            <span id="satf_val_`+counter+`" class="help-block" > {{ $errors->first('satf_val_`+counter+`') }} </span>
            <input type="hidden" name="satf_`+counter+`" id="satf_`+counter+`" value="" class="form-control">
            <input type="hidden" name="id_satf_`+counter+`" id="id_satf_`+counter+`" value="new_data" class="form-control">
        </td>
        <td>
            <button type='button' onclick="$(this).closest('tr').remove(); removeItem();" class="btn btn-danger btn-xs" ><span class="fa fa-times-circle" ></span></button> 
        </td>
    </tr>`);
}

function addSatf(counter, value){
    $('#data-table > tbody:last').append(`
    <tr class="tr_item" id="tr_item">
        <td>`+counter+`</td>
        <td>
            <input type="text" data-id='`+counter+`' class="item_ls form-control" name="satf_val_`+counter+`" id="satf_val_`+counter+`" value="`+value.nama+`">
            <span id="satf_val_`+counter+`" class="help-block" > {{ $errors->first('satf_val_`+counter+`') }} </span>
            <input type="hidden" name="satf_`+counter+`" id="satf_`+counter+`" value="`+value.id+`" class="form-control">
            <input type="hidden" name="id_satf_`+counter+`" id="id_satf_`+counter+`" value="new_data" class="form-control">
        </td>
        <td>
            <button type='button' onclick="$(this).closest('tr').remove(); removeItem();" class="btn btn-danger btn-xs" ><span class="fa fa-times-circle" ></span></button> 
        </td>
    </tr>`);
    // $('.satf').append(`
    // <li id="li_`+counter+`">
    //     <div class="input-group">
    //     <input type="text" name="satf_ui`+counter+`" id="satf_ui`+counter+`" value="`+value.nama+`" readonly class="form-control">
    //             <span class="input-group-addon" ><button type="button" onclick="removeSatf('`+counter+`')" class="btn btn-xs btn-danger" ><i class="fa fa-close" ></i> </button> </span>
    //           </div>
    //     <input type="hidden" name="satf_`+counter+`" id="satf_`+counter+`" value="`+value.id+`" class="form-control">
    //     <input type="hidden" name="id_satf_`+counter+`" id="id_satf_`+counter+`" value="new_data" class="form-control">
    // </li>
    // `);
}

function addDoc(value){
    var o = new Option(value.nama, value.id);
    /// jquerify the DOM object 'o' so we can use the html method
    $(o).html(value.nama);
    $("#doc").append(o);
}

function removeSatf(counter){
    $("#li_"+counter).remove();
}

function store(){
  var formData = new FormData($('#formAdd')[0]);
  var url = "{{ url('laporan') }}";
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url,
    type: 'POST',
    dataType: "JSON",
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
        if (response.status) {
            Swal.fire({
                title: response.message,
                // text: response.success,
                type: 'success',
                confirmButtonText: 'Close',
                confirmButtonColor: '#AAA',
                onClose: function() {
                    // window.location.reload();
                }
            })

        }
    },
    error: function(xhr, status) {
        // reset to remove error
        var a = JSON.parse(xhr.responseText);
        // reset to remove error
        $('.form-group').removeClass('has-error');
        $('.help-block').hide(); // hide error span message
        $.each(a.errors, function(key, value) {
            $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('span[id^="' + key + '"]').show(); // show error message span
            // for select2
            if (!$('[name="' + key + '"]').is("select")) {
                $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
            }
        });
    }
  });
}

function chained_scope(iso){
  var url = "{{ url('laporan/chained_scope') }}/"+iso;
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url,
    type: 'get',
    dataType: "JSON",
    // data: formData,
    // contentType: false,
    // processData: false,
    success: function(response) {
        // console.log(response)
        satf = response.obs;
        $.each(response.obs, function(index, value){
            addSatf(index+1, value)
        })
        $.each(response.doc, function(index, value){
            addDoc(value)
        })
        if (response.status) {
            Swal.fire({
                title: response.message,
                // text: response.success,
                type: 'success',
                confirmButtonText: 'Close',
                confirmButtonColor: '#AAA',
                onClose: function() {
                    // window.location.reload();
                }
            })

        }
    },
    error: function(xhr, status) {
        // reset to remove error
        var a = JSON.parse(xhr.responseText);
        // reset to remove error
        $('.form-group').removeClass('has-error');
        $('.help-block').hide(); // hide error span message
        $.each(a.errors, function(key, value) {
            $('[name="' + key + '"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('span[id^="' + key + '"]').show(); // show error message span
            // for select2
            if (!$('[name="' + key + '"]').is("select")) {
                $('[name="' + key + '"]').next().text(value); //select span help-block class set text error string
            }
        });
    }
  });
}


$('.select2').select2();


</script>
@endpush
