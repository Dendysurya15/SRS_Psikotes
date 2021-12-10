<?php
define('WP_HOME', 'https://www.assessmentcenter-ssms.com/');
define('WP_SITEURL', 'https://www.assessmentcenter-ssms.com/');

date_default_timezone_set("Asia/Jakarta");
include_once '../layout/header.php';

include '../../kumpulan_function.php';

$soal = new Soal();
$skor  = $soal->Skor($_SESSION['i_room']);
$namaPeserta    = $skor->fetch_assoc();
$namaPeserta = $namaPeserta['nama_peserta'];
$soal_id = '';

if (isset($_SESSION['kerja_soal'])) {
    if ($_SESSION['kerja_soal'] != 'soal_10_an') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 10 AN');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_10_an');
        break;
}

$arr_abjad = range('a', 'z');

$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[11]);

$status_s   = $arr_s2[1];

$resSoal2         = $soal->SelectSoal2('Modul 10 AN');
$rowSoal2         = $resSoal2->fetch_assoc();

$d                = $rowSoal2['durasi'];

if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 10 AN');
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
                                Pengerjaan Soal 10 AN
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

                        <form id="soal_contoh" class="mt-4 ml-5">
                            <div class="row mt-4 mb-4">
                                <div class="col-md-12" style="margin-left: auto; margin-right: auto;">
                                    <h3 class="content-header">
                                        Pada tes ini anda dihadapkan dengan soal PERBANDINGAN, kata pertama memiliki perbandingan
                                        dengan kata ke dua, dan kata ke tiga dan kata ke empat seharusnya juga memiliki perbandingan
                                        yang sama. Jadi anda diminta untuk mencari kata yang sesuai untuk melengkapi ‘?’ (kata ke empat)
                                        sesuai dengan perbandingan kata yang sebelumnya.
                                    </h3>
                                </div>
                            </div>
                            <!-- NOMOR 1 -->
                            <div class="row" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="teks-soal">41. menemukan : menghilang = mengingat : ?<p></p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_41" id="optionsRadios1" value="a">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">A.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">MENGHAPAL</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_41" id="optionsRadios1" value="b">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">B.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">MENGENAL</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_41" id="optionsRadios1" value="c">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">C.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">MELUPAKAN</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_41" id="optionsRadios1" value="d">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">D.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">BERPIKIR</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_41" id="optionsRadios1" value="e">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">E.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">MEMIMPIKAN</label>
                                    </div>
                                </div>
                            </div>
                            <!-- NOMOR 1 -->

                            <!-- NOMOR 2 -->
                            <div class="row mt-5" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="teks-soal">42. bunga : jambangan = burung : ?<p></p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_42" id="optionsRadios1" value="a">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">A.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">SARANG</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_42" id="optionsRadios1" value="b">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">B.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">LANGIT</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_42" id="optionsRadios1" value="c">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">C.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">PAGAR</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_42" id="optionsRadios1" value="d">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">D.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">POHON</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_42" id="optionsRadios1" value="e">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">E.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">SANGKAR</label>
                                    </div>
                                </div>
                            </div>
                            <!-- NOMOR 2 -->

                            <!-- NOMOR 3 -->
                            <div class="row mt-5" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <label class="teks-soal">43. kereta api : rel = bis : ?<p></p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_43" id="optionsRadios1" value="a">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">A.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">RODA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_43" id="optionsRadios1" value="b">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">B.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">POROS</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_43" id="optionsRadios1" value="c">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">C.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">BAN</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_43" id="optionsRadios1" value="d">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">D.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">JALAN RAYA</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="radio" class="jawaban radio-pilihan" name="jawaban_43" id="optionsRadios1" value="e">
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">E.</label>
                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;">KECEPATAN</label>
                                    </div>
                                </div>
                            </div>
                            <!-- NOMOR 3 -->
                        </form>


                        <form hidden id="soal_asli" action="../query/peserta_query" method="post" class="mt-5">
                            <?php if ($resultSoalModul->num_rows > 0) : ?>
                                <?php $index = 0; ?>
                                <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                    <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                    <input type="hidden" name="soal_id" value="<?= $soal_id ?>">
                                    <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                    <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">

                                    <?php if ($index == 0) : ?>
                                        <div class="row" style="margin:auto;">
                                            <div class="col-md-1" style="text-align:right;">
                                            </div>
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['teks_soal'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                            </div>
                                            <?php
                                            $pilihan = explode(';', substr($rowSoalModul['pilihan'], 0, -1));
                                            ?>
                                            <?php for ($i = 0; $i < count($pilihan); $i++) : ?>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="radio" class="jawaban radio-pilihan" disabled name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="<?= $arr_abjad[$i] ?>">
                                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;"><?= strtoupper($arr_abjad[$i]) ?>.</label>
                                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;"><?= strtoupper($pilihan[$i]) ?></label>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    <?php else : ?>
                                        <div class="row mt-5" style="margin:auto;">
                                            <div class="col-md-1" style="text-align:right;">
                                            </div>
                                            <div class="col-md-11">
                                                <div class="form-group">
                                                    <label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['teks_soal'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                            </div>
                                            <?php
                                            $pilihan = explode(';', substr($rowSoalModul['pilihan'], 0, -1));
                                            ?>
                                            <?php for ($i = 0; $i < count($pilihan); $i++) : ?>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="radio" class="jawaban radio-pilihan" disabled name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="<?= $arr_abjad[$i] ?>">
                                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;"><?= strtoupper($arr_abjad[$i]) ?>.</label>
                                                        <label class="teks-soal" style="font-size: 15pt; font-weight: normal;"><?= strtoupper($pilihan[$i]) ?></label>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php $index++; ?>
                                <?php endwhile; ?>
                                <div class="row mt-5 mb-4" style="margin:auto; text-align:center;">
                                    <div class="col-md-12">
                                        <input hidden class="btn btn-secondary w-50" type="submit" value="Submit Jawaban" name="soal_10_an" id="soal_10_an">
                                        <input class="btn btn-success w-50 button-tes" type="button" value="KIRIM JAWABAN" name="soal_10_an_" id="soal_10_an_">
                                    </div>
                                </div>
                            <?php endif; ?>
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
            $('#soal_10_an').click();
        }

        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_10_an_').click(function() {
            var konf = confirm('Apakah anda telah selesai mengerjakan?');
            if (konf == true) {
                $('#soal_10_an').click();
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
                    clearInterval(time)
                    Pesan();
                }
            }, 1000);
        }
    </script>

    <style>
        .unselectable {
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>