<?php
  include_once '../layout/header.php';

  if(isset($_GET['status']))
  {
      $status = $_GET['status'];
      switch ($status) {
          case 1:
              echo '<script>
                var html    = "Gagal Menambahkan Modul:\n";
                html        += "Modul Telah Terdaptar";
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
                        Tambah Soal
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
                                Tambah Soal
                            </h1>
                        </div>


                        <form method="post" action="../query/soal_query.php">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputNamaRoom">Modul</label>
                                            <select class="form-control" id="nama_soal" name="nama_soal">
                                                <option disabled selected>Pilih Modul</option>
                                                <option value="Modul 1">Modul 1</option>
                                                <option value="Modul 2">Modul 2</option>
                                                <option value="Modul 3">Modul 3</option>
                                                <option value="Modul 4">Modul 4</option>
                                                <option value="Modul 5">Modul 5</option>
                                                <option value="Modul 6">Modul 6</option>
                                                <option value="Modul 7">Modul 7</option>
                                                <option value="Modul 8">Modul 8</option>
                                                <option value="Modul 9">Modul 9</option>
                                                <option value="Modul 10 SA">Modul 10 SA</option>
                                                <option value="Modul 10 WA">Modul 10 WA</option>
                                                <option value="Modul 10 AN">Modul 10 AN</option>
                                                <option value="Modul 10 RA">Modul 10 RA</option>
                                                <option value="Modul 10 ZR">Modul 10 ZR</option>
                                                <option value="Modul 10 GE">Modul 10 GE</option>
                                                <option value="Modul 10 FA">Modul 10 FA</option>
                                                <option value="Modul 10 WU">Modul 10 WU</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleInputMeetingId">Durasi Pengerjaan</label>
                                            <input type="number" class="form-control" id="exampleInputMeetingId"
                                                placeholder="Durasi Pengerjaan (min)" name="durasi_pengerjaan">
                                        </div>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="deskripsiSoal">Deksripsi Soal</label>
											<textarea class="form-control" name="deskripsi_soal" cols="30" rows="10"></textarea>
										</div>
									</div>
								</div>
                            </div>

                            <div class="card-footer">
                                <input type="submit" class="btn btn-secondary float-sm-right ml-2"
                                    name="button_tambah_soal" value="Tambah Soal">
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