<?php
switch (isset($_GET['status'])) {
  case 'gagal':
    echo '
        <script>
          alert("Gagal Login Karena\nEmail Atau Password Salah");
        </script>
      ';
    break;

  default:
    # code...
    break;
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOGIN</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/x-icon" href="../../layout/dist/img/favicon.ico">
  <link rel="stylesheet" href="../../layout/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../../layout/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../layout/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#">PSIKOTEST</i></b></a>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login to see Admin Psikotest Dashboard</p>
        <form action="../query/auth_admin" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="email" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <a class="btn btn-primary btn-block float-sm-right" href="daftar_admin">Daftar</a>
            </div>
            <div class="col-md-4">
              <input type="submit" value="Login" class="btn btn-primary btn-block float-sm-right" name="login_admin">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="../../layout/plugins/jquery/jquery.min.js"></script>
  <script src="../../layout/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../layout/dist/js/adminlte.min.js"></script>
</body>

</html>