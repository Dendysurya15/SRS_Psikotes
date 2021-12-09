<?php
    include '../../kumpulan_function.php';
    
    $soal = new Soal();

    if(isset($_POST['add_soal']))
    {
        if(isset($_POST['add_nomor']))
        {
            $pindah_html    = '../soal/modul_4';
            $cek_nomor      = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_4');
            switch ($cek_nomor) {
                case 'TIDAK ADA':
                    $nama_modul     = 'modul_4';
                    $array_kolom    = array('soal_id', 'nomor_soal' ,'teks_soal', 'kunci_jawaban');
                    $array_data     = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks_soal']), htmlspecialchars($_POST['add_kunci_jawaban']));
                    $soal->TambahSoalModul($_POST['add_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 0, 1);
                    break;
                
                default:
                    header('location:'.$pindah_html.'?soal_id='.$soal_id.'&status=2');
                    break;
            }           
        
        }
    }

    if(isset($_POST['update_soal']))
    {
        $pindah_html    = '../soal/modul_4';
        $nama_modul     = 'modul_4';
        
        $array_kolom    = array('teks_soal', 'kunci_jawaban', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_teks_soal']), htmlspecialchars($_POST['update_jawaban_soal']), $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 3 , 4);       

    }

    if(isset($_POST['update_modul']))
    {
        #update Data Modul
        $pindah_html = '../soal/modul_4';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }

    if(isset($_POST['delete_soal']))
    {
        
        $pindah_html = '../soal/modul_4';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_4', $pindah_html, 13, 14);
    }

?>