<?php
/* Ključi za vpis v podatkovno bazo z definiranim uporabnikom in geslom  */
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'smerxana');
define('DB_PASSWORD', 'chicken123');
define('DB_NAME', 'solska_evidenca');
 
/* Poskusimo se povezati s podatkovno bazo */
$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Preveri povezavo
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>