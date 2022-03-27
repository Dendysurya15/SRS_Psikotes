<?php
include '../../kumpulan_function.php';
$soal = new Soal();
session_start();
$sesi_terakhir = $_SESSION['kerja_soal'];
unset($_SESSION['kerja_soal']);
unset($_SESSION['status_pengerjaan']);
$_SESSION['kerja_soal'] = '';

$row_update       = array('sesi_terakhir', 'id');
$col_update       = array($sesi_terakhir, $_SESSION['i_peserta']);
$soal->Peserta($row_update, $col_update, 'update');

$session_str = json_encode($_SESSION);

$session_arr = explode(',', $session_str);

$jawaban_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');
$biodata_arr = $soal->array_partial_search($session_arr, 'get');
//hapus semua session soal + jawaban
foreach ($jawaban_arr as $session_data) {
    $firstlastchar = substr($session_data, 1, -1);
    $clean_session = explode('":"', $firstlastchar);

    unset($_SESSION[$clean_session[0]]);
}

foreach ($biodata_arr as $session_data) {
    $firstlastchar = substr($session_data, 1, -1);
    $clean_session = explode('":"', $firstlastchar);

    unset($_SESSION[$clean_session[0]]);
}
header('location:login');
