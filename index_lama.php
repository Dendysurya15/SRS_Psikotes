<?php


session_start();

include 'kumpulan_function.php';

$soal = new Soal();

if (isset($_SESSION['kerja_soal'])) {
    header('location:peserta');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="layout/dist/img/favicon.ico">
    <link rel="stylesheet" href="layout/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="layout/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="layout/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">PSIKOTEST</i></b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"></p>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <a href="peserta/" class="btn btn-primary w-100">Peserta</a>
                    </div>
                    <div class="input-group mb-3">
                        <a href="admin/" class="btn btn-primary w-100">Admin</a>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="layout/plugins/jquery/jquery.min.js"></script>
    <script src="layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="   layout/dist/js/adminlte.min.js"></script>
</body>

</html>