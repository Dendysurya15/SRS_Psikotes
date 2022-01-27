<?php
include '../../kumpulan_function.php';
$soal = new Soal();

if (isset($_POST['add_soal'])) {
    $cek_nomor_soal = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_8');
    $pindah_html    = '../soal/modul_8';
    switch ($cek_nomor_soal) {
        case 'TIDAK ADA':
            $array_kolom    = array('soal_id', 'nomor_soal', 'pernyataan', 'kategori');
            $array_data     = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks']), $_POST['add_kategori']);
            $soal->TambahSoalModul($_POST['add_soal_id'], 'modul_8', $array_kolom, $array_data, $pindah_html, 1, 2);
            break;

        default:
            header('location:' . $pindah_html . '?soal_id=' . $_POST['add_soal_id'] . '&status=0');
            break;
    }
}
if (isset($_POST['update_soal'])) {
    $array_kolom    = array('pernyataan', 'id');
    $array_data     = array(htmlspecialchars($_POST['update_teks']), $_POST['update_id']);
    $pindah_html    = '../soal/modul_8';
    $soal->UpdateSoalModul($_POST['update_soal_id'], 'modul_8', $array_kolom, $array_data, $pindah_html, 3, 4);
}

if (isset($_POST['update_modul'])) {
    #update Data Modul
    $pindah_html = '../soal/modul_8';
    $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
    $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
    $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
}

if (isset($_POST['delete_soal'])) {
    $pindah_html = '../soal/modul_8';
    $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'], 'modul_8', $pindah_html, 13, 14);
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
