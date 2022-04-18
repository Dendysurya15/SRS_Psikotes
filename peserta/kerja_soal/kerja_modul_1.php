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
    if ($_SESSION['kerja_soal'] != 'soal_1') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
$timer  = '';
$batas  = new DateTime($_SESSION['w_selesai']);
$b      = $batas->format('H:i:s');


$resultSelSoal      = $soal->SelectSoal2('Modul 1');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_1');
        $queryNomorSoal    =  $soal->SelectDataSoalModul($soal_id, 'modul_1');
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
        case 1:
            echo '
                        <script>
                            var html = "Biodata berhasil di simpan, selamat mengerjakan semoga berhasil!";
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

$resPeserta       = $soal->Peserta('id', $_SESSION['i_peserta'], 'select');
$rowPeserta       = $resPeserta->fetch_assoc();

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[0]);

$status_s = $arr_s2[1];

$resSoal1         = $soal->SelectSoal2('Modul 1');
$rowSoal1         = $resSoal1->fetch_assoc();

$d         = $rowSoal1['durasi'];

if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 1');
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

$arraySoal = array();
$userSoal = array();
while ($result = $resultSoalModul->fetch_assoc()) {
    $arraySoal[] = $result;
    $max = max($arraySoal);
    $min = min($arraySoal);
    $userSoal[] = $result['nomor_soal'];
}
$index = isset($_GET['index']) ? ($_GET['index']) : 1;

if (isset($_SESSION['jawaban_soal' . $index])) {
    $draft_jawaban = $_SESSION['jawaban_soal' . $index];
}
$status_pengerjaan = 0;
if (isset($_SESSION['status_pengerjaan'])) {
    $status_pengerjaan = $_SESSION['status_pengerjaan'];
}

$checkedSoal = array();
$checkedJawabanSoal = array();
$session_str = json_encode($_SESSION);

$session_arr = explode(',', $session_str);
$result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');
if (!empty($result_partial_arr)) {
    foreach ($result_partial_arr as $session_data) {
        //hapus char pertama dan terakhir yaitu petik
        $firstlastchar = substr($session_data, 1, -1);
        //ubah ke array nomor soal dan jawaban
        $clean_session = explode('":"', $firstlastchar);
        //ambil hanya soal yg memiliki jawaban
        if (!empty($clean_session[1]) && $clean_session[1] != '"') {
            $checkedSoal[] = preg_replace('/[^0-9]/', '', $clean_session[0]);
            $checkedJawabanSoal[] = preg_replace('/[^0-9]/', '', $clean_session[0]) . '=' . $clean_session[1];
        }
    }

    json_encode($checkedSoal);
    json_encode($checkedJawabanSoal);
}

?>

<style>
    input[type=radio] {

        width: 40%;
        height: 1em;
    }

    body {
        overflow-x: hidden;
        /* Hide scrollbars */
    }

    .boxJawaban:hover {

        background-color: #F1F2F4;
        /* box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.1); */
        color: black;
        cursor: pointer;
    }

    .boxJawaban {
        all: unset;
    }
</style>

