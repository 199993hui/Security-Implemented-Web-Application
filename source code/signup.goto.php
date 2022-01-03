<?php

use Phppot\Captcha;


if(isset($_POST["submit"]))
{
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $username = $_POST["username"];
  $pwd = $_POST["password"];
  $repeatpwd = $_POST["Repeatpwd"];

  require_once 'database.php';
  require_once 'functions.php';
  require_once 'Captcha_code.php';
  $captcha=new Captcha();
  $userCaptcha = filter_var($_POST["captcha_code"], FILTER_SANITIZE_STRING);
  $isValidCaptcha = $captcha->validateCaptcha($userCaptcha);


  if($isValidCaptcha){
  if(IncompleteSignupForm($name,$email,$phone,$username,$pwd,$repeatpwd) !== false)
  {
    header("location:../signup.php?error=emptyinput");
    exit();
  }
  if(invalidName($name) !== false)
  {
    header("location:../signup.php?error=name");
    exit();
  }
  if(invalidUsername($username) !== false)
  {
    header("location:../signup.php?error=invalidusername");
    exit();
  }
  if(invalidEmail($email) !== false)
  {
    header("location:../signup.php?error=invalidemail");
    exit();
  }
  if(invalidPhone($phone) !== false)
  {
    header("location:../signup.php?error=invalidphone");
    exit();
  }
  if(pwdMatch($pwd,$repeatpwd) !== false)
  {
    header("location:../signup.php?error=passwordsdontmatch");
    exit();
  }
  if(invalidPwd($pwd) !== false)
  {
    header("location:../signup.php?error=invalidpassword");
    exit();
  }

  if(usernameExist($connect,$username,$email,$phone) !== false)
  {
    header("location:../signup.php?error=usernametaken");
    exit();
  }

  $selector = bin2hex(random_bytes(8));
  $token = random_bytes(32);

  $link = "http://cst235assign2/email-verification.php?selector=". $selector ."&validator=" .bin2hex($token);
  $timelimit = date("U") + 300;

  $userEmail = $email;
  $sql = "DELETE FROM Email_verify WHERE Email_verify_Email=?;";
  $stmt = mysqli_stmt_init($connect);
  if (!mysqli_stmt_prepare($stmt,$sql))
  {
    echo "Something went wrong.";
    exit();
  }
  else
  {
    mysqli_stmt_bind_param($stmt,"s", $userEmail);
    mysqli_stmt_execute($stmt);
  }

  $sql = "INSERT INTO Email_verify (Email_verify_Email, Email_verify_Selector, Email_verify_Token,	Email_verify_Expires, UsersName, UsersEmail, UsersPhone, UsersUserName, UsersPwd) VALUES (?,?,?,?,?,?,?,?,?);";

  if (!mysqli_stmt_prepare($stmt,$sql))
  {
    echo "Something went wrong.";
    exit();
  }
  else
  {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $Hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"sssssssss", $userEmail, $selector, $hashedToken, $timelimit,$name,$email,$phone,$username,$Hashedpwd);
    mysqli_stmt_execute($stmt);
  }

  mysqli_stmt_close($stmt);
  mysqli_close();

  $to = $userEmail;
  $subject = 'Once_Notepad : Email verification';
  $message = '<p>Hello, "'.$name.'",</p>Thank you for choosing our system. Please confirm your email address to finish your account creation process.</p>';
  $message .= '<p>Here is your email verification link</br>';
  $message .= '<a href="'. $link . '">' . $link . '</a></p>';

  $headers ="From: CST235 assign2 <cst235assign2@gmail.com>\r\n";
  $headers .= "Reply-To: cst235assign2@gmail.com\r\n";
  $headers .= "Content-type: text/html\r\n";

  mail($to, $subject, $message, $headers);
  header("location:../Signup.php?error=success");
  }
  else{
    $error_message = "Incorrect Captcha Code";
    header("location:../Signup.php?error=incorrectcaptchacode");
    exit();
  }
}
else
{
  header("location:../Signup.php?error=incorrectsubmit");
  exit();
}
?>
