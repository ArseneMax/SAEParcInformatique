<?php
$nom_BD = "PARKIT";

include("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");

if (isset($_POST['login'], $_POST['password'], $_POST['confirm_password'], $_POST['creation'])) {
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = "tech";

    if ($login == "" || $password == "" || $confirm_password == "") {
        header('location:../creerTech.php?error=empty');
        exit();
    }

    if (strlen($login) < 3 || strlen($password) < 3) {
        header('location:../creerTech.php?error=length');
        exit();
    }

    if ($password !== $confirm_password) {
        header('location:../creerTech.php?error=password_mismatch');
        exit();
    }

    $select = "SELECT * FROM users WHERE login = ?";
    $requete_log = mysqli_prepare($connect, $select);
    mysqli_stmt_bind_param($requete_log, "s", $login);
    mysqli_stmt_execute($requete_log);
    mysqli_stmt_store_result($requete_log);

    if (mysqli_stmt_num_rows($requete_log) < 1) {

        $insert = "INSERT INTO users (login, mdp, role) VALUES (?, ?, ?)";
        $requete = mysqli_prepare($connect, $insert);
        mysqli_stmt_bind_param($requete, "sss", $login, $password, $role);
        mysqli_stmt_execute($requete);
        mysqli_stmt_close($requete);

        $action = "Ajout d'un technicien : " . $login;
        insertionLog($action);

        header('location:../creerTech.php?success');
        exit();
    } else {
        mysqli_stmt_close($requete_log);
        header('location:../creerTech.php?error=exists');
        exit();
    }

    mysqli_stmt_close($requete_log);
} else {
    header('location:../creerTech.php?error=empty');
    exit();
}