<?php

$serverName = "localhost";
$DBusername = "root";
$DBpassword = "";
$DBname = "cst235assign2";

$connect = mysqli_connect($serverName, $DBusername, $DBpassword, $DBname);

if(!$connect)
{
  die("Connection failed ". mysqli_connect_error());
}

?>
