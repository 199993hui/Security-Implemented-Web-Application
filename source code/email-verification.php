<?php
include_once 'page-design-for-signup.php';
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
          $selector = $_GET["selector"];
          $validator = $_GET["validator"];

          if(empty($selector)|| empty($validator))
          {
            echo "!Could not validate your reques. Please sign up again to get a new email to verity your registration request";
          }
          else
          {
            if(ctype_xdigit($selector)!== false && ctype_xdigit($validator)!== false)
            {
              ?>
              <form action = "email-verification-goto.php" method = "post">
                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                <button type="submit" name="verifysubmit">Verify</button>
              </form>
              <?php
            }
          }
         ?>

    </section>
</body>
</html>
