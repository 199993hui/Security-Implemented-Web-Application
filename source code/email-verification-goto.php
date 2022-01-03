<?php
  if(isset($_POST["verifysubmit"]))
  {
    $selector = $_POST["selector"];
    $validator = $_POST["validator"];

    $currentDate = date("U");

    require 'database.php';
    require 'functions.php';
    $sql = "SELECT * FROM Email_verify WHERE Email_verify_Selector = ? AND Email_verify_Expires >= ?;";
    $stmt = mysqli_stmt_init($connect);
    if (!mysqli_stmt_prepare($stmt,$sql))
    {
      echo "Something went wrong.";
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt,"ss", $selector,$currentDate);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      if(!$rowData = mysqli_fetch_assoc($result))
      {
        echo "You need to make your register request again.";
        exit();
      }
      else
      {
        $tokenBin = hex2bin($validator);
        $checktoken = password_verify($tokenBin, $rowData["Email_verify_Token"]);

        if($checktoken === false)
        {
          echo "You need to make your register request again.";
          exit();
        }
        else if ($checktoken === true)
        {
          $tokenEmail = $rowData["Email_verify_Email"];

          $sql = "SELECT * FROM Email_verify WHERE Email_verify_Email = ?;";
          $stmt = mysqli_stmt_init($connect);
          if (!mysqli_stmt_prepare($stmt,$sql))
          {
            echo "Something went wrong.";
            exit();
          }
          else
          {
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if(!$rowData = mysqli_fetch_assoc($result))
            {
              echo "! Something went wrong.";
              exit();
            }
            else
            {
              $name = $rowData["UsersName"];
              $email = $rowData["UsersEmail"];
              $phone = $rowData["UsersPhone"];
              $username = $rowData["UsersUserName"];
              $pwd = $rowData["UsersPwd"];
              if(usernameExist($connect,$username,$email,$phone) !== false)
              {
                header("location:../signup.php?error=usernametaken");
                exit();
              }

              createUsers($connect,$name,$email,$phone,$username,$pwd );
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
