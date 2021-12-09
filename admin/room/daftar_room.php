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
	<section class="content-header">
		<div class="content-fluid ">

			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 pl-2 text-dark">
						Room
					</h1>
				</div>

				<div class="col-sm-6">
					<a href="tambah_room" class="btn btn-primary float-sm-right ml-2" style="width: 15%;"><abbr title="Tambah Room"><i class="fas fa-plus"></i></abbr></a>
				</div>
			</div>

		</div>
	</section>
	<section class="content">

		<div class="container-fluid">
			<div class="card">
				<div class="card-body">
					<?php
					if ($resultDaftarRoom->num_rows > 0) { ?>
						<table class="table table" id="roomTable">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Room</th>
									<th>Tanggal</th>
									<th>Jam Mulai</th>
									<th>Jam Selesai</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>

								<?php
								$number = 1;
								while ($rowDaftarRoom = $resultDaftarRoom->fetch_assoc()) { ?>
									<tr>

										<td> <?= $number . "." ?> </td>
										<td> <?= $rowDaftarRoom['nama_room'] ?> </td>
										<?php
										$convertDate = new DateTime($rowDaftarRoom['tanggal']);
										$dateFormat = date_format($convertDate, 'Y-m-d'); ?>
										<td> <?= $soal->tanggal_indo($dateFormat, true) ?> </td>
										<td> <?= $rowDaftarRoom['jam_mulai'] ?> </td>
										<td> <?= $rowDaftarRoom['jam_selesai'] ?> </td>
										<td>
											<a href="detail_room?room_id=<?= $rowDaftarRoom['id'] ?>" class="btn btn-secondary ">Detail</a>
											<a href="" class="btn btn-danger  mr-2" onclick="confirmDelete(this.id)" id="<?= $rowDaftarRoom['id'] ?>">Hapus</a>
										</td>

									</tr>
								<?php $number++;
								} ?>

							</tbody>
						</table>
					<?php } else { ?>
						<div class="col-md-4">
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h2 class="card-title m-0 text-secondary">
										Room
									</h2>
								</div>
								<div class="card-body text-center">
									<div class="row">
										<div class="col">
											<h3>
												Belum Ada Room Yang Ditambahkan
											</h3>
										</div>
									</div>
								</div>
								<div class="card-footer">
								</div>
							</div>
						</div>
					<?php } ?>
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