<?php
include '../../kumpulan_function.php';
require '../phpmailer/PHPMailerAutoload.php';
$soal   = new Soal();

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['add'])) {
    #Kolom
    $arr_kolom        = array(
        'room_id',
        'username_peserta',
        'password_peserta',
        'email',
        'nama_peserta',
        'usia_peserta',
        'pendidikan_peserta',
        'jenis_tes_peserta',
        'status_login'
    );

    #Data
    $room_id        = $_POST['room_id_p'];
    $u              = strtok($_POST['nama'], ' ') . '_' . mt_rand(100, 999) . '_' . $room_id;
    $username       = strtolower(str_replace(' ', '_', $u));
    $password       = generateRandomString(8);
    $email          = $_POST['email'];
    $nama           = $_POST['nama'];
    $usia           = $_POST['usia'];
    $pendidikan     = $_POST['pendidikan'];
    $jenis          = $_POST['jenis'];
    $status_login   = 0;

    session_start();
    if (empty($email)) {
        $_SESSION['emailErr'] = "Email wajib di isi";
    } else {
        $_SESSION['email'] = $email;
    }
    if (empty($nama)) {
        $_SESSION['namaErr'] = "Nama  wajib di isi";
    } else {
        $_SESSION['nama'] = $nama;
    }
    if (empty($usia)) {
        $_SESSION['usiaErr'] = "Usia wajib di isi";
    } else {
        $_SESSION['usia'] = $usia;
    }
    if (empty($jenis)) {
        $_SESSION['jenisErr'] = "Jenis tes wajib di isi";
    } else {
        $_SESSION['jenis'] = $jenis;
    }
    if (empty($pendidikan)) {
        $_SESSION['pendidikanErr'] = "Pendidikan wajib di isi";
    } else {
        $_SESSION['pendidikan'] = $pendidikan;
    }

    if (
        isset($_SESSION['emailErr']) || isset($_SESSION['namaErr']) || isset($_SESSION['usiaErr']) ||
        isset($_SESSION['jenisErr']) ||  isset($_SESSION['pendidikanErr'])
    ) {
        header('location:../room/detail_room?room_id=' . $room_id);
    } else {
        $arr_data       = array(
            $room_id,
            $username,
            $password,
            $email,
            $nama,
            $usia,
            $pendidikan,
            $jenis,
            $status_login
        );
        // var_dump($arr_data);
        $add_peserta    = $soal->Peserta($arr_kolom, $arr_data, 'tambah');

        #Tambah Peserta 
        switch ($add_peserta) {
                #Berhasil Status = 0
            case 'berhasil':
                header('location:../room/detail_room?room_id=' . $room_id . '&status=0');
                break;
                #Berhasil Status = 1
            case 'gagal':
                header('location:../room/detail_room?room_id=' . $room_id . '&status=1');
                break;
            default:
                # code...
                break;
        }
    }
}

#Hapus Data Peserta
if (isset($_POST['hapus_peserta'])) {
    $hapus = $soal->Peserta('id', $_POST['u_id_peserta'], 'hapus');
    switch ($hapus) {
            #Berhasul hapus Status = 2
        case 'berhasil':
            header('location:../room/detail_room?room_id=' . $_POST['u_room_id'] . '&status=2');
            break;
            #Berhasul hapus Status = 3
        case 'gagal':
            header('location:../room/detail_room?room_id=' . $_POST['u_room_id'] . '&status=3');
            break;
        default:
            # code...
            break;
    }
}

#Update Peserta
if (isset($_POST['update_peserta'])) {
    $arr_kolom      = '';
    $arr_data       = '';
    $room_id        = $_POST['u_room_id'];

    if (isset($_POST['u_jenis'])) {
        #Kolom
        $arr_kolom  = array(
            'password_peserta',
            'email',
            'nama_peserta',
            'usia_peserta',
            'pendidikan_peserta',
            'jenis_tes_peserta',
            'status_login',
            'id'
        );

        #Data
        $password   = $_POST['u_password'];
        $email      = $_POST['u_email'];
        $nama       = $_POST['u_nama'];
        $usia       = $_POST['u_usia'];
        $pendidikan = $_POST['u_pendidikan'];
        $jenis      = $_POST['u_jenis'];
        $status     = $_POST['u_status'];
        $id_peserta = $_POST['u_id_peserta'];

        $arr_data   = array(
            $password,
            $email,
            $nama,
            $usia,
            $pendidikan,
            $jenis,
            $status,
            $id_peserta
        );
    } else {
        #Kolom
        $arr_kolom  = array(
            'password_peserta',
            'email',
            'nama_peserta',
            'usia_peserta',
            'pendidikan_peserta',
            'status_login',
            'id'
        );

        #Data
        $password   = $_POST['u_password'];
        $email      = $_POST['u_email'];
        $nama       = $_POST['u_nama'];
        $usia       = $_POST['u_usia'];
        $pendidikan = $_POST['u_pendidikan'];
        $status     = $_POST['u_status'];
        $id_peserta = $_POST['u_id_peserta'];

        $arr_data   = array(
            $password,
            $email,
            $nama,
            $usia,
            $pendidikan,
            $status,
            $id_peserta
        );
    }
    $update = $soal->Peserta($arr_kolom, $arr_data, 'update');
    switch ($update) {
            #Status Berhasil Update = 4 
        case 'berhasil':
            header('location:../room/detail_room?room_id=' . $room_id . '&status=4');
            break;

            #Status Berhasil Update = 5 
        case 'gagal':
            header('location:../room/detail_room?room_id=' . $room_id . '&status=5');
            break;
        default:
            # code...
            break;
    }
}



