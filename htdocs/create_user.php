<?php

   include 'universal.php';

   //variable declaration
   $first     = trim($_POST['first_name']);
   $username  = trim($_POST['username']);
   $password  = trim($_POST['password']);
   $cpassword = trim($_POST['password_confirm']);
   $last      = trim($_POST['last_name']);
   $email     = trim($_POST['e-mail']);
   $cemail    = trim($_POST['e-mail_confirm']);

   
   //variable checking
   if (!$username){
      $output =  '<p>You have not entered your username!<br>
            Please go back!</p>';
   } else if (!$password){
      $output =  '<p>You have not entered your password!<br>
            Please go back!</p>';
   } else if (!$cpassword || $cpassword != $password){
      $output =  '<p>You have not entered a matching password!<br>
            Please go back!</p>';
   } else if (!$first){
      $ouput =  '<p>You have not entered your first name!<br>
            Please go back!</p>';
   } else if (!$last){
      $output =  '<p>You have not entered your last name!<br>
            Please go back!</p>';
   } else if (!$email){
      $output =  '<p>You have not entered your e-mail address!<br>
            Please go back!</p>';
   } else if (!$cemail || $cemail != $email){
      $output = '<p>You have not entered a matching e-mail address!<br>
            Please go back!</p>';
   } else {
      //check where to see if the username is already in use
      $query = "SELECT Username FROM User WHERE Username = ?";
      $stmt  = $dt->prepare($query);
      $stmt->bind_param('s', $username);
      $stmt->execute();

      while($stmt->fetch()){
         $stmt->store_result();
      }

      if ($stmt->num_rows != 0){
      $output = '<p>Someone else is already using this username!<br>
            Please go back and try again!</p>';
      } else {

        //hash the password
        $hpassword = password_hash($password, PASSWORD_DEFAULT);

        //insert the new user into the table
        $insert = "INSERT INTO User VALUES (NULL, ?, ?, ?, ?, ?)";
        $dbin   = $dt->prepare($insert);
        $dbin->bind_param('sssss', $username, $hpassword, $first, $last, $email);
        $dbin->execute();

        $output = '<p>Account Created!</p>';

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
      <header>
         <h1>Dream Team!</h1>
      </header>
      
      <?php echo $output ?><br>
      <p>To go back to the home page click here:
         <a href = "index.php">Home Page</a></p>
   </body>
</html>

