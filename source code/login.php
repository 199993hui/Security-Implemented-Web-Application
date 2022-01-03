<?php

use Phppot\Captcha;

  require_once 'Captcha_code.php';

  require_once 'Page-design.php';
  include_once 'database.php';
  include_once 'functions.php';

  if (isset($_SESSION["false"]))
  {
    $username = $_SESSION["false"];
    if (check_valid_to_login($connect,$username) == false )
    {

      $sql = "SELECT login FROM users WHERE UsersUserName = '$username';";
      $stmt = mysqli_stmt_init($connect);
      if(!mysqli_stmt_prepare($stmt,$sql))
      {
          header("location:../login.php?error=tmtfailed");
          exit();
      }
      $result = mysqli_query($connect,$sql);
      $row = mysqli_fetch_assoc($result);
      $temp2 = date("U");
      $release= $row["login"];
      $second = $release - $temp2;
      if ($temp2 >= $release)
      {
          unset($_SESSION["login"]);
          session_destroy();
      }
      else
      {
          echo "This account is locked, Please try after ".$second." seconds.";
      }
    }
  }
  if (isset($_SESSION["session_locked"]))
  {
      $temp2 = date("U");
      $release= (int)$_SESSION["session_locked"];
      if ($temp2 >= $release)
      {
          unset($_SESSION["session_locked"]);
          unset($_SESSION["session_login_attempts"]);

          session_destroy();
      }
      else
      {
          echo "Session is still locked, Please Wait.";
      }
  }
?>
<html>
<body>
<div class="team">
  <center><h1>Login</h1><center>
</div>
<div class = "Menu" >
  <ul>
    <li><a href = "Home.php"> Home </a></li>
    <?php
      if(isset($_SESSION["userusername"]))
      {
        echo "<li><a href = 'profile.php'> Profile </a></li>";
        echo "<li><a href = 'system.logs.php'> System logs </a></li>";
        echo "<li><a href = 'logout.php'> Log out </a></li>";
      }
      else
      {
        echo "<li><a href = 'Signup.php'> Sign up </a></li>";
        echo "<li><a href = 'login.php'> Login </a></li>";
      }
    ?>
  </ul>
    <div class = "time">
      <?php echo date("l F j, Y ", time());?>
    </div>
</div>
<section class = "login-form">
    <form action="login.goto.php" method = "post">
      <?php
        if(isset($_GET["error"]))
        {
          if($_GET["error"] === "emptyinput")
          {
            echo "<p>Fill in all fields! </p>";
          }
          else if($_GET["error"] === "incorrectlogin")
          {
            echo "<p>Incorrect login information! Try again.</p>";
          }
          else if($_GET["error"] === "usernotexits")
          {
            echo "<p>User does not exist.</p>";
          }
          else if($_GET["error"] === "tmtfailed")
          {
            echo "<p>Something went wrong！</p>";
          }
          else if($_GET["error"] === "incorrectcaptchacode")
          {
            echo "<p>Incorrect Captcha Code！</p>";
          }
          else if($_GET["error"] === "incorrectsubmit")
          {
            echo "<p>Not suitable submission！</p>";
          }
        }
      ?>
        <div class="keyin">
          <label>Username</label>
          <input type="text" name="user" placeholder = "Username" size "30"  autocomplete="off" required>
        </div>
        <div class="keyin">
          <label>Password</label>
          <input type="password" name="password" placeholder = "Password..." autocomplete="off" required>
        </div>
        <div class=" ">
          <label>Captcha code<span id="error-captcha" class="demo-error"></label></td>
            <?php if(isset($error_message)){
              echo $error_message;
            } ?>
          <input name="captcha_code" type="text"class="demo-input captcha-input">
        </div>
        <div class = "keyin">
            <?php
                if(isset($_SESSION["session_login_attempts"]) AND ($_SESSION["session_login_attempts"] > 2))
                {
                    $_SESSION["session_locked"] = date("U") +10;
                    echo "<p>You have failed 3 attempts in this session.Please wait for 10 seconds and refresh the page to login again</p>";
                }
                else
                {
            ?>
          <button type ="submit" class = "Submit" name = "Submit"> Log In </button>
            <?php } ?>
        </div>
        <div class = "fgt_pwd"> <a href = "resetpassword.php"> Forgot your password </a></div>
     </form>

  </section>
  <style media="screen">
  body
  {
    margin:0;
    font-family: Arial, Helvetica, sans-serif;
    background:#f6fff8;
    background-attachment:fixed;
    background-size:cover;
  }
  </style>
</body>
</html>
