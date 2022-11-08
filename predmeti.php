<?php
   include('session.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="solska_evidenca_styles.css">
    </head>
    <body>
    <?php
        include('header.html');
        $ime_predmeta = $_GET['predmet'];
    ?>
    
    <div class="leftcolumn">
    <br/>
   
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){

        $get_predmet_info_sql = "SELECT * FROM predmeti WHERE ime_predmet = '$ime_predmeta'";
        $get_predmet_info_result = mysqli_query($db, $get_predmet_info_sql);
        $get_predmet_info = mysqli_fetch_assoc($get_predmet_info_result);

        $get_user_id_sql = "SELECT id_uporabnik FROM uporabniki WHERE email = '$email'"; 
        $get_user_id_result = mysqli_query($db, $get_user_id_sql);
        $get_user_id = implode("",mysqli_fetch_assoc($get_user_id_result));

        $get_user_info_sql = "SELECT * FROM uporabniki WHERE id_uporabnik = $get_user_id";
        $get_user_info_result = mysqli_query($db, $get_user_info_sql);
        $get_user_info = mysqli_fetch_assoc($get_user_info_result);

        $ime_uporabnik = $get_user_info["ime_uporabnik"];
        $priimek_uporabnik = $get_user_info["priimek_uporabnik"];
        $email = $get_user_info["email"];

        if(isset($_FILES['fileToUpload']))
        {
            $target_dir = "uploads/";
            $target_file = $target_dir .$ime_uporabnik." ".$priimek_uporabnik." ".basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            /*// Check if file already exists
            if (file_exists($target_file)) {
                echo '<script type="text/JavaScript">
                    console.log("sovrazim se");
                    if(prompt("Datoteka na strežniku že obstaja. Ali jo želite zamenjati?") == true)
                    {
                        document.getElementById("hidden_text").value = "true";
                    }
                    else
                    {
                        document.getElementById("hidden_text").value = "false";
                    }
                    document.getElementById("hidden_form").submit();
                </script>';
                $status_potrditve=$_GET['hidden_text'];
                if($status_potrditve == "true"){
                    $uploadOk = 1;
                }
                else{
                $uploadOk = 0;
                }
            }*/

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
            }

            /*// Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
            }*/

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            }
            else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    $ime_datoteke = $ime_uporabnik." ".$priimek_uporabnik." ".basename($_FILES["fileToUpload"]["name"]);
                    $velikost_datoteke =$_FILES['fileToUpload']['size'];
                    $tip_datoteke=$_FILES['fileToUpload']['type'];
                    date_default_timezone_set('Europe/Ljubljana');
                    $datum_nalaganja = date('y-m-d h:i:s');

                    $vstavi_datoteko_sql = "INSERT INTO datoteke (id_datoteke, ime_datoteke, datum_nalaganja, velikost_datoteka, tip_datoteka, id_uporabnik)
                                            VALUES ('','$ime_datoteke', '$datum_nalaganja', $velikost_datoteke, '$tip_datoteke', $get_user_id)";
                    mysqli_query($db,$vstavi_datoteko_sql);
                }
                else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
    ?>
    <?php
        echo $ime_predmeta."<br/>";
    ?>
    Gradiva in naloge:
    <br/>
    <?php
        $get_naloge_info_sql = "SELECT * FROM naloge";
        $get_naloge_info_result = mysqli_query($db, $get_naloge_info_sql);
        $get_naloge_info = mysqli_fetch_assoc($get_naloge_info_result);

        $naslov_naloge = $get_naloge_info["naslov_naloga"];
        echo "<a href='naloge.php?predmet=$ime_predmeta&naloga=$naslov_naloge'>".$naslov_naloge."</a>";

    ?>
    <br/><hr/>
    
    </div>
    <div class="rightcolumn">
    </div>
    </body>
</html>

<script>
  /*var prenesiImePredmeta = location.search.substring(1);
  var imePredmeta = decodeURIComponent(prenesiImePredmeta);
  function datotekaObstaja() {
    var status_pot = false;
    alert("I HATE YOU");
    if(confirm("Datoteka na strežniku že obstaja. Ali jo želite zamenjati?") == true)
    {
        status_pot = true;
        document.getElementById("hidden_text").value = status_pot;
    }
}*/
</script>

