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
    if ($_SESSION['kerja_soal'] != 'soal_2') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 2');
switch ($resultSelSoal) {
    case $resultSelSoal->num_rows > 0:
        $rowSelectSoal  = $resultSelSoal->fetch_assoc();
        $soal_id        = $rowSelectSoal['id'];
        $timer          = $rowSelectSoal['durasi'];
        break;

    default:
        $soal_id        = 'Tidak Ada';
        break;
}
$resultSoalModul    = '';
switch ($soal_id) {
    case 'Tidak Ada':
        $resultSoalModul    = '';
        break;

    default:
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_2');
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

$resSoal2         = $soal->SelectSoal2('Modul 2');
$rowSoal2         = $resSoal2->fetch_assoc();

$d          = $rowSoal2['durasi'];
if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 2');
        $rowSoal1         = $resSoal1->fetch_assoc();

        $w_selesai              = strtotime($n_jam) + $rowSoal1['durasi'];
        $_SESSION['w_selesai']  = date('H:i:s', $w_selesai);
    } else {
        $t_now      = date('H:i:s');

        $d_b        = new DateTime($_SESSION['w_selesai']);
        $db_n       = $d_b->format('H:i:s');

        $jm_sel    = strtotime($db_n);
        $jm_now    = strtotime(date('H:i:s'));

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
            <a href="" class="brand-link">
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
                                Pengerjaan Soal 2
                            </h1>
                        </div>
                    </div>

                </div>
            </section>
            <section class="content row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                <div class="col-md-12">
                                    <?php if ($status_s == 0) : ?>
                                        <button class="btn btn-danger w-50 button-tes-2" id="timer">
                                            MULAI TES
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-success w-50 button-tes" id="timer">
                                            MULAI TES
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <form id="soal_contoh" class="mt-4">
                            <!-- SOAL NOMOR 1 -->
                            <div class="row" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <p class="teks-soal">1. Hewan dengan huruf permulaan Z-adalah....</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Bunga</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Perkakas</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Burung</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Kesenian</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Binatang</label>

                                    </div>
                                </div>
                            </div>
                            <!-- SOAL NOMOR 1 -->


                            <!-- SOAL NOMOR 2 -->
                            <div class="row" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                    <label></label>
                                </div>
                                <div class="col-md-11 mt-5">
                                    <div class="form-group">
                                        <p class="teks-soal">2. Kata yang mempunyai huruf permulaan B - adalah.......</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Bunga</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Perkakas</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Burung</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Kesenian</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Binatang</label>
                                    </div>
                                </div>
                            </div>
                            <!-- SOAL NOMOR 2 -->

                            <!-- SOAL NOMOR 3 -->
                            <div class="row" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                    <label></label>
                                </div>
                                <div class="col-md-11 mt-5">
                                    <div class="form-group">
                                        <p class="teks-soal">3. Kata yang mempunyai huruf permulaan C - adalah.......</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Bunga</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Perkakas</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Burung</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Kesenian</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio">
                                        <label class="teks-pilihan">Binatang</label>
                                    </div>
                                </div>
                            </div>
                            <!-- SOAL NOMOR 3 -->

                        </form>


                        <form action="../query/peserta_query" method="post" class="mt-5" id="soal_asli" hidden>
                            <table>
                                <?php if ($resultSoalModul->num_rows > 0) : ?>
                                    <?php $index = 1; ?>
                                    <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                        <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                        <input type="hidden" name="id_soal" value="<?= $soal_id ?>">
                                        <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">
                                        <div class="row" style="margin:auto;">
                                            <div class="col-md-1" style="text-align:right;">
                                                <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">
                                                <label></label>
                                            </div>
                                            <?php if ($index <= 1) : ?>
                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <p class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['teks_soal'] ?></p>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="col-md-11 mt-5">
                                                    <div class="form-group">
                                                        <p class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['teks_soal'] ?></p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="bunga">
                                                    <label class="teks-pilihan">Bunga</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="perkakas">
                                                    <label class="teks-pilihan">Perkakas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="burung">
                                                    <label class="teks-pilihan">Burung</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="kesenian">
                                                    <label class="teks-pilihan">Kesenian</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="binatang">
                                                    <label class="teks-pilihan">Binatang</label>
                                                </div>
                                            </div>
                                        </div>

                                        <?php $index++; ?>
                                    <?php endwhile; ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <input hidden name="soal_2" id="soal_2" class="btn btn-secondary w-50" type="submit" value="Submit Jawaban">

                                            <input name="soal_2_" id="soal_2_" class="btn btn-success w-50 button-tes" type="button" value="KIRIM JAWABAN">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </table>
                        </form>
                    </div>
                </div>
                <!-- <div class="col-3">
                    <div class="card">
                        <div style="border-bottom: 1pt solid #E9ECEF;">
                            <p class="text-center pt-3"> Status Jawaban</p>
                        </div>
                        <div class="card-body">

                            <div class="row text-center" style="height:100%;width:100%">
                                <?php if ($statusSoal->num_rows > 0) : ?>
                                    <?php $index = 0; ?>
                                    <?php while ($rowSoalModul = $statusSoal->fetch_assoc()) : ?>
                                        <a href="" class="ml-1 mb-2" style="border: 1px solid #DFDFDF;line-height: 30px;border-radius: 3px;width: 15%;height: 30px;font-size: 10pt;">
                                            <?= $rowSoalModul['nomor_soal'] ?>
                                        </a>
                                        <?php $index++; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div> -->
            </section>

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
            $('#soal_2').click();
        }

        $('#soal_2_').click(function() {
            var conf = confirm('Apakah anda sudah selesai mengerjakan soal?');
            if (conf == true) {
                $('#soal_2').click();
            }
        })
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
                $('#soal_contoh').attr('hidden', true);

                $('#sisa_waktu').removeAttr('hidden');
                $('.jawaban').removeAttr('disabled');
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