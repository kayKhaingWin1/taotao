<?php
ob_start();
session_name('user');
session_start();

// 增强调试日志
error_log("[OTP_DEBUG] Session ID: " . session_id());
error_log("[OTP_DEBUG] Session Data: " . print_r($_SESSION, true));
error_log("[OTP_DEBUG] POST Data: " . print_r($_POST, true));

include_once __DIR__ . '/controller/AuthenticationController.php';

$error = "";
$auth_controller = new AuthenticationController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $missing = [];
  $required_vars = ['otp', 'name', 'email', 'password'];
  foreach ($required_vars as $var) {
    if (empty($_SESSION[$var])) {
      $missing[] = $var;
    }
  }

  if (!empty($missing)) {
    $error = "Session expired. Missing: " . implode(', ', $missing);
    error_log("[OTP_ERROR] $error");
  } elseif (!isset($_POST['otp']) || !is_numeric($_POST['otp'])) {
    $error = "Invalid OTP format";
  } elseif ((string)$_POST['otp'] === (string)$_SESSION['otp']) {
    error_log("[OTP_DEBUG] OTP验证成功，开始创建用户");

    $user_id = $auth_controller->createUserAndGetId(
      $_SESSION['name'],
      $_SESSION['email'],
      $_SESSION['password']
    );

    if ($user_id) {
      error_log("[OTP_SUCCESS] 用户创建成功，ID: $user_id");
      $_SESSION['id'] = $user_id;
      $_SESSION['verified'] = true;

      unset($_SESSION['otp'], $_SESSION['password']);

      ob_end_clean();
      header('Location: index.php');
      exit;
    } else {
      $error = "Account creation failed. Please contact support.";
      error_log("[OTP_ERROR] 用户创建失败");
    }
  } else {
    $error = "Invalid OTP code. Please try again.";
    error_log("[OTP_ERROR] OTP不匹配，输入: " . $_POST['otp'] . "，预期: " . $_SESSION['otp']);
  }
}
ob_end_flush();
?>
<!doctype html>
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
  body {
    background-image: url(images/register_bg.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: top;
    background-attachment: fixed;
  }

  .login_formbg {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(5px);
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
  }

  h2,
  label {
    color: rgb(209, 186, 130);
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
    color: rgb(209, 186, 130);
    padding: 20px 45px 20px 20px;
  }

  .input_group input::placeholder {
    color: rgb(209, 186, 130);
  }

  .input_group i {
    position: absolute;
    right: 14px;
    top: 11px;
    font-size: 1.1rem;
    color: rgb(209, 186, 130);
  }

  .submit_btn button {
    width: 85%;
    border-radius: 40px;
    background-color: brown;
    color: white;
  }

  .submit_btn button:hover {
    background-color: rgb(98, 26, 26);
    color: white;
  }
</style>

<body>
  <div class="login_container ms-5 d-flex justify-content-center align-items-center" style="height:100vh">
    <div class="p-4 py-5 login_formbg col-md-4 col-8" style="border-radius:20px;">
      <div class="text-center">
        <h2>OTP Verify</h2>
      </div>
      <form action="" method="post" class="m-4">
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger mb-3">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <div class="mb-3 input_group">
          <input type="number" name="otp" required placeholder="OTP Code">
          <i class="bi bi-shield-lock"></i>
        </div>

        <div class="submit_btn d-flex justify-content-center">
          <button type="submit" class="btn mb-2" name="submit">Submit</button>
        </div>
      </form>
</body>