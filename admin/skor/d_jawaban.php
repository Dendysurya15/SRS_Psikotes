<?php
include_once '../layout/header.php';
include '../../kumpulan_function.php';
$soal = new Soal();

$room_id        = $_GET['room_id'];
$jawaban_id     = $_GET['jawaban_id'];
$peserta_id     = $_GET['peserta_id'];

$resPeserta       = $soal->Peserta('id', $peserta_id, 'select');
$rowPeserta       = $resPeserta->fetch_assoc();

$skor  = $soal->D_Jawaban($jawaban_id, $room_id, $peserta_id);
$spesifikSkor  = $soal->D_Jawaban($jawaban_id, $room_id, $peserta_id);

$d_jawabanExcel = $skor->fetch_assoc();
$arrModul = array();
$jawabanPeserta = array();
$modul = $spesifikSkor->fetch_assoc();
$arrModul5 = explode(' ', $modul['soal_5']);
$arrModul6 = explode(',', $modul['soal_6']);
$arrModul7 = explode(';', $modul['soal_7']);
$arrModul9 = explode(',', $modul['soal_9']);

if ($modul['soal_10_fa'] != '') {
    $arrModul10FA = explode(',', $modul['soal_10_fa']);
    foreach ($arrModul10FA as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10FA[] = $splitVal[1];
    }
}
if ($modul['soal_10_se'] != '') {
    $arrModul10SE = explode(',', $modul['soal_10_se']);
    foreach ($arrModul10SE as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10SE[] = $splitVal[1];
    }
}
if ($modul['soal_10_ge'] != '') {
    $arrModul10GE = explode(',', $modul['soal_10_ge']);
    foreach ($arrModul10GE as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10GE[] = $splitVal[1];
    }
}
if ($modul['soal_10_wu'] != '') {
    $arrModul10WU = explode(',', $modul['soal_10_wu']);
    foreach ($arrModul10WU as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10WU[] = $splitVal[1];
    }
}
if ($modul['soal_10_wa'] != '') {
    $arrModul10WA = explode(',', $modul['soal_10_wa']);
    foreach ($arrModul10WA as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10WA[] = $splitVal[1];
    }
}
if ($modul['soal_10_an'] != '') {
    $arrModul10AN = explode(',', $modul['soal_10_an']);
    foreach ($arrModul10AN as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10AN[] = $splitVal[1];
    }
}

if ($modul['soal_10_ra'] != '') {
    $arrModul10RA = explode(',', $modul['soal_10_ra']);
    foreach ($arrModul10RA as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10RA[] = $splitVal[1];
    }
}
if ($modul['soal_10_zr'] != '') {
    $arrModul10ZR = explode(',', $modul['soal_10_zr']);
    foreach ($arrModul10ZR as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta10ZR[] = $splitVal[1];
    }
}

if ($modul['soal_5'] != '') {
    $arrModul5 = explode(' ', $modul['soal_5']);
    foreach ($arrModul5 as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta5[$splitVal[0]] = $splitVal[1];
    }
}

if ($modul['soal_7'] != '') {
    $arrModul7 = explode(',', $modul['soal_7']);
    foreach ($arrModul7 as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta7[$splitVal[0]] = $splitVal[1];
    }
}

if ($modul['soal_6'] != '') {
    $arrModul6 = explode(',', $modul['soal_6']);
    foreach ($arrModul6 as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta6[$splitVal[0]] = $splitVal[1];
    }
}

if ($modul['soal_9'] != '') {
    $arrModul9 = explode(',', $modul['soal_9']);
    foreach ($arrModul9 as $key => $value) {
        $splitVal = explode('=', $value);
        $jawabanPeserta9[$splitVal[0]] = $splitVal[1];
    }
}