<body class="hold-transition unselectable sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
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
            <a href="" class="brand-link">
                <img src="../../layout/dist/img/CBI-logo.png" alt="Covid Tracker" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PSIKOTEST</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="../auth/logout.php" onclick="return confirm('Logout berarti anda telah selesai melakukan psikotes\ndan anda tidak melakukan login kembali! apakah anda yakin?')" class="nav-link">
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
                <div class="content-fluid">

                    <div class="row mb-2" id="modul-name">
                        <div class="col-sm-12" style="text-align:center;">
                            <h1 class="m-0 pl-2 text-dark">
                                Pengerjaan Soal 1
                            </h1>
                        </div>
                    </div>

                </div>
            </section>
            <section class="content row">
                <div class="col-12" id="pane_soal">
                    <div class="card pb-5 pt-5" id="card-main">
                        <div class="card-header" id="card-header">
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
                        <div id="soal_contoh">

                            <form>
                                <!-- PENJELASAN -->

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
                                            Pada test ini anda akan menjumpai sejumlah gambar, dimana gambar-gambar A B & C adalah gambar soal, sedangkan gambar 1 2 3 4 5 merupakan pilihan jawabannya.
                                            Tugas anda adalah melanjutkan gambar C dengan pola yang sama seperti pola perubahan gambar A menjadi gambar B.
                                        </h3>
                                        <h3 class="content-header">
                                            Contoh 1. :
                                            Gambar A merupakan kotak persegi empat, gambar B merupakan kotak persegi empat dengan garis kecil di atas kotak tersebut. Untuk mendapatkan gambar B, anda harus menambahkan garis kecil di atas Gambar A. Sehingga, jika gambar C diberi perlakuan yang sama seperti gambar A, maka akan menjadi gambar 2.
                                        </h3>
                                    </div>
                                </div>

                                <!-- PENJELASAN -->

                                <!-- CONTOH SOAL 1 -->
                                <div class="row mt-4" style="margin:auto;">
                                    <div class="col-md-1" style="text-align:right;">
                                        <label class="teks-soal">1.</label>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <img src="../../admin/gambar_soal/contoh_1.png" style="width:100%; height:100%;">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="1">
                                        <label class="teks-soal">1</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="2">
                                        <label class="teks-soal">2</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="3">
                                        <label class="teks-soal">3</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="4">
                                        <label class="teks-soal">4</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="5">
                                        <label class="teks-soal">5</label>
                                    </div>
                                </div>
                            </div> -->
                                <!-- CONTOH SOAL 1 -->


                                <!-- CONTOH SOAL 2 -->

                                <div class="row mt-4">
                                    <div class="col-md-10" style="margin-left: auto; margin-right: auto;">
                                        <h3 class="content-header">
                                            Contoh 2:
                                            Gambar A merupakan sebuah lingkaran utuh, gambar merupakan setengah lingkaran. Untuk mendapatkan gambar B, anda harus memotong bagian kiri gambar A. Jika perlakuan yang sama diberikan kepada gambar C, maka akan diperoleh gambar 5.
                                        </h3>
                                    </div>
                                </div>

                                <div class="row mt-5" style="margin:auto;">
                                    <div class="col-md-1" style="text-align:right;">
                                        <label class="teks-soal">2.</label>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <img src="../../admin/gambar_soal/contoh_2.png" style="width:100%; height:100%;">
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="1">
                                        <label class="teks-soal">1</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="2">
                                        <label class="teks-soal">2</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="3">
                                        <label class="teks-soal">3</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="4">
                                        <label class="teks-soal">4</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="5">
                                        <label class="teks-soal">5</label>
                                    </div>
                                </div>
                            </div> -->
                                <!-- CONTOH SOAL 2 -->

                                <!-- CONTOH SOAL 3 -->

                                <!-- <div class="row mt-5" style="margin:auto;">
                                <div class="col-md-1" style="text-align:right;">
                                    <label class="teks-soal">3.</label>
                                </div>
                                <div class="col-md-11">
                                    <div class="form-group">
                                        <img src="../../admin/gambar_soal/3_1_3.png" style="width:100%; height:100%;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="1">
                                        <label class="teks-soal">1</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="2">
                                        <label class="teks-soal">2</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="3">
                                        <label class="teks-soal">3</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="4">
                                        <label class="teks-soal">4</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="jawaban radio-pilihan" type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="5">
                                        <label class="teks-soal">5</label>
                                    </div>
                                </div>
                            </div> -->
                                <!-- CONTOH SOAL 3 -->
                            </form>

                        </div>
                        <form action="../query/peserta_query" method="post" id="soal_asli" hidden>
                            <table>
                                <?php if ($resultSoalModul->num_rows > 0) : ?>

                                    <div class="col-12 ml-3">
                                        <h4 class=" font-weight-bold ml-3"><?= $arraySoal[$index - 1]['nomor_soal'] ?>.</h4>
                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <input type="hidden" name="nomor_soal<?= $index ?>" value="<?= $index ?>">
                                        <input type="hidden" name="kerja_soal" value="<?= $_SESSION['kerja_soal'] ?>">
                                        <input type="hidden" name="soal_pintas" id="soal_pintas">
                                        <input type="hidden" name="status_pengerjaan" value="1">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <img src="../../admin/gambar_soal/<?= $arraySoal[$index - 1]['link_gambar'] ?>" style="width:100%; height:100%;">
                                        </div>
                                    </div>

                                    <div class="row h4 mt-5 mb-4 font-weight-bold w-50 mx-auto">
                                        <div class="col">
                                            <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '1') { ?> checked="checked" <?php } ?> value="1">
                                            <label class="" for="exampleRadios2">
                                                1
                                            </label>
                                        </div>
                                        <div class="col">
                                            <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '2') { ?> checked="checked" <?php } ?> value="2">
                                            <label class="" for="exampleRadios2">
                                                2
                                            </label>
                                        </div>
                                        <div class="col">
                                            <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '3') { ?> checked="checked" <?php } ?> value="3">
                                            <label class="" for="exampleRadios2">
                                                3
                                            </label>
                                        </div>
                                        <div class="col">
                                            <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '4') { ?> checked="checked" <?php } ?> value="4">
                                            <label class="" for="exampleRadios2">
                                                4
                                            </label>
                                        </div>
                                        <div class="col">
                                            <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '5') { ?> checked="checked" <?php } ?> value="5">
                                            <label class="" for="exampleRadios2">
                                                5
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-12">

                                        <button hidden id="prev" name="draft_jawaban_prev" type="submit" class="float-left btn btn-info ml-5"><i class="mr-2 fas fa-angle-left"></i>PREV</button>
                                        <button hidden id="next" name="draft_jawaban_next" type="submit" class="btn btn-info ml-2">NEXT<i class="ml-2 fas fa-angle-right"></i></button>
                                        <input type="hidden" name="checked_jawaban_soal" value="<?= implode(", ", $checkedJawabanSoal) ?>">
                                        <input type="hidden" name="ans_soal_terakhir" id="ans_soal_terakhir">
                                        <input type="hidden" name="soal_terakhir" id="soal_terakhir">
                                        <input type="hidden" name="checked_soal" value="<?= implode(", ", $checkedSoal) ?>">
                                        <input type="hidden" name="user_soal" value="<?= implode(", ", $userSoal) ?>">
                                        <input type="hidden" name="jumlah_soal" value="<?= $max['nomor_soal'] ?>">
                                        <button hidden name="soal_1" id="soal_1" class="btn btn-secondary w-50" type="submit">
                                            Submit
                                        </button>
                                        <button name="soal_1_" id="soal_1_" hidden class="float-right btn btn-success  mr-5" type="button">
                                            KIRIM JAWABAN
                                        </button>
                                    </div>

                                <?php else : ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <input name="soal_1" id="soal_1" class="btn btn-secondary w-50" type="submit" value="Tidak Ada">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </table>
                    </div>
                </div>
                <div class="col-3" id="status_jawaban" hidden>
                    <div class="card">
                        <div style="border-bottom: 1pt solid #E9ECEF;">
                            <h5 class="text-center text-bold pt-3 pb-2"> Status Jawaban</h5>
                        </div>
                        <div class="card-body ">
                            <div class="row text-center " style="height:100%">
                                <?php if ($queryNomorSoal->num_rows > 0) :
                                    $increment = 1;
                                ?>
                                    <?php while ($resultSoal = $queryNomorSoal->fetch_assoc()) : ?>

                                        <button name="draft_jawaban_pintas" onclick="soalPintas(<?= $increment ?>)" id="soal<?= $increment ?>" class="boxJawaban" style="border: 1px solid #DFDFDF;margin-left:4px;line-height: 30px;margin-bottom:10px;border-radius: 3px;width: 35px;height: 30px;font-size: 10pt;">
                                            <?= $resultSoal['nomor_soal'] ?>
                                        </button>
                                    <?php

                                        $increment++;
                                    endwhile; ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
        </div>

    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</body>

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
<script src="script_soal.js"></script>