if (isset($_POST['kirim_email'])) {
    $room_id        = $_POST['id_room_email'];
    #Data Room
    $resultRoom     = $soal->DetailRoom($room_id);
    $rowRoom        = $resultRoom->fetch_assoc();



    #Peserta
    $status_kirim   = '';
    $resPeserta  = $soal->DetailPesertaRoom($room_id);



    if ($resPeserta->num_rows > 0) {
        while ($rowPeserta = $resPeserta->fetch_assoc()) {
            $t          = new DateTime($rowRoom['tanggal']);
            $tanggal    = $t->format('d-m-Y');

            $hari           = $t->format("D");
            $hari_psikotes  = '';

            switch ($hari) {
                case 'Sun':
                    $hari_psikotes = "Minggu";
                    break;

                case 'Mon':
                    $hari_psikotes = "Senin";
                    break;

                case 'Tue':
                    $hari_psikotes = "Selasa";
                    break;

                case 'Wed':
                    $hari_psikotes = "Rabu";
                    break;

                case 'Thu':
                    $hari_psikotes = "Kamis";
                    break;

                case 'Fri':
                    $hari_psikotes = "Jumat";
                    break;

                case 'Sat':
                    $hari_psikotes = "Sabtu";
                    break;

                default:
                    $hari_psikotes = "Tidak di ketahui";
                    break;
            }


            $mail               = new PHPMailer;
            $mail->isSMTP();
            $mail->Host         = 'smtp.gmail.com';
            $mail->Port         = 587;
            $mail->SMTPAuth     = true;
            $mail->SMTPSecure   = 'tls';

            $mail->Username     = 'ssms.pskts.adm@gmail.com';
            $mail->Password     = 'oplszcpcontgvwty';

            $mail->setFrom('recruitment@citraborneo.co.id', 'SSMS: Psikotest Online');
            $mail->addAddress($rowPeserta['email']);
            $mail->addReplyTo('recruitment@citraborneo.co.id');

            $mail->isHTML(true);
            $mail->Subject      = 'Undangan Psikotest Online';
            $html_ini           = '
                    <html>
                    <style>
                        .hitam {
                            color:black;
                        }
                    </style>
                    <body style="color:black;">
                        <label class="hitam">Dengan Hormat,</label>
                        <p class="hitam">Dimohon kehadiran Bapak/Ibu untuk mengikuti proses <b>Psikotes Online</b> yang akan dilaksanakan pada:</p>
                        
                        <table style="width:100%;" class="hitam">
                        <tr>
                            <th style="text-align:left;"><b>Hari/tanggal</b></th>
                            <th><b>:</b></th>
                            <th><b>' . $hari_psikotes . ', ' . $tanggal . '</b></th>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Waktu</th>
                            <th><b>:</b></th>
                            <th><b>' . $rowRoom['jam_mulai'] . ' WIB - ' . $rowRoom['jam_selesai'] . ' WIB</b></th>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Link Psikotes</th>
                            <th><b>:</b></th>
                            <th><b><a href="https://www.srs-ssms.com/psikotes/peserta/auth/login">https://www.srs-ssms.com/psikotes/peserta/auth/login</a></b></th>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Link Room</th>
                            <th><b>:</b></th>
                            <th><b><a href="' . $rowRoom['link_room'] . '">' . $rowRoom['link_room'] . '</a></b></th>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Username Psikotes</th>
                            <th><b>:</b></th>
                            <th><b>' . $rowPeserta['username_peserta'] . '</b></th>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Password Psikotes</th>
                            <th><b>:</b></th>
                            <th><b>' . $rowPeserta['password_peserta'] . '</b></th>
                        </tr>
                        </table>

                        <p>Mohon menggunkan Laptop/PC dan menginstall aplikasi Cisco Webex sebelum pelaksanaan dimulai.</p>
                        
                        <p>Demikian disampaikan atas perhatiannya kami ucapkan terima kasih.</p>

                        <p><b>Best regards,</b></p>

                        <p><i>Talent Management</i></p>
                    </body>
                    </html>
                
                ';
            $mail->Body         = $html_ini;
            if (!$mail->send()) {
                $status_kirim = 'gagal';
            } else {
                $status_kirim = 'berhasil';
            }
        }
    } else {
        #Status Belum ada peserta yang terdaftar di room = 6  
        header('location:../room/detail_room?room_id=' . $room_id . '&status=6');
    }


    if ($status_kirim == 'berhasil') {
        #Berhasil Mengirimkan email status = 7
        header('location:../room/detail_room?room_id=' . $room_id . '&status=7');
    } else {
        #Gagal Mengirimkan Email status = 8
        header('location:../room/detail_room?room_id=' . $room_id . '&status=8');
    }
}
