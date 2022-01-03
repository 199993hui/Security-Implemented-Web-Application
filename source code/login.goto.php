<?php
use Phppot\Captcha;
  if(isset($_POST["Submit"]))
  {
    $username = $_POST["user"];
    $pwd = $_POST["password"];

    require_once 'database.php';
    require_once 'Captcha_code.php';
    require_once 'functions.php';
    $captcha=new Captcha();
    $userCaptcha = filter_var($_POST["captcha_code"], FILTER_SANITIZE_STRING);
    $isValidCaptcha = $captcha->validateCaptcha($userCaptcha);
    if($isValidCaptcha){

      if(IncompleteLoginForm($username,$pwd) !== false)
      {
        header("location:../login.php?error=emptyinput");
        exit();
      }

      $error_message="Correct captcha code";
      login($connect,$username,$pwd);
    }
    else
    {
      header("location:../login.php?error=incorrectcaptchacode");
      exit();
    }
  }
  else
  {
    header("location:../Home.php?error=incorrectsubmit");
    exit();
  }
?>
