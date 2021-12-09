<?php
    include '../../kumpulan_function.php';
    #--Tambah Soal Modul 3
    $soal = new Soal();
    if(isset($_POST['add_soal']))
    {
        if(isset($_POST['add_nomor']))
        {            
            $kunci_jawaban  = $_POST['add_kunci_jawaban'];
            $pindah_html    = '../soal/modul_3';
            $cek_nomor_soal = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_3');
            switch ($cek_nomor_soal) {
                case 'TIDAK ADA':                
                    $arr_kolom      = array('soal_id', 'nomor_soal, pernyataan_1, pernyataan_2', 'kunci_jawaban');            
                    $arr_data       = array($_POST['add_nomor'], htmlspecialchars($_POST['add_pernyataan_1']), htmlspecialchars($_POST['add_pernyataan_2']), $_POST['add_kunci_jawaban']);
                    $soal->TambahSoalModul($_POST['add_soal_id'], 'modul_3', $arr_kolom, $arr_data, $pindah_html, 0, 1);
                    break;
                
                default:
                    header('location:'.$pindah_html.'?soal_id='.$soal_id.'&status=3');
                    break;
            }
            //TambahSoalModul3($soal_id, $nomor_soal, $pernyataan_1, $pernyataan_2, $kunci_jawaban, $pindah_html)  
        }
    }
    #Tambah Soal Modul 3--

    if(isset($_POST['update_soal']))
    {
        $soal_id        = $_POST['update_soal_id'];
        $pindah_html    = '../soal/modul_3';


        $array_kolom    = array('pernyataan_1', 'pernyataan_2', 'kunci_jawaban', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_pernyataan_1']), htmlspecialchars($_POST['update_pernyataan_2']), $_POST['update_kunci_jawaban'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_soal_id'], 'modul_3', $array_kolom, $array_data, $pindah_html, 4, 5);
    }

    if(isset($_POST['update_modul']))
    {
        $pindah_html = '../soal/modul_3';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }
    if(isset($_POST['delete_soal']))
    {
        
        $pindah_html = '../soal/modul_3';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_3', $pindah_html, 13, 14);
    }
?>