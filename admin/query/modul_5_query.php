<?php
    include '../../kumpulan_function.php';
    $soal = new Soal();
    if(isset($_POST['add_soal']))
    {
        $setuju         = $_POST['add_setuju_1'].';'.$_POST['add_setuju_2'].';'.$_POST['add_setuju_3'].';'.$_POST['add_setuju_4'];
        $teks_soal      = $_POST['add_teks_1'].';'.$_POST['add_teks_2'].';'.$_POST['add_teks_3'].';'.$_POST['add_teks_4'];
        $tak_setuju     = $_POST['add_tak_setuju_1'].';'.$_POST['add_tak_setuju_2'].';'.$_POST['add_tak_setuju_3'].';'.$_POST['add_tak_setuju_4'];
        $pindah_html    = '../soal/modul_5';

        
        $nama_modul     = 'modul_5';
        $array_kolom    = array('soal_id', 'nomor_soal', 'kategori_setuju', 'pernyataan', 'kategori_tidak_setuju');
        $array_data     = array($_POST['add_nomor'], $setuju, $teks_soal, $tak_setuju);
        $soal->TambahSoalModul($_POST['add_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 0, 2);
        
    }

    if(isset($_POST['update_soal']))
    {
        $setuju    = $_POST['update_setuju_1'].';'.$_POST['update_setuju_2'].';'.$_POST['update_setuju_3'].';'.$_POST['update_setuju_4'];

        $teks_soal = $_POST['update_teks_1'].';'.$_POST['update_teks_2'].';'.$_POST['update_teks_3'].';'.$_POST['update_teks_4'];
        
        $tidak_setuju = $_POST['update_tak_setuju_1'].';'.$_POST['update_tak_setuju_2'].';'.$_POST['update_tak_setuju_3'].';'.$_POST['update_tak_setuju_4'];

        $pindah_html    = '../soal/modul_5';
        
        $array_kolom    = array('kategori_setuju', 'pernyataan', 'kategori_tidak_setuju', 'id');
        $array_data     = array($setuju, $teks_soal, $tidak_setuju, $_POST['update_id']);
        $nama_modul     = 'modul_5';
        $soal->UpdateSoalModul($_POST['update_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 3, 4);
    }

    if(isset($_POST['update_modul']))
    {
        #update Data Modul
        $pindah_html = '../soal/modul_5';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }

    if(isset($_POST['delete_soal']))
    {        
        $pindah_html = '../soal/modul_5';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_5', $pindah_html, 13, 14);
    }
?>