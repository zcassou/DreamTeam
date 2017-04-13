<?php

   include 'universal.php';
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }
   $userID = $_SESSION['validID'];

   foreach($_POST['gameid'] as $key => $value){
      $gameq = "SELECT Team1, Team2, UNIX_TIMESTAMP(dt) FROM Game WHERE GameID = ?";
      $gqs   = $dt->prepare($gameq);
      $gqs->bind_param('i', $key);
      $gqs->execute();
      $result = $gqs->get_result();
      $gid = $key;
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
         $pinsert = "INSERT INTO Prediction VALUES ($userID, $key, $value);";
         $pis     = $dt->prepare($pinsert);
         $pis->execute();
      }
      
   }
   header('Location: prediction.php');

?>

