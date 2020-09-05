@extends('frontend.main')

@section('content')
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
  font-size: 20px;
  padding: 5px 10px;
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


    .jumbotron {
		/* background-image: url("p3sm.jpeg");
  		background-size: 15%; */
		background-repeat:no-repeat;
		height: 350px;
		background-color: #f7f7f7 !important;
		background-position-x: 98%;
		background-position-y: 55%;
	    margin-top:1px;
	}
	.logo { 
			margin-top: -55px;
	}

	.customTable thead {
    	background-color: #b7d0ed;
 	}

	@media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
		.jumbotron {
            /* background-image: url("p3sm.jpeg");
            background-size: 10%; */
            background-repeat:no-repeat;
			height: 470px;
			background-position-x: 50%;
			background-position-y: 1%;
			margin: 15px;
			margin-top: 15px;
        }
		.welcome {
			margin-top: -25px;
		}
		.login {
			margin-top: 23px;
		}
		.logo{
			margin-top: -15px;
		}
		img{
			height: 50px;	
		}
		
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<div class="container">
	
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

<script type="text/javascript" >

</script>
@endpush
