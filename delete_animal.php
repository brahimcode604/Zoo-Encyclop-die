<?php
include "includes/db.php";

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM animal WHERE id = $id");
}

// Retour à la liste + message
echo "Location: liste_animaux_sup.php?delete = ${$_POST['id']}";

header("Location: index.php");
            exit();




 
?>
