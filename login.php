<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_name('user');
session_start();
include_once __DIR__ . '/controller/AuthenticationController.php';

$auth_controller = new AuthenticationController();
$users = $auth_controller->getUsers();

if (isset($_POST['submit'])) {
   
    if (empty($_POST['email']) && empty($_POST['password'])) {
        $error = "Please fill email and password";
    } elseif (empty($_POST['email'])) {
        $error = "Please fill email";
    } elseif (empty($_POST['password'])) {
        $error = "Please fill password";
    } else {
        $credentials_valid = false;
        foreach ($users as $user) {
            if ($_POST['email'] == $user['email'] && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                header('location: index.php');
                $credentials_valid = true;
                break;
            }
        }
        if (!$credentials_valid) {
            $error = "Invalid email or password.";
        }
    }
}
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
#bg-video {
  position: fixed;
  top: 50%;
  left: 50%;
  height: 100vw;
  transform: translate(-50%, -50%) rotate(-90deg);
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
        background-color:#323232;
        color: white;
    }
</style>

<body>
    <video autoplay muted loop id="bg-video">
        <source src="https://ia903103.us.archive.org/2/items/bg-video1/bg-video.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="login_container ms-5 d-flex justify-content-center align-items-center" style="height:100vh">
        <div class="p-4 py-5 login_formbg col-md-4" style="height:75%;border-radius:20px;">
            <div class="text-center">
                <h2>Login</h2>
            </div>
            <form action="" method="post" class="m-4">
                <div class="mb-3 input_group">
                    <input type="email" name="email" id="" aria-describedby="emailHelp" placeholder="Email">
                    <i class="bi bi-envelope-at"></i>
                </div>

                <div class="mb-3">
                    <div class="input_group">
                        <input type="password" name="password" id="password" placeholder="Password">
                        <i class="bi bi-eye"></i>
                    </div>
                </div>

                <div class="forgot_group d-flex justify-content-between mb-2">
                    <div class="form-check">
                        <input type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label text-light" for="flexCheckChecked">
                            Remeber this Device
                        </label>
                    </div>
                    <a class="fw-bold" href="forgot_password.php" style="color:rgb(209, 186, 130);">Forgot Password ?</a>
                </div>

                <span class="text-danger"><?php if (isset($error)) echo $error; ?></span>
                <button class="btn mb-2 submit_btn" name="submit">Sign In</button>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="mb-0 fw-medium text-light" style="font-size:0.9rem;margin-top:2px;">New to TaoTao?</p>
                    <a class="ms-2" style="color:rgb(209, 186, 130);" style="font-size:0.9rem" href="register.php">Create an account</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../../src/js/script.js"></script>
</body>

</html>