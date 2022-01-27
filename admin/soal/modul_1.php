<?php
include_once '../layout/header.php';
include '../../kumpulan_function.php';

$soal_id        = $_GET['soal_id'];
$dataModul         = new Soal();
$rowDataModul    = $dataModul->SelectDataSoal($soal_id);

$resultDataSoalModul1    = $dataModul->SelectDataSoalModul($soal_id, 'modul_1');

$nomor_soal     = $dataModul->NomorSoal($soal_id, 'modul_1');


if (isset($_GET['status'])) {
    $status = $_GET['status'];
    switch ($status) {
        case 0:
            echo '<script>
                    var html = "Berhasil Menambah Data";
                    alert(html);                
                </script>';
            break;
        case 1:
            echo '<script>
                    var html = "Nomor Soal Sudah Diinputkan";
                    alert(html);                
                </script>';
            break;
        case 2:
            echo '<script>
                    var html = "Query Gagal Menginputkan Soal";
                    alert(html);                
                </script>';
            break;
        case 3:
            echo '<script>
                    var html = "Berhasil Update Data";
                    alert(html);                
                </script>';
            break;
        case 4:
            echo '<script>
                    var html = "Gagal Melakukan Update Data\nQuery Update Bermasalah";
                    alert(html);                
                </script>';
            break;
        case 6:
            echo '<script>
                    var html = "Berhasil Update Data Soal";
                    alert(html);                
                </script>';
            break;
        case 7:
            echo '<script>
                    var html = "Gagal Update Data Soal\nQuery Update Data Soal Bermasalah";
                    alert(html);                
                </script>';
            break;
        case 8:
            echo '<script>
                        var html = "Berhasil Menghapus Data Soal";
                        alert(html);                
                    </script>';
            break;
        case 21:
            echo '<script>
                                        var html = "Gagal Menambahkan Instruksi karena format bukan file bukan Audio";
                                        alert(html);
                                    </script>';
            break;
        case 22:
            echo '<script>
                                            var html = "Berhasil Menambahkan Instruksi Soal";
                                            alert(html);
                                        </script>';
            break;
        case 23:
            echo '<script>
                                                var html = "Gagal Menambahkan Instruksi Soal";
                                                alert(html);
                                            </script>';
            break;
        case 24:
            echo '<script>
                                                    var html = "Gagal Menambahkan Instruksi Soal karena nama file sama atau sudah ada";
                                                    alert(html);
                                                </script>';
            break;
        case 25:
            echo '<script>
                                                        var html = "Gagal untuk memperbaharui Instruksi Soal";
                                                        alert(html);
                                                    </script>';
            break;
        case 26:
            echo '<script>
                                                            var html = "Berhasil untuk memperbaharui Instruksi Soal";
                                                            alert(html);
                                                        </script>';
            break;
        case 27:
            echo '<script>
                                                            var html = "Berhasil untuk menghapus Instruksi Soal";
                                                            alert(html);
                                                        </script>';
            break;
        case 28:
            echo '<script>
                                                                var html = "Gagal untuk menghapus Instruksi Soal";
                                                                alert(html);
                                                            </script>';
            break;
        case 29:
            echo '<script>
                                                                    var html = "Size file instruksi harus kurang dari 5Mb";
                                                                    alert(html);
                                                                </script>';
            break;
        default:
            echo '<script>
                    var html = "Size Gambar Harus Kurang Dari 5mb";
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
                        Detail <?= $rowDataModul['nama_soal'] ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a href="daftar_soal" class="float-sm-right ml-2 mr-3">
                        <h3 class="text-secondary"><i class="fas fa-backward"></i></h3>
                    </a>
                    <a href="modul_1?soal_id=<?= $soal_id ?>" class="float-sm-right ml-2 mr-3">
                        <h3 class="text-secondary"><i class="fas fa-redo"></i></h3>
                    </a>
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
                        <form role="form" action="../query/modul_1_query" method="POST">
                            <div class="card-body">
                                <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama Modul</th>
                                            <th>Durasi Pengerjaan</th>
                                            <th style="width:70%;">Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width:10%; vertical-align:middle;">
                                                <?= $rowDataModul['nama_soal'] ?>
                                                <input type="hidden" name="update_id" value="<?= $soal_id ?>">
                                            </td>
                                            <td style="vertical-align:middle;"><input class="form-control text-center" name="update_durasi_soal" type="number" value="<?= $rowDataModul['durasi'] ?>" placeholder="detik"></td>
                                            <td>
                                                <textarea class="form-control" name="update_deskripsi_soal" cols="35" rows="5" placeholder="Deskripsi Modul..."><?= $rowDataModul['deskripsi_soal'] ?></textarea>
                                            </td>
                                            <td style="vertical-align:middle;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="submit" name="update_modul" class="btn btn-success float-sm-right" value="Update Data">
                            </div>
                        </form>

                    </div>

                </div>
            </div>


        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="../query/modul_1_query" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="soal_id" value="<?= $soal_id ?>">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">

                                    <thead>
                                        <tr>
                                            <th>Instruksi Modul</th>
                                            <th>File Suara</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php if (!empty($rowDataModul['instruksi_soal'])) : ?>
                                                    <audio src="../instruksi_soal/<?= $rowDataModul['instruksi_soal'] ?>" type="audio/mpeg" controlsList="nodownload" controls>
                                                        Your browser does not support the audio tag.
                                                    </audio>
                                                <?php else : ?>
                                                    Instruksi suara tidak ada
                                                <?php endif; ?>
                                            </td>
                                            <td><input type="file" name="instruksi_suara" accept=".ogg,.flac,.mp3,.m4a,.mp4" class="form-control"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <?php if (!empty($rowDataModul['instruksi_soal'])) : ?>
                                    <input type="hidden" name="instruksi_lama" value="<?= $rowDataModul['instruksi_soal'] ?>">
                                    <input name="tambah_instruksi" type="submit" value="Update Instruksi" class="btn btn-success float-sm-right">
                                    <input name="hapus_instruksi" type="submit" value="Delete Instruksi" class="btn btn-danger float-sm-right mr-1">
                                <?php else : ?>
                                    <input name="tambah_instruksi" type="submit" value="Tambah Instruksi" class="btn btn-primary float-sm-right">
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="../query/modul_1_query" method="post" enctype="multipart/form-data">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">
                                    <input type="hidden" name="add_soal_id" value="<?= $soal_id ?>">
                                    <thead>
                                        <tr>
                                            <th>Nomor Soal</th>
                                            <th>File Gambar</th>
                                            <th>Kunci Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input name="add_nomor_soal" type="number" value="<?= $nomor_soal ?>" class="form-control"></td>
                                            <td><input type="file" name="add_gambar_soal" class="form-control"></td>
                                            <td>
                                                <select name="add_kunci_jawaban" class="form-control">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <input name="add_soal" type="submit" value="Add Soal" class="btn btn-primary float-sm-right">
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
                                <?= $rowDataModul['nama_soal'] ?>
                            </h1>
                        </div>
                        <div class="card-body">
                            <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th style="width:7%;">No Soal</th>
                                        <th style="width: 25%;">Soal</th>
                                        <th style="width: 10%;">Kunci Jawaban</th>
                                        <th style="width: 5%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($resultDataSoalModul1->num_rows > 0) : ?>
                                        <?php while ($rowsDataSoalModul1 = $resultDataSoalModul1->fetch_assoc()) : ?>
                                            <form action="../query/modul_1_query.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="update_id" value="<?= $rowsDataSoalModul1['id'] ?>">
                                                <input type="hidden" name="update_soal_id" value="<?= $soal_id ?>">
                                                <input type="hidden" name="update_nomor_soal" value="<?= $rowsDataSoalModul1['nomor_soal'] ?>">
                                                <input type="hidden" name="update_gambar_soal_lama" value="<?= $rowsDataSoalModul1['link_gambar'] ?>">
                                                <tr>
                                                    <td style="vertical-align: middle;"><?= $rowsDataSoalModul1['nomor_soal'] ?>
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <div class="row">
                                                            <div class="col-md-12" style="margin-left: auto; margin-right: auto;">
                                                                <?php if (!empty($rowsDataSoalModul1['link_gambar'])) : ?>
                                                                    <img class="" src="../gambar_soal/<?= $rowsDataSoalModul1['link_gambar'] ?>" style="width:100%; height:100%;">
                                                                <?php else : ?>
                                                                    <h3>Gambar Tidak Ada</h3>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <input type="file" name="update_gambar_soal_baru" class="form-control">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <select name="update_kunci_jawaban" class="form-control">
                                                            <option selected disabled value="<?= $rowsDataSoalModul1['kunci_jawaban'] ?>"><?= $rowsDataSoalModul1['kunci_jawaban'] ?></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </td>
                                                    <td style="vertical-align: middle;">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <input class="btn btn-success" type="submit" name="update_soal" value="UPDATE"><br>
                                                                <input class="btn btn-danger mt-2" type="submit" name="hapus_soal" value="HAPUS">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
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