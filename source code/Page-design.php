<?php
  session_start();
  session_regenerate_id();
  if(isset($_SESSION["last_active"]))
  {
    if(time() - $_SESSION["last_active"] > 10)
    {
      header("location:../logout.php");
    }
  }
  $_SESSION["last_active"] = time();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<style>
body {
  font-family: "Trebuchet MS", Verdana, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

.Menu {
  font-size: 20px;
  float: left;
  width: 100%;
  transform: translate(0%,-100%);
}
.Menu ul li {
  list-style-type: none;
  float: left;
  display: inline;
}
.Menu li a {
  display: block;
  text-decoration: none;
  color:RGB(119,240,210);
  font-family:verdana;
  border-right: 2px solid #FFFFFF;
  padding: 3px 10px;
  float: left;
}
.Menu li a:hover {
  background-color: #CCCCCC;
}
.Menu .time{
  text-decoration: none;
  color:#abc4ff;
  font-family:verdana;
  border-right: 2px solid #FFFFFF;
  padding: 3px 10px;
  float: right;
  font-size: 20px;
}
.signup-form{
  position: relative;
  left: 50%;
  transform: translate(-50%,-1%);
  width: 50%;
  padding: 20px;
  margin:10px;
  background: rgba(131, 213, 219, 0.2);
  box-sizing: border-box;
  box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
  border-radius: 20px;
}

.signup-form input:{
  position: sticky;
  margin-top:200px;
  top: 200%;
  left: 50%;
  width: 70%;
  padding: 50px;
  background: rgba(255, 240, 236, 0.5);
  box-sizing: border-box;
  box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
  border-radius: 30px;
}

/* design position of the output word */
.signup-form .keyin{
  position: relative;
}

/* design the input place */
.signup-form .keyin input{
  width: 100%;
  padding: 5px 5px;
  font-size: 16px;
  color: rgb(188, 110, 144);
  letter-spacing: 1px;
  margin-bottom: 30px;
  border: none;
  outline: none;
  background: transparent;
  border-bottom: 1px solid #fff;
}
/* design the output to promt user key in */
.signup-form .keyin label{
  position: absolute;
  transform: translate(0%,-50%);
  top: 0;
  left: 0;
  letter-spacing: 0.5px;
  padding: 10px 0px;
  font-size: 12px;
  color: #004e98;
  transition: .5s;
}

.signup-form .keyin input:focus ~ label,
.signup-form .keyin input:valid ~ label{
  top: -5px;
  left: 0px;
  color: rgb(188, 110, 144);
  font-size: 20px;
}
.signup-form button[type="submit"]{
  border: none;
  outline: none;
  color: #fff;
  background: #4c956c;
  padding: 10px 20px;
  border-radius: 5px;
  cursor:pointer;
}

.signup-form button[type="reset"]
{
  border: none;
  outline: none;
  color: #fff;
  background: #a11d33;
  padding: 10px 20px;
  border-radius: 5px;
}
.signup-form button:hover{
  background-color:#DCDCDC ;
}
.login-form{
  position: relative;
  left: 50%;
  transform: translate(-50%,-1%);
  width: 30%;
  padding: 15px;
  margin:10px;
  background: #fbfefb;
  box-sizing: border-box;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.5);
}

.login-form input:{
  position: sticky;
  margin-top:200px;
  top: 200%;
  left: 50%;
  width: 70%;
  padding: 30px;
  background: rgba(255, 240, 236, 0.5);
  box-sizing: border-box;
  box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
}

/* design position of the output word */
.login-form .keyin{
  position: relative;
}

/* design the input place */
.login-form .keyin input{
  width: 100%;
  padding: 5px 5px;
  font-size: 16px;
  color: rgb(188, 110, 144);
  letter-spacing: 1px;
  margin-bottom: 30px;
  border: none;
  outline: none;
  background: transparent;
  border-bottom: 1px solid #fff;
}
/* design the output to promt user key in */
.login-form .keyin label{
  position: absolute;
  transform: translate(0%,-50%);
  top: 0;
  left: 0;
  letter-spacing: 0.5px;
  padding: 10px 0px;
  font-size: 12px;
  color: #004e98;
  transition: .5s;
}

.login-form .keyin input:focus ~ label,
.login-form .keyin input:valid ~ label{
  top: -5px;
  left: 0px;
  color: rgb(188, 110, 144);
  font-size: 20px;
}
.login-form button[type="submit"]{
  border: none;
  outline: none;
  color: #fff;
  background: #4c956c;
  padding: 10px 20px;
  border-radius: 5px;
  cursor:pointer;
}

.demo-error {
	color:#FF0000;
    font-size: 0.95em;
}
.demo-input {
    width: 60%;
    border-radius: 5px;
    border: #CCC 1px solid;
    padding: 12px;
    margin-top: 5px;
}

.captcha-input {
	background: #FFF url(captcha_image.php) repeat-y left center;
    padding-left: 75px;
}




.login-form button:hover{
  background-color:#DCDCDC ;
}

