<?php

   include 'universal.php';
   $output = '';
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }

   $nameq = "SELECT First FROM User WHERE UserID = ?";
   $stmt  = $dt->prepare($nameq);
   $stmt->bind_param('i', $_SESSION['validID']);
   $stmt->bind_result($first);
   $stmt->execute();
   while ($stmt->fetch()){
      $fname = $first;
   }
   $stmt->close();

   $gameq = "SELECT Team1, Team2, UNIX_TIMESTAMP(dt), Winner FROM Game WHERE dt < CURRENT_TIMESTAMP ORDER BY GameID DESC LIMIT 6";
   $gqs   = $dt->prepare($gameq);
   $gqs->execute();
   $result = $gqs->get_result();

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
      esc_var($tname1);
      esc_var($tname2);
      if ($row['Winner'] == 1){
         $output = $output."$date<br>&emsp;<strong>W</strong> $tname1 vs. $tname2 <strong>L</strong><br><br>";
      } elseif ($row['Winner'] == 2){
         $output = $output."$date<br>&emsp;<strong>L</strong> $tname1 vs. $tname2 <strong>W</strong><br><br>";
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
         <h3><?php echo 'Welcome '.$fname.'!'; ?></h3>

         <p>Recent game results will be posted here!</p>
         <p><?php echo $output; ?></p>
      </main>


   </body>

</html>

