<?php
   include("config.php");
   session_start();
   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $password = "";
      $user_email = mysqli_real_escape_string($db,$_POST['email']);
      $password = mysqli_real_escape_string($db,$_POST['password']); 

      $user_info_sql = "SELECT * FROM uporabniki WHERE email = '$user_email'";
      $user_info_result = mysqli_query($db,$user_info_sql);
      $user_info = mysqli_fetch_assoc($user_info_result);
      //$active = $row['active'];
      //$count = mysqli_num_rows($result);

      $user_status = $user_info["status_uporabnik"];

      if($user_status == "ucitelj")
      {
         $status_url = "ucitelj";
      }
      else if ($user_status == "ucenec")
      {
         $status_url = "ucenec";
      }
      else if ($user_status == "admin")
      {
         $status_url = "admin";
      }

      $hashed_password = $user_info['geslo'];

		if(password_verify($password, $hashed_password))
      {	
         header("Location: home_page.php?status=$status_url");
         $_SESSION['login_user'] = $user_email;
         $_SESSION['loggedin'] = true;
      }
      else
      {
         $error = "Your Login Name or Password is invalid" .mysqli_error($db);
      }

      /*if($count == 1) {
		 session_start();
         $_SESSION['login_user'] = $user_email;
		 $_SESSION['loggedin'] = true;
		 
         header("location: home_page.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }*/
   }

   

?>
<html>
   
   <head>
      <title>Login Page</title>
      <link rel="stylesheet" href="css_azure_dragon.css">
   </head>
   
   <body class="login_body">
      <div class="login_window">
         <div>
            <div class="login_title">Login</div>
               <div>
                  <form class="login_form" action = "" method = "post">
                     <br/>
                     <label>E-NASLOV:</label>
                     <br/>
                     <input type = "email" name = "email" class = "box"/>
                     <br /><br />
                     <label>GESLO:</label>
                     <br/>
                     <input type = "password" name = "password" class = "box" />
                     <br/><br />
                     <br/>
                     <input type = "submit" value = "LOG IN" class="button_black_no_animation"/><br />
                  </form>
                  
                  <div><?php echo $error; ?></div><br/>
                  
                  <div class="bold">NEW USER? <a href = "register.php" class="register">REGISTER NOW!</a></div>	
               </div>
            </div>
         </div>
   </body>
</html>