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
    if ($_SESSION['kerja_soal'] != 'soal_5') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 5');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_5');
        $queryNomorSoal    =  $soal->SelectDataSoalModul($soal_id, 'modul_5');
        break;
}

$kategori_setuju        = "";
$pernyataan             = "";
$kategori_tidak_setuju  = "";


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

$jumlah_   = 1;

$arr_nomor  = '';

$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[4]);

$status_s   = $arr_s2[1];


$arr_nomor  = '';

$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[4]);

$status_s   = $arr_s2[1];


$resSoal2         = $soal->SelectSoal2('Modul 5');
$rowSoal2         = $resSoal2->fetch_assoc();

$d                = $rowSoal2['durasi'];
if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 5');
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
    $tmp = explode('_', $draft_jawaban);
    $draft_kiri = $tmp[0];
    $draft_kanan = $tmp[1];
}
$status_pengerjaan = 0;
if (isset($_SESSION['status_pengerjaan'])) {
    $status_pengerjaan = $_SESSION['status_pengerjaan'];
}

$checkedSoal = array();
$halfCheckedSoal = array();
$checkedJawabanSoal = array();
$emptyCheckedSoal = array();
$session_str = json_encode($_SESSION);

$session_arr = explode(',', $session_str);
$result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');


if (!empty($result_partial_arr)) {
    foreach ($result_partial_arr as $session_data) {
        //hapus char pertama dan terakhir yaitu petik
        $firstlastchar = substr($session_data, 1, -1);
        //ubah ke array nomor soal dan jawaban
        $clean_session = explode('":"', $firstlastchar);
        //ubah ke array dan dapatkan jawaban
        $tmp = explode('_', $clean_session[1]);
        $kiri = $tmp[0];
        $kanan = preg_replace('/[^0-9]/', '', $tmp[1]);
        $kiri = $tmp[0];
        $kanan = preg_replace('/[^0-9]/', '', $tmp[1]);

        if ($kiri != '0' && $kanan != '0') {
            $checkedSoal[] = preg_replace('/[^0-9]/', '', $clean_session[0]);
            $checkedJawabanSoal[] = preg_replace('/[^0-9]/', '', $clean_session[0]) . '=' . $tmp[0] . ',' . $tmp[1];
        } else if ($kiri != '0' || $kanan != '0') {
            $halfCheckedSoal[] = preg_replace('/[^0-9]/', '', $clean_session[0]);
        } else {
            $emptyCheckedSoal[] = preg_replace('/[^0-9]/', '', $clean_session[0]);
        }
    }

    json_encode($checkedSoal);
    json_encode($halfCheckedSoal);
    json_encode($emptyCheckedSoal);
    json_encode($checkedJawabanSoal);
}

