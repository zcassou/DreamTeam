<?php
   
   include 'universal.php';
   //print_r($_SESSION, true);

   //variable declaration
   $username  = trim($_POST['lusername']);
   $password  = trim($_POST['lpassword']);
   $output_html = '';

   //setup query
   $query = "SELECT UserID, Password FROM User WHERE Username = ?";
   $stmt  = $dt->prepare($query);
   $stmt->bind_param('s', $username);
   $stmt->bind_result($userID, $hpassword);
   $stmt->execute();

   while($stmt->fetch()){
      $stmt->store_result();
   }

   //variable checking
   if (!$username || !$password || $stmt->num_rows == 0 || !password_verify($password, $hpassword)){
      $output_html = 'Username or password incorrect!';
   } else {
      $_SESSION['validID'] = $userID;
      header('Location: news.php');
      exit;
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
      <div id = "error">
      <p><?php echo $output_html ?><p>
      </div>
   </body>
</html>

