<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"SELECT ime_uporabnik, priimek_uporabnik, email FROM uporabniki WHERE email = '$user_check' ");
   
   $row = mysqli_fetch_assoc($ses_sql);

   $ime_priimek = $row['ime_uporabnik'].' '.$row['priimek_uporabnik'];
   
   //$login_session = $row['email'];

   $login_session = $ime_priimek;
   $email = $row['email'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>