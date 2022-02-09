<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('location:../auth/login_admin');
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


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style type="text/css">
        .center {
            margin: auto;
            height: 500px;
            width: 70%;
            padding: 10px;
            text-align: center;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link">Selamat datang <?= $_SESSION['admin'] ?> !</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"></a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="../../index" class="brand-link">
                <img src="../../layout/dist/img/CBI-logo.png" alt="Covid Tracker" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PSIKOTEST</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="../room/daftar_room" class="nav-link">
                                <i class="nav-icon fas fa-fw fa-chart-area"></i>
                                <p>
                                    Room
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../soal/daftar_soal" class="nav-link">
                                <i class="nav-icon fas fa-fw fa-chart-area"></i>
                                <p>
                                    Soal
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../skor/daftar_skor" class="nav-link">
                                <i class="nav-icon fas fa-fw fa-chart-area"></i>
                                <p>
                                    Skor
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">

                            <a href="../query/auth_admin?logout=admin" class="nav-link">
                                <i class="nav-icon fa fa-window-close"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>