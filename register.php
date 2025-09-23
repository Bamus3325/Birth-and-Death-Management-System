<?php
session_start();
error_reporting(E_ALL);
include('lib/cryptography.php');
include('lib/config.php');
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_SESSION['user'])) {
    header("Location: dashboard");
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])) {
  $uniq_id = htmlentities(md5(uniqid()));
  $fnam = htmlentities(strip_tags($_POST['fnam']));
  $lnam = htmlentities(strip_tags($_POST['lnam']));
  $email = htmlentities(strip_tags($_POST['email']));
  $password = htmlentities(strip_tags($_POST['password']));
  $password = encrypt_decrypt($password, 'encrypt');
  $sql = $con->prepare("SELECT * FROM staffs WHERE email = :email");
  $sql->bindParam(':email', $email, PDO::PARAM_STR);
  $sql->execute();
  $sql->fetch(PDO::FETCH_OBJ);
  if ($sql->rowCount() > 0) {
    // code...
    $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
              <strong>Oh snap!</strong> Account already exist
            </div>';
  }
  else {
    $filename = basename($_FILES['image']['name']);
    $filetype = $_FILES['image']['type'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $extensions = array("image/jpeg", "image/png");
    $image = $uniq_id . "." . $ext;
    $attachments = 'img/' . $image;
    if (!empty($filename) && in_array($filetype, $extensions)) {
      if (($_FILES['image']["size"] > 2000000)) {
          $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                    <strong>Oh snap!</strong> Image size exceeds 2MB
                  </div>';
      }
      else {
        $query = $con->prepare("INSERT INTO staffs (fnam, lnam, email, password, dp) VALUES (:fnam, :lnam, :email, :password, :image)");
        $query->bindParam(':fnam', $fnam, PDO::PARAM_STR);
        $query->bindParam(':lnam', $lnam, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':image', $image, PDO::PARAM_STR);
        $query->execute();
        if ($con->lastInsertId() && move_uploaded_file($_FILES['image']['tmp_name'], $attachments)) {
          $_SESSION['user'] = $email;
          $msg = "<div class=\"alert alert-success left-icon-alert\" role=\"alert\">
                    <strong>Well done!</strong> Registration successful
                    <script>window.location.href = \"dashboard\"</script>
                  </div>";
        }
        else {
            $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                      <strong>Oh snap!</strong> Something went wrong, please try again
                    </div>';
        }
      }
    }
    else {
        $msg = '<div class="alert alert-danger left-icon-alert" role="alert">
                  <strong>Oh snap!</strong> Invalid file format
                </div>';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NPC | Registration</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index" class="h1"><b>NPC</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>
      <?= $msg ?? ""; ?>
      <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="fnam" placeholder="Firstname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="lnam" placeholder="Lastname">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="cpassword" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="file" name="image" class="form-control" title="Image">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" onclick="showPassword()" name="terms" value="agree">
              <label for="agreeTerms">
               Show Password
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <a href="login" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->
<script type="text/javascript">
      function  showPassword() {
        var x = document.getElementById("password");
        var y = document.getElementById("cpassword");
        if (x.type === "password" && y.type === "password") {
          x.type = "text";
          y.type = "text";
        }
        else {
          x.type = "password";
          y.type = "password";
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
