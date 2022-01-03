<?php
require_once 'Page-design-for-signup.php';
?>
<html>
<body>
  <div class="team">
    <center><h1>Reset your password</h1><center>
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
        <form action = "resetpassword.goto.php" method = "post">
          <div><a>An e-mail will be sent to you with instruction on how to reset your password.</a></div>
          <div >
            <label>Email</label>
            <input type="email" name="email" placeholder = "Enter your e-mail address..." size "30"  autocomplete="off" required>
          </div>
          <button type = "submit" name = "resertpassword-submit">Recieve new pssword by email</button>
        </form>
        <?php
          if(isset($_GET["reset"]))
          {
            if($_GET["reset"] == "success")
            {
              echo '<p class = "resetsuccess">Check your e-mail </p>';
            }
            else if($_GET["reset"] === "exceedlimit")
            {
              echo "You have sent more than 10 requests for reset password within 24 hours. Please try it tommorrow.";
            }
            else if($_GET["reset"] === "tmtfailedt")
            {
              echo "Something went wrong!";
            }
          }
        ?>
    </section>
</body>
</html>
