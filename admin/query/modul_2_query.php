<?php    
    include '../../kumpulan_function.php';
    $soal = new Soal();

    if(isset($_POST['add_gambar_hapalan']))
    {            

        $soal_id        = $_POST['hapalan_soal_id'];
        $gambar_hapalan = $_FILES['hapalan_gambar'];
        $nama_modul     = $_POST['hapalan_nama_modul'];
        $durasi         = $_POST['hapalan_durasi'];
        $gambar_lama    = '';
        $tempat_upload  = '../gambar_hapalan/';
        $pindah_html    = '../soal/modul_2';
        $soal->TambahGambarHapalan($soal_id, $nama_modul, $durasi, $gambar_lama, $gambar_hapalan, $tempat_upload, $pindah_html);
    }

    if(isset($_POST['update_hapalan']))
    {
        $soal_id        = $_POST['hapalan_soal_id'];
        $gambar_hapalan = $_FILES['hapalan_gambar'];
        $nama_modul     = $_POST['hapalan_nama_modul'];
        $durasi         = $_POST['hapalan_durasi'];  
        $gambar_lama    = $_POST['gambar_lama'];      
        $tempat_upload  = '../gambar_hapalan/';
        $pindah_html    = '../soal/modul_2';
        
        $soal->TambahGambarHapalan($soal_id, $nama_modul, $durasi, $gambar_lama, $gambar_hapalan, $tempat_upload, $pindah_html);

    }

    if(isset($_POST['add_soal']))
    {
        $pindah_html    = '../soal/modul_2';

        $cekNomorSoal   = $soal->CekNomorSoal($_POST['add_nomor'], 'modul_2');
        switch ($cekNomorSoal) {
            case 'TIDAK ADA':
                $nama_modul = 'modul_2';
                $array_kolom  = array('soal_id', 'nomor_soal', 'teks_soal', 'kunci_jawaban');
                $array_data   = array($_POST['add_nomor'], htmlspecialchars($_POST['add_teks_soal']), $_POST['add_kunci_jawaban']);
                $soal->TambahSoalModul($_POST['add_soal_id'], $nama_modul, $array_kolom, $array_data, $pindah_html, 7, 8);
                
                break;
            
            default:
                header('location:'.$pindah_html.'?soal_id='.$_POST['add_soal_id'].'&status=6');
                break;
        }


    }

    if(isset($_POST['update_soal']))
    {
        $pindah_html    = '../soal/modul_2';
        $array_kolom    = array('teks_soal', 'kunci_jawaban', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_teks_soal']), $_POST['update_kunci_jawaban'], $_POST['update_id']); 

        $soal->UpdateSoalModul($_POST['update_soal_id'], 'modul_2', $array_kolom, $array_data, $pindah_html, 9, 10);
        
    }

    if(isset($_POST['update_modul']))
    {
        $pindah_html = '../soal/modul_2';
        $array_kolom    = array('deskripsi_soal', 'durasi', 'id');
        $array_data     = array(htmlspecialchars($_POST['update_deskripsi_soal']), $_POST['update_durasi_soal'], $_POST['update_id']);
        $soal->UpdateSoalModul($_POST['update_id'], 'soal', $array_kolom, $array_data, $pindah_html, 11, 12);
    }

    if(isset($_POST['delete_soal']))
    {
        $pindah_html = '../soal/modul_2';
        $soal->HapusSoalModul($_POST['update_id'], $_POST['update_soal_id'] ,'modul_2', $pindah_html, 13, 14);
    }
?>