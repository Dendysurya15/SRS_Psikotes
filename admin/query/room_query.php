<?php
    include '../../kumpulan_function.php';

    $soal = new Soal();

    if(isset($_POST['buat_room']))
    {
        $link               = $_POST['link_room'];
        $nama_room          = $_POST['nama_room'];
        $meeting_id         = $_POST['meeting_id'];
        $password_room      = $_POST['password_room'];
        $tanggal_room       = $_POST['tanggal_room'];
        $jam_mulai_room     = $_POST['jam_mulai_room'];
        $jam_selesai_room   = $_POST['jam_selesai_room'];

        $status_soal        = 's_1=0;s_2=0;s_3=0;s_4=0;s_5=0;s_6=0;s_7=0;s_8=0;s_9=0;s_10=0;s_11=0;s_12=0;s_13=0;s_14=0;s_15=0;s_16=0;s_17=0';

        $arr_kolom              = array('link_room', 'nama_room', 'meeting_id_room', 'password_room', 'tanggal', 'jam_mulai', 'jam_selesai', 'status_soal');
        $arr_data               = array($link, $nama_room, $meeting_id, $password_room, $tanggal_room, $jam_mulai_room, $jam_selesai_room, $status_soal);
        $berhasil   = 1;
        $gagal      = 0;

        $tambah_room    = $soal->Room($arr_kolom, $arr_data, $berhasil, $gagal, 'tambah');
        
        #echo $soal->Room($arr_kolom, $arr_data, $berhasil, $gagal, 'tambah');
    }

    #Update room
    if(isset($_POST['update_btn']))
    {
        
        #kolom
        $arr_kolom              = array('link_room', 'nama_room', 'meeting_id_room', 'password_room', 'tanggal', 'jam_mulai', 'jam_selesai', 'id');
        
        #data
        $id_room                = $_POST['up_room_id'];
        $link                   = $_POST['update_link'];
        $nama_room              = $_POST['update_nama_room'];
        $meeting_id             = $_POST['update_meeting_id'];
        $password_room          = $_POST['update_password'];
        $tanggal_room           = $_POST['update_tanggal'];
        $jam_mulai_room         = $_POST['update_jam_mulai'];
        $jam_selesai_room       = $_POST['update_jam_selesai'];
        

        $arr_data               = array($link, $nama_room, $meeting_id, $password_room, $tanggal_room, $jam_mulai_room, $jam_selesai_room, $id_room);
        

        $update = $soal->Room($arr_kolom, $arr_data, '', '', 'update');
        
        switch ($update) {
            case 'berhasil':
                header('location:../room/detail_room?room_id='.$id_room.'&status=9');
                break;
            case 'gagal':
                header('location:../room/detail_room?room_id='.$id_room.'&status=10');
                break;
            default:
                # code...
                break;
        }
    
    }

    if(isset($_POST['jumlah_status']))
    {
        for($i = 1; $i <= $_POST['jumlah_status']; $i++)
        {
            if(isset($_POST['aktifkan_s_'.$i.'']))
            {
                $resRoom    = $soal->DetailRoom($_POST['room_id']);

                $upStatus   = $_POST['s_'.$i.''].'=1';
                $srcStatus  = $_POST['s_'.$i.''].'=0';

                $rowRoom    = $resRoom->fetch_assoc();
                $strStatus  = $rowRoom['status_soal'];

                $strStatus  = str_replace($srcStatus, $upStatus, $strStatus);


                $arr_kolom      = array('status_soal', 'id');         
                $arr_data       = array($strStatus, $_POST['room_id']);
        

                $update = $soal->Room($arr_kolom, $arr_data, '', '', 'update');
                
                switch ($update) {
                    case 'berhasil':
                        header('location:../room/detail_room?room_id='.$_POST['room_id'].'');
                        break;
                    case 'gagal':
                        header('location:../room/detail_room?room_id='.$_POST['room_id'].'');
                        break;
                    default:
                        # code...
                        break;
                }

            }
        }
    }
    
    if(isset($_GET['status']))
    {
        if($_GET['status'] == 'Hapus')
        {
            $hapusRoom = $soal->HapusRoom($_GET['room_id']);
            //STATUS 11 = Berhasil Menghapus Room
            if($hapusRoom == 'Berhasil')
            {
                header('location:../room/daftar_room?status=11');
            }
            //STATUS 12 = Query Hapus Peserta Bermasalah
            else if($hapusRoom == 'Query Hapus Peserta Bermasalah')
            {
                header('location:../room/daftar_room?status=12');
            }
            //STATUS 13 = Query Hapus Peserta Bermasalah
            else if($hapusRoom == 'Query Hapus Jawaban Bermasalah')
            {
                header('location:../room/daftar_room?&status=13');
            }
            //STATUS 14 = Query Hapus Room Bermasalah
            else
            {
                header('location:../room/daftar_room?status=14');
            }
        }
    }

?>