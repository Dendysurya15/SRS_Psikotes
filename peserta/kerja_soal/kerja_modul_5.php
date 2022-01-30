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

                    <div class="row mb-2">
                        <div class="col-sm-12" style="text-align:center;">
                            <h1 class="m-0 pl-2 text-dark">
                                Pengerjaan Soal 5
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
                                        <button class="btn btn-danger w-50 button-tes-2" id="timer" onclick="startCounting()">MULAI TEST</button>
                                    <?php else : ?>
                                        <button class="btn btn-success w-50 button-tes" id="timer" onclick="startCounting()">MULAI TEST</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <form id="soal_contoh" class="mt-3 ml-4">

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

                        <form id="soal_asli" class="mt-3 ml-4" hidden action="../query/peserta_query" method="post">

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

                                        <?php $index = 1; ?>
                                        <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                            <?php
                                            $kategori_setuju    = explode(';', $rowSoalModul['kategori_setuju']);
                                            $pernyataan         = explode(';', $rowSoalModul['pernyataan']);
                                            $kategori_tidak_setuju  =  explode(';', $rowSoalModul['kategori_tidak_setuju']);
                                            $jumlah_ += 1;

                                            $arr_nomor .= '0,';
                                            ?>

                                            <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                            <input type="hidden" name="soal_id" value="<?= $soal_id ?>">
                                            <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                            <input type="hidden" name="nomor_soal[]" id="nomor_soal_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $rowSoalModul['nomor_soal'] ?>">

                                            <tr style="border: none;">
                                                <?php if ($index == 1) : ?>
                                                    <td style="border: none;">
                                                        <h4><?= $rowSoalModul['nomor_soal'] ?>. </h4>
                                                    </td>

                                                    <td style="border: none;">
                                                        <?php $index_setuju = 1; ?>
                                                        <?php for ($i = 0; $i < count($kategori_setuju); $i++) : ?>
                                                            <div class="form-group">
                                                                <input id="kategori_setuju_<?= $rowSoalModul['nomor_soal'] ?>_<?= $index_setuju ?>" class="form-control jawaban" disabled type="radio" name="kategori_setuju_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori_setuju[$i] ?>"><br>
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
                                                                <input id="kategori_tidak_setuju_<?= $rowSoalModul['nomor_soal'] ?>_<?= $index_tidak_setuju ?>" class="form-control jawaban" disabled type="radio" name="kategori_tidak_setuju_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori_tidak_setuju[$i] ?>"><br>
                                                            </div>
                                                            <?php $index_tidak_setuju++ ?>
                                                        <?php endfor; ?>
                                                    </td>
                                                <?php else : ?>

                                                    <td style="border: none;">
                                                        <h4><?= $rowSoalModul['nomor_soal'] ?>. </h4>
                                                    </td>

                                                    <td style="border: none;">
                                                        <?php $index_setuju = 1; ?>
                                                        <?php for ($i = 0; $i < count($kategori_setuju); $i++) : ?>
                                                            <div class="form-group">
                                                                <input id="kategori_setuju_<?= $rowSoalModul['nomor_soal'] ?>_<?= $index_setuju ?>" class="form-control jawaban" disabled type="radio" name="kategori_setuju_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori_setuju[$i] ?>"><br>
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
                                                                <input id="kategori_tidak_setuju_<?= $rowSoalModul['nomor_soal'] ?>_<?= $index_tidak_setuju ?>" class="form-control jawaban" disabled type="radio" name="kategori_tidak_setuju_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori_tidak_setuju[$i] ?>"><br>
                                                            </div>
                                                            <?php $index_tidak_setuju++ ?>
                                                        <?php endfor; ?>
                                                    </td>
                                                <?php endif; ?>

                                            </tr>
                                            <tr style="border: none;">
                                                <td style="border: none;"></td>
                                            </tr>
                                            <?php $index++; ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>

                                </tbody>
                                <tfoot style="border: none;">
                                    <tr style="border: none;">
                                        <td colspan="4" style="border: none;">
                                            <input hidden name="soal_5" id="soal_5" class="btn btn-secondary w-50" type="submit" value="Submit Jawaban">
                                            <input name="soal_5_" id="soal_5_" class="btn btn-success w-50 button-tes" type="button" value="KIRIM JAWABAN">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
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

        <?php
        $arr_nomor = substr($arr_nomor, 0, -1);
        ?>

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
        var nomor = <?= $jumlah_; ?>;
        $("body").on("contextmenu", function(e) {
            return false;
        });

        var nomor_soal_konf = '<?= $arr_nomor; ?>';
        var nomor_soal_kiri = nomor_soal_konf.split(',');
        var nomor_soal_kanan = nomor_soal_konf.split(',');

        console.log(nomor_soal_konf);
        console.log(nomor_soal_kiri);
        console.log(nomor_soal_kanan);


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
            var arr_belum = [];
            for (let i = 0; i < nomor_soal_kanan.length; i++) {
                if (nomor_soal_kanan[i] == 0) {
                    arr_belum.push(i + 1);
                } else if (nomor_soal_kiri[i] == 0) {
                    arr_belum.push(i + 1);
                }
            }

            if (arr_belum.length != 0) {
                var teks = 'Nomor soal yang belum diisi:\n' + arr_belum.toString();
                alert(teks);
            } else {
                var konf = confirm('Apakah anda ingin mengirim jawaban?');
                if (konf == true) {
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



        for (let i = 1; i < nomor; i++) {
            for (let j = 1; j <= 4; j++) {
                if (j == 1) {
                    $('#kategori_tidak_setuju_' + i + '_1').click(function() {
                        $('#kategori_setuju_' + i + '_1').prop('disabled', true);
                        $('#kategori_setuju_' + i + '_2').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_3').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_4').removeAttr('disabled');
                        nomor_soal_kanan[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);

                    });
                    $('#kategori_setuju_' + i + '_1').click(function() {
                        $('#kategori_tidak_setuju_' + i + '_1').prop('disabled', true);
                        $('#kategori_tidak_setuju_' + i + '_2').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_3').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_4').removeAttr('disabled');
                        nomor_soal_kiri[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                } else if (j == 2) {
                    $('#kategori_tidak_setuju_' + i + '_2').click(function() {
                        $('#kategori_setuju_' + i + '_2').prop('disabled', true);
                        $('#kategori_setuju_' + i + '_1').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_3').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_4').removeAttr('disabled');
                        nomor_soal_kanan[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                    $('#kategori_setuju_' + i + '_2').click(function() {
                        $('#kategori_tidak_setuju_' + i + '_2').prop('disabled', true);
                        $('#kategori_tidak_setuju_' + i + '_1').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_3').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_4').removeAttr('disabled');
                        nomor_soal_kiri[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                } else if (j == 3) {
                    $('#kategori_tidak_setuju_' + i + '_3').click(function() {
                        $('#kategori_setuju_' + i + '_3').prop('disabled', true);
                        $('#kategori_setuju_' + i + '_1').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_2').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_4').removeAttr('disabled');
                        nomor_soal_kanan[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                    $('#kategori_setuju_' + i + '_3').click(function() {
                        $('#kategori_tidak_setuju_' + i + '_3').prop('disabled', true);
                        $('#kategori_tidak_setuju_' + i + '_1').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_2').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_4').removeAttr('disabled');
                        nomor_soal_kiri[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                } else if (j == 4) {
                    $('#kategori_tidak_setuju_' + i + '_4').click(function() {
                        $('#kategori_setuju_' + i + '_4').prop('disabled', true);
                        $('#kategori_setuju_' + i + '_1').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_2').removeAttr('disabled');
                        $('#kategori_setuju_' + i + '_3').removeAttr('disabled');
                        nomor_soal_kanan[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                    $('#kategori_setuju_' + i + '_4').click(function() {
                        $('#kategori_tidak_setuju_' + i + '_4').prop('disabled', true);
                        $('#kategori_tidak_setuju_' + i + '_1').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_2').removeAttr('disabled');
                        $('#kategori_tidak_setuju_' + i + '_3').removeAttr('disabled');
                        nomor_soal_kiri[i - 1] = 1;
                        console.log(nomor_soal_kanan);
                        console.log(nomor_soal_kiri);
                    });
                }

            }
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