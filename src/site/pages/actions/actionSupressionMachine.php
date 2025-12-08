<?php
include("../../fonctions/database.php");


if (isset($_POST['ordinateur'])) {

    $ordinateur = mysqli_real_escape_string($connect, $_POST['ordinateur']);


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


    $sql = "UPDATE moniteur SET statut = 'inactif' WHERE SERIAL = ?";


    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $moniteur);


    if (mysqli_stmt_execute($stmt)) {

        header("Location: ../rebut.php");
    } else {

        header("Location: ../inventory.php?error");
    }


    mysqli_stmt_close($stmt);
} else {

    header("Location: ../inventory.php?error");
}

?>