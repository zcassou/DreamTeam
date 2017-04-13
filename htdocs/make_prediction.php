<?php

   include 'universal.php';
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }
   foreach($_GET['game'] as $value){
      $gameq = "SELECT Team1, Team2, UNIX_TIMESTAMP(dt) FROM Game WHERE GameID = ?";
      $gqs   = $dt->prepare($gameq);
      $gqs->bind_param('i', $value);
      $gqs->execute();
      $result = $gqs->get_result();
      $gid = $value;
      while ($row = $result->fetch_assoc()){
         $date = date("F j, Y, g:i A", $row['UNIX_TIMESTAMP(dt)']);
         $teamq = "SELECT Name FROM Team WHERE TeamID = ?";
         $tqs   = $dt->prepare($teamq);
         $tqs->bind_param('i', $row['Team1']);
         $tqs->execute();
         $t1result = $tqs->get_result();
         while ($trow = $t1result->fetch_assoc()){
            $tname1 = $trow['Name'];
         }
         $tqs->bind_param('i', $row['Team2']);
         $tqs->execute();
         $t2result = $tqs->get_result();
         while ($t2row = $t2result->fetch_assoc()){
            $tname2 = $t2row['Name'];
         }
         esc_var($date);
         esc_var($gid);
         esc_var($tname1);
         esc_var($tname2);
         $output = $output."$date<br>&emsp;<input type = 'radio' name = 'gameid[$gid]' value = '1'> $tname1 vs. 
                            $tname2<input type = 'radio' name = 'gameid[$gid]' value = '2'><br><br>";
      }

   }

?>


<!DOCTYPE html>
<html>
   <head>
      <title>Zach's Test Page</title>
      <link rel = "stylesheet" type = "text/css" href = "webpage_style.css">
   </head>

   <body>
      <?php echo $hnav; ?>
      <main>
         <form action = 'set_pred.php' method = 'post'>
            <p><?php  echo $output; ?></p>
            <input type = 'submit' value = 'Submit Predictions'>
         </form>
      </main>


   </body>

</html>

