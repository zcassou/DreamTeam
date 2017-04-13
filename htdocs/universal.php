<?php
   //start session
   session_start();

   //connect to the database 
   @$dt = new mysqli ('localhost', 'dtwa', 'waDreamTeam', 'DreamTeam');
   if(mysqli_connect_errno()) {
      echo '<p>Error: Could not connect to database.<br>
            Please try again later.</p>';

   }

   try {
      $pdodt = new PDO('mysql:host=localhost;dbname=DreamTeam', 'dtwa', 'waDreamTeam');

   } catch (PDOException $e) {
      print "Error!: ". $e->getMessage() ."</br>";
   } 
    
   function esc_var($var){
      return htmlspecialchars($var);
   }


   $hnav = '<header><h1>Dream Team</h1></header>

      <nav>
         <table>
         <tr><td><p><a href="profile.php">Profile</a></p></td>
         <td><p><a href="news.php">News</a></p></td>
         <td><p><a href="previous.php">Completed</br>Games</a></p></td>
         <td><p><a href="upcoming.php">Upcoming</br>Games</a></p></td>
         <td><p><a href="prediction.php">Prediction</a></p></td>
         <td><p><a href="teams.php">Teams</a></p></td>
         <td><p><a href="logout.php">Log Out</a></p></td></tr>
         </table>
      </nav>'

 
?>
