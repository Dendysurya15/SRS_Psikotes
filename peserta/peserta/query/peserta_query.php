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

            $arr_kolom  = array('room_id', 'peserta_id');
            $arr_data   = array($_SESSION['i_room'], $_SESSION['i_peserta']);

            $arr_detail_jawaban     = $soal->JawabanSel($_SESSION['i_room'], $_SESSION['i_peserta']);
            if ($arr_detail_jawaban->num_rows > 0) {
                $row_detail_jawaban     = $arr_detail_jawaban->fetch_assoc();
                $_SESSION['i_jawaban']  = $row_detail_jawaban['id'];

                $row_update       = array('status_login', 'username_peserta');
                $col_update       = array(1, $rowPeserta['username_peserta']);
                $updPeserta       = $soal->Peserta($row_update, $col_update, 'update');

                switch ($updPeserta) {
                    case 'berhasil':
                        if ($_SESSION['status_test'] == 'managerial') {
                            $_SESSION['w_selesai']  = '';
                            $_SESSION['kerja_soal'] = 'soal_10_se';
                            $soal->KerjaSoal($_SESSION['kerja_soal']);
                        } else {
                            $_SESSION['w_selesai']  = '';
                            $_SESSION['kerja_soal'] = 'soal_1';
                            $soal->KerjaSoal($_SESSION['kerja_soal']);
                        }
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
                        $col_update       = array(1, $rowPeserta['username_peserta']);
                        $updPeserta       = $soal->Peserta($row_update, $col_update, 'update');
                        switch ($updPeserta) {
                            case 'berhasil':
                                if ($_SESSION['status_test'] == 'managerial') {

                                    $_SESSION['w_selesai']  = '';

                                    $_SESSION['kerja_soal'] = 'soal_10_se';
                                    $soal->KerjaSoal($_SESSION['kerja_soal']);
                                } else {
                                    $resSoal1         = $soal->SelectSoal2('Modul 1');
                                    $rowSoal1         = $resSoal1->fetch_assoc();

                                    $w_selesai              = strtotime($n_jam) + $rowSoal1['durasi'];
                                    $_SESSION['w_selesai']  = '';


                                    $_SESSION['kerja_soal'] = 'soal_1';
                                    $soal->KerjaSoal($_SESSION['kerja_soal']);
                                }
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

if (isset($_POST['soal_1'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_1'])) {

        $jawaban    = '';

        $nomor_soal = $_POST['nomor_soal'];

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
        $arr_nomor_user     = array();
        $arr_jawab_user     = array();

        for ($i = 0; $i < count($_POST['nomor_soal']); $i++) {
            if (isset($_POST['jawaban_' . $nomor_soal[$i] . ''])) {
                $jawaban    .= $nomor_soal[$i] . '=' . $_POST['jawaban_' . $nomor_soal[$i] . ''] . ';';
                array_push($arr_nomor_user, $nomor_soal[$i]);
                array_push($arr_jawab_user, $_POST['jawaban_' . $nomor_soal[$i] . '']);
            } else {
                $jawaban    .= $nomor_soal[$i] . '= ;';
                array_push($arr_nomor_user, $nomor_soal[$i]);
                array_push($arr_jawab_user, '');
            }
        }

        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_user[$i] and $arr_jawab_modul[$i] == $arr_jawab_user[$i]) {
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

        $jawaban = substr($jawaban, 0, -1);
        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_1', 'skor_1', 'WHERE');
        $arr_data   = array($jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
            $rdetJawaban    = $detJawaban->fetch_assoc();

            if ($_SESSION['status_test'] == 'managerial') {
                $_SESSION['w_selesai']  = '';
                $_SESSION['kerja_soal'] = 'soal_3';
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
            $_SESSION['kerja_soal'] = 'hapalan';
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
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_3';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}


# ~ SOAL 2
if (isset($_POST['soal_2'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

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
        $jawaban    = '';

        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();

        $nomor_soal = $_POST['nomor_soal'];

        for ($i = 0; $i < count($_POST['nomor_soal']); $i++) {
            if (isset($_POST['jawaban_' . $nomor_soal[$i] . ''])) {
                $jawaban    .= $nomor_soal[$i] . '=' . $_POST['jawaban_' . $nomor_soal[$i] . ''] . ';';
                array_push($arr_nomor_peserta, $nomor_soal[$i]);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $nomor_soal[$i] . '']);
            } else {
                $jawaban    .= $nomor_soal[$i] . '=' . ';';
                array_push($arr_nomor_peserta, $nomor_soal[$i]);
                array_push($arr_jawab_peserta, '');
            }
        }
        $jawaban        = substr($jawaban, 0, -1);
        # ~

        # ~ Cek Jawaban Benar 
        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }

        # ~ 
        $nilai = 'B :' . $hasil;

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_2', 'skor_2', 'WHERE');
        $arr_data   = array($jawaban, $nilai, $kondisi);

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
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();

        $nomor_soal = $_POST['nomor_soal'];

        for ($i = 0; $i < count($_POST['nomor_soal']); $i++) {
            if (isset($_POST['jawaban_' . $nomor_soal[$i] . ''])) {
                $jawaban    .= $nomor_soal[$i] . '=' . $_POST['jawaban_' . $nomor_soal[$i] . ''] . ';';
                array_push($arr_nomor_peserta, $nomor_soal[$i]);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $nomor_soal[$i] . '']);
            } else {
                $jawaban    .= $nomor_soal[$i] . '=' . ';';
                array_push($arr_nomor_peserta, $nomor_soal[$i]);
                array_push($arr_jawab_peserta, '');
            }
        }
        $jawaban        = substr($jawaban, 0, -1);
        # ~ 

        # ~ Cek Jawaban Benar 
        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        # ~ 

        $nilai = '';
        if ($hasil >= 78) {
            $nilai = 'SB | B:' . $hasil;
        } elseif (77 >= $hasil and $hasil >= 65) {
            $nilai = 'B | B:' . $hasil;
        } elseif (64 >= $hasil and $hasil >= 52) {
            $nilai = 'C+ | B:' . $hasil;
        } elseif (51 >= $hasil and $hasil >= 39) {
            $nilai = 'C | B:' . $hasil;
        } elseif (38 >= $hasil and $hasil >= 25) {
            $nilai = 'C- | B:' . $hasil;
        } elseif (24 >= $hasil and $hasil >= 12) {
            $nilai = 'K | B:' . $hasil;
        } elseif (11 >= $hasil and $hasil >= 0) {
            $nilai = 'SK | B:' . $hasil;
        }

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_3', 'skor_3', 'WHERE');
        $arr_data   = array($jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {

            $_SESSION['kerja_soal'] = 'soal_4';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_3?status=0');
        }
    } else {
        $_SESSION['kerja_soal'] = 'soal_4';
        $_SESSION['w_selesai']  = '';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
# SOAL 3 ~

# ~ SOAL 4
if (isset($_POST['soal_4'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

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
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();


        $nomor_soal = $_POST['nomor_soal'];

        for ($i = 0; $i < count($_POST['nomor_soal']); $i++) {
            if (isset($_POST['jawaban_' . $nomor_soal[$i] . ''])) {
                $str_jawaban = str_replace('.', ',', $_POST['jawaban_' . $nomor_soal[$i] . '']);
                $jawaban    .= $nomor_soal[$i] . '=' . $str_jawaban . ';';
                array_push($arr_nomor_peserta, $nomor_soal[$i]);
                array_push($arr_jawab_peserta, $str_jawaban);
                //echo $str_jawaban.'<br>';
            } else {
                $jawaban    .= $nomor_soal[$i] . '=' . ';';
                array_push($arr_nomor_peserta, $nomor_soal[$i]);
                array_push($arr_jawab_peserta, '');
            }
        }
        $jawaban        = substr($jawaban, 0, -1);

        # ~ Cek Jawaban Benar 
        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        # ~ 


        $nilai = 'B :' . $hasil;

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_4', 'skor_4', 'WHERE');
        $arr_data   = array($jawaban, $nilai, $kondisi);

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $_SESSION['kerja_soal'] = 'soal_5';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_4?status=0');
        }
    } else {
        $_SESSION['kerja_soal'] = 'soal_5';
        $_SESSION['w_selesai']  = '';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
# SOAL 4 ~

# ~ SOAL 10

# SOAL 10 ~

# ~ SOAL 5
if (isset($_POST['soal_5'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_5'])) {
        $jawaban        = '';
        $nomor_soal     = $_POST['nomor_soal'];

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


        for ($i = 0; $i < count($nomor_soal); $i++) {
            if (isset($_POST['kategori_setuju_' . $nomor_soal[$i] . ''])) {
                $jawaban    .= $nomor_soal[$i] . '=' . $_POST['kategori_setuju_' . $nomor_soal[$i] . ''] . ',';
                switch ($_POST['kategori_setuju_' . $nomor_soal[$i] . '']) {
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
            } else {
                $jawaban     .= $nomor_soal[$i] . '=,';
                $kat_set_nl  += 1;
            }


            if (isset($_POST['kategori_tidak_setuju_' . $nomor_soal[$i] . ''])) {
                $jawaban .= $_POST['kategori_tidak_setuju_' . $nomor_soal[$i] . ''] . ';';

                switch ($_POST['kategori_tidak_setuju_' . $nomor_soal[$i] . '']) {
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
            } else {
                $jawaban .= ';';
                $kat_tdk_nl += 1;
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

        $arr_kolom  = array('soal_5', 'skor_5', 'WHERE');
        $arr_data   = array($jawaban, htmlspecialchars($hasil), $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {

            $_SESSION['kerja_soal'] = 'soal_6';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_5?status=0');
        }
    } else {
        $_SESSION['kerja_soal'] = 'soal_6';
        $_SESSION['w_selesai']  = '';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }


    #echo $soal->InputJawaban($arr_kolom, $arr_data, 'modul_5');


}
# SOAL 5 ~

# ~ SOAL 6 - SOAL 7
# ~ SOAL 6
if (isset($_POST['soal_6'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_6'])) {
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


        #data
        $soal_id    = $_POST['soal_id'];
        $id_user    = $_POST['id_user'];
        $jawaban   = '';

        $nomor_soal = $_POST['nomor_soal'];

        for ($i = 0; $i < count($nomor_soal); $i++) {
            if (isset($_POST['kategori_' . $nomor_soal[$i] . ''])) {
                $jawaban   .= $nomor_soal[$i] . '=' . $_POST['kategori_' . $nomor_soal[$i] . ''] . ';';
                switch ($_POST['kategori_' . $nomor_soal[$i] . '']) {
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
            } else {
                $jawaban   .= $nomor_soal[$i] . '=;';
                $jum_nl += 1;
            }
        }
        $jawaban = substr($jawaban, 0, -1);

        echo $jawaban . '<br>';

        $hasil  = 'A=' . $jum_A . ';B=' . $jum_B . ';C=' . $jum_C . ';D=' . $jum_D . ';E=' . $jum_E . ';F='
            . $jum_F . ';G=' . $jum_G . ';H=' . $jum_H . ';I=' . $jum_I . ';K=' . $jum_K . ';L='
            . $jum_L . ';N=' . $jum_N . ';O=' . $jum_O . ';P=' . $jum_P . ';R=' . $jum_R . ';S='
            . $jum_S . ';T=' . $jum_T . ';V=' . $jum_V . ';W=' . $jum_W . ';X=' . $jum_X . ';Z='
            . $jum_Z . ';Null=' . $jum_nl;
        echo $hasil . '<br>';
        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_6', 'skor_6', 'WHERE');
        $arr_data   = array($jawaban, htmlspecialchars($hasil), $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            if ($_SESSION['status_test'] == 'nonmanagerial') {

                $_SESSION['kerja_soal'] = 'soal_8';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else {

                $_SESSION['kerja_soal'] = 'soal_7';
                $_SESSION['w_selesai']  = '';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            }
        } else {
            header('location:../kerja_soal/kerja_modul_6?status=0');
        }
    } else {
        if ($_SESSION['status_test'] == 'nonmanagerial') {

            $_SESSION['kerja_soal'] = 'soal_8';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {

            $_SESSION['kerja_soal'] = 'soal_7';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        }
    }
}

# ~ SOAL 7
if (isset($_POST['soal_7'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_7'])) { #KOLOM
        $nomor_soal     = $_POST['nomor_soal'];
        $arr_jawaban    = array();

        $jum_           = 0;
        $jawaban        = array();


        $ins_jawaban    = '';

        for ($i = 0; $i < count($nomor_soal); $i++) {
            if ($jum_ < 7) {
                if (isset($_POST['kategori_' . $nomor_soal[$i] . ''])) {

                    array_push($jawaban, $_POST['kategori_' . $nomor_soal[$i] . '']);
                    $jum_ += 1;

                    $ins_jawaban .= $nomor_soal[$i] . '=' . $_POST['kategori_' . $nomor_soal[$i] . ''] . ';';
                } else {
                    array_push($jawaban, '');
                    $jum_ += 1;

                    $ins_jawaban .= $nomor_soal[$i] . '=;';
                }
            } else {
                if (isset($_POST['kategori_' . $nomor_soal[$i] . ''])) {


                    array_push($jawaban, $_POST['kategori_' . $nomor_soal[$i] . '']);

                    array_push($arr_jawaban, $jawaban);

                    $jawaban = array();
                    $jum_ = 0;

                    $ins_jawaban .= $nomor_soal[$i] . '=' . $_POST['kategori_' . $nomor_soal[$i] . ''] . ';';
                } else {
                    echo '<br>';

                    array_push($jawaban, '');

                    array_push($arr_jawaban, $jawaban);

                    $jawaban = array();
                    $jum_ = 0;

                    $ins_jawaban .= $nomor_soal[$i] . '=;';
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

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $_SESSION['kerja_soal'] = 'soal_8';
            $_SESSION['w_selesai']  = date('H:i:s', $w_selesai);
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_7?status=0');
        }
    } else {
        $_SESSION['kerja_soal'] = 'soal_8';
        $_SESSION['w_selesai']  = date('H:i:s', $w_selesai);
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
# SOAL 6 -7 ~

# ~ SOAL 8
if (isset($_POST['soal_8'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_8'])) { #Jawaban User
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
            $_SESSION['kerja_soal'] = 'soal_9';
            $_SESSION['w_selesai']  = '';
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_8?status=0');
        }
    } else {
        $_SESSION['kerja_soal'] = 'soal_9';
        $_SESSION['w_selesai']  = '';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
# SOAL 8 ~

# ~ SOAL 9
if (isset($_POST['soal_9'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_9'])) {
        #KOLOM
        $jawaban = '';
        $nomor_soal = $_POST['nomor_soal'];

        $jum_r = 0;
        $jum_i = 0;
        $jum_a = 0;
        $jum_s = 0;
        $jum_e = 0;
        $jum_c = 0;

        for ($i = 0; $i < count($nomor_soal); $i++) {
            if (isset($_POST['kategori_' . $nomor_soal[$i] . ''])) {
                $jawaban        .= $nomor_soal[$i] . '=' . $_POST['kategori_' . $nomor_soal[$i] . ''] . ';';

                switch ($_POST['kategori_' . $nomor_soal[$i] . '']) {
                    case 'R':
                        $jum_r += 1;
                        break;
                    case 'I':
                        $jum_i += 1;
                        break;
                    case 'A':
                        $jum_a += 1;
                        break;
                    case 'S':
                        $jum_s += 1;
                        break;
                    case 'E':
                        $jum_e += 1;
                        break;
                    case 'C':
                        $jum_c += 1;
                        break;
                    default:
                        # code...
                        break;
                }
            } else {
                $jawaban       .= $nomor_soal[$i] . '=;';
            }
        }
        echo $jawaban . '<br>';
        echo 'R:' . $jum_r . '<br>I:' . $jum_i . '<br>A:' . $jum_a . '<br>S:' . $jum_s . '<br>E:' . $jum_e . '<br>C:' . $jum_c;

        $hasil = 'R=' . $jum_r . ';I=' . $jum_i . ';A=' . $jum_a . ';S=' . $jum_s . ';E=' . $jum_e . ';C=' . $jum_c;
        echo '<br>' . $hasil;

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_9', 'skor_9', 'WHERE');
        $arr_data   = array($jawaban, htmlspecialchars($hasil), $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            if ($_SESSION['status_test'] == 'nonmanagerial') {
                $_SESSION['kerja_soal'] = 'selesai';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            } else {
                $_SESSION['w_selesai']  = '';
                $_SESSION['kerja_soal'] = 'selesai';
                $soal->KerjaSoal($_SESSION['kerja_soal']);
            }
        } else {
            header('location:../kerja_soal/kerja_modul_9?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'selesai';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
# SOAL 9 ~

# ~ SOAL 10

if (isset($_POST['soal_10_se'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_se'])) {
        # ~ Informasi Nomor dan kunci jawaban modul
        $arr_nomor_modul    = array();
        $arr_jawab_modul    = array();

        $resKunciJawaban    = $soal->KunciJawaban('modul_10_se');

        while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
            array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
            array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
        }
        # ~

        # ~ Informasi Jawaban Peserta
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_se', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_10_wa';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_se?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_wa';
        $_SESSION['skor_10']    = $hasil;
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

if (isset($_POST['soal_10_wa'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_wa'])) {
        # ~ Informasi Nomor dan kunci jawaban modul
        $arr_nomor_modul    = array();
        $arr_jawab_modul    = array();

        $resKunciJawaban    = $soal->KunciJawaban('modul_10_wa');

        while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
            array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
            array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
        }
        # ~

        # ~ Informasi Jawaban Peserta
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_wa', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

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
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_an';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}


if (isset($_POST['soal_10_an'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_an'])) {
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
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_an', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $d_hapalan      = $soal->SelectSoal2('Modul 10 RA');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];

            unset($_SESSION['skor_10']);

            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_10_ra';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_an?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_ra';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

if (isset($_POST['soal_10_ra'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_ra'])) { # ~ Informasi Nomor dan kunci jawaban modul
        $arr_nomor_modul    = array();
        $arr_jawab_modul    = array();

        $resKunciJawaban    = $soal->KunciJawaban('modul_10_ra');

        while ($rowKunciJawaban = $resKunciJawaban->fetch_assoc()) {
            array_push($arr_nomor_modul, $rowKunciJawaban['nomor_soal']);
            array_push($arr_jawab_modul, $rowKunciJawaban['kunci_jawaban']);
        }
        # ~

        # ~ Informasi Jawaban Peserta
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_ra', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            $d_hapalan      = $soal->SelectSoal2('Modul 10 ZR');
            $r_hapalan      = $d_hapalan->fetch_assoc();
            $w_selesai      = strtotime($n_jam) + $r_hapalan['durasi'];
            unset($_SESSION['skor_10']);

            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_10_zr';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_ar?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_zr';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

if (isset($_POST['soal_10_zr'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_zr'])) {
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
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_zr', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {

            unset($_SESSION['skor_10']);

            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_10_ge';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_zr?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_ge';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

if (isset($_POST['soal_10_ge'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_ge'])) { # ~ Informasi Nomor dan kunci jawaban modul
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
        print_r($arr_jawab_nilai_2);
        print_r($arr_jawab_nilai_2);
        echo '<br>';

        # ~ Informasi Jawaban Peserta
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        print_r($arr_jawab_peserta);

        echo '<br>';

        $hasil = 0;

        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and in_array(strtolower($arr_jawab_peserta[$i]), $arr_jawab_nilai_2[$i])) {
                $hasil += 2;
            } else if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and in_array(strtolower($arr_jawab_peserta[$i]), $arr_jawab_nilai_1[$i])) {
                $hasil += 1;
            } else {
                $hasil += 0;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_ge', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            unset($_SESSION['skor_10']);
            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_10_fa';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_ge?status=0');
        }
    } else {
        unset($_SESSION['skor_10']);
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_fa';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

if (isset($_POST['soal_10_fa'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_fa'])) {
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
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_fa', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            unset($_SESSION['skor_10']);

            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'soal_10_wu';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_fa?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'soal_10_wu';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}
if (isset($_POST['soal_10_wu'])) {
    $detJawaban     = $soal->JawabanDetail($_SESSION['i_jawaban'], $_SESSION['i_room'], $_SESSION['i_peserta']);
    $rDetJawaban    = $detJawaban->fetch_assoc();

    unset($_SESSION['w_selesai']);
    unset($_SESSION['kerja_soal']);

    if (empty($rDetJawaban['soal_10_wu'])) {
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
        $jawaban    = '';
        $arr_nomor_peserta  = array();
        $arr_jawab_peserta  = array();
        $nomor_soal         = $_POST['nomor_soal'];

        foreach ($nomor_soal as $value) {
            if (isset($_POST['jawaban_' . $value . ''])) {
                $jawaban .= $value . '=' . $_POST['jawaban_' . $value . ''] . ';';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, $_POST['jawaban_' . $value . '']);
            } else {
                $jawaban .= $value . '=;';
                array_push($arr_nomor_peserta, $value);
                array_push($arr_jawab_peserta, '');
            }
        }

        $hasil = 0;
        for ($i = 0; $i < count($arr_nomor_modul); $i++) {
            if ($arr_nomor_modul[$i] == $arr_nomor_peserta[$i] and $arr_jawab_modul[$i] == $arr_jawab_peserta[$i]) {
                $hasil += 1;
            }
        }
        $hasil = $hasil + (int)$_SESSION['skor_10'];

        $kondisi = 'room_id = "' . $_SESSION['i_room'] . '" AND peserta_id = "' . $_SESSION['i_peserta'] . '"';

        $arr_kolom  = array('soal_10_wu', 'skor_10', 'WHERE');
        $arr_data   = array($jawaban, $hasil, $kondisi);

        #echo $jawaban;

        $update     = $soal->InputJawaban($arr_kolom, $arr_data, 'update');

        if ($update == 'berhasil') {
            unset($_SESSION['skor_10']);

            $_SESSION['w_selesai']  = '';
            $_SESSION['kerja_soal'] = 'hapalan';
            $_SESSION['skor_10']    = $hasil;
            $soal->KerjaSoal($_SESSION['kerja_soal']);
        } else {
            header('location:../kerja_soal/kerja_modul_10_wu?status=0');
        }
    } else {
        $_SESSION['w_selesai']  = '';
        $_SESSION['kerja_soal'] = 'hapalan';
        $soal->KerjaSoal($_SESSION['kerja_soal']);
    }
}

    # SOAL 10 ~
