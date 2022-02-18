<?php
include '../../kumpulan_function.php';
$soal = new Soal();
session_start();
unset($_SESSION['kerja_soal']);
unset($_SESSION['status_pengerjaan']);
$_SESSION['kerja_soal'] = '';

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
