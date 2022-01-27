<?php
include '../../kumpulan_function.php';
$soal = new Soal();

if (isset($_POST['add_soal'])) {
    $pindah_html    = '../soal/modul_10_an';



    $cekNomorSoal   = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_10_an');
    switch ($cekNomorSoal) {
        case 'TIDAK ADA':
            $nama_modul = 'modul_10_an';
            $pilihan    = '';

            if (empty($_POST['pilihan_a_' . $_POST['add_nomor'] . '']) || empty($_POST['pilihan_b_' . $_POST['add_nomor'] . '']) || empty($_POST['pilihan_c_' . $_POST['add_nomor'] . '']) || empty($_POST['pilihan_d_' . $_POST['add_nomor'] . '']) || empty($_POST['pilihan_e_' . $_POST['add_nomor'] . ''])) {
                header('location:../soal/modul_10_an?soal_id=' . $_POST['add_soal_id'] . '&status=20');
            } else {
                $pilihan .= $_POST['pilihan_a_' . $_POST['add_nomor'] . ''] . ';' .
                    $_POST['pilihan_b_' . $_POST['add_nomor'] . ''] . ';' .
                    $_POST['pilihan_c_' . $_POST['add_nomor'] . ''] . ';' .
                    $_POST['pilihan_d_' . $_POST['add_nomor'] . ''] . ';' .
                    $_POST['pilihan_e_' . $_POST['add_nomor'] . ''] . ';';
            }


            $array_kolom  = array('soal_id', 'nomor_soal', 'teks_soal', 'pilihan', 'kunci_jawaban');
            $array_data   = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks_soal']), $pilihan, $_POST['add_kunci_jawaban']);
            $soal->TambahSoalModul($_POST['add_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 7, 8);

            break;

        default:
            header('location:' . $pindah_html . '?soal_id=' . $_POST['add_soal_id'] . '&status=6');
            break;
    }
}

if (isset($_POST['update_soal'])) {
    $pindah_html    = '../soal/modul_10_an';

    $nomor_soal     = $_POST['up_nomor_soal'];

    $id_soal        = $_POST['up_id'];

    $teks_soal      = htmlspecialchars($_POST['up_teks_soal']);

    $pilihan_a      = $_POST['up_pilihan_a_' . $nomor_soal . ''];
    $pilihan_b      = $_POST['up_pilihan_b_' . $nomor_soal . ''];
    $pilihan_c      = $_POST['up_pilihan_c_' . $nomor_soal . ''];
    $pilihan_d      = $_POST['up_pilihan_d_' . $nomor_soal . ''];
    $pilihan_e      = $_POST['up_pilihan_e_' . $nomor_soal . ''];

    $pilihan        = $pilihan_a . ';' . $pilihan_b . ';' . $pilihan_c . ';' . $pilihan_d . ';' . $pilihan_e . ';';


    $arr_kolom      = '';
    $arr_data       = '';

    if (isset($_POST['up_kunci_jawaban'])) {
        $kunci_jawaban  = $_POST['up_kunci_jawaban'];

        $arr_kolom      = array('teks_soal', 'pilihan', 'kunci_jawaban', 'id');
        $arr_data       = array($teks_soal, $pilihan, $kunci_jawaban, $id_soal);
    } else {
        $arr_kolom      = array('teks_soal', 'pilihan', 'id');
        $arr_data       = array($teks_soal, $pilihan, $id_soal);
    }

    $soal->UpdateSoalModul($_POST['up_soal_id'], 'modul_10_an', $arr_kolom, $arr_data, $pindah_html, 9, 10);
}

if (isset($_POST['update_modul'])) {
    $pindah_html = '../soal/modul_10_an';
    $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
    $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
    $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
}

if (isset($_POST['delete_soal'])) {
    $pindah_html = '../soal/modul_10_an';
    $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'], 'modul_10_an', $pindah_html, 13, 14);
}

if (isset($_POST['tambah_instruksi']) || isset($_POST['hapus_instruksi'])) {
    $soal_id        = $_POST['soal_id'];
    $instruksi_file   = $_FILES['instruksi_suara'];
    $path     = '../instruksi_soal/';
    $status = isset($_POST['tambah_instruksi']) ? 'tambah' : 'hapus';
    $pindah_html    = '../soal/modul_1';
    $instruksi_lama = null;
    if ($_POST['instruksi_lama']) {
        $instruksi_lama = $_POST['instruksi_lama'];
    }

    $soal->instruksiSoal($soal_id, $instruksi_lama, $instruksi_file, $path, $pindah_html, $status);
}
