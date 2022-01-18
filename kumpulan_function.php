<?php
class Soal
{
    public $server;
    public $username;
    public $password;
    public $database;
    public $conn;

    function __construct()
    {
        $this->server       = 'localhost';
        $this->username     = 'srsssmsc_andre09';
        $this->password     = 'sidewinderzone';
        $this->database     = 'srsssmsc_psikotest';
        $this->conn         = new mysqli($this->server, $this->username, $this->password, $this->database);
    }

    private $nama_soal;



    #--SOAL
    function SelectSoal()
    {
        $sqlSelectSoal      = 'SELECT * FROM soal ORDER BY urutan ASC';
        $resultSelectSoal   = $this->conn->query($sqlSelectSoal);
        return $resultSelectSoal;
    }


    function SelectSoal2($nama_soal)
    {
        $sqlSelectSoal      = 'SELECT * FROM soal WHERE nama_soal="' . $nama_soal . '"';
        $resultSelectSoal   = $this->conn->query($sqlSelectSoal);
        return $resultSelectSoal;
    }

    function CekDataSoal($nama_soal)
    {
        $sqlCekModul    = 'SELECT * FROM soal WHERE nama_soal = ' . $nama_soal . '';
        $resultCekModul = $this->conn->query($sqlCekModul);
        if ($resultCekModul && $resultCekModul->num_rows > 0) {
            return 'ADA';
        } else {
            return 'TIDAK ADA';
        }
    }

    function TambahDataSoal($nama_soal, $deskripsi, $durasi)
    {
        $cekModulSoal = $this->CekDataSoal($nama_soal);
        switch ($cekModulSoal) {
            case 'TIDAK ADA':
                $sqlInsertSoal = 'INSERT INTO soal (nama_soal, deskripsi_soal, durasi)
                    VALUES ("' . $nama_soal . '", "' . $deskripsi . '", "' . $durasi . '")';
                if ($this->conn->query($sqlInsertSoal) === TRUE) {
                    return $this->conn->insert_id;
                } else {
                    return 'Data Telah Diinputkan';
                }
                break;

            default:
                return 'Data Telah Diinputkan';
                break;
        }
    }

    function SelectDataSoal($soal_id)
    {
        $sqlDataSoal         = 'SELECT * FROM soal WHERE id = ' . $soal_id . '';
        $resultDataSoal     = $this->conn->query($sqlDataSoal);
        $rowDataSoal        = $resultDataSoal->fetch_assoc();
        return $rowDataSoal;
    }

    function UpdateDataSoal($id, $durasi, $deskripsi, $pindah_html)
    {
        $sqlUpdateDataSoal  = 'UPDATE soal SET deskripsi_soal="' . $deskripsi . '", durasi=' . $durasi . ' WHERE id=' . $id . '';
        if ($this->conn->query($sqlUpdateDataSoal) === TRUE) {
            header('location:' . $pindah_html . '?soal_id=' . $id . '&status=10');
        } else {
            header('location:' . $pindah_html . '?soal_id=' . $id . '&status=11');
            //return 'gagal';
        }
    }

    function HapusSoalModul($id, $soal_id, $nama_modul, $pindah_html, $status_berhasil, $status_gagal)
    {
        $sqlHapusSoalModul  = 'DELETE FROM ' . $nama_modul . ' WHERE id=' . $id . '';
        switch ($sqlHapusSoalModul) {
            case $this->conn->query($sqlHapusSoalModul) === TRUE:
                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=' . $status_berhasil . '');
                break;

            default:
                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=' . $status_gagal . '');
                break;
        }
    }

    #SOAL--

    function TambahSoalModul($soal_id, $nama_modul, $array_kolom, $array_data, $pindah_html, $status_berhasil, $status_gagal)
    {
        $jumlah_indek_kolom     = count($array_kolom);
        $indek_terakhir_kolom   = count($array_kolom) - 1;

        $sqlInsertData  = 'INSERT INTO ' . $nama_modul . ' (';

        for ($i = 0; $i < $jumlah_indek_kolom; $i++) {
            if ($i != $indek_terakhir_kolom) {
                $sqlInsertData .= $array_kolom[$i] . ', ';
            } else {
                $sqlInsertData .= $array_kolom[$i] . ')';
            }
        }
        $sqlInsertData          .= ' VALUES(';
        $sqlInsertData          .= '"' . $soal_id . '", ';
        $jumlah_indek_data      = count($array_data);
        $indek_terakhir_data    = count($array_data) - 1;
        for ($i = 0; $i < $jumlah_indek_data; $i++) {
            if ($i != $indek_terakhir_data) {
                $sqlInsertData .= '"' . $array_data[$i] . '", ';
            } else {
                $sqlInsertData .= '"' . $array_data[$i] . '")';
            }
        }
        if ($this->conn->query($sqlInsertData) === TRUE) {
            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=' . $status_berhasil . '');
        } else {
            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=' . $status_gagal . '');
        }


        #echo $sqlInsertData;
    }

