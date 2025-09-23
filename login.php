<?php
session_start();
error_reporting(E_ALL);
include('lib/cryptography.php');
include('lib/config.php');
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['user'])) {
    header("Location: dashboard");
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    $username = htmlentities(strip_tags($_POST['email']));
    $password = htmlentities(strip_tags($_POST['password']));
    $password = encrypt_decrypt($password, 'encrypt');
    try {
        $query = $con->prepare("SELECT * FROM staffs WHERE email = :username AND password = :password");
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $_SESSION['user'] = $result->email;
            $msg = '<div class="alert alert-success left-icon-alert" role="alert">
                      <strong>Well done!</strong> Login Successful
                      <script>window.location.href = "dashboard"</script>
                    </div>';
        }
        else {
            $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                        <strong>Oh snap!</strong> Invalid credentials, please try again
                    </div>';
        }
    } catch (Exception $e) {
        $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                    <strong>Error: </strong>' . $e->getMessage() . '
                </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NPC | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index" class="h1"><b>NPC</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <?= $msg ?? ""; ?>
      <form action="<?php $_SERVER['PHP_SELF']; ?>" autocomplete="off" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" onclick="showPassword()">
              <label for="remember">
                Show Password
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <p class="mb-1">
        <a href="forgot-password">I forgot my password</a>
      </p> -->
      <p class="mb-0">
        <a href="register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<script type="text/javascript">
      function  showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
        }
        else {
          x.type = "password";
        }
      }
    </script>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
