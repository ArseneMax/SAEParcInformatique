<?php
$nom_BD = "PARKIT";

include("../../fonctions/database.php");

if (isset($_POST['login'],$_POST['password'],$_POST['connexion'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    if ($login !="" && $password !="") {
        $select = "SELECT * FROM users WHERE login = '$login' and mdp = '$password'";
        $requete_log = mysqli_query($connect,$select);
        if (mysqli_num_rows($requete_log) == 1 ) {
            $user = mysqli_fetch_assoc($requete_log);
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['role'] = $user['role'];
            header("location:../index.php");
        }
        else{
            echo "error";
            header("location:../connexion.php?error");
        }
    }else{
        header('location:../connexion.php?error');
    }
}