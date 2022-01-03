<?php
  function IncompleteSignupForm($name,$email,$phone,$username,$pwd,$repeatpwd)
  {
    $result;
    if(empty($name)||empty($email)||empty($phone)||empty($username)||empty($pwd)||empty($repeatpwd))
    {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }

  function invalidUsername($username)
  {
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/",$username))
    {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }
  function invalidName($name)
  {
    $result;
    if(!preg_match("/^[_A-z]*((-|\s)*[_A-z])*$/",$username))
    {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }

  function invalidEmail($email)
  {
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }
  function invalidPhone($phone)
  {
    $result;
    if(!preg_match("/^(01)[0-46-9]*[0-9]{7,8}$/",$phone))
    {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }
  function invalidPwd($pwd)
  {
    $uppercase = preg_match('@[A-Z]@', $pwd);
    $lowercase = preg_match('@[a-z]@', $pwd);
    $number    = preg_match('@[0-9]@', $pwd);
    $specialChars = preg_match('@[^\w]@', $pwd);
    $result;
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($pwd) < 8)
    {
      $result = true;
    }
    else
    {
      $result = false;
    }
    return $result;
  }

  function pwdMatch($pwd,$repeatpwd)
  {
    $result;
    if($pwd !== $repeatpwd)
    {
      $result = true;
    }
    else {
      $result = false;
    }
    return $result;
  }
  function usernameExist($connect,$username, $email, $phone)
  {
    $sql = "SELECT * FROM users WHERE UsersUserName = ? OR UsersEmail = ? OR UsersPhone = ? ;";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
      header("location:../signup.php?error=tmtfailed");
      exit();
    }
    mysqli_stmt_bind_param($stmt,"sss",$username, $email, $phone);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if($rowData = mysqli_fetch_assoc($resultData))
    {
      return $rowData;
    }
    else
    {
      $result = false;
      return $result;
    }
    mysqli_stmt_close($stmt);
   }
   function createUsers($connect,$name,$email,$phone,$username,$pwd)
   {
     $sql = "INSERT INTO users (UsersName, UsersEmail, UsersPhone, UsersUserName, UsersPwd) VALUES (?,?,?,?,?);";
     $stmt = mysqli_stmt_init($connect);
     if(!mysqli_stmt_prepare($stmt,$sql))
     {
       header("location:../signup.php?error=tmtfailed");
       exit();
     }


     mysqli_stmt_bind_param($stmt,"sssss",$name, $email,$phone,$username,$pwd);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_close($stmt);
     header("location:../signup.php?error=none");
     exit();
    }

    // Functions for login validation
    function IncompleteLoginForm($username,$pwd)
    {
      $result;
      if(empty($username)||empty($pwd))
      {
        $result = true;
      }
      else {
        $result = false;
      }
      return $result;
    }
    function usernameExist_login($connect,$username)
    {
      $sql = "SELECT * FROM users WHERE UsersUserName = ? ;";
      $stmt = mysqli_stmt_init($connect);
      if(!mysqli_stmt_prepare($stmt,$sql))
      {
        header("location:../Signup.php?error=tmtfailed");
        exit();
      }
      mysqli_stmt_bind_param($stmt,"s",$username);
      mysqli_stmt_execute($stmt);
      $resultData = mysqli_stmt_get_result($stmt);

      if($rowData = mysqli_fetch_assoc($resultData))
      {
        return $rowData;
      }
      else
      {
        $result = false;
        return $result;
      }
      mysqli_stmt_close($stmt);
     }
    function login($connect, $username, $pwd)
    {

      $ExistedUsername = usernameExist_login($connect, $username);
      if($ExistedUsername === false)
      {
        session_start();
        $_SESSION["session_login_attempts"] +=1;
        header("location:../login.php?error=incorrectlogin");
        exit();
      }
      $Hashedpwd = $ExistedUsername["UsersPwd"];
      $Correctpwd = password_verify($pwd,$Hashedpwd);

      if($Correctpwd === false)
      {
        $log = "Wrong Password ($pwd)";
        logger($connect,$username,$log);
        attempt_limit($connect,$username);
        $attempt_num = $ExistedUsername["Login_attempt"];

        if ( $attempt_num >=2 )
        {

          $email = $ExistedUsername["UsersEmail"];
          sendAlert($connect,$email);
          bruteforce($connect, $username);
          $_SESSION["login"] = $ExistedUsername["login"];

          $_SESSION["session_login_attempts"] +=1;
        }
        else
        {
          session_start();
          $_SESSION["session_login_attempts"] +=1;
        }
        $_SESSION["false"] = $ExistedUsername["UsersUserName"];
        header("location:../login.php?error=incorrectlogin");
        exit();
      }
      else if ($Correctpwd === true)
      {
        $log = "Correct Password";
        if(check_valid_to_login($connect,$username) === true)
        {
          $_SESSION["false"] = $ExistedUsername["UsersUserName"];
          $_SESSION["login"] = $ExistedUsername["login"];
          header("location:../login.php?error=incorrectlogin");
          exit();
        }
        clear_login_attempt($connect,$username);
        logger($connect,$username,$log);
        systemlogs($connect,$username);
        session_start();
        $_SESSION["userid"] = $ExistedUsername["UsersID"];
        $_SESSION["usersname"] = $ExistedUsername["UsersName"];
        $_SESSION["userusername"] = $ExistedUsername["UsersUserName"];
        $_SESSION["phone"] = $ExistedUsername["UsersPhone"];
        $_SESSION["last_active"] = time();
        header("location:../Home.php");
        exit();
      }
    }

      function logger($connect,$username,$log)
      {

        $sql = "INSERT INTO logger (username,ip_adress,login_time,pwd) VALUES (?,?,?,?);";
        $stmt = mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          header("location:../login.php?error=incorrectlogin");
          exit();
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        date_default_timezone_set('Singapore');
        $time = date('Y-m-d H:i:s', time());
        mysqli_stmt_bind_param($stmt,"ssss",$username,$ip,$time,$log);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }

      function systemlogs ($connect,$username)
      {
        echo ($username);
        $sql = "SELECT * FROM logger where username = '$username';";
        $stmt = mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          header("location:../login.php?error=incorrectlogin");
          exit();
        }
        $result = mysqli_query($connect,$sql);
        $resultCheck = mysqli_num_rows($result);
        echo ($resultCheck);
        if($resultCheck>0){
          while($row = mysqli_fetch_assoc($result)){
            echo $row['username'] . "<br>";
          }
        }
      }
      function check_attempt($connect,$username)
      {

        $sql = "SELECT Login_attempt FROM users WHERE UsersUserName = ? ;";
        $stmt = mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          header("location:../signup.php?error=tmtfailed");
          exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$username);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        if($rowData = mysqli_fetch_assoc($resultData))
        {
          return $rowData["Login_attempt"];
        }
        else
        {
          return false;
        }
        mysqli_stmt_close($stmt);
      }
      function attempt_limit($connect,$username)
      {
        $attempt_num = check_attempt($connect,$username);
        if($attempt_num === false)
        {
          header("location:../login.php");
          echo "Something went wrong!";
        }
        else
        {
          $sql = " UPDATE users SET Login_attempt= ? WHERE UsersUserName = ?;";
          $stmt = mysqli_stmt_init($connect);
          if(!mysqli_stmt_prepare($stmt,$sql))
          {
            header("location:../login.php?error=bruteforce");
            exit();
          }
          $attempt_num = $attempt_num + 1;
          mysqli_stmt_bind_param($stmt,"is",$attempt_num,$username);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        }
      }
      function bruteforce ($connect,$username)
      {
        $sql = " UPDATE users SET login= ? WHERE UsersUserName = ?;";
        $stmt = mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          header("location:../login.php?error=bruteforce");
          exit();
        }

        $time = date("U") + 30;

        mysqli_stmt_bind_param($stmt,"is",$time,$username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }
      function clear_login_attempt($connect,$username)
      {
        $sql = " UPDATE users SET Login_attempt = ? WHERE UsersUserName = ?;";
        $stmt = mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          header("location:../login.php?error=tmtfailed");
          exit();
        }

        $attempt_num = 0;
        mysqli_stmt_bind_param($stmt,"is",$attempt_num,$username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }
      function check_valid_to_login($connect,$username)
      {
        $time = date("U");
        $sql = "SELECT * FROM users WHERE UsersUserName = ? AND login < ?;";
        $stmt = mysqli_stmt_init($connect);
        if (!mysqli_stmt_prepare($stmt,$sql))
        {
          echo "Something went wrong.";
          exit();
        }
        else
        {
          mysqli_stmt_bind_param($stmt,"si", $username,$time);
          mysqli_stmt_execute($stmt);

          $result = mysqli_stmt_get_result($stmt);
          if(!$rowData = mysqli_fetch_assoc($result))
          {
            return false;
          }
          else
          {
            return true;
          }
        }
        mysqli_stmt_close($stmt);
      }

     // Limit email request
     function check_attempt_email($connect,$email)
     {
       $time = date('U') - 86400;
       $now = date('U');

       $sql = "SELECT * FROM countemail WHERE countEmail_Email= '$email' AND countEmail_Time >= '$time' AND countEmail_Time <= '$now';";
       $stmt = mysqli_stmt_init($connect);
       if(!mysqli_stmt_prepare($stmt,$sql))
       {
         header("location:../resetpassword.php?reset=tmtfailed");
         exit();
       }
       $result = mysqli_query($connect,$sql);
       $resultCheck = mysqli_num_rows($result);
       return $resultCheck;
     }

     function update_enable($connect,$email)
     {
       $date = date("U") + 86400;
       $sql = "DELETE FROM requestlimit WHERE requestLimitEmail=?;";
       $stmt = mysqli_stmt_init($connect);
       if (!mysqli_stmt_prepare($stmt,$sql))
       {
         echo "Something went wrong.";
         exit();
       }
       else
       {
         mysqli_stmt_bind_param($stmt,"s", $email);
         mysqli_stmt_execute($stmt);
       }

       $sql = "INSERT INTO requestlimit (requestLimitEmail, requestLimitEnable) VALUES (?,?);";

       if (!mysqli_stmt_prepare($stmt,$sql))
       {
         echo "Something went wrong.";
         exit();
       }
       else
       {
         mysqli_stmt_bind_param($stmt,"ss", $email, $date);
         mysqli_stmt_execute($stmt);
       }
       mysqli_stmt_close($stmt);
       mysqli_close();
     }
     function update_count_email($connect,$email)
     {
       $sql = "INSERT INTO countemail (countEmail_Email, countEmail_Time) VALUES (?,?);";
       $date = date("U");
       $stmt = mysqli_stmt_init($connect);
       if (!mysqli_stmt_prepare($stmt,$sql))
       {
         echo "Something went wrong.";
         exit();
       }
       else
       {
         mysqli_stmt_bind_param($stmt,"si", $email, $date);
         mysqli_stmt_execute($stmt);
       }
       mysqli_stmt_close($stmt);
     }
     function clear_count_email($connect,$email)
     {
       $sql = "DELETE FROM countemail WHERE countEmail_Email = ?;";
       $stmt = mysqli_stmt_init($connect);
       if (!mysqli_stmt_prepare($stmt,$sql))
       {
         header("location:../resetpassword.php?error=tmtfailed");
         exit();
       }
       else
       {
         mysqli_stmt_bind_param($stmt,"s", $email);
         mysqli_stmt_execute($stmt);
         mysqli_stmt_close($stmt);
       }
     }
     function check_valid_to_email($connect,$email)
     {
       $enable;
       $time = date("U");
       $sql = "SELECT * FROM requestlimit WHERE requestLimitEmail = ? AND requestLimitEnable > ?;";
       $stmt = mysqli_stmt_init($connect);
       if (!mysqli_stmt_prepare($stmt,$sql))
       {
         header("location:../resetpassword.php?error=tmtfailed");
         exit();
       }
       else
       {
         mysqli_stmt_bind_param($stmt,"si", $email, $time);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         if(!$rowData = mysqli_fetch_assoc($result))
         {
           $no_of_request = check_attempt_email($connect,$email);
           if($no_of_request >= 10)
           {
             update_enable($connect,$email);
             clear_count_email($connect,$email);
             $enable = false;
           }
           else
           {
             update_count_email($connect,$email);
             $enable = true;
           }
         }
         else
         {
           $enable = false;
         }
         mysqli_stmt_close($stmt);
       }
       return $enable;
     }
     function IncompleteNotepad($title,$note,$username)
     {
       $result;
       if(empty($title)||empty($note)||empty($username))
       {
         $result = true;
       }
       else {
         $result = false;
       }
       return $result;
     }
     function saveNotepad($connect,$title,$note,$username)
     {
       $sql = "INSERT INTO notepad (username, title, note) VALUES (?,?,?);";
       $stmt = mysqli_stmt_init($connect);
       if(!mysqli_stmt_prepare($stmt,$sql))
       {
         header("location:../notepad.php?error=tmtfailed");
         exit();
       }

       mysqli_stmt_bind_param($stmt,"sss",$username, $title,$note);
       mysqli_stmt_execute($stmt);
       mysqli_stmt_close($stmt);
       header("location:../notepad.php?error=none");
       exit();
    }
    function sendAlert($connect,$email)
    {
      $to = $email;
      $subject = 'Once_Notepad : ALERT! Someone login your account with more than 3 failed attempt';
      $message = '<p>Please check if someone try to attack your account</p>';
      $message .= '<p>Please contact us if that is not you.</br>';

      $headers ="From: CST235 assign2 <cst235assign2@gmail.com>\r\n";
      $headers .= "Reply-To: cst235assign2@gmail.com\r\n";
      $headers .= "Content-type: text/html\r\n";

      mail($to, $subject, $message, $headers);
    }


 ?>
