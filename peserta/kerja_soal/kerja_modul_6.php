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
    if ($_SESSION['kerja_soal'] != 'soal_6') {
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

$timer = '';
$resultSelSoal      = $soal->SelectSoal2('Modul 6');
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
        $resultSoalModul    =  $soal->SelectDataSoalModul($soal_id, 'modul_6');
        break;
}

$pernyataan             = "";
$kategori               = "";

$resRoom    = $soal->DetailRoom($_SESSION['i_room']);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[5]);

$status_s   = $arr_s2[1];

$jumlah    = 0;
$arr_nomor  = '';

$resSoal2         = $soal->SelectSoal2('Modul 6');
$rowSoal2         = $resSoal2->fetch_assoc();

$d                = $rowSoal2['durasi'];

if ($status_s == 1) {
    if ($_SESSION['w_selesai'] == '') {

        $n_jam                = date('H:i:s');

        $resSoal1         = $soal->SelectSoal2('Modul 6');
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
                                Pengerjaan Soal 6
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
                                    <?php else : ?>
                                        <button class="btn btn-success w-50 button-tes" id="timer">
                                            MULAI TES
                                        </button>
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
                                        Dalam tes ini setiap nomornya memiliki 2 pilihan atau pernyataan yang berisi gambaran sikap atau
                                        perilaku. Di sini anda harus memilih salah satu yang paling sesuai dengan diri anda.
                                    </h3>
                                </div>
                            </div>

                            <table style="width: 98%; border:none;" class="table table-bordered table-hover text-center">

                                <tr style="border: none;">
                                    <td style="width: 10%; border:none;">
                                        <h4>1. </h4>
                                    </td>
                                    <td style="width: 75%; border:none; text-align: left;">
                                        <label class="teks-soal">Saya seorang pekerja keras</label><br>
                                        <label class="teks-soal">Saya tidak suka uring-uringan</label><br>
                                        <label class="teks-soal"></label><br>
                                    </td>
                                    <td style="border: none;">
                                        <input class="form-control jawaban" type="radio" name="kategori_1" value="G"><br>
                                        <input class="form-control jawaban" type="radio" name="kategori_1" value="E"><br>
                                    </td>
                                </tr>

                                <tr style="border: none;">
                                    <td style="border: none;"></td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"></td>
                                </tr>

                                <tr style="border: none;">
                                    <td style="width: 10%; border:none;">
                                        <h4>2. </h4>
                                    </td>
                                    <td style="width: 75%; border:none; text-align: left;">
                                        <label class="teks-soal">Saya suka menghasilkan pekerjaan yang lebih baik daripada orang lain
                                        </label>
                                        <label class="teks-soal">Saya akan tetap menangani suatu pekerjaan sampai selesai
                                        </label>
                                    </td>
                                    <td style="border: none;">
                                        <input class="form-control jawaban" type="radio" name="kategori_2" value="A"><br>

                                        <input class="form-control jawaban" type="radio" name="kategori_2" value="N"><br>

                                    </td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"></td>
                                </tr>
                                <tr style="border: none;">
                                    <td style="border: none;"></td>
                                </tr>

                                <tr style="border: none;">
                                    <td style="width: 10%; border: none;">
                                        <h4>3. </h4>
                                    </td>
                                    <td style="width: 75%; text-align: left; border: none;">
                                        <label class="teks-soal">Saya suka menunjukkan pada orang lain cara melakukan sesuatu
                                        </label><br>
                                        <label class="teks-soal">Saya ingin berusaha sebaik mungkin
                                        </label><br>
                                    </td>
                                    <td style="border: none;">
                                        <input class="form-control jawaban" type="radio" name="kategori_3" value="P"><br>
                                        <input class="form-control jawaban" type="radio" name="kategori_3" value="A"><br>
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

                        <form id="soal_asli" hidden action="../query/peserta_query" method="post" class="mt-3 ml-4">
                            <table style="width: 98%; border: none;" class="table table-bordered table-hover text-center">
                                <?php if ($resultSoalModul->num_rows > 0) : ?>
                                    <tbody style="border: none;">
                                        <?php while ($rowSoalModul = $resultSoalModul->fetch_assoc()) : ?>
                                            <tr style="border: none;">
                                                <?php
                                                $pernyataan     = explode(';', $rowSoalModul['pernyataan']);
                                                $kategori       =  explode(';', $rowSoalModul['kategori']);

                                                $jumlah += 1;

                                                $arr_nomor .= '0,';

                                                ?>

                                                <input type="hidden" name="id_user" value="<?= $_SESSION['i_peserta'] ?>">
                                                <input type="hidden" name="soal_id" value="<?= $soal_id ?>">
                                                <input type="hidden" name="room_id" value="<?= $_SESSION['room_id'] ?>">

                                                <input type="hidden" name="nomor_soal[]" value="<?= $rowSoalModul['nomor_soal'] ?>">
                                                <td style="width: 10%; border: none;">
                                                    <h4><?= $rowSoalModul['nomor_soal'] ?>. </h4>
                                                </td>
                                                <td style="width: 75%; border: none; text-align: left;">
                                                    <?php for ($i = 0; $i < count($pernyataan); $i++) : ?>
                                                        <label class="teks-soal"><?= $pernyataan[$i] ?></label><br>
                                                    <?php endfor; ?>
                                                </td>
                                                <td style="border: none;">
                                                    <?php for ($i = 0; $i < count($kategori); $i++) : ?>
                                                        <input id="kategori_<?= $rowSoalModul['nomor_soal'] ?>_<?= $i + 1 ?>" class="form-control jawaban" type="radio" disabled name="kategori_<?= $rowSoalModul['nomor_soal'] ?>" value="<?= $kategori[$i] ?>"><br>
                                                    <?php endfor; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>

                                    </tbody>
                                    <tfoot style="border: none;">
                                        <tr style="border: none;">
                                            <td colspan="4" style="border: none;">
                                                <input hidden name="soal_6" id="soal_6" class="btn btn-secondary w-50" type="submit" value="Submit Jawaban">
                                                <input name="soal_6_" id="soal_6_" class="btn btn-success w-50 button-tes" type="button" value="KIRIM JAWABAN">

                                            </td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
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
            $('#soal_6').click();
        }


        $('#soal_asli').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        $('#soal_6_').click(function() {
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
                    $('#soal_6').click();
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