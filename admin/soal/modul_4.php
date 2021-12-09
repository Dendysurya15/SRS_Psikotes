<?php
  	include_once '../layout/header.php';	  
	include '../../kumpulan_function.php';

	$soal_id		= $_GET['soal_id'];
	$dataModul 		= new Soal();
	$rowDataModul	= $dataModul->SelectDataSoal($soal_id);

	$resultDataSoalModul3	= $dataModul->SelectDataSoalModul($soal_id, 'modul_4'); 

	$nomor_soal 	= $dataModul->NomorSoal($soal_id, 'modul_4');

    if(isset($_GET['status']))
    {
        $status = $_GET['status'];
        switch ($status) {
            case 0:
                echo '<script>
                    var html = "Berhasil Menambahkan Soal";
                    alert(html);
                </script>';
                break;
            case 1:
                echo '<script>
                    var html    = "Gagal Menambahkan Soal\n";
                    html        += "Query Bermasalah\n";
                    alert(html);
                </script>';
                break;
            case 2:
                echo '<script>
                    var html     = "Gagal Menambahkan Soal\n";
                    html        += "Soal Memiliki Nomor Yang Sama";
                    alert(html);
                </script>';
                break;
            case 3:
                echo '<script>
                    var html    =  "Berhasil Melakukan Update\n";
                    alert(html);
                </script>';
            break;
            case 4:
                echo '<script>
                    var html     =  "Gagal Melakukan Update\n";
                    html        +=  "Query Update Bermasalah";
                    alert(html);
                </script>';
            break;
            case 11:
                echo '<script>
                    var html     =  "Berhasil Melakukan Update Data Modul";
                    alert(html);
                </script>';
            break;
            case 12:
                echo '<script>
                    var html     =  "Gagal Melakukan Update Data Modul\nQuery Update Modul Bermasalah";
                    alert(html);
                </script>';
            break;
            case 13:
                echo '<script>
                    var html = "Berhasil Menghapus Soal";
                    alert(html);
                </script>';
                break;
            case 14:
                echo '<script>
                    var html = "Gagal Menghapus Soal\nQuery Hapus Soal Bermasalah";
                    alert(html);
                </script>';
                break;
            default:
                # code...
                break;
        }
    }
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="content-fluid ">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 pl-2 text-dark">
                        Detail <?=$rowDataModul['nama_soal']?>
                    </h1>
                </div>
                <div class="col-sm-6"> 
                    <a href="daftar_soal" class="float-sm-right ml-2 mr-3"><h3 class="text-secondary"><i class="fas fa-backward"></i></h3></a>      
                    <a href="modul_4?soal_id=<?=$soal_id?>" class="float-sm-right ml-2 mr-3"><h3 class="text-secondary"><i class="fas fa-redo"></i></h3></a>   
                </div>
            </div>

        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h1 class="card-title m-0 text-dark">
                                    Detail Modul
                                </h1>
                            </div>
                            <form role="form" action="../query/modul_4_query" method="POST">
                                <div class="card-body">
                                    <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">Nama Modul</th>
                                                <th style="width:10%;">Durasi Pengerjaan</th>
                                                <th style="width:65%;">Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width:10%; vertical-align:middle;">
                                                    <?=$rowDataModul['nama_soal']?>
                                                    <input type="hidden" name="update_id" value="<?=$soal_id?>">
                                                </td>
                                                <td style="vertical-align:middle;"><input class="form-control text-center" name="update_durasi_soal" type="number" value="<?=$rowDataModul['durasi']?>" placeholder="detik"></td>
                                                <td>
                                                    <textarea class="form-control" name="update_deskripsi_soal" cols="35" rows="5" placeholder="Deskripsi Modul..."><?=$rowDataModul['deskripsi_soal']?></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-footer">
                                    <input type="submit" name="update_modul" class="btn btn-success float-sm-right" value="Update Data">            
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                </div>
            </div>


        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="../query/modul_4_query.php" method="post">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">
                                    <input type="hidden" name="add_soal_id" value="<?=$soal_id?>">
                                    <thead>
                                        <th>Nomor Soal</th>
                                        <th>Pernyataan</th>
                                        <th>Kunci Jawaban</th>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td style="width:12%; vertical-align:middle;"><input type="number" name="add_nomor" value="<?=$nomor_soal?>" class="form-control" placeholder="Nomor Soal" ></td>
                                            <td style="width:60%;"><textarea class="form-control" name="add_teks_soal" rows="3" placeholder="Pernyataan..."></textarea></td>
                                            <td style="width:15%; vertical-align:middle;"><input type="text" name="add_kunci_jawaban" class="form-control" placeholder="Jawaban"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <input type="submit" name="add_soal" value="Tambah Soal" class="btn btn-primary float-sm-right">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title m-0 text-dark">
                                <?=$rowDataModul['nama_soal']?>
                            </h1>
                        </div>
                            <div class="card-body">
                                <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th style="width:12%;">No Soal</th>
                                            <th style="width: 60%;">Soal</th>
                                            <th style="width: 15%;">Kunci Jawaban</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultDataSoalModul3->num_rows > 0):?>
                                            <?php while ($rowsDataSoalModul3 = $resultDataSoalModul3->fetch_assoc()): ?>
                                            
                                            <form action="../query/modul_4_query.php" method="post">                                            
                                            <input type="hidden" name="update_id" value="<?=$rowsDataSoalModul3['id']?>">
                                            <input type="hidden" name="update_soal_id" value="<?=$soal_id?>">
                                            <tr>
                                                <td style="vertical-align:middle;"><?=$rowsDataSoalModul3['nomor_soal']?></td>
                                                <td style="vertical-align:middle;">
                                                    <textarea name="update_teks_soal" class="form-control" cols="30" rows="3" placeholder="Deskripsi Soal..."><?=$rowsDataSoalModul3['teks_soal']?></textarea>
                                                </td>
                                                <td style="vertical-align:middle;"><input type="text" name="update_jawaban_soal" class="form-control" value="<?=$rowsDataSoalModul3['kunci_jawaban']?>"></td>
                                                <td>
                                                    <input type="submit" name="update_soal" value="Update" class="btn btn-success"><br>
                                                    <input type="submit" name="delete_soal" value="Hapus" class="btn btn-danger mt-2">                                               
                                                </td>
                                            </tr>
                                            </form>
                                            <?php endwhile;?>
                                        <?php else:?>
                                            <tr>
                                                <td colspan="5">Belum Ada Soal Yang dimasukan</td>
                                            </tr>
                                        <?php endif;?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

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