<?php
include_once 'Page-design.php';
?>
<html>
<body>
<div class="team">
  <center><h1>Profile</h1><center>
</div>
<div class = "Menu" >
  <ul>
    <li><a href = "Home.php"> Home </a></li>
    <?php
      if(isset($_SESSION["userusername"]))
      {
        echo "<li><a href = 'profile.php'> Profile </a></li>";
        echo "<li><a href = 'system.logs.php'> System logs </a></li>";
        echo "<li><a href = 'notepad.php'> Notepad </a></li>";
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
<?php
      if(isset($_SESSION["usersname"]))
      {
        echo "<p> Hello, ".$_SESSION["usersname"]."</p>";
      }
    ?>
</body>
</html>
