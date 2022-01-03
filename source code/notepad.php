
<?php

include_once 'Page-design.php';
include_once 'database.php';
?>
<html>
<body>
<div class="team">
  <center><h1>Padlet</h1><center>
</div>
<div class = "Menu" >
  <ul>
    <li><a href = "Home.php"> Home </a></li>
    <?php
      if(isset($_SESSION["userusername"]))
      {
        $username = $_SESSION["userusername"];
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

    <div id = "mario">
        <div class = "notification">
        <center><h1> Your NOTES</h1></center>
        <center><p><h3>Click on the "Add Note" button to add your note</h3></p></center>
        </div>
    </div>
    <?php
      if(isset($_GET["error"]))
      {
        if($_GET["error"] === "emptyinput")
        {
          echo "<center><p>Fill in all fields! </p></center>";
        }
        else if($_GET["error"] === "failed")
        {
          echo "<center><p>Something went wrong!</p></center>";
        }
        else if($_GET["error"] === "tmtfailed")
        {
          echo "<center><p>Something went wrong!</p></center>";
        }
        else if($_GET["error"] === "none")
        {
          echo "<center><p>New note added!</p></center>";
        }
        else if($_GET["error"] === "deleted")
        {
          echo "<center><p>Note deleted!</p></center>";
        }
        else if($_GET["error"] === "deletefailed")
        {
          echo "<center><p>Failed to deleted!</p></center>";
        }

      }
    ?>
    <button class = "openButton" type = "button" onclick = "openNOTES()"> Add Note </button>
    <div id = "addNote" class="openAdding">
      <button class = "extraButton" type = "button" onclick = "closeNOTES()"> X </button>
      <form class = "notepad" action="notepad.goto.php" method = "post">
        <h2>Notes</h2>
         <div class="keyin">
           <input type="text" name="title"  autocomplete="on" required>
           <label >Title</label>
           <textarea type="text" name="note" value = "note" placeholder="Write something.." autocomplete="on" required></textarea>
         </div>
         <input type="hidden" name="username" value="<?php echo $username?>">
         <div>
           <button type ="submit" name = "submit" class = "closeButton"> Save </button>
           <button type = "reset" class = "closeButton"> Clear</button>
         </div>
       </form>
    </div>
    <script>
      function openNOTES()
      {
        document.getElementById("addNote").style.display = "block";
      }

      function closeNOTES()
      {
        document.getElementById("addNote").style.display = "none";
        document.getElementById("addNote").value = '';
      }

    </script>
    <?php
        $sql = "SELECT * FROM notepad where username = '$username'";
        $stmt = mysqli_stmt_init($connect);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
          echo "Unable to load the notes!!";
        }
        $result = mysqli_query($connect,$sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck>0){
          while($row = mysqli_fetch_assoc($result))
          {
            echo "<br><div class = 'retrieve'>";
              {
                echo "<h2>";
                $title = $row["title"];
                echo $title;
                  echo "</h2>";
                  echo "<div class = 'inside'>";

                    echo "<div class = 'insideContent'>";
                    echo "<br>";
                    $note = $row["note"];
                    echo $note;
                    echo "</div>";
                echo "</div>";
                $id = $row["notepadID"];
              }
              ?>
              <form action="notepad-delete.php" method = "post">
              <input type="hidden" name="id"  value = "<?php echo $id?>">
              <button type ="submit" name = "submit"> Delete </button>
            </form>
            </div>
            <?php
          }
        }
    ?>

  </body>
