<?php
include_once '../layout/header.php';

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 0) {
        echo '<script>
				alert("Isi Semua data");
			</script>';
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="content-fluid ">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 pl-2 text-dark">
                        Tambah Room
                    </h1>
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
                            <h1 class="card-title m-0 text-primary">
                                Tambah Room
                            </h1>
                        </div>
                        <form role="form" action="../query/room_query" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputLink">Link Zoom</label>
                                            <input type="text" class="form-control" id="exampleInputLink" placeholder="Masukan Link" value="<?php if (isset($_SESSION['getLink'])) { ?><?php echo $_SESSION['getLink'];
                                                                                                                                                                                        unset($_SESSION['getLink']);
                                                                                                                                                                                    } ?>" name="link_room">
                                            <small class=" text-danger "><?php if (isset($_SESSION['linkErr'])) { ?>
                                                    *<?php echo $_SESSION['linkErr'];
                                                                                unset($_SESSION['linkErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputMeetingId">Meeting ID</label>
                                            <input type="text" class="form-control" id="exampleInputMeetingId" placeholder="Meeting ID" value="<?php if (isset($_SESSION['meetingId'])) { ?><?php echo $_SESSION['meetingId'];
                                                                                                                                                                                            unset($_SESSION['meetingId']);
                                                                                                                                                                                        } ?>" name="meeting_id">
                                            <small class=" text-danger "><?php if (isset($_SESSION['meeting_idErr'])) { ?>
                                                    *<?php echo $_SESSION['meeting_idErr'];
                                                                                unset($_SESSION['meeting_idErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputNamaRoom">Nama Room</label>
                                            <input type="text" class="form-control" id="exampleInputNamaRoom" placeholder="Nama Room" value="<?php if (isset($_SESSION['namaRoom'])) { ?><?php echo $_SESSION['namaRoom'];
                                                                                                                                                                                            unset($_SESSION['namaRoom']);
                                                                                                                                                                                        } ?>" name="nama_room">
                                            <small class=" text-danger "><?php if (isset($_SESSION['nama_roomErr'])) { ?>
                                                    *<?php echo $_SESSION['nama_roomErr'];
                                                                                unset($_SESSION['nama_roomErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputMeetingPassword">Password Room</label>
                                            <input type="text" class="form-control" id="exampleInputMeetingPassword" placeholder="Password Room" value="<?php if (isset($_SESSION['passwordRoom'])) { ?><?php echo $_SESSION['passwordRoom'];
                                                                                                                                                                                                        unset($_SESSION['passwordRoom']);
                                                                                                                                                                                                    } ?>" name="password_room">
                                            <small class=" text-danger "><?php if (isset($_SESSION['password_roomErr'])) { ?>
                                                    *<?php echo $_SESSION['password_roomErr'];
                                                                                unset($_SESSION['password_roomErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputMeetingPassword">Tanggal Tes</label>
                                            <input type="date" class="form-control" id="exampleInputMeetingPassword" placeholder="tanggal" value="<?php if (isset($_SESSION['tanggalRoom'])) { ?><?php echo $_SESSION['tanggalRoom'];
                                                                                                                                                                                                    unset($_SESSION['tanggalRoom']);
                                                                                                                                                                                                } ?>" name="tanggal_room">
                                            <small class=" text-danger "><?php if (isset($_SESSION['tanggal_roomErr'])) { ?>
                                                    *<?php echo $_SESSION['tanggal_roomErr'];
                                                                                unset($_SESSION['tanggal_roomErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputMeetingPassword">Jam Mulai</label>
                                            <input type="time" class="form-control" id="exampleInputMeetingPassword" placeholder="jam" value="<?php if (isset($_SESSION['jamMulai'])) { ?><?php echo $_SESSION['jamMulai'];
                                                                                                                                                                                            unset($_SESSION['jamMulai']);
                                                                                                                                                                                        } ?>" name="jam_mulai_room">
                                            <small class=" text-danger "><?php if (isset($_SESSION['jam_mulaiErr'])) { ?>
                                                    *<?php echo $_SESSION['jam_mulaiErr'];
                                                                                unset($_SESSION['jam_mulaiErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputMeetingPassword">Jam Selesai</label>
                                            <input type="time" class="form-control" id="exampleInputMeetingPassword" placeholder="tanggal" value="<?php if (isset($_SESSION['jamSelesai'])) { ?><?php echo $_SESSION['jamSelesai'];
                                                                                                                                                                                                unset($_SESSION['jamSelesai']);
                                                                                                                                                                                            } ?>" name="jam_selesai_room">
                                            <small class=" text-danger "><?php if (isset($_SESSION['jam_selesaiErr'])) { ?>
                                                    *<?php echo $_SESSION['jam_selesaiErr'];
                                                                                unset($_SESSION['jam_selesaiErr']);
                                                                            } ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <input type="submit" class="btn btn-primary float-sm-right ml-2" name="buat_room" value="Buat Room">
                            </div>
                        </form>

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