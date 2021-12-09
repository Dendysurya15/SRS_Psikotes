<?php
  	include_once '../layout/header.php';	  
	include '../../kumpulan_function.php';

	$soal_id		= $_GET['soal_id'];
	$dataModul 		= new Soal();
	$rowDataModul	= $dataModul->SelectDataSoal($soal_id);

	$resultDataSoalModul10	    = $dataModul->SelectDataSoalModul($soal_id, 'modul_10_wa');

    $pilihan    = '';
    $arr_abjad  = range('a', 'z');
    $jum        = '';

	$nomor_soal 	= $dataModul->NomorSoal($soal_id, 'modul_10_wa');

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
            case 20:
                echo '<script>
                    var html = "Gagal Manambahkan Soal\nPilihan Harus Diisi Semua";
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
                    <form action="../query/modul_10_wa_query" method="post">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Nomor Soal</th>
                                            <th>Pilihan</th>
                                            <th>Kunci Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" name="add_soal_id" value="<?=$soal_id?>">
                                        <tr>
                                            <td style="width:10%; vertical-align:middle;"><input type="number" name="add_nomor" value="<?=$nomor_soal?>" class="form-control" placeholder="Nomor Soal" ></td>
                                            <td style="width: 45%; vertical-align:middle;">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">    
                                                            <label for="">A</label>
                                                            <input type="text" name="pilihan_a_<?=$nomor_soal?>" class="form-control" autofocus>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">    
                                                            <label for="">B</label>
                                                            <input type="text" name="pilihan_b_<?=$nomor_soal?>" class="form-control">    
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">    
                                                            <label for="">C</label>
                                                            <input type="text" name="pilihan_c_<?=$nomor_soal?>" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">D</label>
                                                            <input type="text" name="pilihan_d_<?=$nomor_soal?>" class="form-control mt-2">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">E</label>
                                                            <input type="text" name="pilihan_e_<?=$nomor_soal?>" class="form-control mt-2">    
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </td>
                                            
                                            <td style="width: 15%; vertical-align:middle;">
                                                <select name="add_kunci_jawaban" class="form-control">
                                                    <option value="a">A</option>
                                                    <option value="b">B</option>
                                                    <option value="c">C</option>
                                                    <option value="d">D</option>
                                                    <option value="e">E</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                            <input type="submit" name="add_soal" value="Tambah Soal" class="btn btn-secondary float-sm-right">
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
                                            <th style="width:10%;">No Soal</th>
                                            <th style="width: 50%;">Pilihan</th>
                                            <th style="width: 8%;">Kunci Jawaban</th>
                                            <th style="width: 5%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if($resultDataSoalModul10->num_rows > 0):?>
                                            <?php while ($rowsDataSoalModul10 = $resultDataSoalModul10->fetch_assoc()): ?>
                                            
                                            <form action="../query/modul_10_wa_query" method="post">                                            
                                            <input type="hidden" name="up_id" value="<?=$rowsDataSoalModul10['id']?>">
                                            <input type="hidden" name="up_soal_id" value="<?=$soal_id?>">
                                            <input type="hidden" name="up_nomor_soal" value="<?=$rowsDataSoalModul10['nomor_soal']?>">
                                            <tr>
                                                <td style="vertical-align:middle;"><?=$rowsDataSoalModul10['nomor_soal']?></td>
                                                <td style="vertical-align:middle;">
                                                    <?php 
                                                        $pilihan = explode(';', substr($rowsDataSoalModul10['pilihan'], 0, -1));
                                                    ?>
                                                    
                                                    <div class="row">
                                                    <?php for($i = 0; $i < count($pilihan); $i++): ?>
                                                        <?php if($i < 3) : ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""><?=strtoupper($arr_abjad[$i])?></label>
                                                                    <input type="text" class="form-control" name="up_pilihan_<?=$arr_abjad[$i]?>_<?=$rowsDataSoalModul10['nomor_soal']?>" value="<?=$pilihan[$i]?>">
                                                                </div>
                                                            </div>
                                                        <?php else :?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for=""><?=strtoupper($arr_abjad[$i])?></label>
                                                                    <input type="text" class="form-control" name="up_pilihan_<?=$arr_abjad[$i]?>_<?=$rowsDataSoalModul10['nomor_soal']?>" value="<?=$pilihan[$i]?>">
                                                                </div>
                                                            </div>                                                        
                                                        <?php endif;?>
                                                    <?php endfor; ?>
                                                    </div>                                    
                                                </td>
                                                <td style="vertical-align:middle;">
                                                        <select class="form-control" name="up_kunci_jawaban" id="">
                                                            <option disabled selected><?=strtoupper($rowsDataSoalModul10['kunci_jawaban'])?></option>
                                                            <option value="a">A</option>
                                                            <option value="b">B</option>
                                                            <option value="c">C</option>
                                                            <option value="d">D</option>
                                                            <option value="e">E</option>
                                                        </select>
                                                </td>
                                                <td style="vertical-align:middle;">
                                                    <input type="submit" name="update_soal" value="Update" class="btn btn-secondary">
                                                    <input type="submit" name="delete_soal" value="Hapus" class="btn btn-secondary mt-2">                                               
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