.team {
  padding: 20px;
  background-color: #474e5d;
  color: white;
}
.fgt_pwd
{
  font-family: "Courier New", Georgia, serif;
}
.Job {
  color: #b36a5e;
}

.Matric
{
  color: #00296b;
}
.box {
  position: relative;
  transform: translate(75%,10%);
  text-align: center;
  width: 40%;
  margin-bottom: 16px;
  padding: 20px;
  box-sizing: border-box;
  box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
  /* background-image: url("card.jpg"); */
  background-attachment:fixed;
  background-size:cover;
}


  .notepad{
    position: relative;
    left: 50%;
    transform: translate(-50%,-10%);
    width: 70%;
    padding: 20px;
    margin:0;
    background: rgba(255, 240, 236, 0.5);
    box-sizing: border-box;
    box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
    border-radius: 30px;
  }

  .notepad input:{
    position: sticky;
    margin-top:100px;
    top: 200%;
    left: 50%;
    width: 70%;
    padding: 50px;
    background: rgba(255, 240, 236, 0.5);
    box-sizing: border-box;
    box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
    border-radius: 30px;
  }

  /*  design the login word */
  .notepad h2{
    margin: 0 0 5px;
    padding: 0px;
    color: #880d1e;
    text-align: center;
  }
  /* design position of the output word */
  .notepad .keyin{
    position: relative;
  }

  /* design the input place */
  .notepad .keyin input{
    width: 100%;
    padding: 5px 5px;
    font-size: 16px;
    color: rgb(188, 110, 144);
    letter-spacing: 1px;
    margin-bottom: 30px;
    border: none;
    outline: none;
    background: transparent;
    border-bottom: 1px solid #fff;
  }

  .notepad .con input{
    font-size: 16px;
    color: rgb(188, 110, 144);
    letter-spacing: 1px;
    margin-bottom: 30px;
    border: none;
    outline: none;
    background: transparent;
    border-bottom: 1px solid #fff;
  }

  /* design the output to promt user key in */
  .notepad .keyin label{
    position: absolute;
    transform: translate(0%,-80%);
    top: 0;
    left: 0;
    letter-spacing: 1px;
    padding: 10px 0px;
    font-size: 30px;
    color: #004e98;
    transition: .5s;
  }

  .notepad .con label{
    position: absolute;
    transform: translate(25%,135%);
    top: 0;
    left: 0;
    letter-spacing: 1px;
    padding: 9px 3px;
    font-size: 30px;
    color: #004e98;
    transition: .5s;
  }

  textarea {
    transform: translate(10%,0%);
    width: 80%;
    height: 300px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    background-color:rgba(255, 240, 236, 0.5);
    resize: none;
  }
  .notepad .keyin input:focus ~ label,
  .notepad .keyin input:valid ~ label{
    top: -18px;
    left: 0px;
    color: rgb(188, 110, 144);
    font-size: 20px;
  }
  .openButton[type = "button"]
  {
    position: absolute;
    transform: translate(50%,-10%);
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    background: #bc4749;
    cursor:pointer;
    padding:20px 30px;
    border-radius: 100%;
  }
  .extraButton[type = "button"]
  {
    position: relative;
    transform: translate(200%,-300%);
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    background: #bc4749;
    cursor:pointer;
    padding:10px 20px;
    border-radius: 100%;
  }
  .closeButton[type="submit"]{
    border: none;
    outline: none;
    color: #fff;
    background: #4c956c;
    padding: 10px 20px;
    border-radius: 5px;
    cursor:pointer;
  }

  .closeButton[type="reset"]
  {
    border: none;
    outline: none;
    color: #fff;
    background: #a11d33;
    padding: 10px 20px;
    border-radius: 5px;
  }
  .openButton[type="button"]:hover,
  .extraButton[type="button"]:hover,
  .closeButton[type="submit"]:hover,
  .closeButton[type="reset"]:hover{
    background-color:#DCDCDC ;
  }
  .retrieve
  {
    position:relative;;
    transform: translate(50%,0%);
    margin : 30px 20px;
    float: left;
    width: 33.3%;
    padding: 10px;
    background: rgba(116, 234, 255, 0.3);
    box-sizing: border-box;
    box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
    word-wrap:break-word;
    border-radius:5px;
  }

  .retrieve h2
  {
    padding: 0px;
    color: #73ba9b;
    text-align: center;
  }

  .retrieve .inside
  {
    padding: 10px;
    color: #2d6a4f;
    background: rgba(255, 240, 236, 0.5);
    box-sizing: border-box;
    height: 200px;
    box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.5);
    overflow-y: scroll;
  }
#footer {
  position: absolute;
  transform: translate(0%,293%);
  width: 100%;
  height:20%;
  color: white;
  text-align: center;
  background-color: #495867;
  margin-bottom: auto;
}
#footer center{
  font-size : 15px;
}
.openAdding
{
  display: none;
}
.openAdding h3
{
  font-family:Courier, monospace;
  font-size: 25px;

  color:#800000;
  transform: translate(0%,-300%);
}

</style>
</html>
