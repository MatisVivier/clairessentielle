<?php

$servername = "localhost:3306";  
$username = "clairess";         
$password = "gbf9GI2N8~~0aZ";            
$dbname = "clairess_";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

?>
