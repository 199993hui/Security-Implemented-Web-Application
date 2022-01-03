<?php
include_once 'functions.php';
  if(isset($_POST["resetpwdsubmit"]))
  {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["Pwd"];
    $repeatpassword = $_POST["Repeatpwd"];


    if(empty($password)|| empty($repeatpassword))
    {
      header("location:../create-new-password.php?error=newpwd-empty&selector=". $selector ."&validator=" .$validator);
      exit();
    }
    else if($password != $repeatpassword)
    {
      header("location:../create-new-password.php?error=newpwdnotmatch&selector=". $selector ."&validator=" .$validator);
      exit();
    }
    else if(invalidPwd($password) !== false)
    {
      header("location:../create-new-password.php?error=invalidpassword&selector=". $selector ."&validator=" .$validator);
      exit();
    }
    $currentDate = date("U");

    require 'database.php';
    $sql = "SELECT * FROM resetpwd WHERE ResetpwdSelector = ? AND ResetpwdExpires >= ?";
    $stmt = mysqli_stmt_init($connect);
    if (!mysqli_stmt_prepare($stmt,$sql))
    {
      echo ("Something went wrong!You need to re-submit your reset request.");
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt,"ss", $selector,$currentDate);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      if(!$rowData = mysqli_fetch_assoc($result))
      {
        echo ("You need to re-submit your reset request.");
        exit();
      }
      else
      {
        $tokenBin = hex2bin($validator);
        $checktoken = password_verify($tokenBin, $rowData["ResetpwdToken"]);

        if($checktoken === false)
        {
          echo ("You need to re-submit your reset request.");
          exit();
        }
        else if ($checktoken === true)
        {
          $tokenEmail = $rowData["ResetpwdEmail"];

          $sql = "SELECT * FROM users WHERE UsersEmail = ?;";
          $stmt = mysqli_stmt_init($connect);
          if (!mysqli_stmt_prepare($stmt,$sql))
          {
            echo ("Something went wrong!You need to re-submit your reset request.");
            exit();
          }
          else
          {
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(!$rowData = mysqli_fetch_assoc($result))
            {
              header("location:../Signup.php?reset=wrong");
              exit();
            }
            else
            {
              $sql = "UPDATE users SET UsersPwd = ? WHERE UsersEmail = ?;";
              $stmt = mysqli_stmt_init($connect);
              if (!mysqli_stmt_prepare($stmt,$sql))
              {
                header("location:../Signup.php?reset=wrong");
                exit();
              }
              else
              {
                $newHashedPwd = password_hash($password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $newHashedPwd, $tokenEmail);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM resetpwd WHERE ResetpwdEmail = ?;";
                $stmt = mysqli_stmt_init($connect);
                if (!mysqli_stmt_prepare($stmt,$sql))
                {
                  header("location:../Signup.php?reset=wrong");
                  exit();
                }
                else
                {
                  mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                  mysqli_stmt_execute($stmt);
                  header("location:../Signup.php?newpwd=passwordupdated");
                }
               }
             }
           }
         }
       }
     }
   }
  else
  {
    header("location:../Home.php?error=incorrectsubmit");
    exit();
  }
 ?>
