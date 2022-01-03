<?php

use Phppot\Captcha;
include_once 'page-design-for-signup.php';
require_once 'Captcha_code.php';


?>
<!DOCTYPE html>
<html>
<body>
<div class="team">
  <center><h1>Sign up</h1><center>
</div>
<div class = "Menu" >
  <ul>
    <li><a href = "Home.php"> Home </a></li>
    <li><a href = "Signup.php"> Sign up </a></li>
    <li><a href = "login.php"> Login </a></li>
  </ul>
    <div class = "time">
      <?php echo date("l F j, Y ", time());?>
    </div>
</div>
<section class = "signup-form">
  <?php
    if(isset($_GET["error"]))
    {
      if($_GET["error"] === "emptyinput")
      {
        echo "<p>Fill in all fields! </p>";
      }
      else if($_GET["error"] === "name")
      {
        echo "<p>Choose a proper name that not consists of special character!</p>";
      }
      else if($_GET["error"] === "invalidusername")
      {
        echo "<p>Choose a proper username!</p>";
      }
      else if($_GET["error"] === "invalidemail")
      {
        echo "<p>Choose a proper email!</p>";
      }
      else if($_GET["error"] === "invalidphone")
      {
        echo "<p>Invalid phone number!</p>";
      }
      else if($_GET["error"] === "passwordsdontmatch")
      {
        echo "<p>Passwords does not match!</p>";
      }
      else if($_GET["error"] === "invalidpassword")
      {
        echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
      }
      else if($_GET["error"] === "usernametaken")
      {
        echo "<p>The username/email/phone number has been taken!</p>";
      }
      else if($_GET["error"] === "tmtfailed")
      {
        echo "<p>Something wet wrong, try again!</p>";
      }
      else if($_GET["error"] === "none")
      {
        echo "<p>You have signed up!</p>";
      }
      else if($_GET["error"] === "incorrectsubmit")
      {
        echo "<p>Invalid submission!</p>";
      }
      else if($_GET["error"] === "incorrectcaptchacode")
      {
        echo "<p>Incorrect Captcha Code！</p>";
      }
    }
  ?>
  <?php
    if(isset($_GET["error"]))
    {
      if($_GET["error"] == "success")
      {
        echo '<p class = "resetsuccess">Check your e-mail and verify it in 5 minutes.</p>';
      }
    }
  ?>
  <?php
  if(isset($_GET["newpwd"]))
  {
    if($_GET["newpwd"] === "passwordupdated")
    {
      echo '<p class = "signupsuccess">Your password has been reset!</p>';
    }
  }
  if(isset($_GET["reset"]))
  {
    if($_GET["reset"] == "empty")
    {
      echo '<p class = "resetsuccess">Unable to verify the request. Please re-submit your reset password request. </p>';
    }
    else if($_GET["reset"] == "expired")
    {
      echo '<p class = "resetsuccess">Request expired. Please re-submit your reset password request. </p>';
    }
    else if($_GET["reset"] == "wrong")
    {
      echo '<p class = "resetsuccess">Something went wrong. Please re-submit your reset password request. </p>';
    }
  }
  ?>
    <form action="signup.goto.php" method = "post">
        <div class="keyin">
          <input type="text" name="name" placeholder = "Full name" size "30"  pattern = "^[_A-z]*((-|\s)*[_A-z])*$"autocomplete="off" required>
          <label>Name</label>
        </div>
        <div class="keyin">
          <input type="email" name="email" placeholder = "Email" size "30"  autocomplete="off" required>
          <label>Email</label>
        </div>
        <div class="keyin">
          <input type="text" name="phone" placeholder = "Phone Number : 01xxxxxxxx/011xxxxxxxx" pattern="^(01)*[0-46-9]*[0-9]{9,10}$"  autocomplete="off" title="Format: 01xxxxxxxx/011xxxxxxxx" required>
          <label>Mobile phone</label>
        </div>
        <div class="keyin">
          <input type="text" name="username" placeholder = "Username:Only consists of number and letter" size "30"  autocomplete="off" required>
          <label>Username</label>
        </div><div class="keyin">
          <h6>Password: Must contain number, uppercase, lowercase letter, symbol, and at least 8 characters</h6>
          <input type="password" id = "psw" name="password" placeholder = "Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$" title="Must contain number, uppercase, lowercase letter, symbol, and at least 8 characters" required>
          <label>Password</label>
        </div>
        <div class="keyin">
          <input type="password" name="Repeatpwd" placeholder = "Confirm password" autocomplete="off" required>
          <label>Confirm Password</label>
        </div>
        <div class=" ">
          <label>Captcha code<span id="error-captcha" class="demo-error"></label></td>
            <?php if(isset($error_message)){
              echo $error_message;
            } ?>
          <input name="captcha_code" type="text"class="demo-input captcha-input">
        </div>
        <div class = "keyin">
          <button type ="submit" class = "Submit" name = "submit"> Sign up </button>
          <button type = "reset" class = "clear"> Clear</button>
        </div>

     </form>
     <div class = "fgt_pwd"> <a href = "resetpassword.php"> Forgot your password </a></div>
  </section>
</body>
</html>
