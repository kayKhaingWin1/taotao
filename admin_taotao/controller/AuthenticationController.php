<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once __DIR__ . '/../model/Authentication.php';
include_once __DIR__ . '/../vendor/PhpMailer/src/Exception.php';
include_once __DIR__ . '/../vendor/PhpMailer/src/PHPMailer.php';
include_once __DIR__ . '/../vendor/PhpMailer/src/SMTP.php';

class AuthenticationController {
    private $auth;
    function __construct()
    {
        $this->auth = new Authentication();
    }

    public function authentication()
    {
        if(!isset($_SESSION['id'])){
            header('location: ../dashboard/login.php');
        }
    }

    public function createAdmin($name, $email, $password)
    {
        return $this->auth->createAdmin($name, $email, $password);
    }
    
    public function emailExists($email):bool
    {
        return $this->auth->emailExists($email);
    }

    public function getAdmins()
    {
        return $this->auth->getAdmins();
    }

    public function getAdmin($id)
    {
        return $this->auth->getAdmin($id);
    }

    public function otpVerify($email){
    
    $otp = rand(100000, 999999); 
    $subject = "Your OTP Code for Verification";
    $body = "Your OTP code is: $otp";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;
        $mail->Username = 'helilin15@gmail.com'; 
        $mail->Password = 'nkhq krvt kjra otdf';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('helilin15@gmail.com', 'TaoTao Admin');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

       
        $mail->send();
        return $otp;  
    } catch (Exception $e) {
       
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
    }

    public function editPassword($password, $id)
    {
        return $this->auth->editPassword($password, $id);
    }

    public function updatePassword($password, $email)
    {
        return $this->auth->updatePassword($password, $email);
    }
}

?>