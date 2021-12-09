<?php
    include '../../kumpulan_function.php';
    $soal = new Soal();
    if(isset($_POST['add_soal']))
    {
        $cekNomorSoal = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_7');
        $pindah_html    = '../soal/modul_7';
        switch ($cekNomorSoal) {
            case 'TIDAK ADA':            
            $pernyataan_1   = str_replace('"', "'", $_POST['add_teks_1']);
            $pernyataan_2   = str_replace('"', "'", $_POST['add_teks_2']);   
            $pernyataan     = $pernyataan_1.';'.$pernyataan_2;
            $kategori       = $_POST['add_kategori_1'].';'.$_POST['add_kategori_2'];
            $array_kolom    = array('soal_id', 'nomor_soal', 'pernyataan', 'kategori');
            $array_data     = array($_POST['add_nomor'], $pernyataan, $kategori);
            $soal->TambahSoalModul($_POST['add_soal_id'], 'modul_7', $array_kolom, $array_data, $pindah_html, 0, 1);
            break;
            
            default:
                header('location:'.$pindah_html.'?soal_id='.$_POST['add_soal_id'].'&status=4');
                break;
        }
    }
    if(isset($_POST['update_soal']))
    {
        $pernyataan_1   = str_replace('"', "'", $_POST['update_teks_1']);
        $pernyataan_2   = str_replace('"', "'", $_POST['update_teks_2']);
        $pernyataan     = $pernyataan_1.';'.$pernyataan_2;
        $kategori       = $_POST['update_kategori_1'].';'.$_POST['update_kategori_2'];
        $array_kolom    = array('pernyataan', 'kategori', 'id');
        $array_data     = array(htmlspecialchars($pernyataan), $kategori, $_POST['update_id']);
        $pindah_html    = '../soal/modul_7';
        $soal->UpdateSoalModul($_POST['update_soal_id'], 'modul_7', $array_kolom, $array_data, $pindah_html, 2,3);
    }

    if(isset($_POST['update_modul']))
    {
        #update Data Modul
        $pindah_html = '../soal/modul_7';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }

    if(isset($_POST['delete_soal']))
    {        
        $pindah_html = '../soal/modul_7';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_7', $pindah_html, 13, 14);
    }
?>