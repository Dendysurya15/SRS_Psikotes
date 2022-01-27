<?php
include '../../kumpulan_function.php';
$soal = new Soal();
if (isset($_POST['add_soal'])) {
    $soal_id        = $_POST['add_soal_id'];
    $nomor_soal     = $_POST['add_nomor_soal'];
    $link_gambar    = $_FILES['add_gambar_soal'];
    $kunci_jawaban  = $_POST['add_kunci_jawaban'];
    $pindah_halaman = '../soal/modul_10_wu';
    $tempat_upload  = '../gambar_soal/';


    $soal->TambahSoalModul1($soal_id, 'modul_10_wu', $nomor_soal, $link_gambar, $kunci_jawaban, $tempat_upload, $pindah_halaman);
}

if (isset($_POST['update_soal'])) {
    $id             = $_POST['update_id'];
    $soal_id        = $_POST['update_soal_id'];
    $nomor_soal     = $_POST['update_nomor_soal'];
    $gambar_lama    = $_POST['update_gambar_soal_lama'];
    $gambar_baru    = $_FILES['update_gambar_soal_baru'];
    $kunci_jawaban  = '';
    if (isset($_POST['update_kunci_jawaban'])) {
        $kunci_jawaban  = $_POST['update_kunci_jawaban'];
    } else {
        $kunci_jawaban  = '';
    }
    $tempat_upload  = '../gambar_soal/';
    $pindah_halaman = '../soal/modul_10_wu';


    echo $gambar_lama;
    $soal->UpdateSoalModul1($id, 'modul_10_wu', $soal_id,  $nomor_soal, $gambar_lama, $gambar_baru, $kunci_jawaban, $tempat_upload, $pindah_halaman);
}

if (isset($_POST['update_modul'])) {
    #update Data Modul
    $pindah_html = '../soal/modul_1';
    $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
    $array_data     = array($_POST['update_deskripsi_soal'], $_POST['update_durasi_soal'], $_POST['update_id']);
    $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 6, 7);
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
