<?php
define('WP_HOME', 'https://www.assessmentcenter-ssms.com/');
define('WP_SITEURL', 'https://www.assessmentcenter-ssms.com/');

// define('WP_HOME','localhost');
// define('WP_SITEURL','localhost');

date_default_timezone_set("Asia/Jakarta");
include_once '../layout/header.php';

include '../../kumpulan_function.php';

$soal = new Soal();
$skor  = $soal->Skor($_SESSION['i_room']);
$namaPeserta    = $skor->fetch_assoc();
$namaPeserta = $namaPeserta['nama_peserta'];

$soal_id = '';

if (isset($_SESSION['kerja_soal'])) {
    if ($_SESSION['kerja_soal'] != 'hapalan') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
$timer = '';
$batas  = new DateTime($_SESSION['w_selesai']);
$b      = $batas->format('H:i:s');

$resultSelSoal      = $soal->SelectSoal2('Modul 2');
switch ($resultSelSoal) {
    case $resultSelSoal->num_rows > 0:
        $rowSelectSoal  = $resultSelSoal->fetch_assoc();
        $soal_id        = $rowSelectSoal['id'];
        #$timer          = $rowSelectSoal['durasi'];
        break;

    default:
        $soal_id        = 'Tidak Ada';
        break;
}

$gambar_hapalan     = $soal->SelectGambarHapalan($soal_id);

$resultSoalModul    = '';
switch ($soal_id) {
    case 'Tidak Ada':
        $resultSoalModul    = '';
        break;

    default:
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_1');
        break;
}


if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 0:
            echo '
                    <script>
                        var html = "Gagal Menginsertkan Jawaban Peserta\nQuery Insert Bermasalah";
                        alert(html);
                    </script>                
                ';
            break;

        default:
            # code...
            break;
    }
}





$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[1]);

$status_s   = $arr_s2[1];

$resSoal1         = $soal->KunciJawaban('hapalan');
#$resSoal1         = $soal->SelectSoal2('Modul 1');
$rowSoal1         = $resSoal1->fetch_assoc();

$d          = $rowSoal1['durasi'];
if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {
        $resSoal1         = $soal->KunciJawaban('hapalan');
        #$resSoal1         = $soal->SelectSoal2('Modul 1');
        $rowSoal1         = $resSoal1->fetch_assoc();

        $w_selesai              = strtotime($n_jam) + $rowSoal1['durasi'];
    } else {

        $t_now      = date('H:i:s');

        $d_b        = new DateTime($_SESSION['w_selesai']);
        $db_n       = $d_b->format('H:i:s');

        $jm_sel    = strtotime($db_n);
        $jm_now    = strtotime(date('H:i:s'));

        $d         = $jm_sel - $jm_now;

        $d         = $jm_sel - $jm_now;
    }
}


?>


