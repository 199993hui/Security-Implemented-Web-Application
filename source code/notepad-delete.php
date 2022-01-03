<?php
  if(isset($_POST["submit"]))
  {
    require "database.php";
    require_once 'functions.php';

    $id = $_POST["id"];

    $sql = "DELETE FROM notepad WHERE notepadID=?;";
    $stmt = mysqli_stmt_init($connect);
    if (!mysqli_stmt_prepare($stmt,$sql))
    {
      header("location:../notepad.php?error=tmtfailed");
      exit();
    }
    else
    {
      mysqli_stmt_bind_param($stmt,"i", $id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      header("location:../notepad.php?error=delete.''");
    }
}
else
{
  header("location:../notepad.php?error=deletefailed");
  exit();
}
