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

$resultSelSoal      = $soal->SelectSoal2('Modul 1');
switch ($resultSelSoal) {
    case $resultSelSoal->num_rows > 0:
        $rowSelectSoal  = $resultSelSoal->fetch_assoc();
        $soal_id        = 1;
        $timer          = $rowSelectSoal['durasi'];
        break;

    default:
        $soal_id        = 'Tidak Ada';
        break;
}

$resultSoalModul    =  $soal->SelectDataSoalModul(1, 'modul_1');
$queryNomorSoal    =  $soal->SelectDataSoalModul(1, 'modul_1');


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

    // print_r($checkedSoal);

    // print_r($checkedSoal);

    // print_r($checkedJawabanSoal);
    json_encode($checkedSoal);
    json_encode($checkedJawabanSoal);

    // echo implode(", ", $checkedSoal);
}

$resRoom    = $soal->DetailRoom(120);
$rowRoom    = $resRoom->fetch_assoc();
$statSoal   = $rowRoom['status_soal'];

$resPeserta       = $soal->Peserta('id', 897, 'select');
$rowPeserta       = $resPeserta->fetch_assoc();

$arr_s1     = explode(';', $statSoal);

$arr_s2     = explode('=', $arr_s1[0]);

$status_s = $arr_s2[1];

$resSoal1         = $soal->SelectSoal2('Modul 1');
$rowSoal1         = $resSoal1->fetch_assoc();

$d         = $rowSoal1['durasi'];


$resSoal1         = $soal->SelectSoal2('Modul 1');
$rowSoal1         = $resSoal1->fetch_assoc();


?>

<style>
    input[type=radio] {

        width: 40%;
        height: 1em;
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

<div class="wrapper">

    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-fluid ">

                <div class="row mb-2">
                    <div class="col-sm-12" style="text-align:center;">
                        <h1 class="m-0 pl-2 text-dark">
                            Pengerjaan Soal 1

                            <?php


                            echo  $num_status_login = $rowPeserta['status_login'] - 1;
                            // echo $draft_jawaban;
                            var_export($_SESSION);
                            // $test = array();
                            // $arr = implode(" ", $_SESSION);


                            // print_r($test);
                            // print_r($test);

                            // print_r($result_partial_arr);
                            // $firstlastchar = substr($result_partial_arr[0], 1, -1);
                            // //ubah ke array nomor soal dan jawaban

                            // $clean_session = explode('":"', $firstlastchar);

                            // print_r($clean_session);
                            // if (!empty($clean_session[1]) && $clean_session[1] != '"') {
                            //     echo 'yes';
                            // } else {
                            //     echo 'no';
                            // }
                            // print_r($session_str);

                            // print_r($clean_session);
                            // json_encode($userSoal);
                            // print_r($userSoal);
                            // echo implode(", ", $userSoal);
                            ?>
                        </h1>
                    </div>
                </div>

            </div>
        </section>
        <section class="content row">
            <div class="col-9">
                <div class="card pb-5 pt-5">
                    <form action="../test/cekSession" method="post">
                        <table>
                            <?php if ($resultSoalModul->num_rows > 0) : ?>

                                <div class="col-12 ml-3">
                                    <h2 class="teks-soal font-weight-bold ml-3"><?= $arraySoal[$index - 1]['nomor_soal'] ?>.</h2>
                                    <input type="hidden" name="index" value="<?= $index ?>">
                                    <input type="hidden" name="nomor_soal<?= $index ?>" value="<?= $index ?>">
                                    <input type="hidden" name="soal_pintas" id="soal_pintas">


                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <img src="../../admin/gambar_soal/<?= $arraySoal[$index - 1]['link_gambar'] ?>" style="width:100%; height:100%;">
                                    </div>
                                </div>

                                <div class="row h4 mt-5 mb-5 font-weight-bold w-50 mx-auto">
                                    <div class="col">
                                        <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '1') { ?> checked="checked" <?php } ?> value="1">
                                        <label class="">
                                            1
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '2') { ?> checked="checked" <?php } ?> value="2">
                                        <label class="">
                                            2
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '3') { ?> checked="checked" <?php } ?> value="3">
                                        <label class="">
                                            3
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '4') { ?> checked="checked" <?php } ?> value="4">
                                        <label class="">
                                            4
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input class="" type="radio" name="jawaban" id="exampleRadios2" <?php if (isset($draft_jawaban) && $draft_jawaban == '5') { ?> checked="checked" <?php } ?> value="5">
                                        <label class="">
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
            <div class="col-3">
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

                                    <button name="draft_jawaban_pintas" onclick="soalPintas(<?= $increment ?>)" formaction="../test/cekSession" id="soal<?= $increment ?>" class="boxJawaban" style="border: 1px solid #DFDFDF;margin-left:4px;line-height: 30px;margin-bottom:10px;border-radius: 3px;width: 35px;height: 30px;font-size: 10pt;">
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

<!-- /.content -->


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
    var radio_button;
    var count;
    var id_jawaban = document.getElementById('ans_soal_terakhir');


    // console.log(soalNow);
    const radioButtons = document.querySelectorAll('input[name="jawaban"]');

    if (soalNow == soalMax) {
        $('#soal_1_').removeAttr('hidden');
    }
    for (var i = soalMin; i <= soalMax; i++) {
        if (i == soalNow) {
            // document.getElementById('soal' + i).style.boxShadow = '0px 0px 7px 1px red';
            document.getElementById('soal' + i).style.border = '2px solid #E08253';
            // document.getElementById('soal' + i).style.backgroundColor = '#E06253';
            // document.getElementById('soal' + i).style.color = 'whitesmoke';
            // document.getElementById('soal' + i).onmouseover = function() {
            //     this.style.backgroundColor = "#E08253";
            // }
            // document.getElementById('soal' + i).onmouseleave = function() {
            //     this.style.backgroundColor = "#E06253";
            // }
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
            // document.forms[0].submit();
            // show the output:
            // output.innerText = selectedSize ? `You selected ${selectedSize}` : `You haven't selected any size`;
            $('#soal_1').click();
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
            // Set a value of the class attribute
            $('.jawaban').removeAttr('disabled');

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