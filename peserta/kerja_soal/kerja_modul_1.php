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

$skor  = $soal->Skor($_SESSION['i_room']);
$namaPeserta    = $skor->fetch_assoc();
$namaPeserta = $namaPeserta['nama_peserta'];

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

?>

<body class="hold-transition unselectable sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link">Selamat datang! <?= $namaPeserta; ?> </a>
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
                                Pengerjaan Soal 1
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

                        <form id="soal_contoh">
                            <!-- PENJELASAN -->
                            <div class="row mt-4">
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

                        <form action="../query/peserta_query" method="post" class="mt-5" id="soal_asli" hidden>
                            <table>
                                <?php if ($resultSoalModul->num_rows > 0) : ?>
                                    <?php $index = 1; ?>
                                    <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                        <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                        <input type="hidden" name="id_soal" value="<?= $soal_id ?>">
                                        <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                        <?php if ($index == 1) : ?>
                                            <div class="row mt-2" style="margin:auto;">
                                                <div class="col-md-1" style="text-align:right;">
                                                    <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">
                                                    <label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>.</label>
                                                </div>
                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <img src="../../admin/gambar_soal/<?= $rowSoalModul['link_gambar'] ?>" style="width:100%; height:100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="row mt-5" style="margin:auto;">
                                                <div class="col-md-1" style="text-align:right;">
                                                    <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">
                                                    <label class="teks-soal"><?= $rowSoalModul['nomor_soal'] ?>.</label>
                                                </div>
                                                <div class="col-md-11">
                                                    <div class="form-group">
                                                        <img src="../../admin/gambar_soal/<?= $rowSoalModul['link_gambar'] ?>" style="width:100%; height:100%;">
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="1">
                                                    <label class="teks-soal">1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="2">
                                                    <label class="teks-soal">2</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="3">
                                                    <label class="teks-soal">3</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="4">
                                                    <label class="teks-soal">4</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="jawaban radio-pilihan" disabled type="radio" name="jawaban_<?= $rowSoalModul['nomor_soal'] ?>" id="optionsRadios1" value="5">
                                                    <label class="teks-soal">5</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $index++ ?>
                                    <?php endwhile; ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <button hidden name="soal_1" id="soal_1" class="btn btn-secondary w-50" type="submit">
                                                Submit
                                            </button>
                                            <button name="soal_1_" id="soal_1_" class="btn btn-success w-50 button-tes" type="button">
                                                KIRIM JAWABAN
                                            </button>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="row mt-2 mb-4" style="margin:auto; text-align:center;">
                                        <div class="col-md-12">
                                            <input name="soal_1" id="soal_1" class="btn btn-secondary w-50" type="submit" value="Tidak Ada">
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

    $('#soal_1_').click(function() {
        var conf = confirm('Sudah selesai mengerjakan?');
        if (conf == true) {
            $('#soal_1').click();
        }
    });

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