    function UpdateSoalModul($soal_id, $nama_modul, $array_kolom, $array_data, $pindah_html, $status_berhasil, $status_gagal)
    {
        $jumlah_indek_kolom     = count($array_kolom);
        $indek_terakhir_kolom   = count($array_kolom) - 1;

        $sqlUpdateData = 'UPDATE ' . $nama_modul . ' SET ';

        for ($i = 0; $i < $jumlah_indek_kolom; $i++) {
            if ($i != $indek_terakhir_kolom) {
                $sqlUpdateData .= $array_kolom[$i] . ' = "' . $array_data[$i] . '", ';
            } else {
                $sqlUpdateData = substr($sqlUpdateData, 0, -2);
                $sqlUpdateData .= ' WHERE ' . $array_kolom[$i] . ' = "' . $array_data[$i] . '"';
            }
        }

        #return $sqlUpdateData;

        if ($this->conn->query($sqlUpdateData) === TRUE) {
            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=' . $status_berhasil . '');
        } else {
            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=' . $status_gagal . '');
        }
    }

    #--MODUL 1
    function TambahSoalModul1($soal_id, $nama_tabel, $nomor_soal, $link_gambar, $kunci_jawaban, $tempat_upload, $pindah_html)
    {
        $lima_mb        = 5 * 1048576;
        $cekNomor       = $this->CekNomorSoal($nomor_soal, $nama_tabel);
        switch ($cekNomor) {
            case 'TIDAK ADA':
                if (!empty($link_gambar)) {
                    $gambar_tmp     = $link_gambar['tmp_name'];
                    $gambar_name    = $link_gambar['name'];
                    $gambar_size    = $link_gambar['size'];
                    $gambar_tipe    = $link_gambar['type'];

                    if ($gambar_tipe == 'image/png' or $gambar_tipe == 'image/jpeg' or $gambar_tipe == 'image/jpg') {
                        if ($gambar_size > $lima_mb) {
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=5');
                        } else {
                            $ext_gambar         = pathinfo($gambar_name, PATHINFO_EXTENSION);
                            $img_name           = strtolower(str_replace('.' . $ext_gambar . '', '', $gambar_name));
                            $format_nama_baru   = $img_name . '_' . $soal_id . '_' . $nomor_soal . '.' . strtolower($ext_gambar);

                            $sqlInsertSoal      = 'INSERT INTO ' . $nama_tabel . ' (soal_id, nomor_soal, link_gambar, kunci_jawaban)
                                VALUES("' . $soal_id . '", "' . $nomor_soal . '", "' . $format_nama_baru . '", "' . $kunci_jawaban . '")';

                            if ($this->conn->query($sqlInsertSoal) === TRUE) {
                                move_uploaded_file($gambar_tmp, $tempat_upload . $format_nama_baru);
                                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=0');
                            } else {
                                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=2');
                            }
                        }
                    } else {
                        $sqlInsertSoal      = 'INSERT INTO ' . $nama_tabel . ' (soal_id, nomor_soal, link_gambar, kunci_jawaban)
                            VALUES("' . $soal_id . '", "' . $nomor_soal . '", "", "' . $kunci_jawaban . '")';

                        if ($this->conn->query($sqlInsertSoal) === TRUE) {
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=0');
                        } else {
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=2');
                        }
                    }
                }

                break;

            default:
                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=1');
                break;
        }
    }
    function UpdateSoalModul1($id, $nama_tabel, $soal_id, $nomor_soal, $gambar_lama, $gambar_baru, $kunci_jawaban, $tempat_upload, $pindah_html)
    {
        $lima_mb        = 5 * 1048576;
        $gambar_tmp     = $gambar_baru['tmp_name'];
        $gambar_name    = $gambar_baru['name'];
        $gambar_size    = $gambar_baru['size'];
        $gambar_tipe    = $gambar_baru['type'];

        if ($gambar_size == 0) {
            $sqlUpdateModul1 = 'UPDATE ' . $nama_tabel . ' SET kunci_jawaban ="' . $kunci_jawaban . '" WHERE id=' . $id . '';
            if ($this->conn->query($sqlUpdateModul1) === TRUE) {
                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=3');
            } else {
                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=4');
            }
        } else {
            if ($gambar_size > $lima_mb) {
                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=5');
            } else {

                if ($gambar_lama != $gambar_name and !empty($gambar_lama)) {
                    if (file_exists($tempat_upload . $gambar_lama)) {

                        unlink($tempat_upload . $gambar_lama);
                        if ($gambar_tipe == 'image/png' or $gambar_tipe == 'image/jpeg' or $gambar_tipe == 'image/jpg') {
                            $ext_gambar         = pathinfo($gambar_name, PATHINFO_EXTENSION);
                            $img_name           = strtolower(str_replace('.' . $ext_gambar . '', '', $gambar_name));
                            $format_nama_baru   = $img_name . '_' . $soal_id . '_' . $nomor_soal . '.' . strtolower($ext_gambar);

                            $sqlUpdateModul1      = 'UPDATE ' . $nama_tabel . ' SET link_gambar="' . $format_nama_baru . '" ,kunci_jawaban ="' . $kunci_jawaban . '" WHERE id=' . $id . '';

                            if ($this->conn->query($sqlUpdateModul1) === TRUE) {
                                move_uploaded_file($gambar_tmp, $tempat_upload . $format_nama_baru);
                                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=3');
                            } else {
                                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=4');
                            }
                        }
                    } else {

                        if ($gambar_tipe == 'image/png' or $gambar_tipe == 'image/jpeg' or $gambar_tipe == 'image/jpg') {
                            $ext_gambar         = pathinfo($gambar_name, PATHINFO_EXTENSION);
                            $img_name           = strtolower(str_replace('.' . $ext_gambar . '', '', $gambar_name));
                            $format_nama_baru   = $img_name . '_' . $soal_id . '_' . $nomor_soal . '.' . strtolower($ext_gambar);

                            $sqlUpdateModul1      = 'UPDATE ' . $nama_tabel . ' SET link_gambar="' . $format_nama_baru . '" ,kunci_jawaban ="' . $kunci_jawaban . '" WHERE id=' . $id . '';

                            if ($this->conn->query($sqlUpdateModul1) === TRUE) {

                                //echo 'mantap : '.$format_nama_baru;
                                move_uploaded_file($gambar_tmp, $tempat_upload . $format_nama_baru);
                                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=3');
                            } else {
                                header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=4');
                            }
                        }
                    }
                } else {
                    if ($gambar_tipe == 'image/png' or $gambar_tipe == 'image/jpeg' or $gambar_tipe == 'image/jpg') {
                        $ext_gambar         = pathinfo($gambar_name, PATHINFO_EXTENSION);
                        $img_name           = strtolower(str_replace('.' . $ext_gambar . '', '', $gambar_name));
                        $format_nama_baru   = $img_name . '_' . $soal_id . '_' . $nomor_soal . '.' . strtolower($ext_gambar);

                        $sqlUpdateModul1      = 'UPDATE ' . $nama_tabel . ' SET link_gambar="' . $format_nama_baru . '" ,kunci_jawaban ="' . $kunci_jawaban . '" WHERE id=' . $id . '';

                        if ($this->conn->query($sqlUpdateModul1) === TRUE) {
                            move_uploaded_file($gambar_tmp, $tempat_upload . $format_nama_baru);
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=3');
                        } else {
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=4');
                        }
                    }
                }
            }
        }
    }

