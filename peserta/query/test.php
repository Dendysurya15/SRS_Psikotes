<?php


session_start();    
date_default_timezone_set("Asia/Jakarta");
include '../../kumpulan_function.php';
$soal = new Soal();   


$resPeserta       = $soal->Peserta('username_peserta', 'andre_513_1', 'select');
$rowPeserta       = $resPeserta->fetch_assoc();


$row_update       = array('status_login', 'username_peserta');
$col_update       = array(1, $rowPeserta['username_peserta']);
$updPeserta       = $soal->Peserta($row_update, $col_update, 'update');
echo $updPeserta;

?>