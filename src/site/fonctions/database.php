<?php

$connect = mysqli_connect("localhost", "admin", "!sae2025!");
$db = mysqli_select_db($connect, "PARKIT");


if (!$connect) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

if (!$db) {
    die("Erreur de sélection de la base de données : " . mysqli_error($connect));
}

?>