    function HapusSoal1($id, $gambar, $tempat_file)
    {
        $sqlHapus = 'DELETE FROM modul_1 WHERE id="' . $id . '"';

        if ($this->conn->query($sqlHapus) == TRUE) {
            if (unlink($tempat_file . $gambar)) {
                return 'berhasil';
            }
        }
    }
    #Modul 1--

    #-- Modul 2
    function SelectGambarHapalan($soal_id)
    {
        $sqlSelectGambarHapalan     = 'SELECT * FROM hapalan WHERE soal_id=' . $soal_id . '';
        $resultSelectGambarHapalan  = $this->conn->query($sqlSelectGambarHapalan);
        return $resultSelectGambarHapalan;
    }
    function TambahGambarHapalan($soal_id, $nama_modul, $durasi, $gambar_lama, $gambar_hapalan, $tempat_upload, $pindah_html)
    {
        $lima_mb        = 5 * 1048576;
        $gambar_tmp     = $gambar_hapalan['tmp_name'];
        $gambar_name    = $gambar_hapalan['name'];
        $gambar_size    = $gambar_hapalan['size'];
        $gambar_tipe    = $gambar_hapalan['type'];

        $cekGambarHapalan   = $this->SelectGambarHapalan($soal_id);
        switch ($cekGambarHapalan) {
            case $cekGambarHapalan->num_rows > 0:

                $ext_gambar         = pathinfo($gambar_name, PATHINFO_EXTENSION);
                $format_nama_baru   = $nama_modul . '_' . $soal_id . '.' . strtolower($ext_gambar);
                $sqlUpdateGambarHapalan = 'UPDATE hapalan SET gambar_hapalan="' . $format_nama_baru . '", durasi="' . $durasi . '"
                    WHERE soal_id=' . $soal_id . '';
                if ($this->conn->query($sqlUpdateGambarHapalan) === TRUE) {
                    unlink($tempat_upload . $gambar_lama);
                    move_uploaded_file($gambar_tmp, $tempat_upload . $format_nama_baru);
                    header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=5');
                } else {
                    header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=4');
                }

                break;

            default:
                $ext_gambar         = pathinfo($gambar_name, PATHINFO_EXTENSION);
                $format_nama_baru   = $nama_modul . '_' . $soal_id . '.' . strtolower($ext_gambar);

                if ($gambar_size > $lima_mb) {
                    header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=1');
                } else {
                    if ($gambar_tipe == 'image/png' or $gambar_tipe == 'image/jpeg' or $gambar_tipe == 'image/jpg') {
                        $sqlInsertHapalan = 'INSERT INTO hapalan (soal_id, nama_modul, gambar_hapalan, durasi)
                            VALUES("' . $soal_id . '", "' . $nama_modul . '", "' . $format_nama_baru . '", "' . $durasi . '")';
                        if ($this->conn->query($sqlInsertHapalan) === TRUE) {
                            move_uploaded_file($gambar_tmp, $tempat_upload . $format_nama_baru);
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=3');
                        } else {
                            header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=4');
                        }
                    } else {
                        header('location:' . $pindah_html . '?soal_id=' . $soal_id . '&status=2');
                    }
                }
                break;
        }
    }
    #Modul 2--

