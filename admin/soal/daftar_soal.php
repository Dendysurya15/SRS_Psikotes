<?php
 	include_once '../layout/header.php';
 	
	include '../../kumpulan_function.php';
	
	$soal = new Soal();
	
	$resultDataSoal = $soal->SelectSoal();

?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="content-fluid ">

		<div class="row mb-2">
	        <div class="col-sm-6">
	          <h1 class="m-0 pl-2 text-seconday">
	            SOAL
	          </h1>
	        </div>

          	<div class="col-sm-6">
	          <a href="tambah_soal" class="btn btn-secondary float-sm-right ml-2" style="width: 15%;"><abbr title="Tambah Soal"><i class="fas fa-plus"></i></abbr></a>
	        </div>
		</div>

    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
    	<div class="row">
			<?php if($resultDataSoal->num_rows > 0): ?>
				<?php while ($rowsDataSoal = $resultDataSoal->fetch_assoc()):?>
				<div class="col-md-4">
					<div class="card card-primary card-outline">
						<div class="card-header">
							<h2 class="card-title m-0 text-seconday">
								SOAL
							</h2>
						</div>
						<div class="card-body text-center">
							<div class="row">
								<div class="col">
									<h3>
										<?=$rowsDataSoal['nama_soal'];?>
									</h3>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<a href="<?=strtolower(str_replace(' ', '_', $rowsDataSoal['nama_soal']))?>?soal_id=<?=$rowsDataSoal['id']?>" class="btn btn-secondary float-sm-right">Detail</a>
						</div>
					</div>
				</div>
				<?php endwhile;?>
			
			<?php else :?>
			<div class="col-md-4">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h2 class="card-title m-0 text-primary">
							SOAL
						</h2>
					</div>
					<div class="card-body text-center">
						<div class="row">
							<div class="col">
								<h3>
			    					Belum Ada Soal Yang Dimasukan
			    				</h3>
							</div>
						</div>
					</div>
					<div class="card-footer">
					</div>
				</div>
			</div>
			<?php endif;?>
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