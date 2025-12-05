<?php
include("../../fonctions/database.php");

if (isset($_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['SIZE_INCH'], $_POST['RESOLUTION'], $_POST['CONNECTOR'], $_POST['ATTACHED_TO'],$_POST['ajouter'])) {

    $sql = "INSERT INTO moniteur (SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO) 
            VALUES (?, ?,?,?,?,?,?)";

    $size = (int)$_POST['SIZE_INCH'];

    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sssisss",
        $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $size, $_POST['RESOLUTION'], $_POST['CONNECTOR'], $_POST['ATTACHED_TO']
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../inventory.php");

}else{
    header("Location: ../ajouterMoniteur.php?error");
}
?>