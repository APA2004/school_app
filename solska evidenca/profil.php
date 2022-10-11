<?php
   include('session.php');
?>
<html>
    <head>
        <title>Account</title>

        <!-- Load an icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css_azure_dragon.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <!--<?php include 'my_index.php';?>-->
        <?php include('header.html');?>

        <?php
            $get_user_id_sql = "SELECT id_uporabnik FROM uporabniki WHERE email = '$email'"; 
            $get_user_id_result = mysqli_query($db, $get_user_id_sql);
            $get_user_id = implode("",mysqli_fetch_assoc($get_user_id_result));

            $get_user_info_sql = "SELECT * FROM uporabniki WHERE id_uporabnik = $get_user_id";
            $get_user_info_result = mysqli_query($db, $get_user_info_sql);
            $get_user_info = mysqli_fetch_assoc($get_user_info_result);

            $ime_uporabnik = $get_user_info["ime_uporabnik"];
            $priimek_uporabnik = $get_user_info["priimek_uporabnik"];
            $email = $get_user_info["email"];
            $status_uporabnik = $get_user_info["status_uporabnik"];
            $geslo = $get_user_info["geslo"];


            $error = "";
            $pass_change_status = "";
            $acc_update_status= "";


        ?>

        <div class="flex-container">
            <div class="account_side_column">
                <form class="change_pass" action="" method="post">
                        <div class="side_column_title">Change password</div>
                        <label for="new_user_password">New password: </label>
                        <br/>
                        <input type="password" id="new_user_password" name="new_user_password">
                        <br/><br/>
                        <label for="user_confirm_pass">Confirm new password: </label>
                        <br/>
                        <input type="password" id="user_confirm_pass" name="user_confirm_pass">
                        <br/><br/>
                        <input type = "submit" value = " Submit " class="button" name="change_password_button"/>
            <?php 
                if(isset($_POST['change_password_button']))
                {
                    if(empty(trim($_POST['new_user_password'])))
                    {
                        $error = "Please enter a password.";     
                    }
                    else 
                    {
                        $new_password = trim($_POST['new_user_password']);
                    }
                   
                      
                    // Confirm password
                    if(empty(trim($_POST['user_confirm_pass'])))
                    {
                        $error = "Please enter or confirm password.";     
                    }
                    else
                    {
                    $confirm_password = trim($_POST['user_confirm_pass']);

                    if($new_password != $confirm_password)
                    {
                         $error = "Passwords did not match.";
                         $pass_change_status = "<hr> Changing password failed!";
                    }
                    else{
                        $change_pass_sql = "UPDATE uporabniki SET password='$new_password' WHERE id_uporabnik=$get_user_id";
                        if(mysqli_query($db, $change_pass_sql))
                        {
                            $pass_change_status = "<hr> Password changed successfully!";
                            $password = $new_password; //za izpis v desnem stolpcu da se posodobi
                        }
                        else
                        {
                            $pass_change_status = "<hr> Changing password failed!";
                        }
                    }
                    }

                    
                }
            ?>
            <div><?php echo $pass_change_status;?></div>
            <div><?php echo $error;?></div>
            </form>
            </div>


            <div class="account_main">
                <div class="user_account_info">
                    <div class="column_title">USER ACCOUNT SETTINGS</div>
                    <form action="" method="post" class="user_account_info">
                    <br/>
                    <label for="user_fullname">Fullname: </label>
                    <br/>
                    <input type="text" id="user_fullname" name="user_fullname" value="<?php echo $ime_uporabnik ?>" readonly>
                    <br/><br/>
                    <label for="username">Username: </label>
                    <br/>
                    <input type="text" id="username" name="username" value="<?php echo $priimek_uporabnik ?>" readonly>
                    <br/><br/>
                    <label for="user_email">Email: </label>
                    <br/>
                    <input type="text" id="user_email" name="user_email" value="<?php echo $email ?>" readonly>
                    <br/><br/>
                    <button  type="button" class="button_black" onclick="removeReadOnly()">Edit  your account</button>
                    <button  type="submit" class="button_black" name="change_user_acc_button">Submit changes</button>
                    <br/><br/>
                    <div ><a href = "logout.php" class="logout">Sign Out</a></div>
            </form>

        <?php 
            if(isset($_POST['change_user_acc_button']))
            {
                $new_fullname = $_POST["user_fullname"];
                $new_username = $_POST["username"];
                $new_email = $_POST["user_email"];
                $new_birth = $_POST["user_birth"];

                $update_user_acc_sql = "UPDATE user
                SET fullname = '$new_fullname',
                    username = '$new_username',
                    email = '$new_email',
                    birth = '$new_birth'
                WHERE id = $get_user_id";

                if(mysqli_query($db, $update_user_acc_sql))
                {
                    header("location:login.php");
                }
                else
                {
                    $acc_update_status= "Your account failed to update!";
                }
            }

        ?>
        <hr>
        <div> <?php echo $acc_update_status; ?></div>
        <span class="attention">Important: if your changes will be updated successfuly after clicking Submit changes, you will be redirected to Login.</span>
        </div>
    </div>
    </div>
    </body>
    <script>
        function passwordVisible() {
            var x = document.getElementById("user_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function removeReadOnly() {
            document.getElementById('user_fullname').readOnly = false;
            document.getElementById('username').readOnly = false;
            document.getElementById('user_email').readOnly = false;
            document.getElementById('user_birth').readOnly = false;
        }
    </script>
    
</html>