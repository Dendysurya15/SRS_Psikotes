<?php
define('WP_HOME', 'http://www.assessmentcenter-ssms.com/');
define('WP_SITEURL', 'http://www.assessmentcenter-ssms.com/');

date_default_timezone_set("Asia/Jakarta");
include_once '../layout/header.php';

include '../../kumpulan_function.php';

$soal = new Soal();
$skor  = $soal->Skor($_SESSION['i_room']);
$namaPeserta    = $skor->fetch_assoc();
$namaPeserta = $namaPeserta['nama_peserta'];
$soal_id = '';

if (isset($_SESSION['kerja_soal'])) {
    if ($_SESSION['kerja_soal'] != 'soal_7') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 7');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_7');
        break;
}

$pernyataan             = "";
$kategori               = "";

$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[6]);

$status_s   = $arr_s2[1];

$jumlah    = 0;
$arr_nomor  = '';


$resSoal2         = $soal->SelectSoal2('Modul 7');
$rowSoal2         = $resSoal2->fetch_assoc();

$d                = $rowSoal2['durasi'];

if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 7');
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
                                Pengerjaan Soal 7
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
                                        Pada tes ini di setiap nomornya memiliki 2 pilihan yang berisi mengenai sikap atau tindakan yang
                                        akan anda ambil di dalam lingkungan kerja. Jadi anda harus memilih salah satu dari 2 pilihan
                                        tersebut yang paling sesuai dengan diri anda.
                                    </h3>
                                </div>
                            </div>

                            <table style="width: 98%;" class="table" style="border:none !important;">
                                <tbody>
                                    <tr style="border: none;">
                                        <td rowspan="2" style="width: 10%; border:none;"><label class="teks-soal">1.</label></td>
                                        <td style="width: 75%; border:none;"><label class="teks-soal" style="font-size: 14pt;">Saya tidak akan menegur pelanggar-pelanggar peraturan bila saya merasa pasti bahwa tidak ada satu orangpun yang mengetahui tentang pelanggar-pelanggar tersebut </label></td>
                                        <td style="border: none;">
                                            <div class="form-group">
                                                <input class="form-control jawaban" type="radio" name="kategori_1" value="A">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"><label class="teks-soal" style="font-size: 14pt;">Bila saya mengumumkan suatu keputusan yang kurang menyenangkan, saya akan menjelaskan kepada bawahan saya bahwa keputusan ini dibuat oleh direktur </label></td>
                                        <td style="border: none;">
                                            <div class="form-group">
                                                <input class="form-control jawaban" type="radio" name="kategori_1" value="B">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                </tbody>

                                <tbody>
                                    <tr style="border: none;">
                                        <td rowspan="2" style="width: 10%; border:none;"><label class="teks-soal">2.</label></td>
                                        <td style="width: 75%; border:none;"><label class="teks-soal" style="font-size: 14pt;">Bila ada seorang karyawan yang hasil kerjanya selalu tidak memuaskan saya, saya akan menunggu suatu kesempatan untuk memindahkannya dan bukan untuk memecatnya </label></td>
                                        <td style="border: none;">
                                            <div class="form-group">
                                                <input class="form-control jawaban" type="radio" name="kategori_2" value="A">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"><label class="teks-soal" style="font-size: 14pt;">Bila ada bawahan saya yang dikucilkan dari kelompok kerjanya, saya akan mencari jalan agar orang lain dapat berteman dengannya </label></td>
                                        <td style="border: none;">
                                            <div class="form-group">
                                                <input class="form-control jawaban" type="radio" name="kategori_2" value="B">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                </tbody>

                                <tbody>
                                    <tr style="border: none;">
                                        <td rowspan="2" style="width: 10%; border:none;"><label class="teks-soal">3.</label></td>
                                        <td style="width: 75%; border:none;"><label class="teks-soal" style="font-size: 14pt;">Bila direktur memberikan perintah yang kurang menyenangkan, saya pikir adalah cukup bijaksana bila saya menyebutkan namanya dan bukan nama saya </label></td>
                                        <td style="border: none;">
                                            <div class="form-group">
                                                <input class="form-control jawaban" type="radio" name="kategori_3" value="A">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"><label class="teks-soal" style="font-size: 14pt;">Bila biasanya membuat keputusan-keputusan sendiri dan menyampaikannya kepada bawahan saya
                                            </label></td>
                                        <td style="border: none;">
                                            <div class="form-group">
                                                <input class="form-control jawaban" type="radio" name="kategori_3" value="B">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>

                        <form hidden id="soal_asli" action="../query/peserta_query" method="post" class="mt-4  ml-5">
                            <table style="width: 98%;" class="table" style="border:none !important;">

                                <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                <input type="hidden" name="soal_id" value="<?= $soal_id ?>">
                                <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                <?php if ($resultSoalModul->num_rows > 0) : ?>

                                    <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                        <tbody>
                                            <?php
                                            $pernyataan     = explode(';', $rowSoalModul['pernyataan']);
                                            $kategori       =  explode(';', $rowSoalModul['kategori']);

                                            $jumlah += 1;
                                            $arr_nomor .= '0,';

                                            ?>

                                            <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">

                                            <tr style="border: none;">
                                                <td rowspan="2" style="width: 10%; border:none;"><label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>.</label></td>
                                                <td style="width: 75%; border:none;"><label class="teks-soal" style="font-size: 14pt;"><?= $pernyataan[0] ?></label></td>
                                                <td style="border: none;">
                                                    <div class="form-group">
                                                        <input id="kategori_<?= $rowSoalModul['nomor_soal'] ?>_1" class="form-control jawaban" type="radio" disabled name="kategori_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori[0] ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border: none;">
                                                <td style="border: none;"><label class="teks-soal" style="font-size: 14pt;"><?= $pernyataan[1] ?></label></td>
                                                <td style="border: none;">
                                                    <div class="form-group">
                                                        <input id="kategori_<?= $rowSoalModul['nomor_soal'] ?>_2" class="form-control jawaban" type="radio" disabled name="kategori_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori[1] ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border: none;">
                                                <td style="border: none;"></td>
                                            </tr>
                                        </tbody>
                                    <?php endwhile; ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <div class="col-md-12" style="margin:auto; text-align: center;">
                                                    <input hidden name="soal_7" id="soal_7" class="btn btn-secondary w-50" type="submit" value="Submit Jawaban">
                                                    <input name="soal_7_" id="soal_7_" class="btn btn-success w-50 button-tes" type="button" value="KIRIM JAWABAN">
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
        var timer_ = <?= $d; ?>;
        var jumlah = <?= $jumlah; ?>;
        $("body").on("contextmenu", function(e) {
            return false;
        });

        var nomor_soal_konf = '<?= $arr_nomor; ?>';
        var nomor_soal_kiri = nomor_soal_konf.split(',');

        for (let index = 1; index <= jumlah; index++) {
            $('#kategori_' + index + '_1').click(function() {
                nomor_soal_kiri[index - 1] = 1;
                console.log(nomor_soal_kiri);
            });
            $('#kategori_' + index + '_2').click(function() {
                nomor_soal_kiri[index - 1] = 1;
                console.log(nomor_soal_kiri);
            });
        }

        function Pesan() {
            $('#soal_7').click();
        }

        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_7_').click(function() {
            var arr_belum = [];
            for (let i = 0; i < nomor_soal_kiri.length; i++) {
                if (nomor_soal_kiri[i] == 0) {
                    arr_belum.push(i + 1);
                }
            }
            if (arr_belum.length != 0) {
                var teks = 'Nomor soal yang belum diisi:\n' + arr_belum.toString();
                alert(teks);
            } else {
                var konf = confirm('Apakah anda telah selesai mengerjakan?');
                if (konf == true) {
                    $('#soal_7').click();
                }
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