<?php
define('WP_HOME', 'https://www.assessmentcenter-ssms.com/');
define('WP_SITEURL', 'https://www.assessmentcenter-ssms.com/');

// define('WP_HOME','localhost');
// define('WP_SITEURL','localhost');

date_default_timezone_set("Asia/Jakarta");
include_once '../layout/header.php';

include '../../kumpulan_function.php';

$soal = new Soal();
$soal_id = '';

if (isset($_SESSION['kerja_soal'])) {
    if ($_SESSION['kerja_soal'] != 'soal_3') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 3');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_3');
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

$arr_s2     = explode('=', $arr_s1[2]);

$status_s   = $arr_s2[1];

$resSoal2         = $soal->SelectSoal2('Modul 3');
$rowSoal2         = $resSoal2->fetch_assoc();

$d          = $rowSoal2['durasi'];
if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 3');
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
                    <a class="nav-link">Selamat datang!</a>
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
                                Pengerjaan Soal 3
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
                            <div hidden id="sisa_waktu" class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                <div class="col-md-12">
                                    <h3 id="s_w"><?= $d ?></h3>
                                </div>
                            </div>
                        </div>


                        <form id="soal_contoh" class="mt-3 ml-4">
                            <div class="row mt-4 mb-4">
                                <div class="col-md-12" style="margin-left: auto; margin-right: auto;">
                                    <h3 class="content-header">
                                        “Pada tes ini di setiap nomornya memiliki pasangan kata-kata yang berada di kanan dan kiri. Jika
                                        menurut anda kata-kata yang berada di kanan dan kiri tersebut sudah sama, untuk menjawabnya bisa
                                        anda klik “BENAR”, tetapi jika menurut anda kata-kata tersebut belum sama, untuk menjawabnya
                                        bisa anda klik “SALAH”.
                                    </h3>
                                </div>
                            </div>

                            <!-- PENJELASAN -->

                            <table style="width: 98%; border:none;" class="table table-bordered table-hover teks-vertical">
                                <!-- PENJELASAN -->



                                <!-- INI SOAL 1 -->
                                <tr style="border: none;">
                                    <td style="border: none;">
                                        <p class="teks-soal">1. Merpati Nusantara</p>
                                    </td>
                                    <td style="border: none;">
                                        <p class="teks-soal">1. Merpati Nusantara</p>
                                    </td>
                                    <td style="border: none;">
                                        <div class="form-group">
                                            <input class="jawaban radio-pilihan" type="radio">
                                            <label class="teks-soal">Benar</label>
                                        </div>
                                    </td>
                                    <td style="border: none;">
                                        <div class="form-group">
                                            <input class="jawaban radio-pilihan" type="radio">
                                            <label class="teks-soal">Salah</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="border: none;">
                                    <td colspan="4" style="border: none;"></td>
                                </tr>
                                <tr style="border: none;">
                                    <td colspan="4" style="border: none;"></td>
                                </tr>
                                <!-- INI SOAL 1 -->

                                <!-- INI SOAL 2 -->
                                <tr style="border: none;">
                                    <td style="border: none;">
                                        <p class="teks-soal">2. Bank Bumi Daya</p>
                                    </td>
                                    <td style="border: none;">
                                        <p class="teks-soal">2. Bank Bumi Daya</p>
                                    </td>
                                    <td style="border: none;">
                                        <div class="form-group">
                                            <input class="jawaban radio-pilihan" type="radio">
                                            <label class="teks-soal">Benar</label>
                                        </div>
                                    </td>
                                    <td style="border: none;">
                                        <div class="form-group">
                                            <input class="jawaban radio-pilihan" type="radio">
                                            <label class="teks-soal">Salah</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="border: none;">
                                    <td colspan="4" style="border: none;"></td>
                                </tr>
                                <tr style="border: none;">
                                    <td colspan="4" style="border: none;"></td>
                                </tr>
                                <!-- INI SOAL 2 -->


                                <!-- INI SOAL 3 -->
                                <tr style="border: none;">
                                    <td style="border: none;">
                                        <p class="teks-soal">2. Annanda</p>
                                    </td>
                                    <td style="border: none;">
                                        <p class="teks-soal">2. Ananda</p>
                                    </td>
                                    <td style="border: none;">
                                        <div class="form-group">
                                            <input class="jawaban radio-pilihan" type="radio">
                                            <label class="teks-soal">Benar</label>
                                        </div>
                                    </td style="border: none;">
                                    <td style="border: none;">
                                        <div class="form-group">
                                            <input class="jawaban radio-pilihan" type="radio">
                                            <label class="teks-soal">Salah</label>
                                        </div>
                                    </td>
                                </tr>

                                <tr style="border: none;">
                                    <td colspan="4" style="border: none;"></td>
                                </tr>
                                <tr style="border: none;">
                                    <td colspan="4" style="border: none;"></td>
                                </tr>
                                <!-- INI SOAL 3 -->

                            </table>

                        </form>


                        <form action="../query/peserta_query" method="post" class="mt-3 ml-4" id="soal_asli" hidden>
                            <table style="width: 98%;" class="table" style="border:none !important;">
                                <?php if ($resultSoalModul->num_rows > 0) : ?>
                                    <?php $index = 1; ?>
                                    <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                        <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                        <input type="hidden" name="id_soal" value="<?= $soal_id ?>">
                                        <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                        <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">
                                        <tbody style="border: none;">
                                            <?php if ($index <= 1) : ?>
                                                <tr style="border: none;">
                                                    <td style="border: none;">
                                                        <p class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['pernyataan_1'] ?></p>
                                                    </td>

                                                    <td style="border: none ;">
                                                        <p class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['pernyataan_2'] ?></p>
                                                    </td>

                                                    <td style="width: 15%; border: none ;">
                                                        <div class="form-group">
                                                            <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" value="benar">
                                                            <label class="teks-soal">Benar</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 15%; border: none ;">
                                                        <div class="form-group">
                                                            <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" value="salah">

                                                            <label class="teks-soal">Salah</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="border: none;">
                                                    <td colspan="4" style="border: none;"></td>
                                                </tr>
                                                <tr style="border: none;">
                                                    <td colspan="4" style="border: none;"></td>
                                                </tr>
                                            <?php else : ?>

                                                <tr style="border: none;">
                                                    <td style="border: none;">
                                                        <p class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['pernyataan_1'] ?></p>
                                                    </td>

                                                    <td style="border: none;">
                                                        <p class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>. <?= $rowSoalModul['pernyataan_2'] ?></p>
                                                    </td>

                                                    <td style="width: 15%; border: none;">
                                                        <div class="form-group">
                                                            <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" value="benar">
                                                            <label class="teks-soal">Benar</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 15%; border: none;">
                                                        <div class="form-group">
                                                            <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" value="salah">

                                                            <label class="teks-soal">Salah</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr style="border: none;">
                                                    <td colspan="4" style="border: none;"></td>
                                                </tr>
                                                <tr style="border: none;">
                                                    <td colspan="4" style="border: none;"></td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <?php $index++; ?>
                                    <?php endwhile; ?>
                                    <tfoot style="border: none;">
                                        <tr style="border: none;">
                                            <td colspan="4" style="border: none;">
                                                <div class="row mt-2 mb-5" style="margin:auto; text-align: center;">
                                                    <div class="col-md-12">

                                                        <input hidden name="soal_3" id="soal_3" class="btn btn-secondary w-50" type="submit" value="Submit Jawaban">
                                                        <button name="soal_3_" id="soal_3_" class="btn btn-success w-50 button-tes" type="button">
                                                            KIRIM JAWABAN
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
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

        function Pesan() {
            $('#soal_3').click();
        }
        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_3_').click(function() {
            var konf = confirm('Apakah anda telah selesai menjawab?');

            if (konf == true) {
                Timer();
                $('#soal_3').click();
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
    </script>

    <style>
        .unselectable {
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>