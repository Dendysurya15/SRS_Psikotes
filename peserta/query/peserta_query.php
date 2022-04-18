<?php
define('WP_HOME', 'https://www.assessmentcenter-ssms.com/');
define('WP_SITEURL', 'https://www.assessmentcenter-ssms.com/');

session_start();
date_default_timezone_set("Asia/Jakarta");
include '../../kumpulan_function.php';
$soal = new Soal();

$n_tanggal            = date('Y-m-d');
$n_jam                = date('H:i:s');

if (isset($_POST['login_room'])) {
    # ~ 1. SELECT DATA PESERTA
    $arr_kolom  = array('username_peserta', 'password_peserta');
    $arr_data   = array($_POST['username'], $_POST['password']);
    $login      = $soal->Peserta($arr_kolom, $arr_data, 'login');
    #

    # 2. LOGIN 'BERHASIL'
    if ($login == 'berhasil') {

        # ~ 2.1 Dapatkan data peserta
        $resPeserta       = $soal->Peserta('username_peserta', $_POST['username'], 'select');
        $rowPeserta       = $resPeserta->fetch_assoc();
        #   2.1 ~

        $res_room         = $soal->DetailRoom($rowPeserta['room_id']);
        $row_room         = $res_room->fetch_assoc();
        if ($row_room['tanggal'] == $n_tanggal and $n_jam >= $row_room['jam_mulai'] and $row_room['jam_selesai'] >= $n_jam) {
            # ~ 2.3 Insert ke tabel jawaban dengan nilai room_id = $_SESSION['i_room'], 
            # peserta_id = $_SESSION['i_peserta']

            $_SESSION['status_test']            = $rowPeserta['jenis_tes_peserta'];
            $_SESSION['i_peserta']              = $rowPeserta['id'];
            $_SESSION['i_room']                 = $rowPeserta['room_id'];
            $_SESSION['kerja_soal']             = '';

            $num_status_login = $rowPeserta['status_login'];

            if ($rowPeserta['sesi_terakhir'] != NULL) {
                $sesi_terakhir = $rowPeserta['sesi_terakhir'];
            }

            $arr_kolom  = array('room_id', 'peserta_id');
            $arr_data   = array($_SESSION['i_room'], $_SESSION['i_peserta']);
            $arr_detail_jawaban     = $soal->JawabanSel($_SESSION['i_room'], $_SESSION['i_peserta']);
            if ($arr_detail_jawaban->num_rows > 0) {
                $row_detail_jawaban     = $arr_detail_jawaban->fetch_assoc();
                $_SESSION['i_jawaban']  = $row_detail_jawaban['id'];

                $row_update       = array('status_login', 'username_peserta');
                $col_update       = array($num_status_login - 1, $rowPeserta['username_peserta']);
                $updPeserta       = $soal->Peserta($row_update, $col_update, 'update');

                switch ($updPeserta) {
                    case 'berhasil':
                        $_SESSION['w_selesai']  = '';
                        $_SESSION['status_test']            = $rowPeserta['jenis_tes_peserta'];
                        $_SESSION['kerja_soal'] = $sesi_terakhir ?: 'biodata';
                        $soal->KerjaSoal($_SESSION['kerja_soal']);
                        break;
                    case 'gagal':
                        header('location:../auth/login?status=0');
                        break;
                    default:
                        # code...
                        break;
                }
            } else {
                $rowCekJawaban = $soal->JawabanInfo($arr_kolom, $arr_data, 'select');
                $insJawaban = $soal->InputJawaban($arr_kolom, $arr_data, 'insert');

                switch ($insJawaban) {
                    case $insJawaban != 'gagal':
                        $_SESSION['i_jawaban']  = $insJawaban;
                        $row_update       = array('status_login', 'username_peserta');
                        $col_update       = array($num_status_login - 1, $rowPeserta['username_peserta']);
                        $updPeserta       = $soal->Peserta($row_update, $col_update, 'update');
                        switch ($updPeserta) {
                            case 'berhasil':

                                $_SESSION['w_selesai']  = '';
                                $_SESSION['kerja_soal'] = $sesi_terakhir ?: 'biodata';
                                $soal->KerjaSoal($_SESSION['kerja_soal']);

                                break;
                            case 'gagal':
                                header('location:../auth/login?status=0');
                                break;
                            default:
                                # code...
                                break;
                        }
                        break;
                    case 'gagal':
                        header('location:../auth/login?status=0');
                        break;
                    default:
                        # code...
                        break;
                }
            }
            #   2.3 ~

        } else {
            header('location:../auth/login?status=0');
        }
    }
    # 2. LOGIN 'GAGAL'
    else {
        header('location:../auth/login?status=0');
    }
}