$soal_kosong = array_diff($userSoal, $checkedSoal);
$soal_kosong = (array) $soal_kosong;

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

                    <div class="row mb-2" id="modul-name">
                        <div class="col-sm-12" style="text-align:center;">
                            <h1 class="m-0 pl-2 text-dark">
                                Pengerjaan Soal 5
                            </h1>
                        </div>
                    </div>

                </div>
            </section>
            <section class="content row">
                <div class="col-12 " id="pane_soal">
                    <div class="card pb-5 pt-5" id="card-main">
                        <div class="card-header" id="card-header">
                            <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                <div class="col-md-12">
                                    <?php if ($status_s == 0) : ?>
                                        <button class="btn btn-danger w-50 button-tes-2" id="timer" onclick="startCounting()">MULAI TEST</button>
                                    <?php else : ?>
                                        <button class="btn btn-success w-50 button-tes" id="timer" onclick="startCounting()">MULAI TEST</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div id="soal_contoh">
                            <form class="mt-3 ml-4">

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
                                            Pada tes ini, setiap nomor memiliki 4 pernyataan yang berisi mengenai gambaran sikap atau
                                            perilaku. Di sini anda harus memilih satu yang sesuai atau menggambarkan diri anda dengan klik
                                            pada pilihan di bawah kata “setuju” dan memilih satu yang tidak sesuai atau tidak menggambarkan
                                            diri anda dengan klik pada pilihan di bawah kata “tidak setuju”.
                                        </h3>
                                    </div>
                                </div>

                                <table style="width: 98%; border:none;" class="table table-bordered table-hover text-center">
                                    <thead style="border: none;">
                                        <tr style="border: none;">
                                            <th style="border: none;">
                                                <h4>Nomor Soal</h4>
                                            </th>
                                            <th style="width: 10%; border:none;">
                                                <h4>Setuju</h4>
                                            </th>
                                            <th style="width: 65%; border:none;">
                                                <h4>Pernyataan</h4>
                                            </th>
                                            <th style="width: 10%; border:none;">
                                                <h4>Tidak Setuju</h4>
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody style="border: none;">
                                        <tr style="border: none;">
                                            <td style="border: none;">
                                                <h4>1. </h4>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <input id="kategori_setuju_100_1" class="form-control jawaban" type="radio" name="kategori_setuju_1" value="S"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_100_2" class="form-control jawaban" type="radio" name="kategori_setuju_1" value="I"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_100_3" class="form-control jawaban" type="radio" name="kategori_setuju_1" value="*"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_100_4" class="form-control jawaban" type="radio" name="kategori_setuju_1" value="C"><br>
                                                </div>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <p class="teks-soal" style="font-size: 17.5pt;">Mudah bergaul, ramah mudah setuju </p>
                                                </div>
                                                <div class="form-group">
                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Mempercayai, percaya pada orang lain
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Petualang, suka mengambil resiko
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Penuh toleransi, menghormati orang lain </p>
                                                </div>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_100_1" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_1" value="S"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_100_2" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_1" value="I"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_100_3" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_1" value="C"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_100_4" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_1" value="C"><br>
                                                </div>
                                            </td>

                                        </tr>

                                        <tr style="border: none;">
                                            <td style="border: none;"></td>
                                        </tr>

                                        <tr style="border: none;">
                                            <td style="border: none;">
                                                <h4>2. </h4>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <input id="kategori_setuju_200_1" class="form-control jawaban" type="radio" name="kategori_setuju_2" value="D"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_200_2" class="form-control jawaban" type="radio" name="kategori_setuju_2" value="C"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_200_3" class="form-control jawaban" type="radio" name="kategori_setuju_2" value="*"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_200_4" class="form-control jawaban" type="radio" name="kategori_setuju_2" value="*"><br>
                                                </div>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <p class="teks-soal" style="font-size: 17.5pt;">Yang penting adalah hasil
                                                    </p>
                                                </div>
                                                <div class="form-group">

                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Kerjakan dengan benar, ketepatan sangat penting
                                                    </p>
                                                </div>
                                                <div class="form-group">

                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Buat agar menyenangkan
                                                    </p>
                                                </div>
                                                <div class="form-group">

                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Kerjakan bersama-sama
                                                    </p>
                                                </div>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_200_1" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_2" value="D"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_200_2" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_2" value="C"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_200_3" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_2" value="S"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_200_4" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_2" value="S"><br>
                                                </div>
                                            </td>


                                        </tr>

                                        <tr style="border: none;">
                                            <td style="border: none;"></td>
                                        </tr>

                                        <tr style="border: none;">
                                            <td style="border: none;">
                                                <h4>3. </h4>
                                            </td>

                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <input id="kategori_setuju_300_1" class="form-control jawaban" type="radio" name="kategori_setuju_3" value="*"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_300_2" class="form-control jawaban" type="radio" name="kategori_setuju_3" value="D"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_300_3" class="form-control jawaban" type="radio" name="kategori_setuju_3" value="S"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_setuju_300_4" class="form-control jawaban" type="radio" name="kategori_setuju_3" value="I"><br>
                                                </div>
                                            </td>
                                            <td style="border: none;">
                                                <div class="form-group">

                                                    <p class="teks-soal" style="font-size: 17.5pt;">Pendidikan, kebudayaan
                                                    </p>
                                                </div>
                                                <div class="form-group">

                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Prestasi, penghargaan
                                                    </p>
                                                </div>
                                                <div class="form-group">

                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Keselamatan, keamanan
                                                    </p>
                                                </div>
                                                <div class="form-group">

                                                    <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;">Sosial, pertemuan kelompok
                                                    </p>
                                                </div>
                                            </td>
                                            <td style="border: none;">
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_300_1" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_3" value="C"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_300_2" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_3" value="D"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_300_3" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_3" value="S"><br>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kategori_tidak_setuju_300_4" class="form-control jawaban" type="radio" name="kategori_tidak_setuju_3" value="*"><br>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style="border: none;">
                                            <td style="border: none;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <form id="soal_asli" class="mt-2 ml-4" hidden action="../query/peserta_query" method="post">

                            <table style="width: 98%; border: none;" class="table table-bordered table-hover text-center">
                                <thead style="border: none;">
                                    <tr style="border: none;">
                                        <th style="border: none;">
                                            <h4>Nomor Soal</h4>
                                        </th>
                                        <th style="width: 10%; border: none;">
                                            <h4>Setuju</h4>
                                        </th>
                                        <th style="width: 65%; border: none;">
                                            <h4>Pernyataan</h4>
                                        </th>
                                        <th style="width: 10%; border:none;">
                                            <h4>Tidak Setuju</h4>
                                        </th>
                                    </tr>

                                </thead>
                                <tbody style="border: none;">
                                    <?php if ($resultSoalModul->num_rows > 0) : ?>


                                        <?php
                                        $kategori_setuju    = explode(';',  $arraySoal[$index - 1]['kategori_setuju']);
                                        $pernyataan         = explode(';', $arraySoal[$index - 1]['pernyataan']);
                                        $kategori_tidak_setuju  =  explode(';', $arraySoal[$index - 1]['kategori_tidak_setuju']);
                                        ?>

                                        <input type="hidden" name="index" value="<?= $index ?>">
                                        <input type="hidden" name="nomor_soal<?= $index ?>" value="<?= $index ?>">
                                        <input type="hidden" name="kerja_soal" value="<?= $_SESSION['kerja_soal'] ?>">
                                        <input type="hidden" name="soal_pintas" id="soal_pintas">
                                        <input type="hidden" name="status_pengerjaan" value="1">

                                        <tr style="border: none;">

                                            <td style="border: none;">
                                                <h4><?= $arraySoal[$index - 1]['nomor_soal'] ?>. </h4>
                                            </td>

                                            <td style="border: none;">
                                                <?php $index_setuju = 1; ?>
                                                <?php for ($i = 0; $i < count($kategori_setuju); $i++) : ?>
                                                    <div class="form-group">
                                                        <input id="kategori_setuju_<?= $arraySoal[$index - 1]['nomor_soal'] ?>_<?= $index_setuju ?>" class="form-control jawaban" disabled type="radio" name="jawaban_kiri" <?php if (isset($draft_jawaban) && $draft_kiri == $kategori_setuju[$i]) { ?> checked="checked" <?php } ?> value="<?= $kategori_setuju[$i] ?>"><br>
                                                    </div>
                                                    <?php $index_setuju++ ?>
                                                <?php endfor; ?>
                                            </td>

                                            <td style="border: none;">
                                                <?php for ($i = 0; $i < count($pernyataan); $i++) : ?>
                                                    <div class="form-group">
                                                        <?php if ($i == 0) : ?>
                                                            <p class="teks-soal" style="font-size: 17.5pt;"><?= $pernyataan[$i] ?></p>
                                                        <?php else : ?>
                                                            <p class="teks-soal" style="margin-top: 45px; font-size: 17.5pt;"><?= $pernyataan[$i] ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endfor; ?>
                                            </td>

                                            <td style="border: none;">
                                                <?php $index_tidak_setuju = 1 ?>
                                                <?php for ($i = 0; $i < count($kategori_tidak_setuju); $i++) : ?>
                                                    <div class="form-group">
                                                        <input id="kategori_tidak_setuju_<?= $arraySoal[$index - 1]['nomor_soal'] ?>_<?= $index_tidak_setuju ?>" class="form-control jawaban" disabled type="radio" name="jawaban_kanan" <?php if (isset($draft_jawaban) && $draft_kanan ==  $kategori_tidak_setuju[$i]) { ?> checked="checked" <?php } ?> value="<?= $kategori_tidak_setuju[$i] ?>"> <br>
                                                    </div>
                                                    <?php $index_tidak_setuju++ ?>
                                                <?php endfor; ?>
                                            </td>


                                        </tr>
                                        <tr style="border: none;">
                                            <td style="border: none;"></td>
                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>
                            <div class="col-12 pt-3">

                                <button hidden id="prev" name="draft_jawaban_prev" type="submit" class="float-left btn btn-info ml-5"><i class="mr-2 fas fa-angle-left"></i>PREV</button>
                                <button hidden id="next" name="draft_jawaban_next" type="submit" class="btn btn-info ml-2">NEXT<i class="ml-2 fas fa-angle-right"></i></button>
                                <input type="hidden" name="checked_jawaban_soal" value="<?= implode(", ", $checkedJawabanSoal) ?>">
                                <input type="hidden" name="ans_soal_terakhir" id="ans_soal_terakhir">
                                <input type="hidden" name="soal_terakhir" id="soal_terakhir">
                                <input type="hidden" name="checked_soal" value="<?= implode(", ", $checkedSoal) ?>">
                                <input type="hidden" name="user_soal" value="<?= implode(", ", $userSoal) ?>">
                                <input type="hidden" name="jumlah_soal" value="<?= $max['nomor_soal'] ?>">
                                <button hidden name="soal_5" id="soal_5" class="btn btn-secondary w-50" type="submit">
                                    Submit
                                </button>
                                <button name="soal_5_" id="soal_5_" hidden class="float-right btn btn-success  mr-5" type="button">
                                    KIRIM JAWABAN
                                </button>
                            </div>
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
        var timer;
        var timer_ = <?= $d; ?>;
        var soal_kosong = Object.values(<?= json_encode($soal_kosong) ?>);
        $("body").on("contextmenu", function(e) {
            return false;
        });

        var arrFull = <?= json_encode($checkedSoal) ?>;
        var arrHalf = <?= json_encode($halfCheckedSoal) ?>;
        var soalNow = <?= $index ?>;
        var soalMin = <?= $min['nomor_soal'] ?>;
        var soalMax = <?= $max['nomor_soal'] ?>;
        var radio_button_list = document.getElementsByName('jawaban');
        var session_status_pengerjaan = <?= $status_pengerjaan ?>;
        var radio_button;
        var count;
        var id_jawaban = document.getElementById('ans_soal_terakhir');
        const radioButtonsKanan = document.querySelectorAll('input[name="jawaban_kanan"]');
        const radioButtonsKiri = document.querySelectorAll('input[name="jawaban_kiri"]');

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

        for (var i = soalMin; i <= soalMax; i++) {
            if (i == soalNow) {
                document.getElementById('soal' + i).style.border = '2px solid #E08253';
            }

            //full checked soal
            for (var j = 0; j < arrFull.length; j++) {
                if (i == arrFull[j]) {
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

            //half checked soal
            for (var k = 0; k < arrHalf.length; k++) {
                if (i == arrHalf[k]) {
                    document.getElementById('soal' + i).style.backgroundColor = '#E1C16E';
                    document.getElementById('soal' + i).style.color = 'whitesmoke';
                    document.getElementById('soal' + i).onmouseover = function() {
                        this.style.backgroundColor = "#ddb859";
                    }
                    document.getElementById('soal' + i).onmouseleave = function() {
                        this.style.backgroundColor = "#E1C16E";
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
            $('#soal_5').click();
        }

        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_5_').click(function() {
            var sisa_soal = soal_kosong.length
            var radiokananchecked = false;
            var radiokirichecked = false;
            for (const radioButtonKiri of radioButtonsKiri) {
                if (radioButtonKiri.checked) {
                    radiokananchecked = true;
                    break;
                }
            }
            for (const radioButtonKanan of radioButtonsKanan) {
                if (radioButtonKanan.checked) {
                    radiokirichecked = true;
                    break;
                }
            }

            if (radiokananchecked == true && radiokirichecked == true) {
                sisa_soal = soal_kosong.length - 1
            }

            if (sisa_soal < 0) {
                sisa_soal = sisa_soal + 1
            }

            if (sisa_soal != 0) {
                var teks = 'Nomor soal yang belum diisi:\n' + soal_kosong.toString();
                alert(teks);
            } else {
                var konf = confirm('Apakah anda ingin mengirim jawaban?');
                if (konf == true) {
                    let val_radio_kanan;
                    let val_radio_kiri;
                    for (const radioButtonKiri of radioButtonsKiri) {
                        if (radioButtonKiri.checked) {
                            val_radio_kiri = radioButtonKiri.value;
                            break;
                        }
                    }
                    for (const radioButtonKanan of radioButtonsKanan) {
                        if (radioButtonKanan.checked) {
                            val_radio_kanan = radioButtonKanan.value;
                            break;
                        }
                    }
                    id_jawaban.value = val_radio_kiri + ',' + val_radio_kanan;
                    document.getElementById("soal_terakhir").value = soalNow;
                    $('#soal_5').click();
                }
            }
        });

        function startCounting() {
            var stat_soal = <?= $status_s; ?>;
            if (stat_soal == 0) {
                confirm('Admin belum mempersilahkan untuk mengerjakan soal!');
                location.reload();

            } else {
                var konf = confirm('Apakah anda yakin untuk memulai tes?');
                if (konf == true) {
                    $('#sisa_waktu').removeAttr('hidden');
                    $('.jawaban').removeAttr('disabled');
                    $('#timer').attr('hidden', true);

                    $('#soal_asli').removeAttr('hidden');
                    $('#pane_soal').removeAttr('class');
                    document.getElementById('pane_soal').setAttribute("class", "col-9");

                    $('#status_jawaban').removeAttr('hidden');
                    $('#soal_contoh').attr('hidden', true);
                    timer = window.setTimeout("countDown()", 1000);
                    window.status = timer_; // show the initial value
                }

            }
        }

        function countDown() {
            timer_ = timer_ - 1;
            window.status = timer_;
            if (timer_ == 0) {
                window.clearTimeout(timer);
                timer = null;
                Pesan();
            } else {
                timer = window.setTimeout("countDown()", 1000);
                document.getElementById('s_w').innerHTML = 'Sisa Waktu : ' + timer_ + ' Detik';
            }
        }

        $('#kategori_tidak_setuju_' + soalNow + '_1').click(function() {
            $('#kategori_setuju_' + soalNow + '_1').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_setuju_' + soalNow + '_1').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        $('#kategori_setuju_' + soalNow + '_1').click(function() {
            $('#kategori_tidak_setuju_' + soalNow + '_1').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_tidak_setuju_' + soalNow + '_1').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        $('#kategori_tidak_setuju_' + soalNow + '_2').click(function() {
            $('#kategori_setuju_' + soalNow + '_2').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_setuju_' + soalNow + '_2').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        $('#kategori_setuju_' + soalNow + '_2').click(function() {
            $('#kategori_tidak_setuju_' + soalNow + '_2').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_tidak_setuju_' + soalNow + '_2').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        $('#kategori_tidak_setuju_' + soalNow + '_3').click(function() {
            $('#kategori_setuju_' + soalNow + '_3').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_setuju_' + soalNow + '_3').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        $('#kategori_setuju_' + soalNow + '_3').click(function() {
            $('#kategori_tidak_setuju_' + soalNow + '_3').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_tidak_setuju_' + soalNow + '_3').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        $('#kategori_tidak_setuju_' + soalNow + '_4').click(function() {
            $('#kategori_setuju_' + soalNow + '_4').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_setuju_' + soalNow + '_4').prop('disabled', false);
            } else {
                radio_button = this;
            }
        });

        if (soalNow == soalMax) {
            $('#soal_5_').removeAttr('hidden');
        }

        $('#kategori_setuju_' + soalNow + '_4').click(function() {
            $('#kategori_tidak_setuju_' + soalNow + '_4').prop('disabled', true);
            if (radio_button == this) {
                this.checked = false;
                radio_button = null;
                $('#kategori_tidak_setuju_' + soalNow + '_4').prop('disabled', false);
            } else {
                radio_button = this;
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