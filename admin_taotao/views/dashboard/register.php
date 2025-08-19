<?php
// session_start();
// include_once __DIR__ . '/../../controller/AuthenticationController.php';

// $auth_controller = new AuthenticationController();
// $admins = $auth_controller->getAdmins();

// $name_error = $email_error = $password_error = $conPass_error = $error = "";

// if (isset($_POST['submit'])) {
//   $name = $_POST['name'];
//   $email = $_POST['email'];
//   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//   $con_password = $_POST['con_password'];

//   if (empty($name)) {
//     $name_error = "Please enter your name";
//   }
//   if (empty($email)) {
//     $email_error = "Please enter your email";
//   }
//   if (empty($password)) {
//     $password_error = "Please enter your password";
//   }
//   if (empty($con_password)) {
//     $conPass_error = "Please enter your confirm password";
//   }

//   if ($_POST['password'] != $_POST['con_password']) {
//     $error = 'Password and Confirm Password do not match.';
//   } else {
//     foreach ($admins as $admin) {
//       if ($email == $admin['email']) {
//         $error = "User with this email already exists.";
//       } else {
//         $otp = $auth_controller->otpVerify($email);
//         if (!empty($otp)) {
//           $_SESSION['otp'] = $otp;
//           $_SESSION['name'] = $name;
//           $_SESSION['email'] = $email;
//           $_SESSION['password'] = $password;
//           header('location: otp_verify.php');
//           exit;
//         }
//       }
//     }
//   }
// }


?>
<?php
session_start();
include_once __DIR__ . '/../../controller/AuthenticationController.php';

$auth_controller = new AuthenticationController();
$admins = $auth_controller->getAdmins();


$name_error = $email_error = $password_error = $conPass_error = $error = "";

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $con_password = $_POST['con_password'];

  $emailExists = $auth_controller->emailExists($email);


  // if (empty($name)) {
  //   $name_error = "Please enter your name";
  // }
  // if (empty($email)) {
  //   $email_error = "Please enter your email";
  // }
  // if (empty($password)) {
  //   $password_error = "Please enter your password";
  // }
  // if (empty($con_password)) {
  //   $conPass_error = "Please enter your confirm password";
  // }

  // if ($password !== $con_password) {
  //   $error = "Password and Confirm Password do not match.";
  // } else {

  //   $emailExists = false;
  //   foreach ($admins as $admin) {
  //     if ($email == $admin['email']) {
  //       $emailExists = true;
  //       break;
  //     }
  //   }

  //   if ($emailExists) {
  //     $error = "User with this email already exists.";
  //   } else {
  //     $otp = $auth_controller->otpVerify($email); 

  //     if (!empty($otp)) {
  //       $_SESSION['otp'] = $otp;
  //       $_SESSION['email'] = $email;
  //       $_SESSION['name'] = $name;
  //       $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT); 

  //       header("Location: otp_verify.php");
  //       exit();
  //     } else {
  //       echo "<script>alert('Failed to send OTP. Please try again.');</script>";
  //     }
  //   }

  // }
  if (empty($name)) {
    $name_error = "Please enter your name";
  }
  if (empty($email)) {
    $email_error = "Please enter your email";
  }
  if (empty($password)) {
    $password_error = "Please enter your password";
  }
  if (empty($con_password)) {
    $conPass_error = "Please enter your confirm password";
  }

  if ($password !== $con_password) {
    $error = "Password and Confirm Password do not match.";
  }

  if (
    empty($name_error) && empty($email_error) &&
    empty($password_error) && empty($conPass_error) &&
    empty($error)
  ) {
    $emailExists = false;
    foreach ($admins as $admin) {
      if ($email == $admin['email']) {
        $emailExists = true;
        break;
      }
    }

    if ($emailExists) {
      $error = "User with this email already exists.";
    } else {
      $otp = $auth_controller->otpVerify($email);

      if (!empty($otp)) {
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);

        header("Location: otp_verify.php");
        exit();
      } else {
        echo "<script>alert('Failed to send OTP. Please try again.');</script>";
      }
    }
  }
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TaoTao</title>
  <link rel="shortcut icon" type="image/png" href="../../images/self/TaoTao.png" />
  <link rel="stylesheet" href="../../bootstrap_css/bootstrap.min.css">
  <link rel="stylesheet" href="../../bootstrap_css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0">
            <div class="card-body">
              <div class="d-flex justify-content-center">
                <img src="../../images/self/TaoTao.png" class="w-25 h-25 border rounded-circle" alt="">
              </div>

              <form action="" method="post">
                <div class="mb-3">
                  <label for="" class="form-label">Name</label>
                  <input type="text" name="name" class="form-control" id="" aria-describedby="textHelp">
                  <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Email Address</label>
                  <input type="email" name="email" class="form-control" id="" aria-describedby="emailHelp">
                  <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                </div>
                <div class="mb-4">
                  <label for="" class="form-label">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" id="password">
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                  <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                </div>
                <div class="mb-4">
                  <label for="" class="form-label">Confirm Password</label>
                  <div class="input-group">
                    <input type="password" name="con_password" class="form-control" id="con_password">
                    <button type="button" class="btn btn-outline-secondary" id="toggleConPassword">
                      <i class="bi bi-eye"></i>
                    </button>
                  </div>
                  <span class="text-danger"><?php if (isset($conPass_error)) echo $conPass_error; ?></span>
                </div>
                <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
                <button class="btn btn-dark w-100 py-2 mb-4 rounded-2 " name="register">Sign Up</button>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-6 mb-0 fw-bold">Already have an Account?</p>
                  <a class="text-dark fw-bold ms-2" href="login.php">Sign In</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../../js/script.js"></script>

</body>

</html>