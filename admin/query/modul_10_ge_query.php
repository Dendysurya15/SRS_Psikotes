<?php    
    include '../../kumpulan_function.php';
    $soal = new Soal();

    if(isset($_POST['add_soal']))
    {
        $pindah_html    = '../soal/modul_10_ge';

        
        
        $cekNomorSoal   = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_10_ge');
        switch ($cekNomorSoal) {
            case 'TIDAK ADA':
                $nama_modul = 'modul_10_ge';
                $pilihan    = '';

                echo $_POST['add_teks_soal'].'<br>'.$_POST['add_nilai_2_soal'].'<br>'.$_POST['add_nilai_1_soal'].'<br>'.$_POST['add_nilai_0_soal'].'<br>';

                $array_data     = '';
                $array_kolom    = '';

                if(isset($_POST['add_teks_soal']) || isset($_POST['add_nilai_2_soal']) || isset($_POST['add_nilai_1_soal']) || isset($_POST['add_nilai_0_soal']))
                {
                    $array_kolom    = array('soal_id', 'nomor_soal', 'teks_soal', 'nilai_2', 'nilai_1', 'nilai_0');

                    $nilai_2        = strtolower($_POST['add_nilai_2_soal']).';';
                    $nilai_1        = strtolower($_POST['add_nilai_1_soal']).';';
                    $nilai_0        = strtolower($_POST['add_nilai_0_soal']).';';
                    $array_data     = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks_soal']), $nilai_2, $nilai_1, $nilai_0);
                    

                }
                else 
                {
                    header('location:../soal/modul_10_ra?soal_id='.$_POST['add_soal_id'].'&status=20');
                }


                // $array_kolom    = array('soal_id', 'nomor_soal', 'teks_soal', 'pilihan' ,'kunci_jawaban');
                // $array_data     = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks_soal']), $pilihan, $_POST['add_kunci_jawaban']);
                
                $soal->TambahSoalModul($_POST['add_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 7, 8);
                                
                break;
            
            default:
                header('location:'.$pindah_html.'?soal_id='.$_POST['add_soal_id'].'&status=6');
                break; 
        }


    }

    if(isset($_POST['update_soal']))
    {
        $pindah_html    = '../soal/modul_10_ge';
        
        $nomor_soal     = $_POST['up_nomor_soal'];

        $id_soal        = $_POST['up_id'];

        $teks_soal      = htmlspecialchars($_POST['up_teks_soal']);
        $nilai_2        = strtolower($_POST['up_nilai_2']).';';
        $nilai_1        = strtolower($_POST['up_nilai_1']).';';
        $nilai_0        = strtolower($_POST['up_nilai_0']).';';
        $arr_kolom      = '';
        $arr_data       = '';
    
    

        $arr_kolom      = array('teks_soal', 'nilai_2' ,'nilai_1', 'nilai_0' ,'id');
        $arr_data       = array($teks_soal, $nilai_2, $nilai_1, $nilai_0 ,$id_soal);
    
        
        $soal->UpdateSoalModul($_POST['up_soal_id'], 'modul_10_ge', $arr_kolom, $arr_data, $pindah_html, 9, 10);
        
    }

    if(isset($_POST['update_modul']))
    {
        $pindah_html = '../soal/modul_10_ge';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }

    if(isset($_POST['delete_soal']))
    {
        $pindah_html = '../soal/modul_10_ge';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_10_ge', $pindah_html, 13, 14);
    }
?>