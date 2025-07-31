<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once __DIR__ . '/../../controller/AuthenticationController.php';

$auth_controller = new AuthenticationController();
$admins = $auth_controller->getAdmins();

if (isset($_POST['submit'])) {
  foreach ($admins as $admin) {
    if ($_POST['email'] == $admin['email'] && password_verify($_POST['password'], $admin['password'])) {
      $_SESSION['id'] = $admin['id'];
      $_SESSION['name'] = $admin['name'];
      $_SESSION['email'] = $admin['email'];
      header(header: 'location: ../../index.php');
    } else {
      $error = "Invalid email or password.";
    }
  }
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="../../images/self/TaoTao.png" />
  <link rel="stylesheet" href="../../bootstrap_css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bootstrap_css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3 mx-5">
          <div class="card mb-0">
            <div class="card-body">
              <div class="p-3">
              <div class="d-flex justify-content-center">
                <img src="../../images/self/TaoTao.png" class="w-25 h-25 border rounded-circle" alt="">
              </div>
              <form action="" method="post">
                <div class="mb-4">
                  <label for="" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="" aria-describedby="emailHelp">
                </div>
                <div class="mb-5">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" id="password">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-5">
                  <div class="form-check">
                    <input class="form-check-input bg-dark" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label text-dark" for="flexCheckChecked">
                      Remeber this Device
                    </label>
                  </div>
                  <a class="text-dark fw-bold" href="forgot_password.php">Forgot Password ?</a>
                </div>
                <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
                <button class="btn btn-dark w-100 py-2 mb-4 rounded-2" name="submit">Sign In</button>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-6 mb-0 fw-bold">New to TaoTao?</p>
                  <a class="text-dark fw-bold ms-2" href="register.php">Create an account</a>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../../js/script.js"></script>
</body>

</html>