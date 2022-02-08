<?php
include_once '../layout/header.php';

include '../../kumpulan_function.php';
$soal = new Soal();


$resultDaftarRoom = $soal->DaftarRoom();

$resPeserta       = $soal->Peserta('id', $_SESSION['i_peserta'], 'select');
$rowPeserta       = $resPeserta->fetch_assoc();

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 0:
            echo '
                    <script>
                        var html = "Gagal menyimpan biodata peserta!";
                        alert(html);
                    </script>                
                ';
            break;
        default:
            # code...
            break;
    }
}
?>

<?php

?>

<style>
    input[type=number] {
        width: 100%;
        height: unset;
        box-sizing: border-box;
        font-size: unset;
    }
</style>

<body class="hold-transition unselectable sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="hover"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link">Selamat datang <?= $rowPeserta['nama_peserta'] ?>!</a>
                </li>

            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-none d-sm-inline-block">
                    <a class="nav-link"></a>
                </li>
            </ul>

        </nav>
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="" class="brand-link">
                <img src="../../layout/dist/img/CBI-logo.png" alt="Covid Tracker" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PSIKOTEST</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="../auth/logout" onclick="return confirm('Logout berarti anda telah selesai melakukan psikotes\ndan anda tidak melakukan login kembali! apakah anda yakin?')" class="nav-link">
                                <i class="nav-icon fa fa-window-close"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">

            <section class="content pt-3">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class=" text-bold">Biodata Peserta Psikotes </h4>
                            <span style="font-size: 15px; color: #84757D;">
                                Silahkan isi form berikut ini dengan benar sebelum memulai mengerjakan soal psikotes.
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="../query/peserta_query" method="POST">
                                <input type="text" name="status_test" value="<?= $_SESSION['status_test'] ?>" hidden>
                                <input type="text" name="id_peserta" value="<?= $_SESSION['i_peserta'] ?>" hidden>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput1" style="font-weight: 400;">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan nama" value="<?php if (isset($_SESSION['getNama'])) { ?><?php echo $_SESSION['getNama'];
                                                                                                                                                                                            unset($_SESSION['getNama']);
                                                                                                                                                                                        } ?>" name="nama_lengkap">
                                        <small class=" text-danger "><?php if (isset($_SESSION['namaErr'])) { ?>
                                                *<?php echo $_SESSION['namaErr'];
                                                                            unset($_SESSION['namaErr']);
                                                                        } ?></small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="exampleFormControlInput1" style="font-weight: 400;">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : Bandung" value="<?php if (isset($_SESSION['getTempatlahir'])) { ?><?php echo $_SESSION['getTempatlahir'];
                                                                                                                                                                                                        unset($_SESSION['getTempatlahir']);
                                                                                                                                                                                                    } ?>" name="tempat_lahir">
                                        <small class=" text-danger "><?php if (isset($_SESSION['tempat_lahirErr'])) { ?>
                                                *<?php echo $_SESSION['tempat_lahirErr'];
                                                                            unset($_SESSION['tempat_lahirErr']);
                                                                        } ?></small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4" style="font-weight: 400;">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="exampleFormControlInput1" value="<?php if (isset($_SESSION['getTanggallahir'])) { ?><?php echo $_SESSION['getTanggallahir'];
                                                                                                                                                                        unset($_SESSION['getTanggallahir']);
                                                                                                                                                                    } ?>" name="tanggal_lahir">
                                        <small class=" text-danger "><?php if (isset($_SESSION['tanggal_lahirErr'])) { ?>
                                                *<?php echo $_SESSION['tanggal_lahirErr'];
                                                                            unset($_SESSION['tanggal_lahirErr']);
                                                                        } ?></small>
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label for="exampleFormControlInput1" style="font-weight: 400;">Jenis Kelamin</label>
                                        <?php
                                        if (isset($_SESSION['getGender'])) {
                                            $gender = $_SESSION['getGender'];
                                            unset($_SESSION['getGender']);
                                        } ?>
                                        <div class="row ml-2">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" name="gender" <?php if (isset($gender) && $gender == 'Laki-laki') { ?> checked="checked" <?php } ?> value="Laki-laki" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline1" style="font-weight: 400;">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" name="gender" <?php if (isset($gender) && $gender == 'Perempuan') { ?> checked="checked" <?php } ?> class="custom-control-input" value="Perempuan">
                                                <label class="custom-control-label" for="customRadioInline2" style="font-weight: 400;">Perempuan</label>
                                            </div>
                                        </div>
                                        <small class=" text-danger "><?php if (isset($_SESSION['genderErr'])) { ?>
                                                *<?php echo $_SESSION['genderErr'];
                                                                            unset($_SESSION['genderErr']);
                                                                        } ?></small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4" style="font-weight: 400;">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : S1" value="<?php if (isset($_SESSION['getPendidikanpeserta'])) { ?><?php echo $_SESSION['getPendidikanpeserta'];
                                                                                                                                                                                                        unset($_SESSION['getPendidikanpeserta']);
                                                                                                                                                                                                    } ?>" name="pendidikan_peserta">
                                        <small class=" text-danger "><?php if (isset($_SESSION['pendidikan_pesertaErr'])) { ?>
                                                *<?php echo $_SESSION['pendidikan_pesertaErr'];
                                                                            unset($_SESSION['pendidikan_pesertaErr']);
                                                                        } ?></small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4" style="font-weight: 400;">Jurusan/Program Studi</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : Pendidikan Bahasa Arab" value="<?php if (isset($_SESSION['getJurusan'])) { ?><?php echo $_SESSION['getJurusan'];
                                                                                                                                                                                                                    unset($_SESSION['getJurusan']);
                                                                                                                                                                                                                } ?>" name="jurusan">
                                        <small class=" text-danger "><?php if (isset($_SESSION['jurusanErr'])) { ?>
                                                *<?php echo $_SESSION['jurusanErr'];
                                                                            unset($_SESSION['jurusanErr']);
                                                                        } ?></small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4" style="font-weight: 400;">Posisi yang dituju/dilamar</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : Administrasi" value="<?php if (isset($_SESSION['getPosisiygdilamar'])) { ?><?php echo $_SESSION['getPosisiygdilamar'];
                                                                                                                                                                                                                unset($_SESSION['getPosisiygdilamar']);
                                                                                                                                                                                                            } ?>" name="posisi_yg_dilamar">
                                        <small class=" text-danger "><?php if (isset($_SESSION['posisi_yg_dilamarErr'])) { ?>
                                                *<?php echo $_SESSION['posisi_yg_dilamarErr'];
                                                                            unset($_SESSION['posisi_yg_dilamarErr']);
                                                                        } ?></small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4" style="font-weight: 400;">Kontak Pribadi</label>
                                        <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Contoh : 08123982XXXX" value="<?php if (isset($_SESSION['getKontakpribadi'])) { ?><?php echo $_SESSION['getKontakpribadi'];
                                                                                                                                                                                                                unset($_SESSION['getKontakpribadi']);
                                                                                                                                                                                                            } ?>" name="kontak_pribadi">
                                        <small class=" text-danger "><?php if (isset($_SESSION['kontak_pribadiErr'])) { ?>
                                                *<?php echo $_SESSION['kontak_pribadiErr'];
                                                                            unset($_SESSION['kontak_pribadiErr']);
                                                                        } ?></small>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2 float-sm-right" onclick="return confirmSubmit()" name="store_biodata">Submit Biodata</button>

                            </form>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
    </div>
