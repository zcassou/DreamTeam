<?php

   include 'universal.php';
   $output = '';
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }

   foreach( $pdodt->query('SELECT Name FROM Team') as $row ) {
      $output .= '<p><input type = "checkbox" value = "'.$row['Name'].'" class = "team">'.$row['Name']."</p>";
   }

?>

<!DOCTYPE html>
<html>
   <head>
      <title>Zach's Test Page</title>
      <link rel = "stylesheet" type = "text/css" href = "webpage_style.css">
      <script type = "text/JavaScript" src = "/setup/jquery-3.1.1.min.js"></script>
      <script type = "text/JavaScript" src = "scripts.js"></script>
   </head>

   <body>

      <?php echo $hnav; ?> 
      <main>
         <?php echo $output; ?>
         <div class = "new_team"><h3>Newly Added Teams</h3></div>
         <input type = "button" id = "add_team" value = "Add">
         <input type = "button" id = "edit_list" value = "Edit">
      </main>

   </body>

</html>

