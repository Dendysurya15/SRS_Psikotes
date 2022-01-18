<?php
include '../../kumpulan_function.php';

$soal = new Soal();

if (isset($_POST['store_biodata'])) {

    $username = 'yusril_454_34';
    $password = 'zoNgPxlR';
    $tmpt_lahir = $_POST['tmpt_lahir'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $gender =  $_POST['gender'];
    $pend_terakhir =  $_POST['pend_terakhir'];
    $jurusan = $_POST['jurusan'];
    $posisi =  $_POST['posisi'];
    $nohp =  $_POST['nohp'];

    $pesertaLogin = $soal->loginPeserta($username, $password);
    $peserta       = $pesertaLogin->fetch_assoc();
    // echo $peserta['id'];

    $arrData = array(
        'tempat_lahir' => $tmpt_lahir,
        'tanggal_lahir' => $tgl_lahir,
        'gender' => $gender,
        'pendidikan_peserta' => $pend_terakhir,
        'jurusan' => $jurusan,
        'posisi_yg_dilamar' => $posisi,
        'kontak_pribadi' => $nohp
    );

    // $soal->updatePeserta($peserta['id'], $arrData);
    print_r($arrData);
    // $nama_lengkap =  $_POST['nama_lengkap'];



    // echo $nama_lengkap;
    // echo $tmpt_lahir;
    // echo $tgl_lahir;
    // echo $gender;
    // echo $pend_terakhir;
    // echo $jurusan;
    // echo $posisi;
    // echo $nohp;
}
