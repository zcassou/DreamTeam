<?php
   $upcoming = '';
   $available = '';
   $results  = '';
   $gcount = 1;
   include 'universal.php';
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }

   $teamq = "SELECT Name FROM Team WHERE TeamID = ?";
   $tqs   = $dt->prepare($teamq);

   $ugameq = "SELECT GameID, Team1, Team2, UNIX_TIMESTAMP(dt) FROM Game WHERE dt >= CURRENT_TIMESTAMP() ORDER BY GameID";
   $gqs   = $dt->prepare($ugameq);
   $gqs->execute();
   $result = $gqs->get_result();


   while ($row = $result->fetch_assoc()){
      $date = date("F j, Y, g:i A", $row['UNIX_TIMESTAMP(dt)']);
//      $teamq = "SELECT Name FROM Team WHERE TeamID = ?";
//      $tqs   = $dt->prepare($teamq);
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
      $upredq = "SELECT Winner FROM Prediction WHERE UserID = ? AND GameID = ?";
      $upqs = $dt->prepare($upredq);
      $upqs->bind_param('ii', $_SESSION['validID'], $row['GameID']);
      $upqs->execute();
      $upresult = $upqs->get_result();

      if ($uprow = $upresult->fetch_assoc()){
         if ($uprow['Winner'] == 1){
            $upcoming = $upcoming."$date<br>&emsp;$tname1 vs. $tname2<br>&emsp;Prediction: $tname1 Wins<br><br>";
         } else {
            $upcoming = $upcoming."$date<br>&emsp;$tname1 vs. $tname2<br>&emsp;Prediction: $tname2 Wins<br><br>";
         }
      } else {
         $gid = $row['GameID'];
         $available = $available."<input type = 'checkbox' name = 'game[]' value = '$gid'>
                                  $date<br>&emsp;$tname1 vs. $tname2<br><br>";
         
      }
   }

   $predq = "SELECT GameID, Winner FROM Prediction WHERE UserID = ?";
   $pqs   = $dt->prepare($predq);
   $pqs->bind_param('i', $_SESSION['validID']);
   $pqs->execute();
   $presult = $pqs->get_result();
   
   while($prow = $presult->fetch_assoc()){
      
      $cgameq = "SELECT Team1, Team2, UNIX_TIMESTAMP(dt) FROM Game WHERE dt < CURRENT_TIMESTAMP AND GameID = ?";
      $cgqs = $dt->prepare($cgameq);
      $cgqs->bind_param('i', $prow['GameID']);
      $cgqs->execute();
      $cgresult = $cgqs->get_result();
      
      if ($cgrow = $cgresult->fetch_assoc()){
         $date = date("F j, Y, g:i A", $cgrow['UNIX_TIMESTAMP(dt)']);
         $tqs->bind_param('i', $cgrow['Team1']);
         $tqs->execute();
         $t1result = $tqs->get_result();
         while ($trow = $t1result->fetch_assoc()){
            $tname1 = $trow['Name'];
         }
         $tqs->bind_param('i', $cgrow['Team2']);
         $tqs->execute();
         $t2result = $tqs->get_result();
         while ($t2row = $t2result->fetch_assoc()){
            $tname2 = $t2row['Name'];
         }

         if ($prow['Winner'] == 1){
            if ($cgrow['Winner'] == 1){
               $results = $results."$date<br>&emsp;$tname1 vs. $tname2<br>&emsp;Prediction: $tname1 Wins<br>
                                    &emsp;Result: $tname1 Wins<br><br>";
            } else {
               $results = $results."$date<br>&emsp;$tname1 vs. $tname2<br>&emsp;Prediction: $tname1 Wins<br>
                                    &emsp;Result: $tname2 Wins<br><br>";
            }

         } else {
            if ($cgrow['Winner'] == 1){
               $results = $results."$date<br>&emsp;$tname1 vs. $tname2<br>&emsp;Prediction: $tname2 Wins<br>
                                    &emsp;Result: $tname1 Wins<br><br>";
            } else {
               $results = $results."$date<br>&emsp;$tname1 vs. $tname2<br>&emsp;Prediction: $tname2 Wins<br>
                                    &emsp;Result: $tname2 Wins<br><br>";
            }

         }

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
         <h3>Upcoming Predictions</h3>
            <?php echo $upcoming; ?>
         <h3>Prediction Results</h3>
            <?php echo $results; ?>
         <h3>Available Predictions</h3>
            <form action = 'make_prediction.php' method = 'get'>
               <?php echo $available; ?>
               <input type = 'submit' value = 'Make Predictions'>
            </form>
      </main>


   </body>

</html>

