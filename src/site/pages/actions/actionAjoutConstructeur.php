<?php
session_start();


if (!isset($_SESSION['login']) || $_SESSION['login'] != 'adminweb') {
    header('Location: ../index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Cname'])) {

    include("../../fonctions/database.php");
    include("../../fonctions/fonctionsLog.php");


    $Cname = mysqli_real_escape_string($connect, trim($_POST['Cname']));


    if (empty($Cname)) {
        mysqli_close($connect);

        exit();
    }


    $check_query = "SELECT 1 FROM `constructeur` WHERE `Cname` = '$Cname'";
    $result = mysqli_query($connect, $check_query);


    if (mysqli_num_rows($result) > 0) {
        mysqli_close($connect);
        echo "error";
        header("location:../gestionInfos.php?errorC");
        exit();
    }

    $insert_query = "INSERT INTO `constructeur` (`Cname`) VALUES ('$Cname')";

    if (!mysqli_query($connect, $insert_query)) {
        die("Erreur SQL INSERT : " . mysqli_error($connect));
    }
    $action = "Ajout d'un Constructeur";
    insertionLog($action);

    mysqli_close($connect);
    echo "success";
    header("location:../gestionInfos.php?successC");
    exit();

} else {
    header('Location: ../gestion_infos.php');
    exit();
}
?>
