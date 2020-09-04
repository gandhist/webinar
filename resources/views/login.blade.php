
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PPKB P3SM| Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-2.3.11/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('AdminLTE-2.3.11/plugins/iCheck/square/blue.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<style>
    .button-flash {
      background-color: #004A7F;
      -webkit-border-radius: 10px;
      border-radius: 10px;
      border: none;
      color: #FFFFFF;
      cursor: pointer;
      display: inline-block;
      font-family: Arial;
      text-align: center;
      text-decoration: none;
      -webkit-animation: glowing 1500ms infinite;
      -moz-animation: glowing 1500ms infinite;
      -o-animation: glowing 1500ms infinite;
      animation: glowing 1500ms infinite;
    }
    @-webkit-keyframes glowing {
      0% { background-color: #38b200; -webkit-box-shadow: 0 0 3px #38b200; }
      50% { background-color: #15ff00; -webkit-box-shadow: 0 0 40px #15ff00; }
      100% { background-color: #38b200; -webkit-box-shadow: 0 0 3px #38b200; }
    }

    @-moz-keyframes glowing {
      0% { background-color: #38b200; -moz-box-shadow: 0 0 3px #38b200; }
      50% { background-color: #15ff00; -moz-box-shadow: 0 0 40px #15ff00; }
      100% { background-color: #38b200; -moz-box-shadow: 0 0 3px #38b200; }
    }

    @-o-keyframes glowing {
      0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
      50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
      100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
    }

    @keyframes glowing {
      0% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
      50% { background-color: #15ff00; box-shadow: 0 0 40px #15ff00; }
      100% { background-color: #38b200; box-shadow: 0 0 3px #38b200; }
    }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>PPKB P3SM</b> - Login</a>
  </div>
  @if(session()->get('warning'))
		<div class="alert alert-warning"> {{ session()->get('warning') }}
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		</div>
    @endif

  @if(session()->get('success'))
  <div class="alert alert-success"> {{ session()->get('success') }}
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  </div>
@endif
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{ url('login') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Email" name="username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
       <!--  <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div> -->
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-block btn-flat button-flash">Sign In</button>
        </div>
        <div class="col-xs-6">
          <a href="{{url('')}}" class="btn btn-danger btn-block btn-flat">Cancel</a>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12" style="align-content: center">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
                <a href="{{url('login/google')}}" style="color: white">
                    <i class="fa fa-google fa-fw"></i> Login with Google Account
                </a>
            </button>
        </div>
        <!-- /.col -->
      </div>
      <br>
      {{-- <a href="{{url('reset')}}">Lupa Password?</a> --}}
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('AdminLTE-2.3.11/plugins/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
