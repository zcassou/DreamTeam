<?php
   include 'universal.php';
   if (!isset($_SESSION['validID'])){
      header('Location: index.php');
      exit;
   }

   $tname = $_POST['new_team'];
   $tname = esc_var($tname);
   $tnamei = "INSERT INTO Team(Name) VALUES(:name)";

   try {
      $pdodt->beginTransaction();
         $tis = $pdodt->prepare($tnamei);
         $tis->bindParam(':name', $tname);
         $tis->execute();
         $pdodt->commit();
         echo '<p><input type = "checkbox" value ="'.$tname.'" class = "team">'.$tname.'</p>';
   } catch (Exception $e) {
      $pdodt->rollBack();
      echo "Failed: ".$e->getMessage();
   }


?>