    function CekNomorSoal($nomor_soal, $tabel)
    {
        $sqlNomorSoal       = 'SELECT * FROM ' . $tabel . ' WHERE nomor_soal=' . $nomor_soal . '
            ORDER BY nomor_soal DESC LIMIT 1';
        $resultNomorSoal    = $this->conn->query($sqlNomorSoal);
        switch ($resultNomorSoal) {
            case $resultNomorSoal->num_rows > 0:
                return 'ADA';
                break;

            default:
                return 'TIDAK ADA';
                break;
        }
    }


    function SelectDataSoalModul($soal_id, $nama_tabel)
    {
        $sqlDataSoal    = 'SELECT * FROM ' . $nama_tabel . ' WHERE soal_id = ' . $soal_id . ' ORDER BY nomor_soal ASC';
        $resultDataSoal    = $this->conn->query($sqlDataSoal);
        return $resultDataSoal;
    }


    #--Dapatkan Nomor Soal
    function NomorSoal($soal_id, $tabel)
    {
        $sqlNomorSoal       = 'SELECT * FROM ' . $tabel . ' WHERE soal_id=' . $soal_id . '
            ORDER BY nomor_soal DESC LIMIT 1';
        $resultNomorSoal    = $this->conn->query($sqlNomorSoal);
        switch ($resultNomorSoal) {
            case $resultNomorSoal->num_rows > 0:
                $rowNomorSoal   = $resultNomorSoal->fetch_assoc();
                $nomor_soal     = $rowNomorSoal['nomor_soal'] + 1;
                return $nomor_soal;
                break;

            default:
                $nomor_soal = 1;
                return $nomor_soal;
                break;
        }
    }
    #--Dapatkan Nomor Soal

    function AddUser($tabel, $nama_season, $array_data, $array_kolom, $pindah_html_berhasil, $pindah_html_gagal)
    {
        session_start();

        $sqlAddUser         = 'INSERT INTO ' . $tabel . ' (';
        $idx_terakhir_kol   = count($array_kolom) - 1;
        for ($i = 0; $i < count($array_kolom); $i++) {
            if ($i != $idx_terakhir_kol) {
                $sqlAddUser .= $array_kolom[$i] . ', ';
            } else {
                $sqlAddUser .= $array_kolom[$i] . ')';
            }
        }

        $sqlAddUser     .= 'VALUES (';
        $idx_terakhir_data  = count($array_data) - 1;
        for ($i = 0; $i < count($array_data); $i++) {
            if ($i != $idx_terakhir_data) {
                $sqlAddUser .= '"' . $array_data[$i] . '", ';
            } else {
                $sqlAddUser .= '"' . $array_data[$i] . '")';
            }
        }

        $id = '';

        if ($this->conn->query($sqlAddUser) === TRUE) {
            $id = $this->conn->insert_id;

            $sqlCekData     = 'SELECT * FROM ' . $tabel . ' WHERE id=' . $id . '';
            $resultCekData  = $this->conn->query($sqlCekData);

            if ($resultCekData->num_rows > 0) {
                while ($rowCekData = $resultCekData->fetch_assoc()) {
                    return 'berhasil';
                }
            }
        } else {
            return 'gagal';
        }
    }

    #Fungsi Login
    function login_admin($tabel, $email, $password)
    {
        $pwd = md5($password);
        $sqlLogin   = 'SELECT * FROM ' . $tabel . ' WHERE email="' . $email . '" AND password="' . $pwd . '"';

        $resultLogin = $this->conn->query($sqlLogin);

        if ($resultLogin->num_rows > 0) {
            return 'berhasil';
        } else {
            return 'gagal';
        }
    }

    # ~ Room + Peserta
    #   ~ Daftar Room
    function DaftarRoom()
    {
        $sqlDaftarRoom      = 'SELECT * FROM room';
        $resultDaftarRoom   = $this->conn->query($sqlDaftarRoom);
        return $resultDaftarRoom;
    }

