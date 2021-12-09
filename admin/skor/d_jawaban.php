<?php
include_once '../layout/header.php';
include '../../kumpulan_function.php';
$soal = new Soal();

$room_id        = $_GET['room_id'];
$jawaban_id     = $_GET['jawaban_id'];
$peserta_id     = $_GET['peserta_id'];

$skor  = $soal->D_Jawaban($jawaban_id, $room_id, $peserta_id)

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

                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <table style="width: 300%;" id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
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
                                        if ($skor->num_rows > 0) {
                                            while ($d_jawaban = $skor->fetch_assoc()) {
                                                echo '<tr>
                                                            <td style="text-align: justify; width:2%">' . $_GET['nama_peserta'] . '</td>
                                                    ';

                                                if (!empty($d_jawaban['soal_1'])) {
                                                    $soal_1 = explode(';', $d_jawaban['soal_1']);
                                                    $count_1  = 1;
                                                    echo '<td style="text-align: justify; width:5%">';
                                                    foreach ($soal_1 as $value) {
                                                        if ($count_1 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_1 = 1;
                                                        }
                                                        $count_1++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }


                                                if (!empty($d_jawaban['soal_2'])) {

                                                    $soal_2 = explode(';', $d_jawaban['soal_2']);
                                                    $count_2  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_2 as $value) {
                                                        if ($count_2 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_2 = 1;
                                                        }
                                                        $count_2++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }


                                                if (!empty($d_jawaban['soal_3'])) {
                                                    $soal_3 = explode(';', $d_jawaban['soal_3']);
                                                    $count_3  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_3 as $value) {
                                                        if ($count_3 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_3 = 1;
                                                        }
                                                        $count_3++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }


                                                if (!empty($d_jawaban['soal_4'])) {

                                                    $soal_4 = explode(';', $d_jawaban['soal_4']);
                                                    $count_4  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_4 as $value) {
                                                        if ($count_4 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_4 = 1;
                                                        }
                                                        $count_4++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_5'])) {
                                                    $soal_5 = explode(';', $d_jawaban['soal_5']);
                                                    $count_5  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_5 as $value) {
                                                        if ($count_5 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_5 = 1;
                                                        }
                                                        $count_5++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }


                                                if (!empty($d_jawaban['soal_6'])) {
                                                    $soal_6 = explode(';', $d_jawaban['soal_6']);
                                                    $count_6  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_6 as $value) {
                                                        if ($count_6 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_6 = 1;
                                                        }
                                                        $count_6++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }


                                                if (!empty($d_jawaban['soal_7'])) {
                                                    $soal_7 = explode(';', $d_jawaban['soal_7']);
                                                    $count_7  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_7 as $value) {
                                                        if ($count_7 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_7 = 1;
                                                        }
                                                        $count_7++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_8'])) {
                                                    $soal_8 = explode(';', $d_jawaban['soal_8']);
                                                    $count_8  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_8 as $value) {
                                                        if ($count_8 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_8 = 1;
                                                        }
                                                        $count_8++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_9'])) {

                                                    $soal_9 = explode(';', $d_jawaban['soal_9']);
                                                    $count_9  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_9 as $value) {
                                                        if ($count_9 < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_9 = 1;
                                                        }
                                                        $count_9++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_10_se'])) {

                                                    $soal_10_se = explode(';', $d_jawaban['soal_10_se']);
                                                    $count_10_se  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_se as $value) {
                                                        if ($count_10_se < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_se = 1;
                                                        }
                                                        $count_10_se++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_10_wa'])) {
                                                    $soal_10_wa = explode(';', $d_jawaban['soal_10_wa']);
                                                    $count_10_wa  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_wa as $value) {
                                                        if ($count_10_wa < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_wa = 1;
                                                        }
                                                        $count_10_wa++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_10_an'])) {
                                                    $soal_10_an = explode(';', $d_jawaban['soal_10_an']);
                                                    $count_10_an  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_an as $value) {
                                                        if ($count_10_an < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_an = 1;
                                                        }
                                                        $count_10_an++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }


                                                if (!empty($d_jawaban['soal_10_ra'])) {
                                                    $soal_10_ra = explode(';', $d_jawaban['soal_10_ra']);
                                                    $count_10_ra  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_ra as $value) {
                                                        if ($count_10_ra < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_ra = 1;
                                                        }
                                                        $count_10_ra++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if (!empty($d_jawaban['soal_10_zr'])) {
                                                    $soal_10_zr = explode(';', $d_jawaban['soal_10_zr']);
                                                    $count_10_zr  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_zr as $value) {
                                                        if ($count_10_zr < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_zr = 1;
                                                        }
                                                        $count_10_zr++;
                                                    }
                                                    echo '</td>';
                                                } else {
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if(!empty($d_jawaban['soal_10_ge']))
                                                {
                                                    $soal_10_ge = explode(';', $d_jawaban['soal_10_ge']);
                                                    $count_10_ge  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_ge as $value) {
                                                        if ($count_10_ge < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_ge = 1;
                                                        }
                                                        $count_10_ge++;
                                                    }
                                                    echo '</td>';
                                                }
                                                else{                                                    
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if(!empty($d_jawaban['soal_10_fa']))
                                                {
                                                    $soal_10_fa = explode(';', $d_jawaban['soal_10_fa']);
                                                    $count_10_fa  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_fa as $value) {
                                                        if ($count_10_fa < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_fa = 1;
                                                        }
                                                        $count_10_fa++;
                                                    }
                                                    echo '</td>';
                                                }
                                                else{                                                    
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }

                                                if(!empty($d_jawaban['soal_10_wu']))
                                                {
                                                    $soal_10_wu = explode(';', $d_jawaban['soal_10_wu']);
                                                    $count_10_wu  = 1;
                                                    echo '<td style="text-align: justify; width:5%;">';
                                                    foreach ($soal_10_wu as $value) {
                                                        if ($count_10_wu < 5) {
                                                            echo $value . ', ';
                                                        } else {
                                                            echo $value . ', <br>';
                                                            $count_10_wu = 1;
                                                        }
                                                        $count_10_wu++;
                                                    }
                                                    echo '</td>';
                                                }
                                                else{                                                    
                                                    echo '<td style="text-align: justify; width:5%">Kosong</td>';
                                                }



                                                echo '</tr>';
                                            }
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
        buttons: [{
            extend: "excelHtml5",
            filename: function fred() {
                return nama_user + ' psikotes';
            },
            exportOptions: {
                orthogonal: "exportxls"
            }
        }],
        info: false,
        "columnDefs": [
            {
                "visible": true,
                "targets": 3
            }
        ]
    });
</script>