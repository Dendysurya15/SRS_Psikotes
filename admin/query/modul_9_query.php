<?php
    include '../../kumpulan_function.php';
    $soal = new Soal();
    if(isset($_POST['add_soal']))
    {
        $cekNomorSoal = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_9');
        $pindah_html    = '../soal/modul_9';
        switch ($cekNomorSoal) {
            case 'TIDAK ADA':                
            $array_kolom    = array('soal_id', 'nomor_soal', 'pernyataan', 'kategori');
            $array_data     = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks']), $_POST['add_kategori']);
            $soal->TambahSoalModul($_POST['add_soal_id'], 'modul_9', $array_kolom, $array_data, $pindah_html, 0, 1);
            break;
            
            default:
                header('location:'.$pindah_html.'?soal_id='.$_POST['add_soal_id'].'&status=4');
                break;
        }
    }
    if(isset($_POST['update_soal']))
    {
        $array_kolom    = array('pernyataan', 'kategori', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_teks']), $_POST['update_kategori'], $_POST['update_id']);
        $pindah_html    = '../soal/modul_9';
        $soal->UpdateSoalModul($_POST['update_soal_id'], 'modul_9', $array_kolom, $array_data, $pindah_html, 2,3);
    }

    if(isset($_POST['update_modul']))
    {
        #update Data Modul
        $pindah_html = '../soal/modul_9';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }


    if(isset($_POST['delete_soal']))
    {        
        $pindah_html = '../soal/modul_9';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_9', $pindah_html, 13, 14);
    }
?>