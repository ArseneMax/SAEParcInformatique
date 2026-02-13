<?php
include("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");

// Vérifier uniquement les 3 champs obligatoires : SERIAL, MANUFACTURER, MODEL
if (isset($_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['ajouter'])) {
    $sql = "INSERT INTO moniteur (SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO) 
            VALUES (?, ?,?,?,?,?,?)";

    // Gérer les valeurs optionnelles (peuvent être null ou vides)
    $size = !empty($_POST['SIZE_INCH']) ? (int)$_POST['SIZE_INCH'] : null;
    $resolution = !empty($_POST['RESOLUTION']) ? $_POST['RESOLUTION'] : null;
    $connector = !empty($_POST['CONNECTOR']) ? $_POST['CONNECTOR'] : null;
    $attached_to = !empty($_POST['ATTACHED_TO']) ? $_POST['ATTACHED_TO'] : null;

    $stmt2 = mysqli_prepare($connect,$insertLog);
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "sssisss",
        $_POST['SERIAL'], $_POST['MANUFACTURER'], $_POST['MODEL'], $size, $resolution, $connector, $attached_to
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    session_start();

    $action = "Ajout d'un moniteur";
    insertionLog($action);
    header("Location: ../inventory.php");

}else{
    header("Location: ../ajouterMoniteur.php?error");
}
?>