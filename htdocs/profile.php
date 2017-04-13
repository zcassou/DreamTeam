<?php

   include 'universal.php';

   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }

   $query = "SELECT Username, First, Last, Email FROM User WHERE UserID = ?";
   $stmt  = $dt->prepare($query);
   $stmt->bind_param('i', $_SESSION['validID']);
   $stmt->bind_result($usernm, $first, $last, $email);
   $stmt->execute();
   while ($stmt->fetch()){
      $uname = $usernm;
      $fname = $first;
      $lname = $last;
      $pemail = $email;
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
         <h3><?php echo $fname.' '.$lname; ?></h3>

         <p><strong>Profile name:</strong></br>
            <?php echo $uname ?></br> </p>
         <p><strong>First name:</strong></br>
            <?php echo $fname ?></br> </p>
         <p><strong>Last name:</strong></br>
            <?php echo $lname ?></br> </p>
         <p><strong>E-mail Address:</strong></br>
            <?php echo $pemail ?></br></p>
      </main>


   </body>

</html>

