<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="PPKB ONLINE, P3SM, Sertifikat, Sertifikasi, Seminar, Jakarta, Indonesia, Webinar">
    <meta name="description" content="PPKB P3S MANDIRI adalah halaman web untuk Program Pengembangan Keprofesian Berkelanjutan yang diselenggarakan oleh P3S Mandiri"/>

    <title>PPKB P3S MANDIRI</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/style5.css') }}">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
        .home {
            color: black
        }
        .home:hover{
            text-decoration: none
        }
        #navbar {
            position: fixed;
            width: 100%;
            z-index: 999;
        }
        .navbar {
            /* background-color: whitesmoke; */
            background-color: #b7d0ed;
        }
        /* .navbar{background:#222222;} */
        .nav-item::after{
            content:'';
            display:block;
            width:0px;
            height:2px;
            background:#111111;
            transition: 0.4s;
        }
        .nav-item:hover::after{
            width:100%;
        }
        .nav-item::before{
            content:'';
            display:block;
            width:0px;
            height:2px;
            background:#111111;
            transition: 0.4s;
        }
        .nav-item:hover::before{
            width:100%;
        }
        /* .navbar-dark .navbar-nav .active > .nav-link, .navbar-dark .navbar-nav .nav-link.active, .navbar-dark .navbar-nav .nav-link.show, .navbar-dark .navbar-nav .show > .nav-link,.navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link:hover{
            color:#111111;
            } */
        /* .nav-link{
            padding:15px 5px;transition:0.2s;
            } */
        /* .dropdown-item.active, .dropdown-item:active{
            color:#212529;
            } */
        /* .dropdown-item:focus, .dropdown-item:hover{
            background:#111111;
            } */

        #content{
            padding-top: 50px;
        }
        #content-daftar{
            padding-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 6px;
            border: 0px solid #ccc;
            text-align: left;
        }
        #myBtn {
            display: none;
            position: fixed;
            bottom: 90px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #30363d;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 20px;
            line-height: 1.2;
        }
        .footer {
            background-color: #b7d0ed;
            width:100%;
            color: black;
            height: 40px;
            line-height: 40px;
            text-align: center;
            font-size: 14px;
        }
        .tentang {
            background-color: #252525;
        }
        #logoFoot {
            width: 220px;
        }


        @media only screen and (max-width: 760px),(min-device-width: 768px) and (max-device-width: 1024px)  {
            /* Force table to not be like tables anymore */
            table, thead, tbody, th, td, tr {
                display: block;
            }
            /* Hide table headers (but not display: none;, for accessibility) */
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                border: 1px solid #ccc;
            }
            td {
                /* Behave  like a "row" */
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
            }
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }
            input[type=file] {
                width: 100%;
                padding: 12px 70px;
                margin: 8px 0;
                box-sizing: border-box;
            }
            table.dataTable>tbody>tr.child {
                padding: 0px 0px;
            }
            .customTable td{
                text-align: left !important;
            }
            #myBtn {
                display: none;
                position: fixed;
                bottom: 90px;
                right: 30px;
                z-index: 99;
                border: none;
                outline: none;
                background-color: #30363d;
                color: white;
                cursor: pointer;
                padding: 10px;
                border-radius: 20px;
                line-height: 1.2;
            }

        }
      </style>
      <script>
        FontAwesomeConfig = { autoReplaceSvg: false }
      </script>
</head>
<body>
    @include('frontend.navigation')
    <div id="content">
        @yield('content')
    </div>
    @include('frontend.footer')
