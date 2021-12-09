<?php
  include_once '../layout/header.php';
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="content-fluid ">

		<div class="row mb-2">
	        <div class="col-sm-6">
	          <h1 class="m-0 pl-2 text-dark">
	            Update
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
                        <h5 class="card-title m-0 text-primary"><strong>Room Info</strong></h5>
	          			<a href="" class="btn btn-secondary float-sm-right"><abbr title="Edit Informasi Room"><i class="far fa-edit"></i></abbr></a>
                    </div>

                    <div class="card-body table-responsive">
                        <div class="col-md-12">
                            <table id="rekapTaksasi" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Nama Room</th>
                                        <th>Meeting ID</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>    
                                	<tr>
                                		<td><a href="https://us04web.zoom.us/j/74786107500?pwd=NmJYaFhjL3c2dUs1cU03Ny9hZUZOZz09">https://us04web.zoom.us/j/74786107500?pwd=NmJYaFhjL3c2dUs1cU03Ny9hZUZOZz09</a></td>
                                		<td>Room Psikotest 1</td>
                                		<td>747 8610 7500</td>
                                		<td>GPSfA4</td>
                                    </tr>                                        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h1 class="card-title m-0 text-primary">
							Update Room
						</h1>
					</div>					
				<form role="form">
	                <div class="card-body">
	                  <div class="form-group">
	                    <label for="exampleInputLink">Link Zoom</label>
	                    <input type="text" class="form-control" id="exampleInputLink" placeholder="Masukan Link">
	                  </div>
	                  <div class="form-group">
	                    <label for="exampleInputNamaRoom">Nama Room</label>
	                    <input type="text" class="form-control" id="exampleInputNamaRoom" placeholder="Nama Room">
	                  </div>
	                  <div class="form-group">
	                    <label for="exampleInputMeetingId">Meeting ID</label>
	                    <input type="text" class="form-control" id="exampleInputMeetingId" placeholder="Meeting ID">
	                  </div>
	                  <div class="form-group">
	                    <label for="exampleInputMeetingPassword">Password Room</label>
	                    <input type="text" class="form-control" id="exampleInputMeetingPassword" placeholder="Password Room">
	                  </div>
	                </div>
	                <!-- /.card-body -->

	                <div class="card-footer">
	                  <button type="submit" class="btn btn-secondary float-sm-right ml-2">Update Room</button>
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