<script>
    var timer_ = <?= $d; ?>;
    $("body").on("contextmenu", function(e) {
        return false;
    });

    var obj = <?= json_encode($checkedSoal) ?>;
    var soalNow = <?= $index ?>;
    var soalMin = <?= $min['nomor_soal'] ?>;
    var soalMax = <?= $max['nomor_soal'] ?>;
    var radio_button_list = document.getElementsByName('jawaban');
    var session_status_pengerjaan = <?= $status_pengerjaan ?>;
    var radio_button;
    var count;
    var id_jawaban = document.getElementById('ans_soal_terakhir');
    const radioButtons = document.querySelectorAll('input[name="jawaban"]');

    if (soalNow == soalMax) {
        $('#soal_1_').removeAttr('hidden');
    }

    if (session_status_pengerjaan == 1) {

        $('#soal_asli').removeAttr('hidden');
        $('#pane_soal').removeAttr('class');
        document.getElementById('pane_soal').setAttribute("class", "col-9");


        $('#status_jawaban').removeAttr('hidden');

        $('#soal_contoh').attr('hidden', true);
        $('#card-header').attr('hidden', true);

        $('#modul-name').attr('hidden', false);

        $('#sisa_waktu').removeAttr('hidden');
        $('.jawaban').removeAttr('disabled');
        var time = setInterval(function() {

            timer_ = timer_ - 1;
            if (timer_ > 0) {
                document.getElementById('s_w').innerHTML = 'Sisa Waktu : ' + timer_ + ' Detik';
            } else {
                clearInterval(time);
                Pesan();
            }
        }, 1000);
    }
    // console.log(session_status_pengerjaan);
    for (var i = soalMin; i <= soalMax; i++) {
        if (i == soalNow) {
            document.getElementById('soal' + i).style.border = '2px solid #E08253';
        }

        for (var j = 0; j < obj.length; j++) {


            if (i == obj[j]) {
                document.getElementById('soal' + i).style.backgroundColor = '#50c878';
                document.getElementById('soal' + i).style.color = 'whitesmoke';
                document.getElementById('soal' + i).onmouseover = function() {
                    this.style.backgroundColor = "#40A060";
                }
                document.getElementById('soal' + i).onmouseleave = function() {
                    this.style.backgroundColor = "#50C878";
                }
            }
        }
    }

    for (count = 0; count < radio_button_list.length; count++) {
        radio_button_list[count].onclick = function() {
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
            } else {
                radio_button = this;
            }
        };
    }

    function soalPintas(index) {
        document.getElementById('soal_pintas').value = index;
        document.forms[0].submit();
    }

    if (soalNow == soalMin) {
        $('#next').removeAttr('hidden');

        $('#next').removeAttr('class');
        document.getElementById('next').setAttribute("class", "float-left btn btn-info ml-5");

    } else if (soalNow == soalMax) {
        $('#prev').removeAttr('hidden');
    } else {
        $('#prev').removeAttr('hidden');
        $('#next').removeAttr('hidden');
    }

    function Pesan() {
        $('#soal_1').click();
    }

    $('#soal_asli').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

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
                $('#card-header').attr('hidden', true);
                $('#soal_contoh').attr('hidden', true);
                $('#card-main').attr('hidden', true);
                $('#modul-name').attr('hidden', true);
            }
        }

    })

    $('#soal_1_').click(function() {
        var conf = confirm('Sudah selesai mengerjakan?');
        if (conf == true) {
            let val_radio;
            for (const radioButton of radioButtons) {
                if (radioButton.checked) {
                    val_radio = radioButton.value;
                    break;
                }
            }
            id_jawaban.value = val_radio;
            document.getElementById("soal_terakhir").value = soalNow;
            $('#soal_1').click();
        }
    });

    function Timer() {
        var time = setInterval(function() {
            // Set a value of the class attribute
            $('#soal_asli').removeAttr('hidden');
            $('#pane_soal').removeAttr('class');
            document.getElementById('pane_soal').setAttribute("class", "col-9");

            $('#status_jawaban').removeAttr('hidden');
            $('#card-main').attr('hidden', false);
            $('#modul-name').attr('hidden', false);
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

    //timer waktu pengerjaan tes
    var countDownDate = new Date("<?= date_format(new DateTime($rowRoom['tanggal']), 'M d, Y') ?> <?= $rowRoom['jam_selesai'] ?>").getTime();

    // Update the count down every 1 second
    setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // If the count down is over, write some text 
        if (distance < 0) {
            window.location.href = '../auth/login.php?status=2';
        }
    }, 1000);
</script>

<style>
    .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
</style>