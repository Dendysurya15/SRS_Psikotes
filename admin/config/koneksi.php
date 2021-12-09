<?php
    $server  = 'localhost';
    $username   = 'srsssmsc_andre09';
    $password   = 'sidewinderzone';
    $database   = 'srsssmsc_psikotest';

    $conn       = new mysqli($server, $username, $password, $database);

    if($conn->connect_error)
	{		
		die('Gagal terkoneksi dengan database: '. $conn->connect_error);
	}
?>