$countSoal = 1;

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="layout/dist/css/jquery.dataTables.min.css" />
<div class="content-wrapper">
    <section class="content-header">
        <div class="content-fluid ">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 pl-2 text-dark">
                        DETAIL SKOR

                        <?php

                        // echo $d_jawabanExcel['soal_5'];
                        // echo $modul['soal_5'];

                        // if ($modul['soal_5'] != '') {
                        //     echo 'wkwkjkwjwk';
                        // } else {
                        //     echo 'akdsjflkjaslfdkjaldsk';
                        // }
                        // $modul['soal_5'];
                        ?>
                    </h1>
                </div>

            </div>

        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0 text-primary"><strong>Skor Info</strong></h5>

                        </div>

                        <!-- <div class="ml-4 mt-3">
                            <button class="btn btn-success" id="btnAllSkor">Semua Skor</button>
                            <button class="btn btn-info" hidden id="btnMsdt">MSDT</button>
                            <button class="btn btn-info" hidden id="btnIst">IST</button>
                            <button class="btn btn-info" hidden id="btnPapikostick">PAPIKOSTICK</button>
                            <button class="btn btn-info" hidden id="btnHolland">HOLLAND</button>
                            <button class="btn btn-info" hidden id="btnDisc">DISC</button>
                        </div> -->


                        <div id="msdt" class="m-5" hidden>
                            <table class="table table-borderless text-center">
                                <tbody>
                                    <?php for ($row = 0; $row < sqrt(count($arrModul7)); $row++) {
                                    ?>
                                        <tr>
                                            <?php for ($col = 0; $col < sqrt(count($arrModul7)); $col++) {
                                                if ($jawabanPeserta7[$countSoal] != '') {
                                            ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countSoal ?></td>
                                                    <th scope="col"><?= $jawabanPeserta7[$countSoal] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                }
                                                ?>

                                            <?php
                                                $countSoal++;
                                            } ?>
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div id="papikostik" hidden>
                            <div class="row">
                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta6 as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                    <th scope="col"><?= $value ?></th>
                                                </tr>

                                            <?php

                                                if ($key == 30) {
                                                    break;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta6 as $key => $value) {
                                                if ($key >= 31 && $key <= 60) {

                                            ?>
                                                    <tr>
                                                        <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                        <th scope="col"><?= $value ?></th>
                                                    </tr>

                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta6 as $key => $value) {
                                                if ($key > 60 && $key <= 90) {
                                            ?>
                                                    <tr>
                                                        <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                        <th scope="col"><?= $value ?></th>
                                                    </tr>

                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div id="holland" hidden>
                            <div class="row">
                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta9 as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                    <th scope="col"><?= $value ?></th>
                                                </tr>

                                            <?php
                                                if ($key == 21) {
                                                    break;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta9 as $key => $value) {
                                                if ($key > 21 && $key <= 42) {
                                            ?>
                                                    <tr>
                                                        <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                        <th scope="col"><?= $value ?></th>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div id="disc" hidden>
                            <div class="row">
                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta5 as $key => $value) {
                                            ?>
                                                <tr>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                    <th scope="col"><?= $value ?></th>
                                                </tr>

                                            <?php
                                                if ($key == 12) {
                                                    break;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="m-5 col-md-2">
                                    <table class="table table-borderless text-center">
                                        <tbody>
                                            <?php
                                            foreach ($jawabanPeserta5 as $key => $value) {
                                                if ($key > 12 && $key <= 24) {
                                            ?>
                                                    <tr>
                                                        <td style="background-color: #E7EAED !important;color: black;"> <?= $key ?></td>
                                                        <th scope="col"><?= $value ?></th>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div id="ist" class="row" hidden>

                            <div class="m-5 col-2">
                                <h5 class="text-center ">SE</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countSE = 0;
                                        for ($row = 0; $row < count($arrModul10SE); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10SE[$countSE] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countSE + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10SE[$countSE] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countSE++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                            <div class="m-5 col-2">
                                <h5 class="text-center ">WA</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countWA = 20;
                                        for ($row = 0; $row < count($arrModul10WA); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10WA[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countWA + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10WA[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countWA++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="m-5 col-2">
                                <h5 class="text-center ">AN</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countAN = 40;
                                        for ($row = 0; $row < count($arrModul10AN); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10AN[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countAN + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10AN[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countAN++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="m-5 col-2">
                                <h5 class="text-center ">GE</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countGE = 60;
                                        for ($row = 0; $row < count($arrModul10GE); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10GE[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countGE + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10GE[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countGE++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>


                            <div class="m-5 col-2">
                                <h5 class="text-center ">RA</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countRA = 76;
                                        for ($row = 0; $row < count($arrModul10RA); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10RA[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countRA + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10RA[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countRA++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>


                            <div class="m-5 col-2">
                                <h5 class="text-center ">ZR</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countRA = 96;
                                        for ($row = 0; $row < count($arrModul10RA); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10RA[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countRA + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10RA[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countRA++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="m-5 col-2">
                                <h5 class="text-center ">FA</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countFA = 116;
                                        for ($row = 0; $row < count($arrModul10FA); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10FA[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countFA + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10FA[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countFA++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                            <div class="m-5 col-2">
                                <h5 class="text-center ">WU</h5>
                                <table class="table border table-borderless text-center">
                                    <tbody>
                                        <?php
                                        $countWU = 136;
                                        for ($row = 0; $row < count($arrModul10WU); $row++) {
                                        ?>
                                            <tr>
                                                <?php
                                                if ($jawabanPeserta10WU[$row] != '') {
                                                ?>
                                                    <td style="background-color: #E7EAED !important;color: black;"> <?= $countWU + 1 ?></td>
                                                    <th scope="col"><?= $jawabanPeserta10WU[$row] ?></th>
                                                <?php
                                                } else {
                                                ?>
                                                    <td> </td>
                                                <?php
                                                } ?>
                                            </tr>
                                        <?php
                                            $countWU++;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>


                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <table style="width: 300%;" id="rekapTaksasi" class=" table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>
                                                No Soal
                                            </th>
                                            <th>Detail Jawaban Modul 1</th>
                                            <th>Detail Jawaban Modul 2</th>
                                            <th>Detail Jawaban Modul 3</th>
                                            <th>Detail Jawaban Modul 4</th>
                                            <th>Detail Jawaban Modul 5</th>
                                            <th>Detail Jawaban Modul 6</th>
                                            <th>Detail Jawaban Modul 7</th>
                                            <th>Detail Jawaban Modul 8</th>
                                            <th>Detail Jawaban Modul 9</th>
                                            <th>Detail Jawaban Modul 10 SE</th>
                                            <th>Detail Jawaban Modul 10 WA</th>
                                            <th>Detail Jawaban Modul 10 AN</th>
                                            <th>Detail Jawaban Modul 10 RA</th>
                                            <th>Detail Jawaban Modul 10 ZR</th>
                                            <th>Detail Jawaban Modul 10 GE</th>
                                            <th>Detail Jawaban Modul 10 FA</th>
                                            <th>Detail Jawaban Modul 10 WU</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        for ($i = 0; $i < 100; $i++) {
                                        ?>
                                            <tr>
                                                <td> <?= $i + 1 ?></td>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_1'])) {
                                                    $soal_1 = explode(',', $d_jawabanExcel['soal_1']);
                                                    // foreach ($soal_1 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        if ($i <= 20) {
                                                            $output = explode('=', $soal_1[$i]);
                                                            echo $output[1];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_2'])) {
                                                    $soal_2 = explode(',', $d_jawabanExcel['soal_2']);
                                                    // foreach ($soal_2 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        if ($i < 20) {
                                                            $output = explode('=', $soal_2[$i]);
                                                            echo $output[1];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if (!empty($d_jawabanExcel['soal_3'])) {
                                                    $soal_3 = explode(',', $d_jawabanExcel['soal_3']);
                                                    // foreach ($soal_3 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php

                                                        $output = explode('=', $soal_3[$i]);
                                                        echo $output[1];

                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_4'])) {
                                                    $soal_4 = explode(',', $d_jawabanExcel['soal_4']);
                                                    // foreach ($soal_4 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        foreach ($soal_4 as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal4[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal4);
                                                        if (!empty($jawabansoal4[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal4[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if (!empty($d_jawabanExcel['soal_5'])) {
                                                    $soal_5 = explode(' ', $d_jawabanExcel['soal_5']);
                                                ?>
                                                    <td>
                                                        <?php
                                                        foreach ($soal_5 as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal5[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal5);
                                                        if (!empty($jawabansoal5[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal5[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_6'])) {
                                                    $soal_6 = explode(',', $d_jawabanExcel['soal_6']);

                                                ?>
                                                    <td>
                                                        <?php
                                                        foreach ($soal_6 as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal6[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal6);
                                                        if (!empty($jawabansoal6[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal6[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if (!empty($d_jawabanExcel['soal_7'])) {
                                                    $soal_7 = explode(',', $d_jawabanExcel['soal_7']);
                                                    // foreach ($soal_7 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal7 = array();
                                                        foreach ($soal_7 as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal7[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal7);
                                                        if (!empty($jawabansoal7[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal7[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_8'])) {
                                                    $soal_8 = explode(',', $d_jawabanExcel['soal_8']);
                                                    // foreach ($soal_8 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        if ($i < 90) {
                                                            $output = explode('=', $soal_8[$i]);
                                                            echo $output[1];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_9'])) {
                                                    $soal_9 = explode(',', $d_jawabanExcel['soal_9']);
                                                    // foreach ($soal_9 as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        if ($i < 42) {
                                                            $output = explode('=', $soal_9[$i]);
                                                            echo $output[1];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_se'])) {
                                                    $soal_10_se = explode(',', $d_jawabanExcel['soal_10_se']);
                                                    // foreach ($soal_10_se as  $value) {
                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10se = array();
                                                        foreach ($soal_10_se as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10se[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10se);
                                                        if (!empty($jawabansoal10se[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10se[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_wa'])) {
                                                    $soal_10_wa = explode(',', $d_jawabanExcel['soal_10_wa']);
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10wa = array();
                                                        foreach ($soal_10_wa as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10wa[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10wa);
                                                        if (!empty($jawabansoal10wa[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10wa[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_an'])) {
                                                    $soal_10_an = explode(',', $d_jawabanExcel['soal_10_an']);
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10an = array();
                                                        foreach ($soal_10_an as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10an[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10an);
                                                        if (!empty($jawabansoal10an[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10an[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_ra'])) {
                                                    $soal_10_ra = explode(',', $d_jawabanExcel['soal_10_ra']);
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10ra = array();
                                                        foreach ($soal_10_ra as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10ra[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10ra);
                                                        if (!empty($jawabansoal10ra[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10ra[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_zr'])) {
                                                    $soal_10_zr = explode(',', $d_jawabanExcel['soal_10_zr']);
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10zr = array();
                                                        foreach ($soal_10_zr as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10zr[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10zr);
                                                        if (!empty($jawabansoal10zr[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10zr[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_ge'])) {
                                                    $soal_10_ge = explode(',', $d_jawabanExcel['soal_10_ge']);
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10ge = array();
                                                        foreach ($soal_10_ge as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10ge[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10ge);
                                                        if (!empty($jawabansoal10ge[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10ge[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_fa'])) {
                                                    $soal_10_fa = explode(',', $d_jawabanExcel['soal_10_fa']);
                                                    // $soal->arfay_dump($soal_10_fa);
                                                    // foreach ($soal_10_fa as  $value) {

                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10fa = array();
                                                        foreach ($soal_10_fa as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10fa[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10fa);
                                                        if (!empty($jawabansoal10fa[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10fa[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if (!empty($d_jawabanExcel['soal_10_wu'])) {
                                                    $soal_10_wu = explode(',', $d_jawabanExcel['soal_10_wu']);
                                                    // $soal->arwuy_dump($soal_10_wu);
                                                    // foreach ($soal_10_wu as  $value) {

                                                    // echo $value;
                                                ?>
                                                    <td>
                                                        <?php
                                                        $jawabansoal10wu = array();
                                                        foreach ($soal_10_wu as  $value) {
                                                            $split = explode('=', $value);
                                                            $jawabansoal10wu[($split[0]) - 1] = $split[1];
                                                        }
                                                        // $soal->array_dump($jawabansoal10wu);
                                                        if (!empty($jawabansoal10wu[$i])) {
                                                            // $output = explode('=', $soal_5[$i]);
                                                            echo $jawabansoal10wu[$i];
                                                        } else {
                                                            echo '';
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    // }
                                                    ?>

                                                <?php

                                                } else {
                                                ?>
                                                    <td></td>
                                                <?php
                                                }
                                                ?>

                                            </tr>

                                        <?php
                                        }

                                        ?>
                                    </tbody>
                                </table>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>




<script>
    // $('#rekapTaksasi').DataTable({
    //     dom: 'Bfrtip',
    //     buttons: [
    //         'excel',
    //         'pdf'
    //     ],
    //     info: false,
    //     "columnDefs": [{
    //             "orderData": 3,
    //             "targets": 2
    //         },
    //         {
    //             "visible": false,
    //             "targets": 3
    //         }
    //     ]
    // });

    var nama_user = '<?= $_GET['nama_peserta'] ?>';

    $('#rekapTaksasi').DataTable({
        dom: 'Bfrtip',
        "paging": false,
        "searching": false,
        buttons: [{
            extend: "excelHtml5",
            text: 'Export to excel',
            filename: function fred() {
                return nama_user + ' psikotes';
            },
            exportOptions: {
                orthogonal: "exportxls"
            }
        }],
        info: false,
        "columnDefs": [{
            "visible": true,
            "targets": 3
        }]

    });

    var status_peserta = '<?= $rowPeserta['jenis_tes_peserta'] ?>';

    if (status_peserta == 'staff/asisten') {
        $('#btnPapikostick').removeAttr('hidden');
        $('#btnDisc').removeAttr('hidden');
        $('#btnIst').removeAttr('hidden');
    } else if (status_peserta == 'nonstaff') {
        $('#btnHolland').removeAttr('hidden');
        $('#btnPapikostick').removeAttr('hidden');
        $('#btnDisc').removeAttr('hidden');
    } else if (status_peserta == 'asmen-up') {
        $('#btnMsdt').removeAttr('hidden');
        $('#btnIst').removeAttr('hidden');
        $('#btnPapikostick').removeAttr('hidden');
    }

    // $('#btnMsdt').click(function() {
    //     $('#allskor').attr('hidden', true);
    //     $('#disc').attr('hidden', true);
    //     $('#holland').attr('hidden', true);
    //     $('#papikostik').attr('hidden', true);
    //     $('#ist').attr('hidden', true);
    //     $('#msdt').removeAttr('hidden');
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnMsdt').setAttribute("class", "btn btn-success");
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-info");
    //     $('#btnAllSkor').removeAttr('class');
    //     document.getElementById('btnAllSkor').setAttribute("class", "btn btn-info");
    //     $('#btnPapikostick').removeAttr('class');
    //     document.getElementById('btnPapikostick').setAttribute("class", "btn btn-info");
    //     $('#btnDisc').removeAttr('class');
    //     document.getElementById('btnDisc').setAttribute("class", "btn btn-info");
    //     $('#btnHolland').removeAttr('class');
    //     document.getElementById('btnHolland').setAttribute("class", "btn btn-info");
    // })

    // $('#btnPapikostick').click(function() {
    //     $('#allskor').attr('hidden', true);
    //     $('#msdt').attr('hidden', true);
    //     $('#ist').attr('hidden', true);
    //     $('#holland').attr('hidden', true);
    //     $('#disc').attr('hidden', true);
    //     $('#papikostik').removeAttr('hidden');
    //     $('#btnPapikostick').removeAttr('class');
    //     document.getElementById('btnPapikostick').setAttribute("class", "btn btn-success");
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-info");
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnMsdt').setAttribute("class", "btn btn-info");
    //     $('#btnAllSkor').removeAttr('class');
    //     document.getElementById('btnAllSkor').setAttribute("class", "btn btn-info");
    //     $('#btnDisc').removeAttr('class');
    //     document.getElementById('btnDisc').setAttribute("class", "btn btn-info");
    //     $('#btnHolland').removeAttr('class');
    //     document.getElementById('btnHolland').setAttribute("class", "btn btn-info");
    // })


    // $('#btnHolland').click(function() {
    //     $('#allskor').attr('hidden', true);
    //     $('#msdt').attr('hidden', true);
    //     $('#ist').attr('hidden', true);
    //     $('#papikostik').attr('hidden', true);
    //     $('#disc').attr('hidden', true);
    //     $('#holland').removeAttr('hidden');
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnHolland').setAttribute("class", "btn btn-success");
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-info");
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnMsdt').setAttribute("class", "btn btn-info");
    //     $('#btnAllSkor').removeAttr('class');
    //     document.getElementById('btnAllSkor').setAttribute("class", "btn btn-info");
    //     $('#btnDisc').removeAttr('class');
    //     document.getElementById('btnDisc').setAttribute("class", "btn btn-info");
    //     $('#btnPapikostick').removeAttr('class');
    //     document.getElementById('btnPapikostick').setAttribute("class", "btn btn-info");
    // })

    // $('#btnDisc').click(function() {
    //     $('#allskor').attr('hidden', true);
    //     $('#msdt').attr('hidden', true);
    //     $('#ist').attr('hidden', true);
    //     $('#papikostik').attr('hidden', true);
    //     $('#holland').attr('hidden', true);
    //     $('#disc').removeAttr('hidden');
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnDisc').setAttribute("class", "btn btn-success");
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-info");
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnMsdt').setAttribute("class", "btn btn-info");
    //     $('#btnAllSkor').removeAttr('class');
    //     document.getElementById('btnAllSkor').setAttribute("class", "btn btn-info");
    //     $('#btnPapikostick').removeAttr('class');
    //     document.getElementById('btnPapikostick').setAttribute("class", "btn btn-info");
    //     $('#btnHolland').removeAttr('class');
    //     document.getElementById('btnHolland').setAttribute("class", "btn btn-info");
    // })

    // $('#btnIst').click(function() {
    //     $('#allskor').attr('hidden', true);
    //     $('#msdt').attr('hidden', true);
    //     $('#disc').attr('hidden', true);
    //     $('#holland').attr('hidden', true);
    //     $('#papikostik').attr('hidden', true);
    //     $('#ist').removeAttr('hidden');
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-success");
    //     $('#btnAllSkor').removeAttr('class');
    //     document.getElementById('btnAllSkor').setAttribute("class", "btn btn-info");
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnMsdt').setAttribute("class", "btn btn-info");
    //     $('#btnDisc').removeAttr('class');
    //     document.getElementById('btnDisc').setAttribute("class", "btn btn-info");
    //     $('#btnPapikostik').removeAttr('class');
    //     document.getElementById('btnPapikostik').setAttribute("class", "btn btn-info");
    //     $('#btnHolland').removeAttr('class');
    //     document.getElementById('btnHolland').setAttribute("class", "btn btn-info");
    // })

    // $('#btnAllSkor').click(function() {
    //     $('#msdt').attr('hidden', true);
    //     $('#ist').attr('hidden', true);
    //     $('#papikostik').attr('hidden', true);
    //     $('#disc').attr('hidden', true);
    //     $('#holland').attr('hidden', true);
    //     $('#allskor').attr('hidden', false);
    //     $('#btnMsdt').removeAttr('class');
    //     document.getElementById('btnMsdt').setAttribute("class", "btn btn-info");
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-info");
    //     $('#btnPapikostick').removeAttr('class');
    //     document.getElementById('btnPapikostick').setAttribute("class", "btn btn-info");
    //     $('#btnHolland').removeAttr('class');
    //     document.getElementById('btnHolland').setAttribute("class", "btn btn-info");
    //     $('#btnDisc').removeAttr('class');
    //     document.getElementById('btnDisc').setAttribute("class", "btn btn-info");
    //     $('#btnIst').removeAttr('class');
    //     document.getElementById('btnIst').setAttribute("class", "btn btn-info");
    //     $('#btnAllSkor').removeAttr('class');
    //     document.getElementById('btnAllSkor').setAttribute("class", "btn btn-success");
    // })
</script>