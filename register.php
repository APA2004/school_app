<?php
	// Vključi konfiguracijo
   include("config.php");
   session_start();
   
   // Declare variables with empty values
   $username = $password = $confirm_password = "";
   $error = "";
   
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	  
	  /*// Validate email
	  $myusername = mysqli_real_escape_string($db,$_POST['username']);
      
      $sql = "SELECT id FROM uporabniki WHERE username = '$myusername'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $count = mysqli_num_rows($result);
      // If result matched $myusername table row must be 1 row
      if($count == 1) {
		 $error = "This username is already taken.";
      } else {
		  $username = trim($_POST['username']);
	  }*/
	  
	  // Validate password
	  if(empty(trim($_POST['password']))){
        $error = "Please enter a password.";     
      } /*elseif(strlen(trim($_POST['password'])) < 6){
        $error = "Password must have atleast 6 characters.";*/
      
      else 
      {
		$password = trim($_POST['password']);
	   }
   
	  
	  // Confirm password
	  if(empty(trim($_POST['confirm_password']))){
        $error = "Please confirm password.";     
      } else{
        $confirm_password = trim($_POST['confirm_password']);

        if($password != $confirm_password){
            $error = "Password did not match.";
        }
        if(strlen(trim($_POST['password'])) < 6){
         $error = "Password must have atleast 6 characters.";
      }
   }
	  
	  // Check if no errors happened so far
	  if(empty($error)){
		  
		// Prepare INSERT SQL statement
		$user_password = mysqli_real_escape_string($db,$_POST['password']);
      $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

		$user_name = mysqli_real_escape_string($db,$_POST['ime_uporabnik']);
      $user_surname = mysqli_real_escape_string($db,$_POST['priimek_uporabnik']);
      $user_email = mysqli_real_escape_string($db,$_POST['email']);

      $user_status = 'ucenec';

		$sql = "INSERT INTO uporabniki (id_uporabnik, ime_uporabnik, priimek_uporabnik, email, status_uporabnik, geslo) VALUES ('','$user_name', '$user_surname', '$user_email', '$user_status', '$hashed_password')";

		if (mysqli_query($db,$sql))
      {
         header("Location: login.php");

		}
      else
      {
			$error = "Registration failed: ".mysqli_error($db);
		}
	  }
   }
?>
<html>
   <head>
      <title>Registration Page</title>
      <link rel="stylesheet" href="css_azure_dragon.css">
   </head>
   <body class="register_body">
      <div class="register_window">
            <div class="register_title">Register</div>
               <form action = "" method = "post" class="register_form">
                  <label>IME:</label>
                  <br/>
                  <input type = "text" name = "ime_uporabnik" class = "box"/>
                  <br /><br />
				      <label>PRIIMEK:</label>
                  <br/>
                  <input type = "text" name = "priimek_uporabnik" class = "box"/>
                  <br /><br />
                  <label for="user_email">EMAIL:</label>
                  <br/>
                  <input type="email" id="email" name="email">
                  <br/><br/>
                  <label>GESLO:</label>
                  <br/>
                  <input type = "password" name = "password" class = "box" />
                  <br/><br />
                  <label>POTRDI GESLO:</label>
                  <br/><input type = "password" name = "confirm_password" class = "box" />
                  <br/><br />
                  <input type = "submit" value = "REGISTER" class="button_black_no_animation"/>
                  <br />
               </form>
               
               <div><?php echo $error; ?></div><br/>
			   <div class="bold">ALREADY REGISTERED? <a href="login.php" class="login">LOG IN</a></div>	
            </div>
</div>
   </body>
</html>