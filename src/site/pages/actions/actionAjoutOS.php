<?php
session_start();


if (!isset($_SESSION['login']) || $_SESSION['login'] != 'adminweb') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OSname'])) {

    include("../../fonctions/database.php");


    $OSname = mysqli_real_escape_string($connect, trim($_POST['OSname']));

    // Vérification si champ vide
    if (empty($OSname)) {
        mysqli_close($connect);

        exit();
    }


    $check_query = "SELECT 1 FROM `OS` WHERE `OSname` = '$OSname'";
    $result = mysqli_query($connect, $check_query);


    if (mysqli_num_rows($result) > 0) {
        mysqli_close($connect);
        echo "error";
        header("location:../gestionInfos.php?error");
        exit();
    }

    $insert_query = "INSERT INTO `OS` (`OSname`) VALUES ('$OSname')";

    if (!mysqli_query($connect, $insert_query)) {
        die("Erreur SQL INSERT : " . mysqli_error($connect));
    }

    mysqli_close($connect);
    $action = "Ajout d'un OS";
    insertionLog($action);

    echo "success";
    header("location:../gestionInfos.php?success");
    exit();

} else {
    header('Location: ../gestion_infos.php');
    exit();
}
?>
