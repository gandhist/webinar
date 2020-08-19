<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="P3SM, Sertifikat, Seminar, Jakarta, Indonesia, Seminar">
    <meta name="description" content="Sertifikat P3SM adalah Halaman Web untuk melakukan pendaftaran seminar yang diselenggarakan oleh P3SM"/>

    <title>SERTIFIKAT P3SM</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/style5.css') }}">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <style>
        #navbar {
            position: fixed;
            width: 100%;
            z-index: 999;
        }
        .navbar {
            background-color: #b7d0ed;   
        }
        #cont{
            padding-top: 60px;
        } 
        #content{
            padding-top: 55px;
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
            background-color: #b7d0ed;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 20px;
            line-height: 1.2;
        } 
        .footer {
            background-color: #b7d0ed;
            width:100%;
            color: #black;
            height: 40px;
            line-height: 40px;
            text-align: center;
            font-size: 14px;
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
                background-color: #b7d0ed;
                color: white;
                cursor: pointer;
                padding: 10px;
                border-radius: 20px;
                line-height: 1.2;
            }
        }
      </style>
</head>
<body>
    @include('frontend.navigation')
    <div id="content">
        @yield('content')
    </div> 
    @include('frontend.footer')