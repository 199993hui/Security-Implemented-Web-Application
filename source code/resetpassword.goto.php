<?php
  if(isset($_POST["resertpassword-submit"]))
  {
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $link = "http://cst235assign2/create-new-password.php?selector=". $selector ."&validator=" .bin2hex($token);
    $timelimit = date("U") + 1800;

    require "database.php";
    require_once 'functions.php';
    $userEmail = $_POST["email"];
    if(check_valid_to_email($connect,$userEmail) === false)
    {
      header("location:../resetpassword.php?reset=exceedlimit");
    }
    else
    {
      $sql = "DELETE FROM resetpwd WHERE ResetpwdEmail=?;";
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

      $sql = "INSERT INTO resetpwd (ResetpwdEmail, ResetpwdSelector, ResetpwdToken,	ResetpwdExpires) VALUES (?,?,?,?);";

      if (!mysqli_stmt_prepare($stmt,$sql))
      {
        echo "Something went wrong.";
        exit();
      }
      else
      {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt,"ssss", $userEmail, $selector, $hashedToken, $timelimit);
        mysqli_stmt_execute($stmt);
      }

      mysqli_stmt_close($stmt);

      $to = $userEmail;
      $subject = 'Once_Notepad : Reset your password';
      $message = '<p>We recieved a password reset request. The link to reset your password reset your password is below if you did not make this request, you can ignore this email.</p>';
      $message .= '<p>Here is your password reset link</br>';
      $message .= '<a href="'. $link . '">' . $link . '</a></p>';

      $headers ="From: CST235 assign2 <cst235assign2@gmail.com>\r\n";
      $headers .= "Reply-To: cst235assign2@gmail.com\r\n";
      $headers .= "Content-type: text/html\r\n";

      mail($to, $subject, $message, $headers);
      header("location:../resetpassword.php?reset=success");
    }

  }
  else {
    header("location:../resetpassword.php?reset=tmtfailedt");
  }
 ?>
