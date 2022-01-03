<?php
include_once 'Page-design.php';
?>
<html>
<body>
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
          if($_GET["error"] === "newpwd-empty")
          {
            echo "<p>Fill in all fields! </p>";
          }

          else if($_GET["error"] === "newpwdnotmatch")
          {
            echo "<p>Passwords does not match!</p>";
          }
          else if($_GET["error"] === "invalidpassword")
          {
            echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
          }
        }
      ?>
        <?php
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];
            if(empty($selector)|| empty($validator))
            {
              echo ("Invalid request, you need to re-submit your reset request");
            }
            if(ctype_xdigit($selector)!== false && ctype_xdigit($validator)!== false)
            {
              ?>
              <form action = "reset-password.php" method = "post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
              </div><div class="keyin">
                <h6>Password: Must contain number, uppercase, lowercase letter, symbol, and at least 8 characters</h6>
                <input type="password" id = "psw" name="Pwd" placeholder = "Enter a new Password..." pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}$" title="Must contain number, uppercase, lowercase letter, symbol, and at least 8 characters" required>
                <label>Password</label>
              </div>
              <div class="keyin">
                <input type="password" name="Repeatpwd" placeholder = "Confirm a new Password..." autocomplete="off" required>
                <label>Confirm Password</label>
              </div>
                <button type="submit" name="resetpwdsubmit">Reset password</button>
              </form>
              <?php
            }

         ?>
    </section>
</body>
</html>
