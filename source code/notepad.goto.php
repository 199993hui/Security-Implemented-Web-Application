<?php
if(isset($_POST["submit"]))
{
  $title = $_POST["title"];
  $note = $_POST["note"];
  $username = $_POST["username"];

  require_once 'database.php';
  require_once 'functions.php';

  if(IncompleteNotepad($title,$note,$username) !== false)
  {
    header("location:../notepad.php?error=emptyinput");
    exit();
  }
  else
  {
    saveNotepad($connect,$title,$note,$username);
  }
}
else
{
  header("location:../notepad.php?error=failed");
}
?>