</body>
<!-- jQuery -->
<script src="../../layout/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../layout/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="../../layout/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../layout/dist/js/demo.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<!-- page script -->
<script src="../../layout/dist/js_tabel/jquery.dataTables.min.js"></script>
<script src="../../layout/dist/js_tabel/dataTables.buttons.min.js"></script>

<script>
    $("body").on("contextmenu", function(e) {
        return false;
    });

    function confirmSubmit() {
        if (confirm("Apakah biodata anda sudah benar? Pastikan tidak ada kesalahan dalam input data")) {
            window.location('../query/peserta_query.php')
        } else {
            return false;
        }
    }

    var currSeconds = 0;
    var link = document.createElement("a");


    /* kode awal idle mode 30 menit */
    let idleInterval =
        setInterval(timerIncrement, 1000);

    /* Zero the idle timer
        on mouse movement */
    $(this).mousemove(resetTimer);
    $(this).keypress(resetTimer);


    function resetTimer() {

        /* Hide the timer text */
        document.querySelector(".timertext")
            .style.display = 'none';

        currSeconds = 0;
    }

    function timerIncrement() {
        currSeconds = currSeconds + 1;

        if (currSeconds == 1800) {
            link.href = "../auth/logout"
            link.click()
            alert("Anda tidak melakukan akitivitas apapun selama 30 menit, mohon maaf anda dikeluarkan dari tes ini!")
        }

        /* Set the timer text to
            the new value */
        document.querySelector(".secs")
            .textContent = currSeconds;

        /* Display the timer text */
        document.querySelector(".timertext")
            .style.display = 'block';
    }
    // kode akhir idle mode 30 menit
</script>


<style>
    .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
</style>