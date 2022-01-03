<?php
include_once 'Page-design.php';
include_once 'database.php';
require_once 'functions.php';
?>
<html>
<body>
<div class="team">
  <center><h1>System Logs</h1><center>
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
</body>
</html>
<?php
$user = $_SESSION["userusername"];

$sql = "SELECT * FROM logger where username = '$user';";
$stmt = mysqli_stmt_init($connect);
if(!mysqli_stmt_prepare($stmt,$sql))
{
    header("location:../login.php?error=incorrectlogin");
    exit();
}
$result = mysqli_query($connect,$sql);
$resultCheck = mysqli_num_rows($result);
if($resultCheck>0){

    while($row = mysqli_fetch_assoc($result)){
        echo 'Username :'.$row['username'].'<br>';
        echo 'IP Address:'.$row['ip_adress'].'<br>';
        echo 'Login Time :'.$row['login_time'].'<br>';
        echo 'Password :'.$row['pwd'].'<br>'.'<br>';

    }
}
?>
