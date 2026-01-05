<?php
include("../../fonctions/database.php");
$categorie = array('SERIAL', 'MANUFACTURER', 'MODEL', 'SIZE_INCH', 'RESOLUTION', 'CONNECTOR','ATTACHED_TO');

$sql = "UPDATE moniteur SET ";

for ($i=1; $i<count($categorie); $i++){
    if ($i != 1){
        $sql .= " , ";
    }
    $sql .= $categorie[$i]." = '" . $_POST[$categorie[$i]] . "'";
}
$sql .= " WHERE SERIAL ='" . $_POST['SERIAL'] . "'";


$requete_log = mysqli_query($connect, $sql);
$action = "Modification d'un Moniteur";
insertionLog($action);


header("location:../inventory.php");

