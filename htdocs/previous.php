<?php

   include 'universal.php';
   $current = time();
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }
   $i = 0; //incrementing value that allows several game arrays to be created and stored in one larger games_array variable
   $games_array = array();

   $gameq = "SELECT t1.Name AS team_1, t2.name AS team_2, UNIX_TIMESTAMP(g.dt) AS dt, g.Winner AS winner FROM Team AS t1 INNER JOIN Game AS g ON g.Team1 = t1.TeamID INNER JOIN Team AS t2 ON g.Team2 = t2.TeamID WHERE g.dt < CURRENT_TIMESTAMP ORDER BY GameID";
   $gqs   = $dt->prepare($gameq);
   $gqs->execute();
   $result = $gqs->get_result();

   while ($row = $result->fetch_assoc()){
      $date = esc_var(date("F j, Y, g:i A", $row['dt']));
      $tname1 = esc_var($row['team_1']);
      $tname2 = esc_var($row['team_2']);
      if ($row['winner'] == 1){
         $games_array[$i][0] = $date;
         $games_array[$i][1] = $tname1;
         $games_array[$i][2] = $tname2;
         $i++;
      } elseif ($row['winner'] == 2){
         $games_array[$i][0] = $date; 
         $games_array[$i][1] = $tname2; 
         $games_array[$i][2] = $tname1; 
         $i++;
      }
   }


?>

<!DOCTYPE html>
<html>
   <head>
      <title>Zach's Test Page</title>
      <link rel = "stylesheet" type = "text/css" href = "webpage_style.css">
      <link rel = "stylesheet" type = "text/css" href = "center.css">
   </head>

   <body>

      <?php echo $hnav; ?>
      <main>
         <h2>Completed Games</h2>
         <table>
           <tr>
             <th>Date</th>
             <th>Winner</th>
             <th>Loser</th>
           </tr>
           <?php 
             foreach ($games_array as $game) {
               echo "<tr>
                       <td>$game[0]</td>
                       <td>$game[1]</td>
                       <td>$game[2]</td>
                     </tr>";
             }
            ?>
         </table>
      </main>


   </body>

</html>

