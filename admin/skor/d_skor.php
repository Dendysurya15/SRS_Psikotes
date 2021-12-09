<?php
	include_once '../layout/header.php';
	include '../../kumpulan_function.php';
  $soal = new Soal();

  $room_id  = $_GET['room_id'];
  $skor  = $soal->Skor($room_id);



?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="content-fluid ">

		<div class="row mb-2">
	        <div class="col-sm-6">
	          <h1 class="m-0 pl-2 text-dark">
	            DETAIL SKOR
	          </h1>
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
                        <h5 class="card-title m-0 text-primary"><strong>Skor Info</strong></h5>
                    </div>

                    <div class="card-body table-responsive">
                        <div class="col-md-12">
                            <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Skor Modul 1</th>
                                        <th>Skor Modul 2</th>
                                        <th>Skor Modul 3</th>
                                        <th>Skor Modul 4</th>
                                        <th>Skor Modul 5</th>
                                        <th>Skor Modul 6</th>
                                        <th>Skor Modul 7</th>
                                        <th>Skor Modul 8</th>
                                        <th>Skor Modul 9</th>
                                        <th>Skor Modul 10</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php if($skor->num_rows > 0) :?>
                                    <?php while ($r_skor = $skor->fetch_assoc()): ?>
                                      <tr>
                                        <td><?= $r_skor['nama_peserta'] ?></td>
                                        <td><?= $r_skor['skor_1'] ?></td>
                                        <td><?= $r_skor['skor_2'] ?></td>
                                        <td><?= $r_skor['skor_3'] ?></td>
                                        <td><?= $r_skor['skor_4'] ?></td>
                                        <td><?= str_replace('&lt;br&gt;', '<br>', $r_skor['skor_5']) ?></td>
                                        <td>
                                          <?php
                                            $skor_6 = explode(';', $r_skor['skor_6']);
                                            $lima   = 1;
                                            for ($i = 0; $i < count($skor_6) ; $i++) { 
                                              if($lima != 5)
                                              {
                                                echo $skor_6[$i].',';
                                              }
                                              else 
                                              {
                                                echo $skor_6[$i].'<br>';
                                                $lima = 0;
                                              }
                                              $lima += 1;
                                            }
                                          ?>
                                        </td>
                                        <td><?= $r_skor['skor_7'] ?></td>
                                        <td><?= $r_skor['skor_8'] ?></td>
                                        <td><?= $r_skor['skor_9'] ?></td>
                                        <td>
                                          <?php
                                              if((int)$r_skor['skor_10'] >= 119)
                                              {
                                                echo 'BS B:'.$r_skor['skor_10'];
                                              }    
                                              elseif ( 118 >= (int)$r_skor['skor_10'] AND $r_skor['skor_10'] >= 115) {
                                                echo 'B B:'.$r_skor['skor_10'];
                                              }    
                                              elseif ( 114 >= (int)$r_skor['skor_10'] AND (int)$r_skor['skor_10'] >= 111) {
                                                echo 'C+ B:'.$r_skor['skor_10'];
                                              }    
                                              elseif ( 110 >= (int)$r_skor['skor_10'] AND (int)$r_skor['skor_10'] >= 99) {
                                                echo 'C B:'.$r_skor['skor_10'];
                                              }    
                                              elseif ( 98 >= (int)$r_skor['skor_10'] AND (int)$r_skor['skor_10'] >= 95) {
                                                echo 'C- B:'.$r_skor['skor_10'];
                                              }    
                                              elseif ( 94 >= (int)$r_skor['skor_10'] AND (int)$r_skor['skor_10'] >= 50) {
                                                echo 'K B:'.$r_skor['skor_10'];
                                              }    
                                              elseif (  50 > (int)$r_skor['skor_10']) {
                                                echo 'KS B:'.$r_skor['skor_10'];
                                              }    
                                          ?>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary">Detail Jawaban</a>
                                        </td>

                                      </tr>
                                    <?php endwhile;?>
                                  <?php else:?>
                                    <tr>
                                      <td>Belum Dilakukan Psikotest</td>
                                    </tr>
                                  <?php endif; ?>
                                </tbody>
                            </table>
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

<script>
  //  $('#rekapTaksasi').slideToggle();
</script>