<?php
  	include_once '../layout/header.php';	  
	include '../../kumpulan_function.php';

	$soal_id		= $_GET['soal_id'];
	$dataModul 		= new Soal();
	$rowDataModul	= $dataModul->SelectDataSoal($soal_id);

	$resultDataSoalModul2	    = $dataModul->SelectDataSoalModul($soal_id, 'modul_2');
    $resultDataGambarHapalan    = $dataModul->SelectGambarHapalan($soal_id);


	$nomor_soal 	= $dataModul->NomorSoal($soal_id, 'modul_2');

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
                    var html = "Gambar Harus Lebih Kecil Dari 5mb";
                    alert(html);
                </script>';
                break;
            case 2:
                echo '<script>
                    var html = "Gambar Harus .jpg, .png, .jpeg";
                    alert(html);
                </script>';
                break;
            case 3:
                echo '<script>
                    var html = "Berhasil Menambahkan Gambar Hapalan";
                    alert(html);
                </script>';
                break;
            case 4:
                echo '<script>
                    var html = "Query Menambahkan Gambar Hapalan Bermasalah";
                    alert(html);
                </script>';
                break;
            case 6:
                echo '<script>
                    var html = "Nomor Soal Yang Diinputkan Sudah Terdaftar";
                    alert(html);
                </script>';
                break;
            case 7:
                echo '<script>
                    var html = "Berhasil Menambahkan Soal";
                    alert(html);
                </script>';
                break;
            case 8:
                echo '<script>
                    var html = "Query Add Soal Bermasalah";
                    alert(html);
                </script>';
                break;
            case 9:
                echo '<script>
                    var html = "Berhasil Update Soal";
                    alert(html);
                </script>';
                break;
            case 10:
                echo '<script>
                    var html = "Query Add Soal Bermasalah";
                    alert(html);
                </script>';
                break;
            case 11:
                echo '<script>
                    var html = "Berhasil Update Data Modul";
                    alert(html);
                </script>';
                break;
            case 12:
                echo '<script>
                    var html = "Gagal Update Data Modul\nQuery Update Bermasalah";
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
                echo '<script>
                        var html = "Berhasil Update Gambar Hapalan";
                        alert(html);
                </script>';
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
                    <a href="modul_2?soal_id=<?=$soal_id?>" class="float-sm-right ml-2 mr-3"><h3 class="text-secondary"><i class="fas fa-redo"></i></h3></a>   
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
                            <form role="form" action="../query/modul_2_query.php" method="POST">
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
                                <!-- /.card-body -->
                            </form>

                            <div class="card-footer">
                                <input type="submit" name="update_modul" class="btn btn-success float-sm-right" value="Update Data">      
                            </div>
                        </div>
                </div>
            </div>


        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Modul</th>
                                        <th>Gambar Hapalan</th>
                                        <th>Durasi (Detik)</th>
                                    </tr>
                                </thead>    
                                <tbody>
                                <?php if($resultDataGambarHapalan->num_rows > 0 ): ?>
                                    <?php while($rowDataGambarHapalan = $resultDataGambarHapalan->fetch_assoc()) : ?>
                                    <form action="../query/modul_2_query" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="hapalan_soal_id" value="<?=$soal_id?>">
                                        <input type="hidden" name="hapalan_nama_modul" value="<?=$rowDataModul['nama_soal']?>">
                                        <input type="hidden" name="hapalan_gambar_lama" value="<?=$rowDataGambarHapalan['gambar_hapalan']?>">

                                        <tr>
                                            <td style="vertical-align: middle;"><?=$rowDataGambarHapalan['nama_modul']?></td>
                                            <td style>
                                                <div class="row">
                                                    <div class="col-md-12" style="margin-left: auto; margin-right: auto;">
                                                        <?php if(empty($rowDataGambarHapalan['gambar_hapalan'])):?>
                                                            <h4>Belum Upload</h4>
                                                        <?php else:?>
                                                            <img style="width:100%; height:100%;" src="../gambar_hapalan/<?=$rowDataGambarHapalan['gambar_hapalan']?>" alt="Photo">
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-6" style="margin-left: auto; margin-right: auto;">                                                    
                                                        <input type="file" name="hapalan_gambar">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; width: 15%;">
                                                <input type="number" name="hapalan_durasi" value="<?=$rowDataGambarHapalan['durasi']?>" class="form-control" placeholder="Detik">
                                            </td>
                                        </tr>
                                    </form>
                                    
                                    </tbody>
                                    </table>                                    
                                    </div>
                                    <div class="card-footer">
                                        <input type="submit" class="btn btn-success float-sm-right" name="update_hapalan" id="" value="Update Hapalan">
                                    </div>
                                    <?php endwhile;?>
                                <?php else :?>
                                    <form action="../query/modul_2_query" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="hapalan_soal_id" value="<?=$soal_id?>">
                                        <input type="hidden" name="hapalan_nama_modul" value="<?=$rowDataModul['nama_soal']?>">
                                        <tr>
                                            <td style="vertical-align: middle;"><?=$rowDataModul['nama_soal']?></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>Masih Belum Ada Gambar Hapalan</h4>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6" style="margin-left: auto; margin-right: auto;">
                                                        <input type="file" name="hapalan_gambar">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; width: 15%;">
                                                <input type="number" name="hapalan_durasi" class="form-control" placeholder="Detik">
                                            </td>
                                            
                                        </tr>
                                        </tbody>
                                    </table>                                    
                                </div>
                                <div class="card-footer">
                                    <input type="submit" name="add_gambar_hapalan" value="Update Hapalan" class="btn btn-secondary">
                                </div>
                                <?php endif;?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="../query/modul_2_query.php" method="post">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">
                                    <input type="hidden" name="add_soal_id" value="<?=$soal_id?>"> 

                                    <thead>
                                        <tr>
                                            <th>Nomor Soal</th>
                                            <th>Pertanyaan</th>
                                            <th>Kunci Jawaban</th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td style="width:12%; vertical-align:middle;"><input type="number" name="add_nomor" value="<?=$nomor_soal?>" class="form-control" placeholder="Nomor Soal" ></td>
                                        <td style="width: 50%;">
                                            <textarea name="add_teks_soal" class="form-control" rows="2" placeholder="Tuliskan Soal..."></textarea>
                                        </td>
                                        <td style="width: 15%; vertical-align:middle;">
                                            <select name="add_kunci_jawaban" class="form-control">
                                                <option value="bunga">bunga</option>
                                                <option value="perkakas">perkakas</option>
                                                <option value="burung">burung</option>
                                                <option value="kesenian">kesenian</option>
                                                <option value="binatang">binatang</option>
                                            </select>
                                        </td>
                                        
                                    </tr>
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
                                            <th style="width:5%;">No Soal</th>
                                            <th style="width: 15%;">Pertanyaan</th>
                                            <th style="width: 10%;">Kunci Jawaban</th>
                                            <th style="width: 5%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultDataSoalModul2->num_rows > 0):?>
                                            <?php while ($rowsDataSoalModul2 = $resultDataSoalModul2->fetch_assoc()): ?>
                                            
                                            <form action="../query/modul_2_query" method="post">                                            
                                            <input type="hidden" name="update_id" value="<?=$rowsDataSoalModul2['id']?>">
                                            <input type="hidden" name="update_soal_id" value="<?=$soal_id?>">
                                            <tr>
                                                <td style="vertical-align:middle;"><?=$rowsDataSoalModul2['nomor_soal']?></td>
                                                <td style="width: 50%;">
                                                    <textarea name="update_teks_soal" cols="30" rows="3" class="form-control" placeholder="Teks Soal..."><?=$rowsDataSoalModul2['teks_soal']?></textarea>
                                                </td>
                                                <td style="vertical-align:middle;">
                                                    <select name="update_kunci_jawaban" class="form-control">
                                                        <option selected disabled value="<?=$rowsDataSoalModul2['kunci_jawaban']?>"><?=$rowsDataSoalModul2['kunci_jawaban'];?></option>
                                                        <option value="bunga">bunga</option>
                                                        <option value="perkakas">perkakas</option>
                                                        <option value="burung">burung</option>
                                                        <option value="kesenian">kesenian</option>
                                                        <option value="binatang">binatang</option>
                                                    </select>                                               
                                                </td>
                                                <td>
                                                    <input type="submit" name="update_soal" value="Update" class="btn btn-success">
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