    #   ~ Detail Room
    function DetailRoom($room_id)
    {
        $sqlDetailRoom      = 'SELECT * FROM room WHERE id=' . $room_id . '';
        $resultDetailRoom   = $this->conn->query($sqlDetailRoom);

        return $resultDetailRoom;
    }
    function DetailPesertaRoom($room_id)
    {
        $sqlPesertaRoom      = 'SELECT * FROM peserta WHERE room_id=' . $room_id . '';
        $resultPesertaRoom   = $this->conn->query($sqlPesertaRoom);

        // echo $sqlPesertaRoom;
        return $resultPesertaRoom;
    }

    #   ~ Tambah, Update , Hapus
    function Room($arr_kolom, $arr_data, $berhasil, $gagal, $status)
    {
        switch ($status) {
            case 'tambah':
                $sqlTambahRoom  = 'INSERT INTO room (';
                $jum_kol        = count($arr_kolom) - 1;
                for ($i = 0; $i < count($arr_kolom); $i++) {
                    if ($i != $jum_kol) {
                        $sqlTambahRoom .= $arr_kolom[$i] . ',';
                    } else {
                        $sqlTambahRoom .= $arr_kolom[$i] . ')';
                    }
                }

                $sqlTambahRoom .= ' VALUES (';

                $jum_data       = count($arr_data) - 1;
                for ($i = 0; $i < count($arr_data); $i++) {
                    if ($i != $jum_data) {
                        $sqlTambahRoom .= '"' . $arr_data[$i] . '" , ';
                    } else {
                        $sqlTambahRoom .= '"' . $arr_data[$i] . '" )';
                    }
                }

                switch ($this->conn->query($sqlTambahRoom)) {
                    case TRUE:
                        $_SESSION['getLink'] = '';
                        $_SESSION['meetingId'] = '';
                        $_SESSION['namaRoom'] = '';
                        $_SESSION['passwordRoom'] = '';
                        $_SESSION['tanggalRoom'] = '';
                        $_SESSION['jamMulai'] = '';
                        $_SESSION['jamSelesai'] = '';
                        header('location:../room/daftar_room?status=' . $berhasil . '');
                        break;

                    case FALSE:
                        header('location:../room/daftar_room?status=' . $gagal . '');
                        break;
                    default:
                        # code...
                        break;
                }

                #return $sqlTambahRoom;


                break;

            case 'update':
                $sqlUpdateRoom  = 'UPDATE room SET ';
                $jum            = count($arr_kolom) - 1;
                for ($i = 0; $i < count($arr_kolom); $i++) {
                    if ($i != $jum) {
                        $sqlUpdateRoom .= $arr_kolom[$i] . '="' . $arr_data[$i] . '", ';
                    } else {
                        $sqlUpdateRoom  = substr($sqlUpdateRoom, 0, -2);
                        $sqlUpdateRoom .= ' WHERE ' . $arr_kolom[$i] . '=' . $arr_data[$i];
                    }
                }
                if ($this->conn->query($sqlUpdateRoom) === TRUE) {
                    return 'berhasil';
                } else {
                    return 'gagal';
                }

                break;

            default:
                # code...
                break;
        }
    }

    #Peserta login

    function loginPeserta($username, $password)
    {
        $query = "SELECT * FROM `peserta` WHERE username_peserta ='$username' and password_peserta='$password'";
        $resultPesertaLogin = $this->conn->query($query);
        return $resultPesertaLogin;
    }

    function updatePeserta($id_peserta, $arrData)
    {
        $query = "UPDATE `peserta` WHERE id='$id_peserta'";
        $updatePeserta = $this->conn->query($query);


        return $updatePeserta;
    }

