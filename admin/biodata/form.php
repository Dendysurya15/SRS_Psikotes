<?php
include_once '../layout/header.php';
include '../../kumpulan_function.php';
$soal = new Soal();


$resultDaftarRoom = $soal->DaftarRoom();
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 0:
            echo '
					<script>
						alert("Gagal Menambahkan Room Baru\nQuery Add Room Bermasalah");
					</script>
				';
            break;
        case 1:
            echo '
					<script>
						alert("Room Baru Berhasil Ditambahkan");
					</script>
				';
            break;
        case 11:
            echo '
					<script>
						alert("Room Baru Berhasil Dihapus");
					</script>
				';
            break;
        case 12:
            echo '
					<script>
						alert("Query Hapus Peserta Bermasalah");
					</script>
				';
            break;
        case 13:
            echo '
					<script>
						alert("Query Hapus Peserta Bermasalah");
					</script>
				';
            break;
        case 14:
            echo '
    				<script>
    					alert("Query Hapus Room Bermasalah");
    				</script>
    			';
            break;
        default:
            # code...
            break;
    }
}




?>

<?php

?>

<div class="content-wrapper unselectable">

    <section class="content pt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" ">
                    <h4 class=" text-bold">Biodata Peserta Psikotes</h4>
                    <span style="font-size: 15px; color: #84757D;">
                        Silahkan isi form berikut ini dengan benar sebelum memulai mengerjakan soal psikotes.
                    </span>
                </div>
                <div class="card-body">
                    <form action="../biodata/submited" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="exampleFormControlInput1" style="font-weight: 400;">Nama Lengkap</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan nama" name="nama_lengkap">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleFormControlInput1" style="font-weight: 400;">Tempat Lahir</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : Bandung" name="tmpt_lahir">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" style="font-weight: 400;">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="exampleFormControlInput1" name="tgl_lahir">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="row">
                                    <label for="exampleFormControlInput1" style="font-weight: 400;">Jenis Kelamin</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline1" name="gender" class="custom-control-input" value="Laki-laki">
                                    <label class="custom-control-label" for="customRadioInline1" style="font-weight: 400;">Laki-laki</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="customRadioInline2" name="gender" class="custom-control-input" value="Perempuan">
                                    <label class="custom-control-label" for="customRadioInline2" style="font-weight: 400;">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" style="font-weight: 400;">Pendidikan Terakhir</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : S1" name="pend_terakhir">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" style="font-weight: 400;">Jurusan/Program Studi</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : Pendidikan Bahasa Arab" name="jurusan">

                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4" style="font-weight: 400;">Posisi yang dituju/dilamar</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : Administrasi" name="posisi">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4" style="font-weight: 400;">Kontak Pribadi</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : 08123982XXXX" name="nohp">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2 float-sm-right" name="store_biodata">Submit Data</button>

                    </form>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<!-- page script -->
<script src="../../layout/dist/js_tabel/jquery.dataTables.min.js"></script>
<script src="../../layout/dist/js_tabel/dataTables.buttons.min.js"></script>

<script>
    $(document).ready(function() {
        $('#roomTable').DataTable();
        $("body").on("contextmenu", function(e) {
            return false;
        });
    });

    var link = document.createElement("a")

    function confirmDelete(idRoom) {
        if (confirm("Apakah benar ingin menghapus room ini?")) {
            link.href = "../query/room_query?room_id=" + idRoom + "&status=Hapus"
            link.click()
            alert("Room berhasil dihapus")
        }
    }
</script>


<style>
    .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
</style>