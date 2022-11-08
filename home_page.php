<?php
   include('session.php');
?>
      <!--<?php echo $login_session; ?>-->
<!DOCTYPE html>
<html>
<head>
<style>

</style>
  <link rel="stylesheet" href="solska_evidenca_styles.css">
</head>
<body>
<?php
   include('header.html');
?>
<div class="row">
  <div class="leftcolumn">
    <div class="card">
      <h1>Predmeti, ki jih obiskujete</h1>
      <div>
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
                        echo "<a href='predmeti.php?predmet=$row[ime_predmet]'>".$row['ime_predmet']."</a><br/>";
                    }
                }
            ?>
        </div>
    </div>
    <div class="card">
      <h2>TITLE HEADING</h2>
      <h5>Title description, Sep 2, 2017</h5>
      <div class="fakeimg" style="height:200px;">Image</div>
      <p>Some text..</p>
      <p>Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
    </div>
  </div>
  <div class="rightcolumn">
    <div class="card">
      <h2>Uporabniški profil</h2>
      <div class="fakeimg" style="height:100px;">Image</div>
      <p><?php echo $login_session; ?></p>
      <p><a href="profil.php">Urejanje uporabniškega profila</a></p>
      <p><a href = "logout.php">Izpis</a></p>
    </div>
    <div class="card">
      <div><a href="urejanje_predmetov.php">Predmeti</a></div>
      <div>Ocene</div>
      <div>Datoteke</div>
    </div>
    <div class="card">
      <h3>Follow Me</h3>
      <p>Some text..</p>
    </div>
  </div>
</div>

<div class="footer">
  <h2>Footer</h2>
</div>
</body>
</html>


