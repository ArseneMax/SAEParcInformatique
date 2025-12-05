<?php
include("../../fonctions/database.php");

$categorie = array('NAME', 'SERIAL', 'MANUFACTURER', 'MODEL', 'TYPE', 'CPU', 'RAM_MB', 'DISK_GB', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING', 'ROOM', 'MACADDR', 'PURCHASE_DATE', 'WARRANTY_END');

if (isset($_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['TYPE'], $_POST['CPU'], $_POST['RAM_MB'], $_POST['DISK_GB'], $_POST['OS'], $_POST['DOMAIN'], $_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'], $_POST['MACADDR'], $_POST['PURCHASE_DATE'], $_POST['WARRANTY_END'])) {

    $sql = "INSERT INTO ordinateur (NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB, OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR, PURCHASE_DATE, WARRANTY_END) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
            SERIAL = VALUES(SERIAL), MANUFACTURER = VALUES(MANUFACTURER), MODEL = VALUES(MODEL), TYPE = VALUES(TYPE), 
            CPU = VALUES(CPU), RAM_MB = VALUES(RAM_MB), DISK_GB = VALUES(DISK_GB), OS = VALUES(OS), 
            DOMAIN = VALUES(DOMAIN), LOCATION = VALUES(LOCATION), BUILDING = VALUES(BUILDING), 
            ROOM = VALUES(ROOM), MACADDR = VALUES(MACADDR), PURCHASE_DATE = VALUES(PURCHASE_DATE), 
            WARRANTY_END = VALUES(WARRANTY_END)";

    if ($stmt = mysqli_prepare($connect, $sql)) {
        // Lier les paramètres à la requête préparée
        mysqli_stmt_bind_param($stmt, "ssssssssssssssss",
            $_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['TYPE'],
            $_POST['CPU'], $_POST['RAM_MB'], $_POST['DISK_GB'], $_POST['OS'], $_POST['DOMAIN'],
            $_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'], $_POST['MACADDR'], $_POST['PURCHASE_DATE'],
            $_POST['WARRANTY_END']
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../inventory.php");
            exit;
        } else {
            echo "Erreur lors de l'insertion des données.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête.";
    }
}
?>