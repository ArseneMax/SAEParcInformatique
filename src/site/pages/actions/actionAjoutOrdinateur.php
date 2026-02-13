<?php
include("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");

// Vérifier uniquement les 3 champs obligatoires : NAME, SERIAL, MANUFACTURER
if (isset($_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['ajouter'])) {

    $sql = "INSERT INTO ordinateur (NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB, OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR, PURCHASE_DATE, WARRANTY_END) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Gérer les valeurs optionnelles (peuvent être null ou vides)
    $model = !empty($_POST['MODEL']) ? $_POST['MODEL'] : null;
    $type = !empty($_POST['TYPE']) ? $_POST['TYPE'] : null;
    $cpu = !empty($_POST['CPU']) ? $_POST['CPU'] : null;
    $ram = !empty($_POST['RAM_MB']) ? (int)$_POST['RAM_MB'] : null;
    $disk = !empty($_POST['DISK_GB']) ? (int)$_POST['DISK_GB'] : null;
    $os = !empty($_POST['OS']) ? $_POST['OS'] : null;
    $domain = !empty($_POST['DOMAIN']) ? $_POST['DOMAIN'] : null;
    $location = !empty($_POST['LOCATION']) ? $_POST['LOCATION'] : null;
    $building = !empty($_POST['BUILDING']) ? $_POST['BUILDING'] : null;
    $room = !empty($_POST['ROOM']) ? $_POST['ROOM'] : null;
    $macaddr = !empty($_POST['MACADDR']) ? $_POST['MACADDR'] : null;
    $purchase_date = !empty($_POST['PURCHASE_DATE']) ? $_POST['PURCHASE_DATE'] : null;
    $warranty_end = !empty($_POST['WARRANTY_END']) ? $_POST['WARRANTY_END'] : null;

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssiissssssss",
        $_POST['NAME'], $_POST['SERIAL'], $_POST['MANUFACTURER'], $model, $type,
        $cpu, $ram, $disk, $os, $domain,
        $location, $building, $room, $macaddr, $purchase_date,
        $warranty_end
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