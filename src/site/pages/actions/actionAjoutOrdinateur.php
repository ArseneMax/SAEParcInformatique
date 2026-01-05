<?php
include("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");

if (isset($_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['TYPE'], $_POST['CPU'], $_POST['RAM_MB'], $_POST['DISK_GB'], $_POST['OS'], $_POST['DOMAIN'], $_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'], $_POST['MACADDR'], $_POST['PURCHASE_DATE'], $_POST['WARRANTY_END'],$_POST['ajouter'])) {

    $sql = "INSERT INTO ordinateur (NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB, OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR, PURCHASE_DATE, WARRANTY_END) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $ram = (int)$_POST['RAM_MB'];
    $dis = (int)$_POST['DISK_GB'];

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssiissssssss",
            $_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['TYPE'],
            $_POST['CPU'],$ram, $dis, $_POST['OS'], $_POST['DOMAIN'],
            $_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'], $_POST['MACADDR'], $_POST['PURCHASE_DATE'],
            $_POST['WARRANTY_END']
        );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $action = "Ajout d'un ordinateur";
    insertionLog($action);

    header("Location: ../inventory.php");

}else{
    header("Location: ../ajouterMachine.php?error");
}
?>