    #Peserta Tambah, Update, Hapus
    function Peserta($arr_kolom, $arr_data, $status)
    {
        switch ($status) {
            case 'tambah':
                $sqlTambahPeserta   = 'INSERT INTO peserta (';
                #Kolom
                $jum_kol            = count($arr_kolom) - 1;
                for ($i = 0; $i < count($arr_kolom); $i++) {
                    if ($i != $jum_kol) {
                        $sqlTambahPeserta .= $arr_kolom[$i] . ', ';
                    } else {
                        $sqlTambahPeserta .= $arr_kolom[$i] . ') ';
                    }
                }

                $sqlTambahPeserta .= 'VALUES (';
                #Data
                $jum_data           = count($arr_data) - 1;
                for ($i = 0; $i < count($arr_data); $i++) {
                    if ($i != $jum_kol) {
                        $sqlTambahPeserta .= '"' . $arr_data[$i] . '", ';
                    } else {
                        $sqlTambahPeserta .= '"' . $arr_data[$i] . '") ';
                    }
                }

                switch ($this->conn->query($sqlTambahPeserta)) {
                    case TRUE:
                        $_SESSION['email'] = '';
                        $_SESSION['nama'] = '';
                        $_SESSION['usia'] = '';
                        $_SESSION['jenis'] = '';
                        $_SESSION['pendidikan'] = '';
                        return 'berhasil';
                        break;
                    case FALSE:
                        return 'gagal';
                        break;
                    default:
                        # code...
                        break;
                }
                break;
            case 'select':
                $sqlSelectPeserta       = 'SELECT * FROM peserta WHERE ';
                $sqlSelectPeserta       .= $arr_kolom . '=';
                $sqlSelectPeserta       .= '"' . $arr_data . '"';
                $resultSelectPeserta    = $this->conn->query($sqlSelectPeserta);
                return $resultSelectPeserta;

                #tes
                #return $sqlSelectPeserta;

                break;
            case 'hapus':
                $sqlHapusPeserta       = 'DELETE FROM peserta WHERE ';
                $sqlHapusPeserta       .= $arr_kolom . '=';
                $sqlHapusPeserta       .= '' . $arr_data . '';
                switch ($this->conn->query($sqlHapusPeserta)) {
                    case TRUE:
                        return 'berhasil';
                        break;
                    case FALSE:
                        return 'gagal';
                        break;
                    default:
                        # code...
                        break;
                }
                # code...
                break;
            case 'update':
                $sqlUpdatePeserta   = 'UPDATE peserta SET ';
                $jml                = count($arr_data) - 1;
                for ($i = 0; $i < count($arr_data); $i++) {
                    if ($i != $jml) {
                        $sqlUpdatePeserta .= $arr_kolom[$i] . '="' . $arr_data[$i] . '", ';
                    } else {
                        $sqlUpdatePeserta = substr($sqlUpdatePeserta, 0, -2);
                        $sqlUpdatePeserta .= ' WHERE ' . $arr_kolom[$i] . '="' . $arr_data[$i] . '"';
                    }
                }
                switch ($this->conn->query($sqlUpdatePeserta)) {
                    case TRUE:
                        return 'berhasil';
                        break;
                    case FALSE:
                        return 'gagal';
                        break;
                    default:
                        # code...
                        break;
                }

                //return $sqlUpdatePeserta;
                break;
            case 'login':
                $sqlLogin   = 'SELECT * FROM peserta WHERE ';
                $jml        = count($arr_kolom) - 1;
                for ($i = 0; $i < count($arr_kolom); $i++) {
                    if ($i != $jml) {
                        $sqlLogin .= $arr_kolom[$i] . ' = "' . $arr_data[$i] . '" AND ';
                    } else {
                        $sqlLogin .= $arr_kolom[$i] . ' = "' . $arr_data[$i] . '"';
                    }
                }
                $sqlLogin   .= ' AND status_login = 0';

                $resLogin = $this->conn->query($sqlLogin);
                if ($resLogin->num_rows > 0) {
                    return 'berhasil';
                } else {
                    return 'gagal';
                }

                return $sqlLogin;

                break;

            default:
                # code...
                break;
        }
    }

    function KerjaSoal($soal)
    {
        switch ($soal) {
            case 'soal_1':
                header('location:../kerja_soal/kerja_modul_1');
                break;
            case 'hapalan':
                header('location:../kerja_soal/hapalan');
                break;
            case 'soal_2':
                header('location:../kerja_soal/kerja_modul_2');
                break;
            case 'soal_3':
                header('location:../kerja_soal/kerja_modul_3');
                break;
            case 'soal_4':
                header('location:../kerja_soal/kerja_modul_4');
                break;
            case 'soal_5':
                header('location:../kerja_soal/kerja_modul_5');
                break;
            case 'soal_6':
                header('location:../kerja_soal/kerja_modul_6');
                break;
            case 'soal_7':
                header('location:../kerja_soal/kerja_modul_7');
                break;
            case 'soal_8':
                header('location:../kerja_soal/kerja_modul_8');
                break;
            case 'soal_9':
                header('location:../kerja_soal/kerja_modul_9');
                break;
            case 'soal_10_se':
                header('location:../kerja_soal/kerja_modul_10_se');
                break;
            case 'soal_10_wa':
                header('location:../kerja_soal/kerja_modul_10_wa');
                break;
            case 'soal_10_an':
                header('location:../kerja_soal/kerja_modul_10_an');
                break;
            case 'soal_10_ra':
                header('location:../kerja_soal/kerja_modul_10_ra');
                break;
            case 'soal_10_zr':
                header('location:../kerja_soal/kerja_modul_10_zr');
                break;
            case 'soal_10_ge':
                header('location:../kerja_soal/kerja_modul_10_ge');
                break;
            case 'soal_10_fa':
                header('location:../kerja_soal/kerja_modul_10_fa');
                break;
            case 'soal_10_wu':
                header('location:../kerja_soal/kerja_modul_10_wu');
                break;
            case 'selesai':
                header('location:../kerja_soal/selesai');
                break;
            default:
                header('location:../auth/login?status=1');
                break;
        }
    }

