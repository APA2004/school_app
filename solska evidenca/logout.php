<?php
   session_start();
   
   // Brisanje polja seje
   $_SESSION = array();
   
   // Če se seja uspešno ustavi, preusmeri na login.
   if(session_destroy()) {
      header("Location: login.php");
   }
?>