<?php	
	include '../../kumpulan_function.php';
	$soal   = new Soal();
	
	if(isset($_POST['button_tambah_soal']))
	{
		if(empty($_POST['nama_soal']) || empty($_POST['durasi_pengerjaan']) || empty($_POST['deskripsi_soal']))
		{
			header('location:../soal/tambah_soal?status=1');
		}
		else
		{
			$nama_soal 		= $_POST['nama_soal'];
			$deskripsi_soal = $_POST['deskripsi_soal'];
			$durasi 		= $_POST['durasi_pengerjaan'];

			$insertSoal		= $soal->TambahDataSoal($nama_soal, $deskripsi_soal, $durasi);
			switch ($insertSoal) {
				case 'Data Telah Diinputkan':
					header('location:../soal/tambah_soal?status=');
					break;				
				default:				
					$nama_soal = strtolower(str_replace(' ', '_', $nama_soal));	
					header('location:../soal/'.$nama_soal.'?soal_id='.$insertSoal.'');
					break;
			}
		}	
	}
	
	if(isset($_POST['update_modul']))
	{
	    $soal_id        = $_POST['update_id'];
	    $durasi         = $_POST['update_durasi_soal'];
	    $deskripsi      = htmlspecialchars($_POST['update_deskripsi_soal']);
	    $pindah_html    = '../soal/'.$_POST['update_pindah_html'];
	    
	    echo $durasi.', '.$deskripsi;
	    
	    $mantap  = $soal->UpdateDataSoal($soal_id, $durasi, $deskripsi, $pindah_html);
	    echo $mantap;
	}
	
?>