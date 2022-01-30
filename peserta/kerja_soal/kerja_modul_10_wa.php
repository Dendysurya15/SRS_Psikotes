<?php
define('WP_HOME', 'https://www.assessmentcenter-ssms.com/');
define('WP_SITEURL', 'https://www.assessmentcenter-ssms.com/');

date_default_timezone_set("Asia/Jakarta");
include_once '../layout/header.php';

include '../../kumpulan_function.php';

$soal = new Soal();
$resPeserta       = $soal->Peserta('id', $_SESSION['i_peserta'], 'select');
$rowPeserta       = $resPeserta->fetch_assoc();
$soal_id = '';

if (isset($_SESSION['kerja_soal'])) {
    if ($_SESSION['kerja_soal'] != 'soal_10_wa') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 10 WA');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_10_wa');
        break;
}

$arr_abjad = range('a', 'z');


$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[10]);

$status_s   = $arr_s2[1];

$resSoal2         = $soal->SelectSoal2('Modul 10 WA');
$rowSoal2         = $resSoal2->fetch_assoc();

$d                = $rowSoal2['durasi'];

if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 10 WA');
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
                    <a class="nav-link">Selamat datang <?= $rowPeserta['nama_peserta'] ?>!</a>
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
                                Pengerjaan Soal 10 WA
                            </h1>
                        </div>
                    </div>

                </div>
            </section>
            <section class="content row">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                <div class="col-md-12">
                                    <?php if ($status_s == 0) : ?>
                                        <button class="btn btn-danger w-50 button-tes-2" id="timer">
                                            MULAI TES
                                        </button>
                                        <?php
                                        var_dump($resultSelSoal)
                                        ?>
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

                        <form id="soal_contoh" class="mt-5">

                            <div class="row mt-4 mb-4">
                                <?php if (!empty($rowSelectSoal['instruksi_soal'])) : ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <audio src="../../admin/instruksi_soal/<?= $rowSelectSoal['instruksi_soal'] ?>" type="audio/mpeg" controlsList="nodownload" controls>
                                                Your browser does not support the audio tag.
                                            </audio>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-12" style="margin-left: auto; margin-right: auto;">
                                    <h3 class="content-header">
                                        “Pada tes ini, carilah kata yang paling berbeda di antara 5 kata yang diberikan”
                                    </h3>
                                </div>
                            </div>

                            <div class="row">
                                <!-- NOMOR 1 -->
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-1 ml-5">
                                            <div class="form-group" style="margin:auto; ">
                                                <label class="teks-soal">21.</label>
                                            </div>
                                        </div>
                                        <div class="col-md" style="text-align: left;">


                                            <table style="width: 98%;" class="table">
                                                <tbody>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_21" id="optionsRadios1" value="a">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">A.LINGKARAN</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_21" id="optionsRadios1" value="b">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">B.PANAH</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_21" id="optionsRadios1" value="c">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">C.LINGKARAN</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_21" id="optionsRadios1" value="d">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">D.LINGKARAN</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_21" id="optionsRadios1" value="e">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">E.LENGKUNGAN</label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- NOMOR 1 -->

                                <!-- NOMOR 2 -->
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-1 ml-5">
                                            <div class="form-group" style="margin:auto; ">
                                                <label class="teks-soal">22.</label>
                                            </div>
                                        </div>
                                        <div class="col-md" style="text-align: left;">


                                            <table style="width: 98%;" class="table">
                                                <tbody>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_22" id="optionsRadios1" value="a">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">A.MENGETUK</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_22" id="optionsRadios1" value="b">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">B.MEMAKI</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_22" id="optionsRadios1" value="c">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">C.MENJAHIT</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_22" id="optionsRadios1" value="d">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">D.MENGGERGAJI</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_22" id="optionsRadios1" value="e">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">E.MEMUKUL</label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- NOMOR 2 -->

                                <!-- NOMOR 3 -->
                                <div class="col-md-5">
                                    <div class="row mt-5">
                                        <div class="col-md-1 ml-5">
                                            <div class="form-group" style="margin:auto; ">
                                                <label class="teks-soal">23.</label>
                                            </div>
                                        </div>
                                        <div class="col-md" style="text-align: left;">


                                            <table style="width: 98%;" class="table">
                                                <tbody>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_23" id="optionsRadios1" value="a">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">A.LEBAR</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_23" id="optionsRadios1" value="b">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">B.KELILING</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_23" id="optionsRadios1" value="c">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">C.LUAS</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_23" id="optionsRadios1" value="d">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">D.ISI</label>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:none !important;">
                                                        <td style="border:none !important;">
                                                            <div class="form-group">
                                                                <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" name="jawaban_23" id="optionsRadios1" value="e">
                                                            </div>
                                                        </td>
                                                        <td style="border:none !important;">
                                                            <label class="teks-soal" style="text-align: right;font-weight: normal;">E.PANJANG</label>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- NOMOR 3 -->
                            </div>
                        </form>


                        <form hidden id="soal_asli" action="../query/peserta_query" method="post" class="mt-5">
                            <?php if ($resultSoalModul->num_rows > 0) : ?>
                                <div class="row ">
                                    <?php $index = 0; ?>
                                    <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>

                                        <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                        <input type="hidden" name="soal_id" value="<?= $soal_id ?>">
                                        <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                        <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">

                                        <?php if ($index <= 1) : ?>

                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="col-md-1 ml-5">
                                                        <div class="form-group" style="margin:auto; ">
                                                            <label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md" style="text-align: left;">


                                                        <?php
                                                        $pilihan = explode(';', substr($rowSoalModul['pilihan'], 0, -1));
                                                        ?>
                                                        <table style="width: 98%;" class="table" style="border:none !important;">
                                                            <?php for ($i = 0; $i < count($pilihan); $i++) : ?>
                                                                <tr style="border:none !important;">
                                                                    <td style="border:none !important;">
                                                                        <div class="form-group">
                                                                            <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" disabled name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="<?= $arr_abjad[$i] ?>">
                                                                        </div>
                                                                    </td>
                                                                    <td style="border:none !important;">
                                                                        <label class="teks-soal" style="text-align: right;font-weight: normal;"><?= strtoupper($arr_abjad[$i]) ?>.<?= strtoupper($pilihan[$i]) ?></label>
                                                                    </td>
                                                                </tr>
                                                            <?php endfor; ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="col-md-5">
                                                <div class="row mt-5">
                                                    <div class="col-md-1 ml-5">
                                                        <div class="form-group" style="margin:auto; ">
                                                            <label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md" style="text-align: left;">


                                                        <?php
                                                        $pilihan = explode(';', substr($rowSoalModul['pilihan'], 0, -1));
                                                        ?>
                                                        <table style="width: 98%;" class="table" style="border:none !important;">
                                                            <?php for ($i = 0; $i < count($pilihan); $i++) : ?>
                                                                <tr style="border:none !important;">
                                                                    <td style="border:none !important;">
                                                                        <div class="form-group">
                                                                            <input style="width: 50px;" type="radio" class="jawaban radio-pilihan" disabled name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="<?= $arr_abjad[$i] ?>">
                                                                        </div>
                                                                    </td>
                                                                    <td style="border:none !important;">
                                                                        <label class="teks-soal" style="text-align: right;font-weight: normal;"><?= strtoupper($arr_abjad[$i]) ?>.<?= strtoupper($pilihan[$i]) ?></label>
                                                                    </td>
                                                                </tr>
                                                            <?php endfor; ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php $index++; ?>
                                    <?php endwhile; ?>

                                </div>
                                <div class="row mt-5 mb-4" style="margin:auto; text-align:center;">
                                    <div class="col-md-12">
                                        <input hidden class="btn btn-secondary w-50" type="submit" value="Submit Jawaban" name="soal_10_wa" id="soal_10_wa">
                                        <input class="btn btn-success w-50 button-tes" type="button" value="KIRIM JAWABAN" name="soal_10_wa_" id="soal_10_wa_">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row text-center " style="height:100%">
                                <?php if ($resultSoalModul->num_rows > 0) : ?>
                                    <?php $index = 0; ?>
                                    <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>

                                        <p class="" style="border: 1px solid #DFDFDF;margin-left:5px;margin-top:-10px;line-height: 30px;border-radius: 3px;width: 35px;height: 30px;font-size: 10pt;">
                                            <?= $rowSoalModul['nomor_soal'] ?>
                                        </p>
                                        <?php $index++; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
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
            $('#soal_10_wa').click();
        }


        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_10_wa_').click(function() {
            var konf = confirm('Apakah anda telah selesai mengerjakan?');
            if (konf == true) {
                $('#soal_10_wa').click();
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