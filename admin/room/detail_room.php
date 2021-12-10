<?php
include_once '../layout/header.php';

include '../../kumpulan_function.php';
$soal = new Soal();
$resultDataRoom = $soal->DetailRoom($_GET['room_id']);

$resultDataPeserta = $soal->Peserta('room_id', $_GET['room_id'], 'select');

$room_id = '';

$status_soal = '';

$arr_soal        = array();
$arr_status_soal = array();

$arr_bagi        = '';

#Status

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    switch ($status) {
            #Berhasil Add Peserta
        case 0:
            echo '
        <script>
          var html = "Berhasil Menambahkan Peserta Baru";
          alert(html);
        </script>';
            break;

        case 1:
            echo '
        <script>
          var html = "Gagal Menambahkan Peserta Baru\nUsername Peserta Telah Terdaftar";
          alert(html);
        </script>';
            break;
        case 2:
            echo '
        <script>
          var html = "Peserta Berhasil Dihapus";
          alert(html);
        </script>';
            break;
        case 3:
            echo '
        <script>
          var html = "Gagal Hapus Peserta\nQuery Hapus Peserta Bermasalah";
          alert(html);
        </script>';
            break;
        case 4:
            echo '
        <script>
          var html = "Berhasil Melakukan Update Data Peserta";
          alert(html);
        </script>';
            break;
        case 5:
            echo '
        <script>
          var html = "Gagal Update Data Peserta\nQuery Update Peserta Bermasalah";
          alert(html);
        </script>';
            break;
        case 6:
            echo '
        <script>
          var html = "Gagal Mengirikan Email\nPeserta Belum Ada Yang Terdaftar";
          alert(html);
        </script>';
            break;
        case 7:
            echo '
        <script>
        var html = "Email Telah Dikirimkan Kepada Peserta";
        alert(html);
        </script>';
            break;
        case 8:
            echo '
        <script>
        var html = "Gagal Mengirimkan Email\nProses Pengiriman Email Bermasalah\nCek Koding";
        alert(html);
        </script>';
            break;
        case 9:
            echo '
        <script>
        var html = "Berhasil Update Data Room";
        alert(html);
        </script>';
            break;
        case 10:
            echo '
        <script>
        var html = "Gagal Update Data Room\nQuery Update Bermasalah";
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
                        Detail Room
                    </h1>
                </div>
                <div class="col-sm-6">
                    <form action="../query/peserta_query" method="post">
                        <input type="hidden" name="id_room_email" value="<?= $_GET['room_id'] ?>">
                        <button name="kirim_email" value="lol" class="btn btn-secondary float-sm-right ml-2" style="width: 20%;"><abbr title="Kirim Informasi Room Ke Peserta"><i class="far fa-envelope"></i></abbr></button>
                    </form>
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
                            <h3 class="text-secondary"><strong>Room Info</strong></h3>
                        </div>

                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <?php if ($resultDataRoom->num_rows > 0) : ?>
                                    <?php while ($rowDataRoom = $resultDataRoom->fetch_assoc()) : ?>
                                        <form action="../query/room_query" method="post">
                                            <?php $room_id = $rowDataRoom['id']; ?>
                                            <input type="hidden" name="up_room_id" id="room_id" value="<?= $room_id ?>">

                                            <table id="rekapTaksasi" class="table table-bordered table-hover text-center">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 for="">Input Info Zoom</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">link Room</label>
                                                            <input name="update_link" type="text" class="form-control" id="" value="<?= $rowDataRoom['link_room']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Meeting ID Room</label>
                                                            <input name="update_meeting_id" type="text" class="form-control" value="<?= $rowDataRoom['meeting_id_room']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">Password Room</label>
                                                            <input name="update_password" type="text" class="form-control" value="<?= $rowDataRoom['password_room']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h3 for=""></h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Nama Room</label>
                                                            <input name="update_nama_room" type="text" class="form-control" value="<?= $rowDataRoom['nama_room']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Tanggal</label>
                                                            <input type="date" class="form-control" name="update_tanggal" value="<?= $rowDataRoom['tanggal']; ?>">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Jam Mulai</label>
                                                            <input type="time" class="form-control" name="update_jam_mulai" value="<?= $rowDataRoom['jam_mulai']; ?>">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Jam Selesai</label>
                                                            <input type="time" class="form-control" name="update_jam_selesai" value="<?= $rowDataRoom['jam_selesai']; ?>">

                                                        </div>
                                                    </div>
                                                </div>
                                            </table>

                                            <div class="card-footer">

                                                <input name="update_btn" type="submit" class="btn btn-success float-sm-right ml-2" value="Update">

                                            </div>

                                            <?php $status_soal = $rowDataRoom['status_soal']; ?>

                                        </form>
                                    <?php endwhile; ?>
                                <?php else : ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="text-secondary"><strong>Status Soal</strong></h3>
                        </div>
                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <form action="../query/room_query" method="post">
                                    <table style="width: 120%;" class="table table-bordered table-hover text-center" id="taksasi">

                                        <?php
                                        $status_soal = explode(';', $status_soal);
                                        $jum_status = count($status_soal);
                                        echo '<input type="hidden" name="jumlah_status" value=' . $jum_status . '>';
                                        ?>
                                        <?php foreach ($status_soal as $value) : ?>
                                            <tr>
                                                <?php
                                                $arr_bagi = explode('=', $value);
                                                array_push($arr_soal, $arr_bagi[0]);
                                                array_push($arr_status_soal, $arr_bagi[1]);
                                                ?>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <?php for ($i = 0; $i < count($arr_soal); $i++) : ?>
                                                <input type="hidden" name="<?= $arr_soal[$i] ?>" value="<?= $arr_soal[$i] ?>">
                                                <input type="hidden" name="status_<?= $arr_soal[$i] ?>" value="<?= $arr_status_soal[$i] ?>">
                                                <input type="hidden" name="room_id" value="<?= $_GET['room_id'] ?>">
                                                <?php if ($i > 0) : ?>
                                                    <?php if ($arr_soal[$i] == 's_10') : ?>
                                                        <td><?= strtoupper('soal 10 se') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_11') : ?>
                                                        <td><?= strtoupper('soal 10 wa') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_12') : ?>
                                                        <td><?= strtoupper('soal 10 an') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_13') : ?>
                                                        <td><?= strtoupper('soal 10 ra') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_14') : ?>
                                                        <td><?= strtoupper('soal 10 zr') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_15') : ?>
                                                        <td><?= strtoupper('soal 10 ge') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_16') : ?>
                                                        <td><?= strtoupper('soal 10 fa') ?></td>
                                                    <?php elseif ($arr_soal[$i] == 's_17') : ?>
                                                        <td><?= strtoupper('soal 10 wu') ?></td>
                                                    <?php else : ?>
                                                        <td><?= strtoupper(str_replace('_', ' ', $arr_soal[$i])) ?></td>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <th>Nama Soal</th>
                                                    <td><?= strtoupper(str_replace('_', ' ', $arr_soal[$i])) ?></td>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </tr>
                                        <tr>
                                            <?php for ($i = 0; $i < count($arr_soal); $i++) : ?>
                                                <?php if ($i > 0) : ?>
                                                    <td>
                                                        <?php if ($arr_status_soal[$i] == 0) : ?>
                                                            <input type="submit" name="aktifkan_<?= $arr_soal[$i] ?>" class="btn btn-danger" value="Aktifkan">
                                                        <?php else : ?>
                                                            <input type="button" name="aktif" class="btn btn-success" value="Aktif">
                                                        <?php endif; ?>
                                                    </td>
                                                <?php else : ?>
                                                    <th>Status Soal</th>
                                                    <td>
                                                        <?php if ($arr_status_soal[$i] == 0) : ?>
                                                            <input type="submit" name="aktifkan_<?= $arr_soal[$i] ?>" class="btn btn-danger" value="Aktifkan">
                                                        <?php else : ?>
                                                            <input type="button" name="aktif" class="btn btn-success" value="Aktif">
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0 text-primary"><strong>Daftar Peserta</strong></h5>
                        </div>

                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <table style="width: 150%;" class="table table-bordered table-hover text-center table-responsive" id="taksasi">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">No</th>
                                            <th style="width: 10%;">Nama</th>
                                            <th style="width: 5%;">Username</th>
                                            <th style="width: 5%;">Email</th>
                                            <th style="width: 5%;">Password</th>
                                            <th style="width: 3%;">Usia</th>
                                            <th style="width: 7%;">Pendidikan</th>
                                            <th style="width: 5%;">Jenis Tes</th>
                                            <th style="width: 5%;">Status</th>
                                            <th style="width: 6%;">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody style="vertical-align: middle;">

                                        <?php if ($resultDataPeserta->num_rows > 0) : ?>
                                            <?php
                                            $nomor_soal = 1;
                                            ?>
                                            <?php while ($rowDataPeserta = $resultDataPeserta->fetch_assoc()) : ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form action="../query/peserta_query" method="post">
                                                            <input type="hidden" name="u_room_id" value="<?= $rowDataPeserta['room_id'] ?>">
                                                            <input type="hidden" name="u_id_peserta" value="<?= $rowDataPeserta['id'] ?>">
                                                            <tr>
                                                                <td><?= $nomor_soal ?></td>
                                                                <td>
                                                                    <input style="text-align: center;" class="form-control" type="text" name="u_nama" value="<?= $rowDataPeserta['nama_peserta'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input style="text-align: center;" class="form-control" type="text" name="u_username" value="<?= $rowDataPeserta['username_peserta'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input style="text-align: center;" class="form-control" type="email" name="u_email" value="<?= $rowDataPeserta['email'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input style="text-align: center;" class="form-control" type="text" name="u_password" value="<?= $rowDataPeserta['password_peserta'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input style="text-align: center;" class="form-control" type="number" name="u_usia" value="<?= $rowDataPeserta['usia_peserta'] ?>">
                                                                </td>
                                                                <td>
                                                                    <input style="text-align: center;" class="form-control" type="text" name="u_pendidikan" value="<?= $rowDataPeserta['pendidikan_peserta'] ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="u_jenis">
                                                                        <option disabled selected>
                                                                            <?= strtoupper($rowDataPeserta['jenis_tes_peserta']) ?>
                                                                        </option>
                                                                        <option value="nonmanagerial">NONMANAGERIAL</option>
                                                                        <option value="managerial">MANAGERIAL</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="u_status">
                                                                        <?php if ($rowDataPeserta['status_login'] == 1) : ?>
                                                                            <option value="<?= $rowDataPeserta['status_login'] ?>">Sudah Melakukan Tes</option>
                                                                        <?php else : ?>
                                                                            <option value="<?= $rowDataPeserta['status_login'] ?>">Belum Melakukan Tes</option>
                                                                        <?php endif; ?>
                                                                        <option value="0">Reset Status</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-success" name="update_peserta"><abbr title="Update data peserta"><i class="fas fa-arrow-right"></i></abbr></button>
                                                                        <button type="submit" class="btn btn-danger" name="hapus_peserta"><abbr title="Hapus peserta"><i class="fas fa-trash"></i></abbr></button>

                                                                    </div>


                                                                </td>
                                                            </tr>
                                                        </form>

                                                    </div>
                                                </div>
                                                <?php
                                                $nomor_soal += 1;
                                                ?>
                                            <?php endwhile; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="10" style="width: 2000px;">Peserta Belum Ada</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>


                                </table>

                            </div>

                        </div>
                        <div class="card-footer">
                            <form action="../query/peserta_query" method="post">

                                <input type="hidden" name="room_id_p" value="<?= $room_id ?>">
                                <table style="border:none;" class="table table-bordered table-hover table-responsive" id="taksasi">
                                    <tr style="border:none;">
                                        <th style="width: 20%; border:none;">Email</th>
                                        <th style="width: 20%; border:none;">Nama</th>
                                        <th style="width: 10%; border:none;">Usia</th>
                                        <th style="border:none;">Jenis Tes</th>
                                        <th style="border:none;">Pendidikan</th>
                                        <th style="width: 10%;text-align: center; vertical-align: bottom; border:none;" rowspan="2">
                                            <button style="width: 100%;" type="submit" name="add" class="btn btn-primary" value="Tambah Peserta"><abbr title="Tambahkan Peserta"><i class="fas fa-plus-circle"></i></abbr></button>
                                        </th>
                                    </tr>


                                    <tr style="border:none;">
                                        <td style="border:none;">
                                            <input type="email" name="email" id="email" value="" class="form-control" placeholder="Email Peserta">
                                            <small class=" text-danger "><?php if (isset($_SESSION['emailErr'])) { ?>
                                                    *<?php echo $_SESSION['emailErr'];
                                                                                unset($_SESSION['emailErr']);
                                                                            } ?></small>
                                        </td>
                                        <td style="border:none;">
                                            <input type="text" name="nama" id="nama" value="" class="form-control" placeholder="Nama Peserta">
                                            <small class=" text-danger "><?php if (isset($_SESSION['namaErr'])) { ?>
                                                    *<?php echo $_SESSION['namaErr'];
                                                                                unset($_SESSION['namaErr']);
                                                                            } ?></small>
                                        </td>
                                        <td style="border:none;">
                                            <input type="number" name="usia" id="usia" value="" class="form-control" placeholder="Usia Peserta">
                                            <small class=" text-danger "><?php if (isset($_SESSION['usiaErr'])) { ?>
                                                    *<?php echo $_SESSION['usiaErr'];
                                                                                unset($_SESSION['usiaErr']);
                                                                            } ?></small>
                                        </td>
                                        <td style="border:none;">
                                            <select name="jenis" class="form-control">
                                                <option disabled selected>Jenis Tes</option>
                                                <option value="managerial">Managerial</option>
                                                <option value="nonmanagerial">Nonmanagerial</option>
                                            </select>
                                            <small class=" text-danger "><?php if (isset($_SESSION['jenisErr'])) { ?>
                                                    *<?php echo $_SESSION['jenisErr'];
                                                                                unset($_SESSION['jenisErr']);
                                                                            } ?></small>
                                        </td>
                                        <td style="border:none;">
                                            <input type="text" name="pendidikan" id="pendidikan" value="" class="form-control" placeholder="Pendidikan">
                                            <small class=" text-danger "><?php if (isset($_SESSION['pendidikanErr'])) { ?>
                                                    *<?php echo $_SESSION['pendidikanErr'];
                                                                                unset($_SESSION['pendidikanErr']);
                                                                            } ?></small>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    $(function() {
        $('#taksasi').DataTable({

            "searching": false,
            buttons: [],
            dom: 'Bfrtip',
        });
    });
    $('#nama').on('keypress', function() {
        $('#username').val().split(' ').join('_');
        if ($('#nama').val() == '') {
            var value = '';
            $('#username').val(value);
        } else {
            var u_peserta = $('#nama').val() + '_' + $('#room_id').val();
            $('#username').val(u_peserta);
        }
    });

    function ubahSpasi() {
        $('#username').val().split(' ').join('_');
    }
</script>

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

<script src="../../layout/dist/js_tabel/jquery-3.5.1.js"></script>
<script src="../../layout/dist/js_tabel/jquery.dataTables.min.js"></script>
<script src="../../layout/dist/js_tabel/dataTables.buttons.min.js"></script>
<script src="../../layout/dist/js_tabel/buttons.flash.min.js"></script>
<script src="../../layout/dist/js_tabel/jszip.min.js"></script>
<script src="../../layout/dist/js_tabel/pdfmake.min.js"></script>
<script src="../../layout/dist/js_tabel/vfs_fonts.js"></script>
<script src="../../layout/dist/js_tabel/buttons.html5.min.js"></script>
<script src="../../layout/dist/js_tabel/buttons.print.min.js"></script>