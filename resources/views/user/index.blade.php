@extends('templates.header')

@push('style')

@endpush

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengelolaan User
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="#">Users</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
            @if(session()->get('success'))
            <div class="alert alert-success">
              {{ session()->get('success') }}  
            </div><br />
            @endif
            {{--  sub menu  --}}
            <div style="margin-bottom: 20px">
                 <a href="{{url('users/create')}}" class="btn bg-olive"><span>Input</span></a>
            </div>
            {{--  end of sub menu  --}}

            {{--  table data of user  --}}
            <div>
                <table id="table-user" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>User Name</th>
                            <th>Jabatan</th>
                            <th>Tgl Input</th>
                            <th>Aktif</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $k => $d)
                        <tr>
                            <td>{{$k + 1}}</td>
                            <td>{{$d->name}}</td>
                            <td>{{$d->username}}</td>
                            <td>{{$d->role->name}}</td>
                            <td>{{$d->created_at}}</td>
                            <td><div class="label label-{{$d->is_active ? "success" : "danger"}}">{{$d->is_active ? "Active" : "Inactive"}}</div></td>
                            <td>
                                <a href="{{url('users/' . $d->id . '/edit')}}" class="btn btn-warning btn-xs"><span class='glyphicon glyphicon-pencil'></span></a>
                                <button class='btn btn-xs btn-danger delete' data-id="{{$d->id}}" data-name="{{$d->name}}"><span class='glyphicon glyphicon-trash'></span></button></td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{--  end of user data  --}}
            

            <!-- modal konfirmasi -->
   
            <div class="modal fade" id="modal-konfirmasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
                    </div>
                    <div class="modal-body" id="konfirmasi-body">
                        test
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-id="" id="btn-hapus">Yes</button>
                    </div>
                    </div>
                </div>
                </div>
            <!-- end of modal konfirmais -->
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
$(function(){
    $(".delete").on("click", function(){
        $("#modal-konfirmasi").modal('show');

        $("#modal-konfirmasi").find("#btn-hapus").data("id", $(this).data("id"));
        $("#konfirmasi-body").text("Delete data User " + $(this).data("name"));
    })

    $('#btn-hapus').click(function(){
        var id = $(this).data("id");

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax(
        {
            url: "users/"+id,
            type: 'delete', // replaced from put
            dataType: "JSON",
            data: {
                "id": id // method and token not needed in data
            },
            success: function (response)
            {
                location.reload();
            },
            error: function(xhr) {
            console.log(xhr.responseText); // this line will save you tons of hours while debugging
            // do something here because of error
        }
        });
    });
});
</script>
@endpush
