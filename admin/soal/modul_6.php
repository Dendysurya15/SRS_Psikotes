<?php
include_once '../layout/header.php';
include '../../kumpulan_function.php';

$soal_id        = $_GET['soal_id'];
$dataModul         = new Soal();
$rowDataModul    = $dataModul->SelectDataSoal($soal_id);

$resultDataSoalModul6    = $dataModul->SelectDataSoalModul($soal_id, 'modul_6');

$nomor_soal     = $dataModul->NomorSoal($soal_id, 'modul_6');

if (isset($_GET['status'])) {
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
                    var html = "Query Insert Bermasalah";
                    alert(html);
                </script>';
            break;
        case 2:
            echo '<script>
                    var html = "Berhasil Melakukan Update Soal";
                    alert(html);
                </script>';
            break;
        case 3:
            echo '<script>
                    var html = "Query Update Soal Bermasalah";
                    alert(html);
                </script>';
            break;
        case 4:
            echo '<script>
                    var html = "Nomor Soal Sudah Terdaftar";
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
                    var html = "Gagal Melakukan Update Data Modul\nQuery Update Data Modul Bermasalah";
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
                        Detail <?= $rowDataModul['nama_soal'] ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a href="daftar_soal" class="float-sm-right ml-2 mr-3">
                        <h3 class="text-secondary"><i class="fas fa-backward"></i></h3>
                    </a>
                    <a href="modul_6?soal_id=<?= $soal_id ?>" class="float-sm-right ml-2 mr-3">
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
                        <form role="form" action="../query/modul_6_query" method="POST">
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
                                                <?= $rowDataModul['nama_soal'] ?>
                                                <input type="hidden" name="update_id" value="<?= $soal_id ?>">
                                            </td>
                                            <td style="vertical-align:middle;"><input class="form-control text-center" name="update_durasi_soal" type="number" value="<?= $rowDataModul['durasi'] ?>" placeholder="detik"></td>
                                            <td>
                                                <textarea class="form-control" name="update_deskripsi_soal" cols="35" rows="5" placeholder="Deskripsi Modul..."><?= $rowDataModul['deskripsi_soal'] ?></textarea>
                                            </td>
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
                    <form action="../query/modul_6_query" method="post" enctype="multipart/form-data">
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
                    <form action="../query/modul_6_query.php" method="post">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-hover text-center">

                                    <thead>
                                        <tr>
                                            <th>Nomor Soal</th>
                                            <th>Pernyataan</th>
                                            <th>Kategori</th>
                                        </tr>
                                    </thead>
                                    <input type="hidden" name="add_soal_id" value="<?= $soal_id ?>">
                                    <tr>
                                        <td style="width:12%; vertical-align:middle;"><input type="number" name="add_nomor" value="<?= $nomor_soal ?>" class="form-control" placeholder="Nomor Soal"></td>
                                        <td style="width:60%;">
                                            <textarea name="add_teks_1" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan 1..."></textarea>
                                            <textarea name="add_teks_2" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan 2..."></textarea>
                                        </td>
                                        <td style="width:15%;">
                                            <input type="text" name="add_kategori_1" class="form-control mt-4" placeholder="Kategori 1...">
                                            <input type="text" name="add_kategori_2" class="form-control mt-4" placeholder="Kategori 2...">
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
                                <?= $rowDataModul['nama_soal'] ?>
                            </h1>
                        </div>
                        <div class="card-body">
                            <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th style="width:12%;">No Soal</th>
                                        <th style="width:60%;">Pernyataan</th>
                                        <th style="width: 15%;">Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($resultDataSoalModul6->num_rows > 0) : ?>
                                        <?php
                                        while ($rowDataSoalModul6 = $resultDataSoalModul6->fetch_assoc()) {
                                            echo '<form action="../query/modul_6_query.php" method="POST">';
                                            echo '<input type="hidden" name="update_id" value="' . $rowDataSoalModul6['id'] . '">';
                                            echo '<input type="hidden" name="update_soal_id" value="' . $soal_id . '">';
                                            echo '<tr>';
                                            echo '<td style="width:12%; vertical-align:middle;">
                                                                ' . $rowDataSoalModul6['nomor_soal'] . '
                                                            </td>';
                                            echo '<td>';
                                            $arr_pernyataan = explode(';', $rowDataSoalModul6['pernyataan']);
                                            $index_pernyataan = 1;
                                            foreach ($arr_pernyataan as $value) {
                                                echo '<textarea name="update_teks_' . $index_pernyataan . '" cols="30" rows="2" class="form-control mt-2" placeholder="Pernyataan ' . $index_pernyataan . '...">' . $value . '</textarea>';
                                                $index_pernyataan++;
                                            }
                                            echo '</td>';

                                            echo '<td>';
                                            $arr_kategori = explode(';', $rowDataSoalModul6['kategori']);
                                            $index_kategori = 1;
                                            foreach ($arr_kategori as $value) {
                                                echo '<input type="text" name="update_kategori_' . $index_kategori . '" class="form-control mt-4" placeholder="Kategori ' . $index_kategori . '..." value="' . $value . '">';
                                                $index_kategori++;
                                            }
                                            echo '</td>';

                                            echo '<td>
                                                            <input type="submit" name="update_soal" value="Update Soal" class="btn btn-success mt-4">
                                                            <input type="submit" name="delete_soal" value="Hapus Soal" class="btn btn-danger mt-4">
                                                            </td>';

                                            echo '</tr>';
                                            echo '</form>';
                                        }
                                        ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="5">Belum Ada Soal Yang Dimasukan</td>
                                        </tr>
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