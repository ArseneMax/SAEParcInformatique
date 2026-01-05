<?php
include("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");
$categorie = array('NAME', 'SERIAL', 'MANUFACTURER', 'MODEL', 'TYPE', 'CPU', 'RAM_MB', 'DISK_GB', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING', 'ROOM', 'MACADDR', 'PURCHASE_DATE', 'WARRANTY_END');

$sql = "UPDATE ordinateur SET ";

for ($i=1; $i<count($categorie); $i++){
    if ($i != 1){
        $sql .= " , ";
    }
    $sql .= $categorie[$i]." = '" . $_POST[$categorie[$i]] . "'";
}
$sql .= " WHERE NAME ='" . $_POST['NAME'] . "'";


$requete_log = mysqli_query($connect, $sql);
$action = "Modification d'un Ordinateur";
insertionLog($action);

header("location:../inventory.php");
