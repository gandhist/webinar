@extends('templates.header')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Role Management
        {{--  <small>it all starts here</small>  --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url("")}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url("role")}}">Role</a></li>
        <li class="active"><a href="#">Create</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="row">

	      <div class="col-md-6  col-md-offset-3">

	        <!-- general form elements -->
	        <div class="box box-primary">
	          <div class="box-header with-border">
	            <h3 class="box-title">Edit Role</h3>
	          </div>
	          <!-- /.box-header -->
	          <!-- form start -->
	          <form role="form" method="post" action="{{route('user_role.update', $role->id)}}">
	          	@method('PATCH') 
              @csrf
	            <div class="box-body">
	              <div class="form-group">
	                <label for="name">Nama</label>
	                <input type="text" class="form-control" name="name" id="name" value="{{$role->name}}" placeholder="Enter name">
								</div>
								
	              <div class="form-group">
									<label>Permission</label>
									<div style="column-count: 3">
										@foreach($permission as $perm)
											<div class="checkbox" style="margin-top: 0">
												<label><input type="checkbox" name="permission[]" {{$role_permission->contains('permission_id', $perm->id) ? "checked" : ""}} value="{{$perm->id}}">{{$perm->name}}</label>
											</div>
										@endforeach
									</div>
								</div>
	            </div>
	            <!-- /.box-body -->

	            <div class="box-footer">
	              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
	            </div>
	          </form>
	        </div>
	        <!-- /.box -->

	      </div>

	    </div>
    </section>
    <!-- /.content -->
@endsection
