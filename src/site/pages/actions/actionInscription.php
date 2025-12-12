<?php
$nom_BD = "PARKIT";

include("../../fonctions/database.php");

if (isset($_POST['login'],$_POST['password'],$_POST['inscription'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $role = "user";
    if ($login !="" && $password !="") {
        $select = "SELECT * FROM users WHERE login = '$login'";
        $requete_log = mysqli_query($connect,$select);
        if (mysqli_num_rows($requete_log) == 1 ) {
            header("location:../creerCompte.php?error");
        }
        else{
            $insert = "INSERT INTO users (login,mdp,role) VALUES (?,?,?) ";
            $requete = mysqli_prepare($connect,$insert);
            mysqli_stmt_bind_param($requete,"sss",$login,$password,$role);
            mysqli_stmt_execute($requete);
            mysqli_stmt_close($requete);
            header("location:../index.php");
        }
    }else{
        header('location:../creerCompte.php?error');
    }
}