<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed unselectable">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link">Selamat datang! <?= $namaPeserta ?> </a>
                </li>

            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"></a>
                </li>
            </ul>



            <div id="sisa_waktu" class="float-sm-right">
                <div class="col-md-12">
                    <h3 id="s_w">Sisa Waktu : <?= $d ?> Detik</h3>
                </div>
            </div>
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
                            <a href="../auth/logout" onclick="return confirm('Logout berarti anda telah selesai melakukan psikotes\ndan anda tidak melakukan login kembali! apakah anda yakin?')" class="nav-link">
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

        <div class="content-wrapper">
            <section class="content-header">
                <div class="content-fluid ">

                    <div class="row mb-2">
                        <div class="col-sm-12" style="text-align:center;">
                            <h1 class="m-0 pl-2 text-dark">
                                Hapalan
                            </h1>
                        </div>
                    </div>

                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                <div class="col-md-12">
                                    <?php if ($status_s == 0) : ?>
                                        <button class="btn btn-danger w-50 button-tes-2" id="timer">
                                            MULAI MENGHAPAL
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-success w-50 button-tes" id="timer">
                                            MULAI MENGHAPAL
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <form id="soal_contoh">
                            <div class="row mt-4">
                                <?php if (!empty($rowSelectSoal['instruksi_soal'])) : ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <audio src="../../admin/instruksi_soal/<?= $rowSelectSoal['instruksi_soal'] ?>" type="audio/mpeg" controlsList="nodownload" controls>
                                                Your browser does not support the audio tag.
                                            </audio>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-10" style="margin-left: auto; margin-right: auto;">
                                    <h3 class="content-header">
                                        Pada tes kali ini memiliki 5 kategori dimana setiap kategorinya berisi 5 kata-kata, anda harus
                                        mengafalkan seluruh kata-kata yang ada di dalam kotak ini. Anda memiliki waktu 3 menit untuk
                                        menghafalkan kata-kata tersebu
                                    </h3>
                                </div>
                            </div>
                        </form>

                        <form action="../query/peserta_query" method="post" class="mt-5" hidden id="soal_asli">
                            <table>
                                <?php if ($gambar_hapalan->num_rows > 0) : ?>
                                    <?php while ($rowSoalModul = $gambar_hapalan->fetch_assoc()) : ?>
                                        <?php $timer = $rowSoalModul['durasi']; ?>
                                        <div class="row" style="margin:auto;">
                                            <div class="col-md-12" style="text-align:center;">
                                                <div class="form-group">
                                                    <img hidden id="gambar_hapalan" src="../../admin/gambar_hapalan/<?= $rowSoalModul['gambar_hapalan'] ?>" style="width:90%; height:100%;">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <button name="hapalan_1" hidden id="hapalan_1" class="btn btn-success w-50 button-tes" type="button">
                                                SELESAI
                                            </button>


                                            <input hidden name="hapalan" id="hapalan" class="btn btn-secondary w-50" type="submit" value="Selesai">
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <input name="hapalan" id="hapalan" class="btn btn-success w-50 button-tes" type="submit" value="Tidak Ada">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </table>
                        </form>
                    </div>
                </div>
        </div>

    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>

    <!-- jQuery -->
    <script src="../../layout/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../layout/plugins/chart.js/Chart.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../layout/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../layout/dist/js/demo.js"></script>
    <!-- page script -->


    <script>
        var timer_ = <?= $d; ?>;
        $("body").on("contextmenu", function(e) {
            return false;
        });

        function Pesan() {
            $('#hapalan').click();
        }


        $('#hapalan_1').click(function() {
            var conf = confirm('Apakah Selesai Mengerjakan?');
            if (conf == true) {
                $('#hapalan').click();
            }
        });

        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#timer').click(function() {
            var stat_soal = <?= $status_s; ?>;
            if (stat_soal == 0) {
                confirm('Admin belum mempersilahkan untuk mengerjakan soal!');
                location.reload();

            } else {
                var konf = confirm('Apakah anda yakin untuk memulai tes?');

                if (konf == true) {
                    Timer();
                    $('#timer').attr('hidden', true);
                }
            }
        })


        function Timer() {
            var time = setInterval(function() {
                $('#soal_asli').removeAttr('hidden');
                $('#sisa_waktu').removeAttr('hidden');
                $('#gambar_hapalan').removeAttr('hidden');

                $('#soal_contoh').attr('hidden', true);
                timer_ = timer_ - 1;
                if (timer_ > 0) {
                    document.getElementById('s_w').innerHTML = 'Sisa Waktu : ' + timer_ + ' Detik';
                } else {
                    clearInterval(time);
                    Pesan();
                }
            }, 1000);
        }

        var currSeconds = 0;
        var link = document.createElement("a");


        /* kode awal idle mode 30 menit */
        let idleInterval =
            setInterval(timerIncrement, 1000);

        /* Zero the idle timer
            on mouse movement */
        $(this).mousemove(resetTimer);
        $(this).keypress(resetTimer);


        function resetTimer() {

            /* Hide the timer text */
            document.querySelector(".timertext")
                .style.display = 'none';

            currSeconds = 0;

        }

        function timerIncrement() {
            currSeconds = currSeconds + 1;

            if (currSeconds == 1800) {
                link.href = "../auth/logout"
                link.click()
                alert("Anda tidak melakukan akitivitas apapun selama 30 menit, mohon maaf anda dikeluarkan dari tes ini!")
            }

            /* Set the timer text to
                the new value */
            document.querySelector(".secs")
                .textContent = currSeconds;

            /* Display the timer text */
            document.querySelector(".timertext")
                .style.display = 'block';
        }
        // kode akhir idle mode 30 menit
    </script>

    <style>
        .unselectable {
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>