    function InputJawaban($arr_kolom, $arr_data, $status)
    {
        switch ($status) {
            case 'insert':
                $sqlInputJawaban = 'INSERT INTO jawaban_modul (';
                $k_jum   = count($arr_kolom) - 1;
                for ($i = 0; $i < count($arr_kolom); $i++) {
                    if ($i != $k_jum) {
                        $sqlInputJawaban .= $arr_kolom[$i] . ',';
                    } else {
                        $sqlInputJawaban .= $arr_kolom[$i] . ') VALUES (';
                    }
                }
                $d_jum  = count($arr_data) - 1;
                for ($i = 0; $i < count($arr_data); $i++) {
                    if ($i != $d_jum) {
                        $sqlInputJawaban .= '"' . $arr_data[$i] . '",';
                    } else {
                        $sqlInputJawaban .= '"' . $arr_data[$i] . '")';
                    }
                }

                switch ($this->conn->query($sqlInputJawaban)) {
                    case TRUE:
                        return $this->conn->insert_id;
                        break;
                    case FALSE:
                        return 'gagal';
                        break;
                    default:
                        # code...
                        break;
                }

                break;
            case 'update':
                $sqlUpdateJawaban = 'UPDATE jawaban_modul SET ';
                $jum_ = count($arr_kolom) - 1;
                for ($i = 0; $i < count($arr_data); $i++) {
                    if ($i != $jum_) {
                        $sqlUpdateJawaban .= $arr_kolom[$i] . '="' . $arr_data[$i] . '",';
                    } else {
                        $sqlUpdateJawaban = substr($sqlUpdateJawaban, 0, -1);
                        $sqlUpdateJawaban .= ' ' . $arr_kolom[$i] . ' ' . $arr_data[$i] . '';
                    }
                }
                if ($this->conn->query($sqlUpdateJawaban) == TRUE) {
                    return 'berhasil';
                } else {
                    return 'gagal';
                }
                break;
            default:
                # code...
                break;
        }
    }

    function SelModulId($status)
    {
        $id             = '';
        $sqlSelectId    = 'SELECT id FROM soal WHERE ';
        switch ($status) {
            case 'modul_1':
                $sqlSelectId .= 'nama_soal = "Modul 1"';
                break;
            case 'modul_2':
                $sqlSelectId .= 'nama_soal = "Modul 2"';
                break;
            case 'modul_3':
                $sqlSelectId .= 'nama_soal = "Modul 3"';
                break;
            case 'modul_4':
                $sqlSelectId .= 'nama_soal = "Modul 4"';
                break;
            case 'modul_5':
                $sqlSelectId .= 'nama_soal = "Modul 5"';
                break;
            case 'modul_6':
                $sqlSelectId .= 'nama_soal = "Modul 6"';
                break;
            case 'modul_7':
                $sqlSelectId .= 'nama_soal = "Modul 7"';
                break;
            case 'modul_8':
                $sqlSelectId .= 'nama_soal = "Modul 8"';
                break;
            case 'modul_9':
                $sqlSelectId .= 'nama_soal = "Modul 9"';
                break;
            default:
                # code...
                break;
        }

        $resSqlSelectId     = $this->conn->query($sqlSelectId);
        $rowSqlSelectId     = $resSqlSelectId->fetch_assoc();
        return $rowSqlSelectId['id'];
    }


    function KunciJawaban($nama_modul)
    {
        $sqlKunciJawaban = 'SELECT * FROM ' . $nama_modul . '';
        $resKunciJawaban = $this->conn->query($sqlKunciJawaban);
        return $resKunciJawaban;
    }

    function Modul($arr_kolom, $arr_data)
    {
        $sqlSelectModul = 'SELECT * FROM soal WHERE ' . $arr_kolom . ' = "' . $arr_data . '"';
        $resSelectModul = $this->conn->query($sqlSelectModul);
        $rowSelectModul = $resSelectModul->fetch_assoc();
        return $rowSelectModul;
    }

    function JawabanInfo($arr_kolom, $arr_data, $status)
    {
        switch ($status) {
            case 'select':
                $jum_   = count($arr_kolom) - 1;
                $sqlJ   = 'SELECT * FROM jawaban_modul WHERE ';
                for ($i = 0; $i < count($arr_kolom); $i++) {
                    if ($i != $jum_) {
                        $sqlJ .= $arr_kolom[$i] . '="' . $arr_data[$i] . '" AND';
                    } else {
                        $sqlJ .= ' ' . $arr_kolom[$i] . '="' . $arr_data[$i] . '"';
                    }
                }
                $resJ   = $this->conn->query($sqlJ);
                $rowJ   = $resJ->fetch_assoc();
                return $rowJ;

            default:
                # code...
                break;
        }
    }

