<?php

include_once 'Page-design.php';
?>
<html>
<body>
<div class="team">
  <center><h1>Once_notepad</h1><center>
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
    <?php
      if(isset($_GET["error"]))
      {
        if($_GET["error"] === "incorrectsubmit")
        {
          echo "<p>Submission error! </p>";
        }
      }
    ?>
  </ul>
    <div class = "time">
      <?php echo date("l F j, Y ", time());?>
    </div>
</div>
<center><h2>Our Team</h2></center>
  <div class="box">
    <div class="personal">
      <div class="information">
        <h2>Chia Wai Xuan</h2>
        <p class="Job">Developer</p>
        <p class = "Matric">149123</p>
      </div>
    </div>
  </div>
  <div class="box">
    <div class="personal">
      <div class="information">
        <h2>Lau Sie Hao</h2>
        <p class=" Job">Developer</p>
        <p class = "Matric">145815</p>
      </div>
    </div>
  </div>
  <div class="box">
    <div class="personal">
      <div class="information">
        <h2>Lee Hui Ying</h2>
        <p class=" Job">Developer</p>
        <p class = "Matric">149044</p>
      </div>
    </div>
  </div>
  <div class="box">
    <div class="personal">
      <div class="information">
        <h2>Ng Jack Lung</h2>
        <p class=" Job">Developer</p>
        <p class = "Matric">148600</p>
      </div>
    </div>
  </div>
</body>
<footer id="footer">
  <center><p>About us</p></center>
  <center><br>CST235</center>
  <center>2021</center>
</footer>
<style media="screen">
body
{
  margin:0;
  font-family: Arial, Helvetica, sans-serif;
  background:#cbf3f0;
  background-attachment:fixed;
  background-size:cover;
}
</style>

</html>
