<?php
session_name('user');
session_start();
include_once __DIR__ . '/controller/AuthenticationController.php';

$auth_controller = new AuthenticationController();
$users = $auth_controller->getUsers();

$name_error = $email_error = $password_error = $conPass_error = $error = "";
$name_value = $email_value = "";

if (isset($_POST['submit'])) {
  $name_value = $_POST['name'];
  $email_value = $_POST['email'];
  $password = $_POST['password'];
  $con_password = $_POST['con_password'];

  $name_error = $email_error = $password_error = $conPass_error = $error = "";

  if (empty($name_value)) {
    $name_error = "Please enter your name";
  }

  if (empty($email_value)) {
    $email_error = "Please enter your email";
  } elseif (!filter_var($email_value, FILTER_VALIDATE_EMAIL)) {
    $email_error = "Please enter a valid email address";
  } else {
    $emailExists = false;
    foreach ($users as $user) {
      if ($email_value == $user['email']) {
        $emailExists = true;
        break;
      }
    }
    if ($emailExists) {
      $email_error = "This email is already registered";
    }
  }

  if (empty($password)) {
    $password_error = "Please enter your password";
  } elseif (strlen($password) < 8) {
    $password_error = "Password must be at least 8 characters";
  }

  if (empty($con_password)) {
    $conPass_error = "Please confirm your password";
  }

  if (empty($name_error) && empty($email_error) && empty($password_error) && empty($conPass_error)) {
    if ($password != $con_password) {
      $error = 'Password and Confirm Password do not match.';
    } else {
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);
      $otp = $auth_controller->otpVerify($email_value);

      if (!empty($otp)) {
        $_SESSION['otp'] = $otp;
        $_SESSION['name'] = $name_value;
        $_SESSION['email'] = $email_value;
        $_SESSION['password'] = $hashed_password;
        header('location: otp_verify.php');
        exit;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="my_css/style.css">
</head>



<style>
  #bg-video {
    position: fixed;
    top: 50%;
    left: 50%;
    height: 100vw;
    transform: translate(-50%, -50%);
    z-index: -1;
    object-fit: cover;
  }


  .login_formbg {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
  }

  h2,
  label {
    color: white;
  }

  .input_group {
    position: relative;
    width: 100%;
    height: 50px;
  }

  .input_group input {
    background: transparent;
    border: none;
    outline: none;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 40px;
    width: 100%;
    height: 100%;
    font-size: 1.01rem;
    color: white;
    padding: 20px 45px 20px 20px;
  }

  .input_group input::placeholder {
    color: white;
  }

  .input_group i {
    position: absolute;
    right: 14px;
    top: 11px;
    font-size: 1.1rem;
    color: white;
  }

  .error-message {
    display: block;
    margin-bottom: 15px;
    font-size: 0.8rem;
    padding-left: 20px;
  }

  .forgot_group input {
    accent-color: #fff;
    margin-right: 3px;
  }

  .forgot_group label {
    font-size: 0.8rem;
    margin-right: 20px;
  }

  .forgot_group a {
    font-size: 0.8rem;
    margin: 2px;
  }

  .submit_btn {
    width: 100%;
    border-radius: 40px;
    background-color: black;
    color: white;
  }

  .submit_btn:hover {
    background-color: #323232;
    color: white;
  }
</style>

<body>
  <video autoplay muted loop id="bg-video">
    <source src="https://ia803103.us.archive.org/2/items/bg-video1/bg-video1.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>

  <div class="login_container ms-5 d-flex justify-content-center align-items-center" style="height:100vh">
    <div class="p-4 py-5 login_formbg col-md-4 col-8" style="border-radius:20px;">
      <div class="text-center">
        <h2>Registration</h2>
      </div>
      <form action="" method="post" class="m-4">
        <div class="mb-3 input_group">
          <input type="text" name="name" id="" placeholder="Name" value="<?php echo htmlspecialchars($name_value); ?>">
          <i class="bi bi-person fs-5"></i>
          <span class="text-danger error-message"><?php if (isset($name_error)) echo $name_error; ?></span>
        </div>
        <div class="mb-3 input_group">
          <input type="email" name="email" id="" aria-describedby="emailHelp" placeholder="Email" value="<?php echo htmlspecialchars($email_value); ?>">
          <i class="bi bi-envelope-at"></i>
          <span class="text-danger error-message"><?php if (isset($email_error)) echo $email_error; ?></span>
        </div>

        <div class="mb-3">
          <div class="input_group">
            <input type="password" name="password" id="password" placeholder="Password">
            <i class="bi bi-eye"></i>
            <span class="text-danger error-message"><?php if (isset($password_error)) echo $password_error; ?></span>
          </div>
        </div>

        <div class="mb-3">
          <div class="input_group">
            <input type="password" name="con_password" id="password" placeholder="Confirm Password">
            <i class="bi bi-eye"></i>
            <span class="text-danger error-message"><?php if (isset($conPass_error)) echo $conPass_error; ?></span>
          </div>
        </div>
        <span class="text-danger error-message"><?php if (isset($error)) echo $error; ?></span>
        <button class="btn mb-2 submit_btn" name="submit">Sign Up</button>
        <div class="d-flex align-items-center justify-content-center">
          <p class="mb-0 fw-medium text-light" style="font-size:0.9rem;margin-top:2px;">Already have an Account?</p>
          <a class="ms-2 text-dark fw-bold" style="font-size:0.9rem" href="login.php">Sign In</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>