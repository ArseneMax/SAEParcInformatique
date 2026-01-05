<?php
include("../../fonctions/database.php");

$sql = "SELECT statut FROM config_rebut WHERE id = 1";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


if ($row['statut'] == 'inactif') {
    header("Location: ../supression.php?error=table_bloquee");
    exit;
}

if (isset($_POST['ordinateur'])) {

    $ordinateur = mysqli_real_escape_string($connect, $_POST['ordinateur']);
    $action = "Suppression d'un Ordinateur";

    $sql = "UPDATE ordinateur SET statut = 'inactif' WHERE NAME = ?";


    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $ordinateur);


    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../rebut.php");
    } else {

        header("Location: ../inventory.php?error");
    }


    mysqli_stmt_close($stmt);
}

if (isset($_POST['moniteur'])) {

    $moniteur = mysqli_real_escape_string($connect, $_POST['moniteur']);
    $action = "Suppression d'un Moniteur";


    $sql = "UPDATE moniteur SET statut = 'inactif' WHERE SERIAL = ?";


    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $moniteur);


    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../rebut.php");
    } else {

        header("Location: ../inventory.php?error");
    }
    insertionLog($action);

    mysqli_stmt_close($stmt);
}

?>