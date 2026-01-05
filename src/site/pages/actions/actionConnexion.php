<?php
$nom_BD = "PARKIT";

include("../../fonctions/database.php");

if (isset($_POST['login'],$_POST['password'],$_POST['connexion'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    if ($login !="" && $password !="") {
        $insertLog = "INSERT INTO journal (login,ip,role,action,date,heure) VALUES (?,?,?,?,?,?)";
        $select = "SELECT * FROM users WHERE login = '$login' and mdp = '$password'";
        $requete_log = mysqli_query($connect,$select);
        $stmt = mysqli_prepare($connect,$insertLog);
        if (mysqli_num_rows($requete_log) == 1 ) {
            $user = mysqli_fetch_assoc($requete_log);
            session_start();
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['role'] = $user['role'];
            $role = $_SESSION['role'];
            $date = date("Y-m-d");
            $ip =  $_SERVER['REMOTE_ADDR'];
            $action = "connexion";
            $heure = date("H:i:s");
            mysqli_stmt_bind_param($stmt,"ssssss",$login,$ip,$role,$action,$date,$heure);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
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