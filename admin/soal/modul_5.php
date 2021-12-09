<?php
  	include_once '../layout/header.php';	  
	include '../../kumpulan_function.php';

	$soal_id		= $_GET['soal_id'];
	$dataModul 		= new Soal();
	$rowDataModul	= $dataModul->SelectDataSoal($soal_id);

	$resultDataSoalModul5	= $dataModul->SelectDataSoalModul($soal_id, 'modul_5'); 

	$nomor_soal 	= $dataModul->NomorSoal($soal_id, 'modul_5');

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
                    var html = "Nomor Soal Soal Sudah Ada";
                    alert(html);
                </script>';
                break;
            case 2:
                echo '<script>
                    var html = "Query Insert Soal Bermasalah";
                    alert(html);
                </script>';
                break;
            case 3:
                echo '<script>
                    var html = "Berhasil Update Soal";
                    alert(html);
                </script>';
                break;
            case 4:
                echo '<script>
                    var html = "Query Update Soal Bermasalah";
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
                    var html = "Gagal Melakukan Update Data Modul\nQuery Update Modul Bermasalah";
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
                    <a href="modul_5?soal_id=<?=$soal_id?>" class="float-sm-right ml-2 mr-3"><h3 class="text-secondary"><i class="fas fa-redo"></i></h3></a>   
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
                            <form role="form" action="../query/modul_5_query" method="POST">
                                <div class="card-body">
                                    <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">Nama Modul</th>
                                                <th style="width:10%;">Durasi Pengerjaan</th>
                                                <th style="width:65%;">Deskripsi</th>
                                                <th style="width:15%;">Action</th>
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
                                                <td style="vertical-align:middle;"><input type="submit" name="update_modul" class="btn btn-secondary" value="Update Data"></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                    <form action="../query/modul_5_query.php" method="post">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">
                                    <input type="hidden" name="add_soal_id" value="<?=$soal_id?>">
                                    <thead>
                                        <td>Nomor Soal</td>
                                        <td>Kategori Setuju</td>
                                        <td>Pernyataan</td>
                                        <td>Kategori Tidak Setuju</td>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:12%; vertical-align:middle;"><input type="number" name="add_nomor" value="<?=$nomor_soal?>" class="form-control" placeholder="Nomor Soal" ></td>
                                            <td style="width:15%;">
                                                <input type="text" name="add_setuju_1" class="form-control mt-3" placeholder="Setuju 1...">
                                                <input type="text" name="add_setuju_2" class="form-control mt-4" placeholder="Setuju 2...">
                                                <input type="text" name="add_setuju_3" class="form-control mt-4" placeholder="Setuju 3...">
                                                <input type="text" name="add_setuju_4" class="form-control mt-4" placeholder="Setuju 4...">
                                            </td>
                                            <td style="width:50%;">
                                                <textarea name="add_teks_1" cols="30" rows="2" class="form-control" placeholder="Pernyataan 1..."></textarea>
                                                <textarea name="add_teks_2" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan 2..."></textarea>
                                                <textarea name="add_teks_3" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan 3..."></textarea>
                                                <textarea name="add_teks_4" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan 4..."></textarea>
                                            </td>
                                            <td style="width:15%;">
                                                <input type="text" name="add_tak_setuju_1" class="form-control mt-3" placeholder="Tak Setuju 1...">
                                                <input type="text" name="add_tak_setuju_2" class="form-control mt-4" placeholder="Tak Setuju 2...">
                                                <input type="text" name="add_tak_setuju_3" class="form-control mt-4" placeholder="Tak Setuju 3...">
                                                <input type="text" name="add_tak_setuju_4" class="form-control mt-4" placeholder="Tak Setuju 4...">
                                            </td>
                                            <td style="vertical-align:middle;">
                                            </td>
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
                                            <th style="width:15%;">Kategori Setuju</th>
                                            <th style="width:50%;">Pernyataan</th>
                                            <th style="width: 15%;">Kategori Tidak Setuju</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultDataSoalModul5->num_rows > 0):?>
                                            <?php while($rowDataSoalModul5 = $resultDataSoalModul5->fetch_assoc())
                                            {
                                                echo '<form method="POST" action="../query/modul_5_query">';
                                                echo '<input type="hidden" name="update_id" value="'.$rowDataSoalModul5['id'].'">';
                                                echo '<input type="hidden" name="update_soal_id" value="'.$soal_id.'">';
                                                $setuju         = explode(';', $rowDataSoalModul5['kategori_setuju']); 
                                                $pernyataan     = explode(';', $rowDataSoalModul5['pernyataan']); 
                                                $tidak_setuju   = explode(';', $rowDataSoalModul5['kategori_tidak_setuju']); 
                                                $update_nomor_soal = $rowDataSoalModul5['nomor_soal'];
                                                echo '<tr>';
                                                echo '<td style="vertical-align:middle;">'.$update_nomor_soal.'</td>';                                            
                                                echo '<td>';                                                
                                                $index1  = 1;  
                                                for ($i=0; $i < count($setuju); $i++) { 
                                                    switch ($index1) {
                                                        case 1:
                                                            echo '<input type="text" name="update_setuju_'.$index1.'" value="'.$setuju[$i].'" class="form-control mt-3" placeholder="Setuju '.$index1.'...">';
                                                            break;
                                                        
                                                        default:
                                                            echo '<input type="text" name="update_setuju_'.$index1.'" value="'.$setuju[$i].'" class="form-control mt-4" placeholder="Setuju '.$index1.'...">';
                                                            break;
                                                    }
                                                    $index1++;
                                                }                                                 
                                                echo '</td>';

                                                echo '<td>';
                                                $index2 = 1;     
                                                for ($i=0; $i < count($pernyataan); $i++) { 
                                                    switch ($index2) {
                                                        case 1:
                                                            echo '<textarea name="update_teks_'.$index2.'" cols="30" rows="2" class="form-control" placeholder="Pernyataan '.$index2.'...">'.$pernyataan[$i].'</textarea>';
                                                            break;
                                                        
                                                        default:
                                                        echo '<textarea name="update_teks_'.$index2.'" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan '.$index2.'...">'.$pernyataan[$i].'</textarea>';
                                                            break;
                                                    }
                                                    
                                                    $index2++;  
                                                }                                                 
                                                echo '</td>';

                                                echo '<td>';                                                     
                                                $index3 = 1; 
                                                for ($i=0; $i < count($tidak_setuju); $i++) { 
                                                    switch ($index3) {
                                                        case 1:
                                                            echo '<input type="text" name="update_tak_setuju_'.$index3.'" class="form-control mt-3" placeholder="Tak Setuju '.$index3.'..." value="'.$tidak_setuju[$i].'">';
                                                            break;
                                                        
                                                        default:
                                                        echo '<input type="text" name="update_tak_setuju_'.$index3.'" class="form-control mt-4" placeholder="Tak Setuju '.$index3.'..." value="'.$tidak_setuju[$i].'">';
                                                            break;
                                                    }
                                                    $index3++;  
                                                }                                                 
                                                echo '</td>';

                                                echo '<td style="vertical-align:middle;">';
                                                echo '<input type="submit" name="update_soal" value="Update Soal" class="btn btn-success">';
                                                echo '<input type="submit" name="delete_soal" value="Hapus" class="btn btn-danger mt-2">';
                                                echo '</td>';

                                                echo '</tr>';                                                
                                                echo '</form>';
                                            }
                                            ?>
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