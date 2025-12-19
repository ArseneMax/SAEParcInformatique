<?php
include("../../fonctions/database.php");

if (isset($_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['TYPE'], $_POST['CPU'], $_POST['RAM_MB'], $_POST['DISK_GB'], $_POST['OS'], $_POST['DOMAIN'], $_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'], $_POST['MACADDR'], $_POST['PURCHASE_DATE'], $_POST['WARRANTY_END'],$_POST['ajouter'])) {

    $sql = "INSERT INTO ordinateur (NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB, OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR, PURCHASE_DATE, WARRANTY_END) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertLog = "INSERT INTO journal (login,ip,role,action,date) VALUES (?,?,?,?,?)";
    $ram = (int)$_POST['RAM_MB'];
    $dis = (int)$_POST['DISK_GB'];

    $stmt2 = mysqli_prepare($connect,$insertLog);
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssiissssssss",
            $_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['TYPE'],
            $_POST['CPU'],$ram, $dis, $_POST['OS'], $_POST['DOMAIN'],
            $_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'], $_POST['MACADDR'], $_POST['PURCHASE_DATE'],
            $_POST['WARRANTY_END']
        );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();
    $login=$_SESSION['login'];
    $role=$_SESSION['role'];
    $date = date("Y-m-d");
    $ip =  $_SERVER['REMOTE_ADDR'];
    $action = "Ajout d'un ordinateur";
    mysqli_stmt_bind_param($stmt2,"sssss",$login,$ip,$role,$action,$date);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
    header("Location: ../inventory.php");

}else{
    header("Location: ../ajouterMachine.php?error");
}
?>