    function Jawaban($arr_kolom, $arr_data, $status, $modul, $j_modul)
    {
        switch ($status) {
            case 'select':
                switch ($j_modul) {
                    case 'modul_bs':
                        $jum_ = count($arr_kolom) - 1;
                        $sqlJawaban = 'SELECT * FROM ' . $modul . ' WHERE ';
                        for ($i = 0; $i < count($arr_kolom); $i++) {
                            if ($i != $jum_) {
                                $sqlJawaban .= $arr_kolom[$i] . '= "' . $arr_data[$i] . '" AND ';
                            } else {
                                $sqlJawaban .= $arr_kolom[$i] . '= "' . $arr_data[$i] . '"';
                            }
                        }
                        $resJawaban = $this->conn->query($sqlJawaban);
                        $rowJawaban = $resJawaban->fetch_assoc();
                        return $rowJawaban;
                        break;

                    default:
                        # code...
                        break;
                }
            case 'update':
                switch ($j_modul) {
                    case 'modul_bs':
                        $sqlUJawaban    = 'UPDATE ' . $modul . ' SET ';
                        $jum_           = count($arr_kolom) - 1;
                        for ($i = 0; $i < count($arr_kolom); $i++) {
                            if ($i != $jum_) {
                                $sqlUJawaban .= $arr_kolom[$i] . '="' . $arr_data[$i] . '", ';
                            }
                        }
                        $sqlUJawaban = substr($sqlUJawaban, 0, -2);
                        $sqlUJawaban .= ' WHERE ';
                        for ($i = 0; $i < count($arr_kolom); $i++) {
                            if ($i == $jum_) {
                                $sqlUJawaban .= ' ' . $arr_kolom[$i] . '="' . $arr_data[$i] . '"';
                            }
                        }

                        #return $sqlUJawaban;
                        if ($this->conn->query($sqlUJawaban) === TRUE) {
                            return 'berhasil';
                        } else {
                            return 'gagal';
                        }

                        break;

                    default:
                        # code...
                        break;
                }
                break;
            default:
                # code...
                break;
        }
    }


    function Skor($room_id)
    {
        $sqlPeserta = 'SELECT jawaban_modul.*, peserta.nama_peserta as nama_peserta FROM jawaban_modul JOIN peserta ON jawaban_modul.peserta_id=peserta.id WHERE jawaban_modul.room_id="' . $room_id . '"';
        $resPeserta = $this->conn->query($sqlPeserta);
        return $resPeserta;
    }

    function JawabanSel($room_id, $peserta_id)
    {
        $sqlPeserta = 'SELECT jawaban_modul.*, peserta.nama_peserta as nama_peserta FROM jawaban_modul JOIN peserta ON jawaban_modul.peserta_id="' . $peserta_id . '" WHERE jawaban_modul.room_id="' . $room_id . '"';
        $resPeserta = $this->conn->query($sqlPeserta);
        return $resPeserta;
    }

    function JawabanDetail($id_jawaban, $room_id, $peserta_id)
    {
        $sqlPeserta = 'SELECT jawaban_modul.*, peserta.nama_peserta as nama_peserta FROM jawaban_modul JOIN peserta ON jawaban_modul.peserta_id="' . $peserta_id . '" WHERE jawaban_modul.room_id="' . $room_id . '" AND jawaban_modul.id = "' . $id_jawaban . '"';
        $resPeserta = $this->conn->query($sqlPeserta);
        return $resPeserta;
    }

    function D_Jawaban($id_jawaban, $room_id, $peserta_id)
    {
        $sqlPeserta = 'SELECT * FROM jawaban_modul WHERE room_id="' . $room_id . '" AND id = "' . $id_jawaban . '" AND peserta_id = "' . $peserta_id . '"';
        $resPeserta = $this->conn->query($sqlPeserta);
        return $resPeserta;
    }

    function HapusRoom($room_id)
    {
        $sqlHapusPeserta = 'DELETE FROM peserta WHERE room_id=' . $room_id . '';
        if ($this->conn->query($sqlHapusPeserta) === TRUE) {
            $sqlHapusJawaban = 'DELETE FROM jawaban_modul WHERE room_id=' . $room_id . '';
            if ($this->conn->query($sqlHapusJawaban) === TRUE) {
                $sqlHapusRoom = 'DELETE FROM room WHERE id=' . $room_id . '';
                if ($this->conn->query($sqlHapusRoom) === TRUE) {
                    return 'Berhasil';
                } else {
                    return 'Query Hapus Room Bermasalah';
                }
            } else {
                return 'Query Hapus Jawaban Bermasalah';
            }
        } else {
            return 'Query Hapus Peserta Bermasalah';
        }
    }

    function tanggal_indo($tanggal, $cetak_hari = false)
    {
        $hari = array(
            1 =>    'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        );

        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split       = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;
    }
}