if (isset($_POST['store_biodata'])) {

    $id_peserta = $_POST['id_peserta'];
    $status_test = $_POST['status_test'];
    $nama = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir  = $_POST['tanggal_lahir'];
    $gender =  $_POST['gender'];
    $pendidikan_peserta =  $_POST['pendidikan_peserta'];
    $posisi_yg_dilamar =  $_POST['posisi_yg_dilamar'];
    $jurusan = $_POST['jurusan'];
    $kontak_pribadi =  $_POST['kontak_pribadi'];

    session_start();
    if (empty($nama)) {
        $_SESSION['namaErr'] = "Nama wajib di isi";
    } else {
        $_SESSION['getNama'] = $nama;
    }

    if (empty($tanggal_lahir)) {
        $_SESSION['tanggal_lahirErr'] = "Tanggal lahir wajib di isi";
    } else {
        $_SESSION['getTanggallahir'] = $tanggal_lahir;
    }

    if (empty($tempat_lahir)) {
        $_SESSION['tempat_lahirErr'] = "Tempat lahir wajib di isi";
    } else {
        $_SESSION['getTempatlahir'] = $tempat_lahir;
    }

    if (empty($pendidikan_peserta)) {
        $_SESSION['pendidikan_pesertaErr'] = "Pendidikan terakhir wajib di isi";
    } else {
        $_SESSION['getPendidikanpeserta'] = $pendidikan_peserta;
    }

    if (empty($gender)) {
        $_SESSION['genderErr'] = "Gender wajib di isi";
    } else {
        $_SESSION['getGender'] = $gender;
    }

    if (empty($jurusan)) {
        $_SESSION['jurusanErr'] = "Jurusan wajib di isi";
    } else {
        $_SESSION['getJurusan'] = $jurusan;
    }

    if (empty($posisi_yg_dilamar)) {
        $_SESSION['posisi_yg_dilamarErr'] = "Posisi yang dilamar wajib di isi";
    } else {
        $_SESSION['getPosisiygdilamar'] = $posisi_yg_dilamar;
    }

    if (empty($kontak_pribadi)) {
        $_SESSION['kontak_pribadiErr'] = "Kontak pribadi wajib di isi";
    } else {
        $_SESSION['getKontakpribadi'] = $kontak_pribadi;
    }

    if (
        isset($_SESSION['namaErr']) || isset($_SESSION['tanggal_lahirErr']) || isset($_SESSION['tempat_lahirErr']) || isset($_SESSION['pendidikan_pesertaErr']) ||
        isset($_SESSION['genderErr']) ||  isset($_SESSION['jurusanErr']) ||  isset($_SESSION['posisi_yg_dilamarErr']) ||  isset($_SESSION['kontak_pribadiErr'])
    ) {
        header('location:../kerja_soal/biodata');
    } else {


        $rowUpdate = array('tempat_lahir', 'tanggal_lahir', 'gender', 'pendidikan_peserta', 'posisi_yg_dilamar', 'jurusan', 'kontak_pribadi', 'id');
        $arrData = array($tempat_lahir, $tanggal_lahir, $gender, $pendidikan_peserta, $posisi_yg_dilamar, $jurusan, $kontak_pribadi, $id_peserta);

        $updatePeserta = $soal->Peserta($rowUpdate, $arrData, 'update');

        if ($updatePeserta == 'berhasil') {
            if ($status_test == 'asmen-up' || $status_test == 'staff/asisten') {
                $_SESSION['kerja_soal'] = 'soal_10_se';
                $_SESSION['w_selesai']  = '';
                $_SESSION['status'] = '1';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else {
                $_SESSION['kerja_soal'] = 'soal_1';
                $_SESSION['w_selesai']  = '';
                $_SESSION['status'] = '1';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            }
        } else {
            header('location:../kerja_soal/biodata?status=0');
        }
    }
}

if (isset($_POST['draft_jawaban_prev']) || isset($_POST['draft_jawaban_next']) || isset($_POST['draft_jawaban_pintas'])) {

    $button = '';
    if (isset($_POST['draft_jawaban_prev'])) {
        $button = 'kiri';
    }
    if (isset($_POST['draft_jawaban_next'])) {
        $button = 'kanan';
    }
    if (isset($_POST['draft_jawaban_pintas'])) {
        $button = 'pintas';
    }

    $index = $_POST['index'];
    $kerja_soal = $_POST['kerja_soal'];
    $noSoal =  $_POST['nomor_soal' . $index];


    $jawabanSoal =  $_POST['jawaban'] ?: '';
    $jawabanKiri = $_POST['jawaban_kiri'] ?: 0;
    $jawabanKanan = $_POST['jawaban_kanan'] ?: 0;

    // echo $kerja_soal;
    // echo $_SESSION['kerja_soal'];

    if ($kerja_soal == 'soal_5') {
        $_SESSION['jawaban_soal' . $index] = $jawabanKiri . '_' . $jawabanKanan;
        // echo 'ya';
    } else {
        // echo 'tidak';
        $_SESSION['jawaban_soal' . $index] = $jawabanSoal;
    }

    // echo $jawabanSoal;
    // echo $_SESSION['jawaban_soal' . $index];

    $soalPintas = $_POST['soal_pintas'];
    $_SESSION['status_pengerjaan'] = $_POST['status_pengerjaan'];

    switch ($button) {
        case 'kiri':
            $page = $soal->modulSoal($_SESSION['kerja_soal']);
            header($page . '?index=' . ($noSoal - 1));
            break;
        case 'kanan':
            $page = $soal->modulSoal($_SESSION['kerja_soal']);
            header($page . '?index=' . ($noSoal + 1));
            break;
        case 'pintas':
            $page = $soal->modulSoal($_SESSION['kerja_soal']);
            header($page . '?index=' . $soalPintas);
            break;
        default:
            return 'tidak ada button yang ditekan';
            break;
    }
}

if (isset($_POST['soal_1'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['status_pengerjaan']);

    $jumlah_soal = $_POST['jumlah_soal'];
    $user_soal = $_POST['user_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    foreach ($checked_jawaban_soal_arr as $value) {

        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');
    $biodata_arr = $soal->array_partial_search($session_arr, 'get');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    foreach ($biodata_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    if (empty($rDetJawaban['soal_1'])) {

        $resKunciJawaban    = $soal->KunciJawaban('modul_1');

        # ~ Nomor Soal Yang terdapat di modul 1 
        $arr_nomor_modul    = array();

        # ~ Kunci Jawaban Soal Yang terdapat di modul 1
        $arr_jawab_modul    = array();

        if ($resKunciJawaban->num_rows > 0) {
            while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
                array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
                array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
            }
        }
        print_r($arr_nomor_modul);
        echo '<br><br>';
        print_r($arr_jawab_modul);

        #Skoring 
        $jum_benar          = 0;
        $soal_user = array();
        $jawaban_user = array();
        $store_jawaban = array();
        $increment = 0;
        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $soal_user[] = $i;
            if (in_array($i, $soalArr)) {
                $jawaban_user[] = $jawabanArr[$increment];
                $store_jawaban[] = $i . '=' . $increment;
                $increment++;
            } else {
                $jawaban_user[] = '0';
                $store_jawaban[] = $i . '= ';
            }
        }

        for ($i = 0; $i < $jumlah_soal; $i++) {
            if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
                $jum_benar += 1;
            }
        }

        $nilai = '';
        if (30 >= $jum_benar and $jum_benar >= 27) {
            $nilai = 'BS B :' . $jum_benar;
        } else if (26 >= $jum_benar and $jum_benar >= 23) {
            $nilai = 'B B :' . $jum_benar;
        } else if (22 >= $jum_benar and $jum_benar >= 18) {
            $nilai = 'C+ B :' . $jum_benar;
        } else if (17 >= $jum_benar and $jum_benar >= 12) {
            $nilai = 'C- B :' . $jum_benar;
        } else if (11 >= $jum_benar and $jum_benar >= 6) {
            $nilai = 'C- B :' . $jum_benar;
        } else if (5 >= $jum_benar and $jum_benar >= 3) {
            $nilai = 'K B :' . $jum_benar;
        } else {
            $nilai = 'SK B :' . $jum_benar;
        }
        echo '<br><br>' . $nilai;

        $store_jawaban =  implode(", ", $store_jawaban);
        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_1', 'skor_1', 'WHERE');
        $arr_data   = array($store_jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
            $rdetJawaban    = $detJawaban->fetch_assoc();

            if ($_SESSION['status_test'] == 'managerial') {
                $_SESSION['w_selesai']  = '';
                $_SESSION['kerja_soal'] = 'soal_3';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else if (($_SESSION['status_test'] == 'nonstaff')) {
                $_SESSION['kerja_soal'] = 'soal_3';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else {
                $_SESSION['kerja_soal'] = 'hapalan';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            }
        } else {
            header('location:../kerja_soal/kerja_modul_1?status=0');
        }
    } else {
        if ($_SESSION['status_test'] == 'managerial') {
            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_3';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $_SESSION['kerja_soal'] = 'soal_3';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }
}

if (isset($_POST['hapalan'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_2'])) {
        #   2.2.1 ~
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_2';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        if (($_SESSION['status_test'] == 'staff/asisten')  || ($_SESSION['status_test'] == 'asmen-up')) {
            $_SESSION['kerja_soal'] = 'soal_2';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_3';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }
}


# ~ SOAL 2
if (isset($_POST['soal_2'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    // unset($_SESSION['w_selesai']);
    // unset($_SESSION['kerja_soal']);

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    echo $checked_jawaban_soal;
    $checked_soal_arr = explode(", ", $checked_soal);

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soal->array_dump($checked_jawaban_soal_arr);
    // print_r($checked_jawaban_soal);
    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');
    $biodata_arr = $soal->array_partial_search($session_arr, 'get');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    foreach ($biodata_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    unset($_SESSION['status_pengerjaan']);
    if (empty($rDetJawaban['soal_2'])) {

        # ~ informasi kunci jawaban dan nomor modul
        $arr_nomor_modul    = array();
        $arr_jawab_modul    = array();

        $resKunciJawaban    = $soal->KunciJawaban('modul_2');

        while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
            array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
            array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
        }

        # ~

        # ~ Informasi submit jawaban peserta
        $jum_benar          = 0;
        $soal_user = array();
        $jawaban_user = array();
        $store_jawaban = array();
        $increment = 0;
        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $soal_user[] = $i;
            if (in_array($i, $soalArr)) {
                $jawaban_user[] = $jawabanArr[$increment];
                $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
                $increment++;
            } else {
                $jawaban_user[] = '';
                $store_jawaban[] = $i . '= ';
            }
        }

        # ~ Cek Jawaban Benar 
        $hasil = 0;
        for ($i = 0; $i < $jumlah_soal; $i++) {
            if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
                $hasil += 1;
            }
        }

        # ~ 
        $nilai = 'B :' . $hasil;

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';
        $store_jawaban =  implode(", ", $store_jawaban);
        $arr_kolom  = array('soal_2', 'skor_2', 'WHERE');
        $arr_data   = array($store_jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            if ($_SESSION['status_test'] == 'managerial') {

                $_SESSION['kerja_soal'] = 'soal_1';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else {

                $_SESSION['kerja_soal'] = 'soal_3';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            }
        } else {
            header('location:../kerja_soal/kerja_modul_2?status=0');
        }
    } else {
        if ($_SESSION['status_test'] == 'managerial') {

            $_SESSION['kerja_soal'] = 'soal_1';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {

            $_SESSION['kerja_soal'] = 'soal_3';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }
}
# SOAL 2 ~


# ~ SOAL 3
if (isset($_POST['soal_3'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);
    unset($_SESSION['status_pengerjaan']);

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    // print_r($checked_jawaban_soal);
    $soalArr = array();
    $jawabanArr = array();
    foreach ($checked_jawaban_soal_arr as $value) {

        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    if (empty($rDetJawaban['soal_3'])) { # ~ Informasi Nomor dan kunci jawaban modul
        $arr_nomor_modul    = array();
        $arr_jawab_modul    = array();

        $resKunciJawaban    = $soal->KunciJawaban('modul_3');

        while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
            array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
            array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
        }
        # ~

        # ~ Informasi Jawaban Peserta
        $jum_benar          = 0;
        $soal_user = array();
        $jawaban_user = array();
        $store_jawaban = array();
        $increment = 0;
        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $soal_user[] = $i;
            if (in_array($i, $soalArr)) {
                $jawaban_user[] = $jawabanArr[$increment];
                $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
                $increment++;
            } else {
                $jawaban_user[] = '';
                $store_jawaban[] = $i . '= ';
            }
        }
        # ~ 

        $soal->array_dump($store_jawaban);
        # ~ Cek Jawaban Benar 
        $hasil = 0;
        for ($i = 0; $i < $jumlah_soal; $i++) {
            if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
                $jum_benar += 1;
            }
        }
        # ~ 
        $nilai = '';
        if ($jum_benar >= 78) {
            $nilai = 'SB | B:' . $jum_benar;
        } elseif (77 >= $jum_benar and $jum_benar >= 65) {
            $nilai = 'B | B:' . $jum_benar;
        } elseif (64 >= $jum_benar and $jum_benar >= 52) {
            $nilai = 'C+ | B:' . $jum_benar;
        } elseif (51 >= $jum_benar and $jum_benar >= 39) {
            $nilai = 'C | B:' . $jum_benar;
        } elseif (38 >= $jum_benar and $jum_benar >= 25) {
            $nilai = 'C- | B:' . $jum_benar;
        } elseif (24 >= $jum_benar and $jum_benar >= 12) {
            $nilai = 'K | B:' . $jum_benar;
        } elseif (11 >= $jum_benar and $jum_benar >= 0) {
            $nilai = 'SK | B:' . $jum_benar;
        }

        $store_jawaban =  implode(", ", $store_jawaban);
        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_3', 'skor_3', 'WHERE');
        $arr_data   = array($store_jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            if (($_SESSION['status_test'] == 'staff/asisten') || ($_SESSION['status_test'] == 'asmen-up')) {
                $_SESSION['kerja_soal'] = 'soal_5';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else {
                $_SESSION['kerja_soal'] = 'soal_4';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            }
        } else {
            header('location:../kerja_soal/kerja_modul_3?status=0');
        }
    } else {
        if ($_SESSION['status_test'] == 'nonstaff') {
            $_SESSION['kerja_soal'] = 'soal_4';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'staff/asisten') {
            $_SESSION['kerja_soal'] = 'soal_5';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'asmen-up') {
            $_SESSION['kerja_soal'] = 'soal_5';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $_SESSION['kerja_soal'] = 'soal_4';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }
}
# SOAL 3 ~

# ~ SOAL 4
if (isset($_POST['soal_4'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);
    unset($_SESSION['status_pengerjaan']);

    $jumlah_soal = $_POST['jumlah_soal'];
    $user_soal = $_POST['user_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    foreach ($checked_jawaban_soal_arr as $value) {

        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    if (empty($rDetJawaban['soal_4'])) { # ~ Informasi Nomor dan kunci jawaban modul
        $arr_nomor_modul    = array();
        $arr_jawab_modul    = array();

        $resKunciJawaban    = $soal->KunciJawaban('modul_4');

        while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
            array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
            array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
        }
        # ~


        # ~ Informasi Jawaban Peserta
        $soal_user = array();
        $jawaban_user = array();
        $store_jawaban = array();
        $increment = 0;
        for ($i = 1; $i <= $jumlah_soal; $i++) {
            $soal_user[] = $i;
            if (in_array($i, $soalArr)) {
                $jawaban_user[] = $jawabanArr[$increment];
                $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
                $increment++;
            } else {
                $jawaban_user[] = '0';
                $store_jawaban[] = $i . '= ';
            }
        }

        # ~ Cek Jawaban Benar 
        $hasil = 0;
        for ($i = 0; $i < $jumlah_soal; $i++) {
            if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
                $jum_benar += 1;
            }
        }
        # ~ 

        $nilai = 'B :' . $hasil;

        $store_jawaban =  implode(", ", $store_jawaban);
        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_4', 'skor_4', 'WHERE');
        $arr_data   = array($store_jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $_SESSION['kerja_soal'] = 'soal_5';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_4?status=0');
        }
    } else {
        if ($_SESSION['status_test'] == 'managerial') {
            $_SESSION['kerja_soal'] = 'soal_4';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'nonstaff') {
            $_SESSION['kerja_soal'] = 'soal_5';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $_SESSION['kerja_soal'] = 'soal_5';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }
}
# SOAL 4 ~

# ~ SOAL 10

# SOAL 10 ~

# ~ SOAL 5
if (isset($_POST['soal_5'])) {

    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined,undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    echo $checked_jawaban_soal;

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soal->array_dump($checked_jawaban_soal_arr);

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    if (empty($rDetJawaban['soal_5'])) {

        #MOST
        $kat_set_d = 0;
        $kat_set_i = 0;
        $kat_set_s = 0;
        $kat_set_c = 0;
        $kat_set_bin = 0;
        $kat_set_nl = 0;

        #LEAST
        $kat_tdk_d = 0;
        $kat_tdk_i = 0;
        $kat_tdk_s = 0;
        $kat_tdk_c = 0;
        $kat_tdk_bin = 0;
        $kat_tdk_nl = 0;

        $soalArr = array();
        $jawabanArrSetuju = array();
        $jawabanArrTidakSetuju = array();
        $tmp_store = array();
        $store_jawaban = array();
        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $soalArr[] = $newValue[0];

            $arrTemp = explode(',', $newValue[1]);
            $jawabanArrSetuju[] = $arrTemp[0];
            $jawabanArrTidakSetuju[] = $arrTemp[1];
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        //sorting jawaban berdasarkan key
        ksort($tmp_store);

        foreach ($tmp_store as $key => $value) {
            $store_jawaban[] = $key . '=' . $value;
        }

        unset($_SESSION['status_pengerjaan']);
        // $soal->array_dump($jawabanArrSetuju);

        foreach ($jawabanArrSetuju as $key => $value) {
            switch ($value) {
                case 'D':
                    $kat_set_d += 1;
                    break;
                case 'I':
                    $kat_set_i += 1;
                    break;
                case 'S':
                    $kat_set_s += 1;
                    break;
                case 'C':
                    $kat_set_c += 1;
                    break;
                case '*':
                    $kat_set_bin += 1;
                    break;
                default:
                    # code...
                    break;
            }
        }

        foreach ($jawabanArrTidakSetuju as $key => $value) {
            switch ($value) {
                case 'D':
                    $kat_tdk_d += 1;
                    break;
                case 'I':
                    $kat_tdk_i += 1;
                    break;
                case 'S':
                    $kat_tdk_s += 1;
                    break;
                case 'C':
                    $kat_tdk_c += 1;
                    break;
                case '*':
                    $kat_tdk_bin += 1;
                    break;
                default:
                    # code...
                    break;
            }
        }


        #CHANGE
        $kat_chg_d = $kat_set_d - $kat_tdk_d;
        $kat_chg_i = $kat_set_i - $kat_tdk_i;
        $kat_chg_s = $kat_set_s - $kat_tdk_s;
        $kat_chg_c = $kat_set_c - $kat_tdk_c;

        $set    = 'M_D=' . $kat_set_d . ';M_I=' . $kat_set_i . ';M_S=' . $kat_set_s . ';M_C=' . $kat_set_c . ';M_*=' . $kat_set_bin . ';Null=' . $kat_set_nl . ';';
        $tid    = 'L_D=' . $kat_tdk_d . ';L_I=' . $kat_tdk_i . ';L_S=' . $kat_tdk_s . ';L_C=' . $kat_tdk_c . ';L_*=' . $kat_tdk_bin . ';Null=' . $kat_tdk_nl . ';';
        $chg    = 'C_D=' . $kat_chg_d . ';C_I=' . $kat_chg_i . ';C_S=' . $kat_chg_s . ';C_C=' . $kat_chg_c . ';';

        $hasil  = $set . '<br>' . $tid . '<br>' . $chg;

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $store_jawaban =  implode(", ", $store_jawaban);

        $arr_kolom  = array('soal_5', 'skor_5', 'WHERE');
        $arr_data   = array($store_jawaban, htmlspecialchars($hasil), $kondisi);


        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {

            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_5?status=0');
        }
    } else {
        if ($_SESSION['status_test'] == 'managerial') {
            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'nonstaff') {
            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'staff/asisten') {
            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'asmen-up') {
            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }


    #echo $soal->InputJawaban($arr_kolom, $arr_data, 'modul_5');


}
# SOAL 5 ~

# ~ SOAL 6 - SOAL 7
# ~ SOAL 6
if (isset($_POST['soal_6'])) {

    $jum_A = 0;
    $jum_B = 0;
    $jum_C = 0;
    $jum_D = 0;
    $jum_E = 0;
    $jum_F = 0;
    $jum_G = 0;
    $jum_H = 0;
    $jum_I = 0;
    $jum_K = 0;
    $jum_L = 0;
    $jum_N = 0;
    $jum_O = 0;
    $jum_P = 0;
    $jum_R = 0;
    $jum_S = 0;
    $jum_T = 0;
    $jum_V = 0;
    $jum_W = 0;
    $jum_X = 0;
    $jum_Z = 0;
    $jum_nl = 0;

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_soal_arr = explode(", ", $checked_soal);

    echo $checked_jawaban_soal;
    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soal->array_dump($checked_jawaban_soal_arr);
    // print_r($checked_jawaban_soal);
    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
        $tmp_store[$newValue[0]] = $newValue[1];
    }
    //sorting jawaban berdasarkan key
    ksort($tmp_store);

    foreach ($tmp_store as $key => $value) {
        $store_jawaban[] = $key . '=' . $value;
    }


    foreach ($jawabanArr as $value) {
        switch ($value) {
            case 'A':
                $jum_A += 1;
                break;
            case 'B':
                $jum_B += 1;
                break;
            case 'C':
                $jum_C += 1;
                break;
            case 'D':
                $jum_D += 1;
                break;
            case 'E':
                $jum_E += 1;
                break;
            case 'F':
                $jum_F += 1;
                break;
            case 'G':
                $jum_G += 1;
                break;
            case 'H':
                $jum_H += 1;
                break;
            case 'I':
                $jum_I += 1;
                break;
            case 'K':
                $jum_K += 1;
                break;
            case 'L':
                $jum_L += 1;
                break;
            case 'N':
                $jum_N += 1;
                break;
            case 'O':
                $jum_O += 1;
                break;
            case 'P':
                $jum_P += 1;
                break;
            case 'R':
                $jum_R += 1;
                break;
            case 'S':
                $jum_S += 1;
                break;
            case 'T':
                $jum_T += 1;
                break;
            case 'V':
                $jum_V += 1;
                break;
            case 'W':
                $jum_W += 1;
                break;
            case 'X':
                $jum_X += 1;
                break;
            case 'Z':
                $jum_Z += 1;
                break;
            default:
                # code...
                break;
        }
    }


    $hasil  = 'A=' . $jum_A . ';B=' . $jum_B . ';C=' . $jum_C . ';D=' . $jum_D . ';E=' . $jum_E . ';F='
        . $jum_F . ';G=' . $jum_G . ';H=' . $jum_H . ';I=' . $jum_I . ';K=' . $jum_K . ';L='
        . $jum_L . ';N=' . $jum_N . ';O=' . $jum_O . ';P=' . $jum_P . ';R=' . $jum_R . ';S='
        . $jum_S . ';T=' . $jum_T . ';V=' . $jum_V . ';W=' . $jum_W . ';X=' . $jum_X . ';Z='
        . $jum_Z . ';Null=' . $jum_nl;

    $store_jawaban =  implode(", ", $store_jawaban);

    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_6', 'skor_6', 'WHERE');
    $arr_data   = array($store_jawaban, htmlspecialchars($hasil), $kondisi);

    #echo $jawaban;

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        // if ($_SESSION['status_test'] == 'nonmanagerial') {
        //     $d_hapalan      = $soal->SelectSoal2('Modul 8');
        //     $r_hapalan      = $d_hapalan->fetch_assoc();
        //     $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        //     echo '<br><br>' . $r_hapalan['durasi'];

        //     unset($_SESSION['w_selesai']);
        //     unset($_SESSION['kerja_soal']);

        //     $_SESSION['kerja_soal'] = 'soal_8';
        //     $_SESSION['w_selesai']  = '';
        //     $soal->KerjaSoal($_SESSION['kerja_soal']);
        // } 
        if ($_SESSION['status_test'] == 'nonstaff') {
            $d_hapalan      = $soal->SelectSoal2('Modul 9');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

            echo '<br><br>' . $r_hapalan['durasi'];
            $_SESSION['kerja_soal'] = 'soal_9';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'asmen-up') {
            $d_hapalan      = $soal->SelectSoal2('Modul 9');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];
            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);
            echo '<br><br>' . $r_hapalan['durasi'];
            $_SESSION['kerja_soal'] = 'soal_7';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else if ($_SESSION['status_test'] == 'staff/asisten') {
            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);

            $_SESSION['kerja_soal'] = 'selesai';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $d_hapalan      = $soal->SelectSoal2('Modul 9');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

            echo '<br><br>' . $r_hapalan['durasi'];

            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);

            $_SESSION['kerja_soal'] = 'soal_9';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    } else {
        header('location:../kerja_soal/kerja_modul_6?status=0');
    }
}

# ~ SOAL 7
if (isset($_POST['soal_7'])) {
    #KOLOM
    $arr_jawaban    = array();

    $jum_           = 0;
    $jawaban        = array();


    $ins_jawaban    = '';

    $jumlah_soal = $_POST['jumlah_soal'];
    $user_soal = $_POST['user_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    echo $checked_jawaban_soal;
    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soal->array_dump($checked_jawaban_soal_arr);

    $soalArr = array();
    $jawabanArr = array();
    foreach ($checked_jawaban_soal_arr as $value) {

        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $soal_user = array();
    $jawaban_user = array();
    $increment = 0;
    for ($i = 1; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }
    $soal->array_dump($store_jawaban);
    $soal->array_dump($jawaban_user);

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');
    $biodata_arr = $soal->array_partial_search($session_arr, 'get');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    foreach ($biodata_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    unset($_SESSION['status_pengerjaan']);
    for ($i = 0; $i < $jumlah_soal; $i++) {
        if ($jum_ < 7) {
            if ($jawaban_user[$i] != '') {

                array_push($jawaban, $jawaban_user[$i]);
                $jum_ += 1;

                $ins_jawaban .= $soal_user[$i] . '=' . $jawaban_user[$i] . ';';
            } else {
                array_push($jawaban, '');
                $jum_ += 1;

                $ins_jawaban .= $soal_user[$i] . '=;';
            }
        } else {
            if ($jawaban_user[$i] != '') {


                array_push($jawaban, $jawaban_user[$i]);

                array_push($arr_jawaban, $jawaban);

                $jawaban = array();
                $jum_ = 0;

                $ins_jawaban .= $soal_user[$i] . '=' . $jawaban_user[$i] . ';';
            } else {
                echo '<br>';

                array_push($jawaban, '');

                array_push($arr_jawaban, $jawaban);

                $jawaban = array();
                $jum_ = 0;

                $ins_jawaban .= $soal_user[$i] . '=;';
            }
        }
    }


    $jum_a = 0;
    $jum_b = 0;

    $arr_a = array();
    $arr_b = array();
    echo '<table border="1">';
    for ($row = 0; $row < count($arr_jawaban); $row++) {
        echo '<tr>';
        for ($col = 0; $col < count($arr_jawaban[$row]); $col++) {
            echo '<td>' . $arr_jawaban[$row][$col] . '</td>';

            if ($arr_jawaban[$row][$col] == 'A') {
                $jum_a += 1;
            } else {
            }

            if ($arr_jawaban[$col][$row] == 'B') {
                $jum_b += 1;
            }
        }
        array_push($arr_a, $jum_a);
        echo '<td>' . $jum_a . '</td>';
        $jum_a = 0;
        echo '<td>' . $jum_b . '</td>';
        array_push($arr_b, $jum_b);
        $jum_b = 0;
        echo '</tr>';
    }
    echo '</table>';
    echo '<br><br>';

    $arr_koreksi    = array(1, 2, 1, 0, 3, -1, 0, -4);
    $arr_jumlah     = array();

    for ($i = 0; $i < count($arr_koreksi); $i++) {
        $jumlah = $arr_a[$i] + $arr_b[$i] + $arr_koreksi[$i];
        array_push($arr_jumlah, $jumlah);
    }
    $arr_ds = array(0, 0, 0, $arr_jumlah[0]);
    $arr_mi = array(0, $arr_jumlah[1], 0, 0);
    $arr_aa = array($arr_jumlah[2], 0, 0, 0);
    $arr_co = array($arr_jumlah[3], $arr_jumlah[3], 0, 0);
    $arr_bu = array(0, 0, $arr_jumlah[4], 0);
    $arr_dv = array(0, $arr_jumlah[5], $arr_jumlah[5], 0);
    $arr_ba = array($arr_jumlah[6], 0, $arr_jumlah[6], 0);
    $arr_e  = array($arr_jumlah[7], $arr_jumlah[7], $arr_jumlah[7], 0);

    $jum_to = $arr_aa[0] + $arr_co[0] + $arr_ba[0] + $arr_e[0];
    $jum_ro = $arr_mi[1] + $arr_co[1] + $arr_dv[1] + $arr_e[1];
    $jum_e  = $arr_bu[2] + $arr_dv[2] + $arr_ba[2] + $arr_e[2];
    $jum_o  = $arr_ds[3];

    $hasil  = 'TO=' . $jum_to . '|' . 'RO=' . $jum_ro . '|' . 'E=' . $jum_e . '|' . 'O=' . $jum_o;

    $ins_jawaban = substr($ins_jawaban, 0, -1);

    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_7', 'skor_7', 'WHERE');
    $arr_data   = array($ins_jawaban, htmlspecialchars($hasil), $kondisi);

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        if ($_SESSION['status_test'] == 'asmen-up') {
            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);

            $_SESSION['kerja_soal'] = 'selesai';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            $d_hapalan      = $soal->SelectSoal2('Modul 8');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

            echo '<br><br>' . $r_hapalan['durasi'];

            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);

            $_SESSION['kerja_soal'] = 'soal_8';
            $_SESSION['w_selesai']  = date('H:i:s', $w_selesai);
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    } else {
        header('location:../kerja_soal/kerja_modul_7?status=0');
    }

    /* switch ($modul_7) {
            case 'berhasil':
                unset($_SESSION['kerja_soal']);
                $_SESSION['kerja_soal'] = 'soal_8';
                $soal->KerjaSoal($_SESSION['kerja_soal']);    
                break;
            
            default:
                header('location:../kerja_soal/kerja_modul_7?status=0');
                break;
        } */
}
# SOAL 6 -7 ~

# ~ SOAL 8
if (isset($_POST['soal_8'])) {

    #Jawaban User
    $jawaban    = '';

    $arr_kateg_peserta = array();
    $arr_nomor_peserta = array();


    $nomor_soal = $_POST['nomor_soal'];
    for ($i = 0; $i < count($nomor_soal); $i++) {
        if (isset($_POST['kategori_' . $nomor_soal[$i] . ''])) {
            $jawaban        .= $nomor_soal[$i] . '=' . $_POST['kategori_' . $nomor_soal[$i] . ''] . ';';
            array_push($arr_nomor_peserta, $nomor_soal[$i]);
            array_push($arr_kateg_peserta, $_POST['kategori_' . $nomor_soal[$i] . '']);
        } else {
            $jawaban        .= $nomor_soal[$i] . '=;';
            array_push($arr_nomor_peserta, $nomor_soal[$i]);
            array_push($arr_kateg_peserta, '');
        }
    }
    $jawaban = substr($jawaban, 0, -1);

    $q_f    = 0;
    $c_i    = 0;
    $c_o    = 0;
    $t_w    = 0;
    $c_     = 0;
    $i_     = 0;


    for ($i = 0; $i < count($arr_nomor_peserta); $i++) {
        if (
            $arr_nomor_peserta[$i] == 6 || $arr_nomor_peserta[$i] == 19 ||
            $arr_nomor_peserta[$i] == 26
        ) {
            $q_f    += (int)$arr_kateg_peserta[$i];
        } else if (
            $arr_nomor_peserta[$i] == 4 || $arr_nomor_peserta[$i] == 11 || $arr_nomor_peserta[$i] == 32 ||
            $arr_nomor_peserta[$i] == 13 || $arr_nomor_peserta[$i] == 15 || $arr_nomor_peserta[$i] == 34
        ) {
            $c_i     += (int)$arr_kateg_peserta[$i];
        } else if (
            $arr_nomor_peserta[$i] == 1 || $arr_nomor_peserta[$i] == 8 || $arr_nomor_peserta[$i] == 27 ||
            $arr_nomor_peserta[$i] == 16 || $arr_nomor_peserta[$i] == 23 || $arr_nomor_peserta[$i] == 24 ||
            $arr_nomor_peserta[$i] == 28 || $arr_nomor_peserta[$i] == 31
        ) {
            $c_o    += (int)$arr_kateg_peserta[$i];
        } else if (
            $arr_nomor_peserta[$i] == 2 || $arr_nomor_peserta[$i] == 36 || $arr_nomor_peserta[$i] == 30 ||
            $arr_nomor_peserta[$i] == 35
        ) {
            $t_w    += (int)$arr_kateg_peserta[$i];
        } else if (
            $arr_nomor_peserta[$i] == 5 || $arr_nomor_peserta[$i] == 14 || $arr_nomor_peserta[$i] == 33 ||
            $arr_nomor_peserta[$i] == 3 || $arr_nomor_peserta[$i] == 12 || $arr_nomor_peserta[$i] == 22
        ) {
            $c_    += (int)$arr_kateg_peserta[$i];
        } else if (
            $arr_nomor_peserta[$i] == 7 || $arr_nomor_peserta[$i] == 10 || $arr_nomor_peserta[$i] == 17 ||
            $arr_nomor_peserta[$i] == 18 || $arr_nomor_peserta[$i] == 29 || $arr_nomor_peserta[$i] == 9 ||
            $arr_nomor_peserta[$i] == 20 || $arr_nomor_peserta[$i] == 21 || $arr_nomor_peserta[$i] == 25 ||
            $arr_nomor_peserta[$i] == 37
        ) {
            $i_    += (int)$arr_kateg_peserta[$i];
        }
    }

    $hasil = '';

    #Quality Focus
    if ($q_f >= 12) {
        $hasil .= 'QF=S;';
    } else if (12 > $q_f and $q_f >= 8) {
        $hasil .= 'QF=CS;';
    } else if (8 > $q_f) {
        $hasil .= 'QF=BS;';
    }
    #

    #Continuous Improvement
    if ($c_i >= 18) {
        $hasil .= 'CI=S;';
    } else if (18 > $c_i and $c_i >= 12) {
        $hasil .= 'CI=CS;';
    } else if (12 > $c_i) {
        $hasil .= 'CI=BS;';
    }
    #

    #Care
    if ($c_ >= 18) {
        $hasil .= 'C=S;';
    } else if (18 > $c_ and $c_ >= 12) {
        $hasil .= 'C=CS;';
    } else if (12 > $c_) {
        $hasil .= 'C=BS;';
    }
    #

    #Commitment Organzation
    if ($c_o >= 24) {
        $hasil .= 'CO=S;';
    } else if (24 > $c_o and $c_o >= 16) {
        $hasil .= 'CO=CS;';
    } else if (16 > $c_o) {
        $hasil .= 'CO=BS;';
    }
    #

    #Integrity
    if ($i_ >= 24) {
        $hasil .= 'I=S;';
    } else if (24 > $i_ and $i_ >= 16) {
        $hasil .= 'I=CS;';
    } else if (16 > $i_) {
        $hasil .= 'I=BS;';
    }
    #


    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_8', 'skor_8', 'WHERE');
    $arr_data   = array($jawaban, htmlspecialchars($hasil), $kondisi);

    #echo $jawaban;

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 9');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        echo '<br><br>' . $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);

        $_SESSION['kerja_soal'] = 'soal_9';
        $_SESSION['w_selesai']  = '';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_8?status=0');
    }

    /* $modul_8     = $soal->InputJawaban($arr_kolom, $arr_data, 'modul_8');

        switch ($modul_8) {
            case 'berhasil':
                unset($_SESSION['kerja_soal']);
                $_SESSION['kerja_soal'] = 'soal_9';
                $soal->KerjaSoal($_SESSION['kerja_soal']);    
                break;
            
            default:
                header('location:../kerja_soal/kerja_modul_8?status=0');
                break;
        } */
}
# SOAL 8 ~

# ~ SOAL 9
if (isset($_POST['soal_9'])) {
    #KOLOM
    $jum_R = 0;
    $jum_I = 0;
    $jum_A = 0;
    $jum_S = 0;
    $jum_E = 0;
    $jum_C = 0;

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);
    // echo $jumlah_soal;

    if (isset($_POST['ans_soal_terakhir'])) {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    // echo $checked_jawaban_soal;
    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();

    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $incJawaban = 0;
    for ($i = 1; $i <= $jumlah_soal; $i++) {
        if (in_array($i, $soalArr)) {
            $store_jawaban[] = $i . '=' . $jawabanArr[$incJawaban];
            $incJawaban++;
        } else {
            $store_jawaban[] = $i . '= ';
        }
    }

    $soal->array_dump($store_jawaban);

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    foreach ($jawabanArr as $value) {
        switch ($value) {
            case 'A':
                $jum_A++;
                break;
            case 'B':
                $jum_B++;
                break;
            case 'C':
                $jum_C++;
                break;
            case 'D':
                $jum_D++;
                break;
            case 'E':
                $jum_E++;
                break;
            case 'F':
                $jum_F++;
                break;
            case 'G':
                $jum_G++;
                break;
            case 'H':
                $jum_H++;
                break;
            case 'I':
                $jum_I++;
                break;
            case 'K':
                $jum_K++;
                break;
            case 'L':
                $jum_L++;
                break;
            case 'N':
                $jum_N++;
                break;
            case 'O':
                $jum_O++;
                break;
            case 'P':
                $jum_P++;
                break;
            case 'R':
                $jum_R++;
                break;
            case 'S':
                $jum_S++;
                break;
            case 'T':
                $jum_T++;
                break;
            case 'V':
                $jum_V++;
                break;
            case 'W':
                $jum_W++;
                break;
            case 'X':
                $jum_X++;
                break;
            case 'Z':
                $jum_Z++;
                break;
            default:
                # code...
                break;
        }
    }

    // echo 'R:' . $jum_r . '<br>I:' . $jum_i . '<br>A:' . $jum_a . '<br>S:' . $jum_s . '<br>E:' . $jum_e . '<br>C:' . $jum_c;

    $hasil = 'R=' . $jum_R . ';I=' . $jum_I . ';A=' . $jum_A . ';S=' . $jum_S . ';E=' . $jum_E . ';C=' . $jum_C;
    // echo '<br>' . $hasil;

    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_9', 'skor_9', 'WHERE');
    $arr_data   = array($store_jawaban, htmlspecialchars($hasil), $kondisi);

    #echo $jawaban;

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        if ($_SESSION['status_test'] == 'nonmanagerial') {
            $d_hapalan      = $soal->SelectSoal2('Modul 10 SE');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

            echo '<br><br>' . $r_hapalan['durasi'];

            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);

            $_SESSION['w_selesai']  = date('H:i:s', $w_selesai);
            $_SESSION['kerja_soal'] = 'selesai';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            unset($_SESSION['w_selesai']);
            unset($_SESSION['kerja_soal']);

            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'selesai';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    } else {
        header('location:../kerja_soal/kerja_modul_9?status=0');
    }
}
# SOAL 9 ~

# ~ SOAL 10

if (isset($_POST['soal_10_se'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_se');

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
        $tmp_store[$newValue[0]] = $newValue[1];
    }
    //sorting jawaban berdasarkan key
    ksort($tmp_store);

    foreach ($tmp_store as $key => $value) {
        $store_jawaban[] = $key . '=' . $value;
    }

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    # ~ Informasi Jawaban Peserta
    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');
    $biodata_arr = $soal->array_partial_search($session_arr, 'get');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);
    foreach ($biodata_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    $soal_user = array();
    $jawaban_user = array();
    $store_jawaban = array();
    $increment = 0;
    for ($i = 1; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $jum_benar += 1;
        }
    }

    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_se', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 WA');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_wa';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_se?status=0');
    }
}

if (isset($_POST['soal_10_wa'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_wa');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);
    $soal_user = array();
    $jawaban_user = array();
    $increment = 0;
    for ($i = 21; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal - 21; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $hasil += 1;
        }
    }

    $hasil = $hasil + (int)$_SESSION['skor_10'];
    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_wa', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);


    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 AN');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_an';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_wa?status=0');
    }
}


if (isset($_POST['soal_10_an'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_an');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    # ~ Informasi Jawaban Peserta
    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);
    $soal_user = array();
    $jawaban_user = array();
    $increment = 0;
    for ($i = 41; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal - 41; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $hasil += 1;
        }
    }
    $hasil = $hasil + (int)$_SESSION['skor_10'];

    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_an', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);

    #echo $jawaban;

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 RA');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_ra';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_an?status=0');
    }
}

if (isset($_POST['soal_10_ra'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_ra');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    # ~ Informasi Jawaban Peserta
    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);
    $soal_user = array();
    $jawaban_user = array();
    $increment = 0;
    for ($i = 61; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }


    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal - 61; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $hasil += 1;
        }
    }

    $hasil = $hasil + (int)$_SESSION['skor_10'];

    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_ra', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);

    #echo $jawaban;

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 ZR');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_zr';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_ar?status=0');
    }
}

if (isset($_POST['soal_10_zr'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_zr');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    # ~ Informasi Jawaban Peserta
    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);

    $soal_user = array();
    $jawaban_user = array();
    $increment = 0;
    for ($i = 81; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal - 81; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $hasil += 1;
        }
    }
    // $soal->array_dump($store_jawaban);
    $hasil = $hasil + (int)$_SESSION['skor_10'];
    $store_jawaban =  implode(", ", $store_jawaban);

    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_zr', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);

    #echo $jawaban;

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 GE');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_ge';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_zr?status=0');
    }
}

if (isset($_POST['soal_10_ge'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul        = array();
    $arr_jawab_nilai_2      = array();
    $arr_jawab_nilai_1      = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_ge');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_nilai_2, explode(';', substr($rowKunciJawaban['nilai_2'], 0, -1)));
        array_push($arr_jawab_nilai_1, explode(';', substr($rowKunciJawaban['nilai_1'], 0, -1)));
    }

    # ~
    // print_r($arr_jawab_nilai_2);
    // print_r($arr_jawab_nilai_2);

    # ~ Informasi Jawaban Peserta
    $jumlah_soal = $_POST['jumlah_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    echo $checked_jawaban_soal;

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soal->array_dump($checked_jawaban_soal_arr);

    $soalArr = array();
    $jawabanArr = array();
    $tmp_store = array();
    $store_jawaban = array();
    foreach ($checked_jawaban_soal_arr as $value) {
        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    // $soal->array_dump($soalArr);
    // $soal->array_dump($jawabanArr);

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }
    unset($_SESSION['status_pengerjaan']);
    $soal_user = array();
    $jawaban_user = array();
    $increment = 0;
    for ($i = 1; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' . $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;

    for ($i = 0; $i <  $jumlah_soal; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and in_array(strtolower($jawaban_user[$i]), $arr_jawab_nilai_2[$i])) {
            $hasil += 2;
        } else if ($arr_nomor_modul[$i] == $soal_user[$i] and in_array(strtolower($jawaban_user[$i]), $arr_jawab_nilai_1[$i])) {
            $hasil += 1;
        } else {
            $hasil += 0;
        }
    }

    $hasil = $hasil + (int)$_SESSION['skor_10'];
    $store_jawaban =  implode(", ", $store_jawaban);

    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_ge', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);


    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 FA');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_fa';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_ge?status=0');
    }
}

if (isset($_POST['soal_10_fa'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_fa');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    # ~ Informasi Jawaban Peserta
    $jumlah_soal = $_POST['jumlah_soal'];
    $user_soal = $_POST['user_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);
    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    // echo $checked_jawaban_soal;
    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    foreach ($checked_jawaban_soal_arr as $value) {

        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    unset($_SESSION['status_pengerjaan']);

    $soal_user = array();
    $jawaban_user = array();
    $store_jawaban = array();
    $increment = 0;
    for ($i = 1; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' .  $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $hasil += 1;
        }
    }

    echo $hasil;

    $hasil = $hasil + (int)$_SESSION['skor_10'];
    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_fa', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);

    #echo $jawaban;

    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {
        $d_hapalan      = $soal->SelectSoal2('Modul 10 WU');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_wu';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_fa?status=0');
    }
}
if (isset($_POST['soal_10_wu'])) {
    # ~ Informasi Nomor dan kunci jawaban modul
    $arr_nomor_modul    = array();
    $arr_jawab_modul    = array();

    $resKunciJawaban    = $soal->KunciJawaban('modul_10_wu');

    while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
        array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
        array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
    }
    # ~

    # ~ Informasi Jawaban Peserta


    $jumlah_soal = $_POST['jumlah_soal'];
    $user_soal = $_POST['user_soal'];
    $checked_soal = $_POST['checked_soal'];
    $checked_jawaban_soal = $_POST['checked_jawaban_soal'];
    $checked_soal_arr = explode(", ", $checked_soal);

    if (isset($_POST['ans_soal_terakhir']) && $_POST['ans_soal_terakhir'] != 'undefined') {
        $tmp_store = array();
        $store_jawaaban = array();
        $checked_jawaban_soal =  $checked_jawaban_soal . ', ' . $_POST['soal_terakhir'] . '=' . $_POST['ans_soal_terakhir'];

        //ini kode untuk melakukan sorting array dan jawaban setelah ditambahkan value nmor soal dan jawaban baru
        $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

        foreach ($checked_jawaban_soal_arr as $value) {
            $newValue = explode('=', $value);
            $tmp_store[$newValue[0]] = $newValue[1];
        }
        ksort($tmp_store);

        $checked_jawaban_soal = '';
        $sstore = count($tmp_store);
        $iteration = 1;

        //ini kode untuk membuat string dengan last char tidak ada koma
        foreach ($tmp_store as $key => $value) {
            if ($iteration == $sstore) {
                $checked_jawaban_soal .= $key . '=' . $value;
            } else {
                $checked_jawaban_soal .= $key . '=' . $value . ', ';
            }
            $iteration++;
        }
    }

    $checked_jawaban_soal_arr = explode(", ", $checked_jawaban_soal);

    $soalArr = array();
    $jawabanArr = array();
    foreach ($checked_jawaban_soal_arr as $value) {

        $newValue = explode('=', $value);
        $soalArr[] = $newValue[0];
        $jawabanArr[] = $newValue[1];
    }

    $session_str = json_encode($_SESSION);

    $session_arr = explode(',', $session_str);

    $result_partial_arr = $soal->array_partial_search($session_arr, 'jawaban_soal');

    //hapus semua session soal
    foreach ($result_partial_arr as $session_data) {
        $firstlastchar = substr($session_data, 1, -1);
        $clean_session = explode('":"', $firstlastchar);

        unset($_SESSION[$clean_session[0]]);
    }

    unset($_SESSION['status_pengerjaan']);

    $soal_user = array();
    $jawaban_user = array();
    $store_jawaban = array();
    $increment = 0;
    for ($i = 21; $i <= $jumlah_soal; $i++) {
        $soal_user[] = $i;
        if (in_array($i, $soalArr)) {
            $jawaban_user[] = $jawabanArr[$increment];
            $store_jawaban[] = $i . '=' .  $jawabanArr[$increment];
            $increment++;
        } else {
            $jawaban_user[] = '';
            $store_jawaban[] = $i . '= ';
        }
    }

    $hasil = 0;
    for ($i = 0; $i < $jumlah_soal - 21; $i++) {
        if ($arr_nomor_modul[$i] == $soal_user[$i] and $arr_jawab_modul[$i] == $jawaban_user[$i]) {
            $hasil += 1;
        }
    }

    $hasil = $hasil + (int)$_SESSION['skor_10'];
    $store_jawaban =  implode(", ", $store_jawaban);
    $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

    $arr_kolom  = array('soal_10_wu', 'skor_10', 'WHERE');
    $arr_data   = array($store_jawaban, $hasil, $kondisi);


    $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

    if ($update == 'berhasil') {

        $d_hapalan      = $soal->SelectSoal2('Modul 2');
        $r_hapalan      = $d_hapalan->fetch_assoc();
        $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

        unset($_SESSION['w_selesai']);
        unset($_SESSION['kerja_soal']);
        unset($_SESSION['skor_10']);

        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'hapalan';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    } else {
        header('location:../kerja_soal/kerja_modul_10_wu?status=0');
    }
}

    # SOAL 10 ~
