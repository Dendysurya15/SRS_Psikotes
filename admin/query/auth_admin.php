<?php
session_start();
include '../../kumpulan_function.php';
#--Tambah Soal Modul 3
$soal = new Soal();
if (isset($_POST['add_user'])) {
    $tabel          = 'admin';
    $nama_season    = 'admin';
    $array_kolom    = array('username', 'nama', 'email', 'password');
    $array_data     = array($_POST['username'], $_POST['nama'], $_POST['email'], md5($_POST['password']));
    $pindah_html_berhasil   = '../home/web_admin_psikotes';
    $pindah_html_gagal      = '../auth/daftar_admin';
    echo $_POST['username'] . ' ' . $_POST['nama'] . ' ' . $_POST['email'] . ' ' . $_POST['password'];
    $hasil = $soal->AddUser($tabel, $nama_season, $array_data, $array_kolom, $pindah_html_berhasil, $pindah_html_gagal);

    switch ($hasil) {
        case 'berhasil':
            $_SESSION[$nama_season] = $_POST['email'];
            header('location:' . $pindah_html_berhasil . '');
            break;

        default:
            header('location:' . $pindah_html_gagal . '?status=gagal');
            break;
    }
}

if (isset($_POST['login_admin'])) {
    $tabel      = 'admin';
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    $login      = $soal->login_admin($tabel, $email, $password);

    if ($login == 'berhasil') {
        $_SESSION['admin'] = $email;
        header('location:../home/web_admin_psikotes');
    } else {
        header('location:../auth/login_admin?status=gagal');
    }
}

switch (isset($_GET['logout'])) {
    case 'admin':
        unset($_SESSION['admin']);
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
        header('location:../home/web_admin_psikotes');
        break;

    default:
        # code...
        break;
}
