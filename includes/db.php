<?php
$host = "localhost";
$user = "rootzoo";
$pass = "brahim123";
$db   = "zoo";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur connexion DB : " . $conn->connect_error);
}
?>
