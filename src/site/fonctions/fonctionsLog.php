<?php
include("database.php");

function insertionLog($action){
    global $connect;
    $insertLog = "INSERT INTO journal (login,ip,role,action,date,heure) VALUES (?,?,?,?,?,?)";
    $stmt2 = mysqli_prepare($connect,$insertLog);
    session_start();
    $login = $_SESSION['login'];
    $role = $_SESSION['role'];
    $date = date("Y-m-d");
    $ip =  $_SERVER['REMOTE_ADDR'];
    $heure = date("H:i:s");
    mysqli_stmt_bind_param($stmt2,"ssssss",$login,$ip,$role,$action,$date,$heure);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
}
