<?php
session_start();
include("../../fonctions/database.php");

if (isset($_POST['submit'])){
    if ($_POST['objects'] == "moniteurs"){
        $filename = "moniteurs_rebut.csv";
        $sql = "SELECT SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO
            FROM moniteur
            WHERE statut = 'inactif'";
    }
    if ($_POST['objects'] == "ordinateurs"){
        $filename = "ordinateurs_rebut.csv";
        $sql = "SELECT NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB,
                   OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR,
                   PURCHASE_DATE, WARRANTY_END
            FROM ordinateur
            WHERE statut = 'inactif'";
    }
}

$result = mysqli_query($connect, $sql);

if (!$result) {
    die("Erreur SQL : " . mysqli_error($connect));
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');
$fields = mysqli_fetch_fields($result);
$headers = [];

foreach ($fields as $field) {
    $headers[] = $field->name;
}
fputcsv($output, $headers, ',');

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, $row, ',');
}

fclose($output);
exit;
