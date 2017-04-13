<?php

   include 'universal.php';
   
   $_SESSION = array();
   setcookie();
   session_destroy();
   header('Location: index.php');

?>
