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
    ?>
    <div class="leftcolumn">
        <div>
            Seznam predmetov, ki jih obiskujete:
            <?php
                $id_uporabnik_sql = "SELECT id_uporabnik FROM uporabniki WHERE email = '$email'";
                $id_uporabnik_result = mysqli_query($db, $id_uporabnik_sql);
                $id_uporabnik = implode("",mysqli_fetch_assoc($id_uporabnik_result));

                $get_obiskovani_predmeti_id_sql = "SELECT id_predmet FROM uporabniki_predmeti WHERE id_uporabnik = '$id_uporabnik'";
                $get_obiskovani_predmeti_id_result = mysqli_query($db, $get_obiskovani_predmeti_id_sql);

                while($id_predmet=mysqli_fetch_assoc($get_obiskovani_predmeti_id_result))
                {
                    foreach($id_predmet as &$value)
                    {
                        $predmeti_sql = "SELECT ime_predmet FROM predmeti WHERE id_predmet = '$value'";
                        $predmeti_result = mysqli_query($db, $predmeti_sql);
                        $row = mysqli_fetch_assoc($predmeti_result);
                        echo "<ul>".$row['ime_predmet']."</ul>";
                    }
                }
            ?>
        </div>
        <div>Dodajte nove predmete, ki jih želite obiskovati:</div>
        <br/>
        <form name="izbira_predmetov" method="POST">
            <?php
                $predmeti_sql ="SELECT p.ime_predmet
                                FROM predmeti AS p
                                WHERE p.id_predmet NOT IN (SELECT up.id_predmet 
                                                FROM uporabniki_predmeti AS up
                                                WHERE up.id_uporabnik = $id_uporabnik)"; 
                                                /*"SELECT p.ime_predmet
                                FROM predmeti AS p
                                LEFT JOIN uporabniki_predmeti AS up
                                ON p.id_predmet=up.id_predmet
                                WHERE up.id_uporabnik = $id_uporabnik AND up.id_predmet IS NULL";*/
                                $result = mysqli_query($db, $predmeti_sql);
                                if (mysqli_num_rows($result) > 0)
                                {
                                    while($row =mysqli_fetch_assoc($result))
                                    {
                                        echo '<input type="'."checkbox".'" id="'.$row['ime_predmet'].'" name ="'."predmeti[]".'" value="'.$row['ime_predmet'].'">
                                        <label for="'.$row['ime_predmet'].'"> '.$row['ime_predmet'].'</label> <br>';


                                        $error = mysqli_error($db);
                                        echo $error;
                                    }
                                }

                                /*if (mysqli_num_rows($result) > 0)
                                {
                                    while($row =mysqli_fetch_assoc($result))
                                    {
                                        echo "<input type='checkbox' id=".$row["ime_predmet"]." name='predmeti[]' value=".$row["ime_predmet"]."
                                        <label for=".$row["ime_predmet"].">".$row["ime_predmet"]."</label><br>";
                                        $error = mysqli_error($db);
                            echo $error;
                                    }
                                }*/
                
            ?>
            <input type = "submit" value = "Shrani spremembe" class="button" name="izbira_predmetov_button"/>
        </form>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                /*$id_uporabnik_sql = "SELECT id_uporabnik FROM uporabniki WHERE email = '$email'";
                $id_uporabnik_result = mysqli_query($db, $id_uporabnik_sql);
                $id_uporabnik = implode("",mysqli_fetch_assoc($id_uporabnik_result));*/

                if(isset($_POST['predmeti']))
                {
                    foreach($_POST['predmeti'] as $selected)
                    {
                        $id_predmet_sql = "SELECT id_predmet FROM predmeti WHERE ime_predmet = '$selected'";
                        $id_predmet_result = mysqli_query($db, $id_predmet_sql);
                        $id_predmet = implode("",mysqli_fetch_assoc($id_predmet_result));

                        $vstavi_predmet_sql = "INSERT INTO uporabniki_predmeti (id_uporabniki_predmeti, id_uporabnik, id_predmet) VALUES ('', '$id_uporabnik', '$id_predmet');";
                        if(mysqli_query($db, $vstavi_predmet_sql))
                        {
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                        else
                        {
                            $error = mysqli_error($db);
                            echo $error;
                        }

                    }
                }
            }
        ?>
        
        
    </div>
    <div class="rightcolumn">
        <div>Vsi predmeti, ki jih lahko obiskujete:
            <?php
            $predmeti_sql = "SELECT ime_predmet FROM predmeti";
                            $result = mysqli_query($db, $predmeti_sql);
                            if (mysqli_num_rows($result) > 0)
                            {
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    echo "<div class='display_container'>
                                                    <div class='title'>".$row["ime_predmet"]."</div>
                                        </div><br/>";
                                }
                            }
            
            ?>
        </div>
    </div>
    

    </body>
</html>