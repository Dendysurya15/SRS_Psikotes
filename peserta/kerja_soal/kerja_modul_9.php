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
    if ($_SESSION['kerja_soal'] != 'soal_9') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 9');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_9');
        $queryNomorSoal    =  $soal->SelectDataSoalModul($soal_id, 'modul_9');
        break;
}

$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[8]);

$status_s   = $arr_s2[1];


$resSoal2         = $soal->SelectSoal2('Modul 9');
$rowSoal2         = $resSoal2->fetch_assoc();

$d                = $rowSoal2['durasi'];

if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 9');
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
$all_session_soal = array();
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
        //store semua session soal yang telah dibuat
        $all_session_soal[] = preg_replace('/[^0-9]/', '', $clean_session[0]);;
    }

    json_encode($all_session_soal);
    json_encode($checkedSoal);
    json_encode($checkedJawabanSoal);
}
?>

<style>
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

                    <div class="row mb-2" id="modul-name">
                        <div class="col-sm-12" style="text-align:center;">
                            <h1 class="m-0 pl-2 text-dark">
                                Pengerjaan Soal 9
                            </h1>
                        </div>
                    </div>

                </div>
            </section>
            <section class="content row">
                <div class="col-12" id="pane_soal">
                    <div class="card  pb-5 pt-5" id="card-main">
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
                            <form class="mt-4 ml-5">

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
                                            Tes ini berisi mengenai aktivitas-aktvitas di setiap nomornya. Dalam tes ini anda hanya perlu
                                            memilih aktivitas yang anda sukai dengan mencentang box jawaban dan kosongkan apabila anda tidak menyukai aktivitas tersebut.
                                        </h3>
                                    </div>
                                </div>
                                <table style="width: 98%; border: none;" class="table table-bordered table-hover text-center">
                                    <tr style="border: none;">
                                        <td style="width: 8%; border: none;">
                                            <h4 class="teks-soal">1. </h4>
                                        </td>
                                        <td style="text-align: left; border: none;">
                                            <label class="teks-soal">Saya suka bekerja dengan hal yang berkaitan dengan otomotif
                                            </label>
                                        </td>
                                        <td style="width: 12%; border: none;">
                                            <div class="form-group">
                                                <input class="jawaban radio-pilihan" type="checkbox" style="width: 35px; height:35px;" name="kategori_1" value="R"><br>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>

                                    <tr style="border: none;">
                                        <td style="width: 8%; border: none;">
                                            <h4 class="teks-soal">2. </h4>
                                        </td>
                                        <td style="text-align: left; border: none;">
                                            <label class="teks-soal">Saya suka mengerjakan puzzle</label>
                                        </td>
                                        <td style="width: 12%; border: none;">
                                            <div class="form-group">
                                                <input class="jawaban radio-pilihan" type="checkbox" style="width: 35px; height:35px;" name="kategori_2" value="I"><br>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>

                                    <tr style="border: none;">
                                        <td style="width: 8%; border: none;">
                                            <h4 class="teks-soal">3. </h4>
                                        </td>
                                        <td style="text-align: left; border: none;">
                                            <label class="teks-soal">Saya dapat bekerja secara mandiri/independen
                                            </label>
                                        </td>
                                        <td style="width: 12%; border: none;">
                                            <div class="form-group">
                                                <input class="jawaban radio-pilihan" type="checkbox" style="width: 35px; height:35px;" name="kategori_3" value="A"><br>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                    <tr style="border: none;">
                                        <td style="border: none;"></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <form id="soal_asli" hidden action="../query/peserta_query" method="post" class="mt-4 ml-5">
                            <table style="width: 98%; border: none;" class="table table-bordered table-hover text-center">

                                <?php if ($resultSoalModul->num_rows > 0) : ?>
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <input type="hidden" name="nomor_soal<?= $index ?>" value="<?= $index ?>">
                                    <input type="hidden" name="kerja_soal" value="<?= $_SESSION['kerja_soal'] ?>">
                                    <input type="hidden" name="soal_pintas" id="soal_pintas">
                                    <input type="hidden" name="status_pengerjaan" value="1">

                                    <tbody style="border: none;">
                                        <tr style="border: none;">
                                            <td style="width: 8%; border: none;">
                                                <h4 class="teks-soal"><?= $arraySoal[$index - 1]['nomor_soal'] ?>. </h4>
                                            </td>
                                            <td style="text-align: left; border: none;">
                                                <label class="teks-soal"><?= $arraySoal[$index - 1]['pernyataan'] ?></label>
                                            </td>
                                            <td style="width: 12%; border: none;">
                                                <div class="form-group">
                                                    <input class="jawaban" type="checkbox" style="width: 35px; height:35px;" disabled name="jawaban" <?php if (isset($draft_jawaban) && $draft_jawaban ==  $arraySoal[$index - 1]['kategori']) { ?> checked="checked" <?php } ?> value="<?= $arraySoal[$index - 1]['kategori'] ?>"><br>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr rowspan="2" style="border: none;">
                                            <td colspan="4" style="border: none;"></td>
                                        </tr>
                                        <tr style="border: none;">
                                        </tr>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                            <div class="col-12 pt-3">

                                <button hidden id="prev" name="draft_jawaban_prev" type="submit" class="float-left btn btn-info ml-5"><i class="mr-2 fas fa-angle-left"></i>PREV</button>
                                <button hidden id="next" name="draft_jawaban_next" type="submit" class="btn btn-info ml-2">NEXT<i class="ml-2 fas fa-angle-right"></i></button>
                                <input type="hidden" name="checked_jawaban_soal" value="<?= implode(", ", $checkedJawabanSoal) ?>">

                                <input type="hidden" name="checked_soal" value="<?= implode(", ", $checkedSoal) ?>">
                                <input type="hidden" name="user_soal" value="<?= implode(", ", $userSoal) ?>">
                                <input type="hidden" name="jumlah_soal" value="<?= $max['nomor_soal'] ?>">
                                <button hidden name="soal_9" id="soal_9" class="btn btn-secondary w-50" type="submit">
                                    Submit
                                </button>
                                <button name="soal_9_" id="soal_9_" class="float-right btn btn-success  mr-5" type="button">
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
        var timer_ = <?= $d; ?>;
        $("body").on("contextmenu", function(e) {
            return false;
        });

        var obj = <?= json_encode($all_session_soal) ?>;
        var soalNow = <?= $index ?>;
        var soalMin = <?= $min['nomor_soal'] ?>;
        var soalMax = <?= $max['nomor_soal'] ?>;
        var session_status_pengerjaan = <?= $status_pengerjaan ?>;


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
                    clearInterval(time)
                    Pesan();
                }
            }, 1000);
        }

        console.log(obj.length);
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
            $('#soal_9').click();
        }

        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_9_').click(function() {
            var konf = confirm('Apakah anda telah selesai mengerjakan?');
            if (konf == true) {
                $('#soal_9').click();
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
                    $('#card-header').attr('hidden', true);
                    $('#soal_contoh').attr('hidden', true);
                    $('#card-main').attr('hidden', true);
                    $('#modul-name').attr('hidden', true);
                }
            }

        })

        function Timer() {
            var time = setInterval(function() {
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