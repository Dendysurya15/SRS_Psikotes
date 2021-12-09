<?php
    session_start();
    if(!isset($_SESSION['i_peserta']))
    {
        header('location:../auth/login?status=3');
    } 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PSIKOTES</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="../../layout/dist/img/CBI-logo.png">
    <link rel="stylesheet" href="../../layout/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../layout/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="../../layout/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../layout/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../layout/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../layout/dist/css/jquery.fancybox.min.css">


    <!--download-->
    <link href="../../layout/dist/css/css.css" rel="stylesheet">    
    
    <!--download-->
    <script type="text/javascript" src="../../layout/dist/js/loader.js"></script>

    <!--download-->
    <link rel="stylesheet" type="text/css" href="../../layout/dist/css_tabel/buttons.dataTables.min.css" />
     <!--download-->
    <link rel="stylesheet" type="text/css" href="../../layout/dist/css/jquery.dataTables.min.css" />

    <style type="text/css">
        .center {
          margin: auto;
          height: 500px;
          width: 70%;
          padding: 10px;
          text-align: center;
        }

        .button-tes{
            font-size: 25pt;
            background-color: #28A745;
        }

        .button-tes-2{
            font-size: 25pt;
        }
        .radio-pilihan {
            width: 30%;
            height: 2em;
        }
        .teks-soal{
            font-size: 20pt;
            font-weight: bold;
        }

        .teks-pilihan{
            font-size: 20pt;
            font-weight: normal !important;
        }

        input[type=number] {
            width: 100%;
            height: 50px;
            box-sizing: border-box;
            font-size: 20pt;
        }

    </style>

</head>