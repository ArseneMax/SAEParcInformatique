<?php
require_once("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");

if (isset($_POST['submit']) && isset($_POST['type_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];

        $statut = 'actif';

        if (($handle = fopen($file, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Lecture de la première ligne (entêtes)

            // Définir les colonnes requises en fonction du type sélectionné
            if ($_POST['type_csv'] == "moniteurs") {
                $requiredColumns = ['SERIAL'];
                $insertQuery = "INSERT INTO moniteur (SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO,statut) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
                $checkSerialQuery = "SELECT COUNT(*) FROM moniteur WHERE SERIAL = ?";
                $action = "Import de moniteurs via CSV";
            } elseif ($_POST['type_csv'] == "ordinateurs") {
                $requiredColumns = ['NAME', 'SERIAL'];
                $insertQuery = "INSERT INTO ordinateur (NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB, OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR, PURCHASE_DATE, WARRANTY_END, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $checkSerialQuery = "SELECT COUNT(*) FROM ordinateur WHERE NAME = ?";
                $action = "Import d'ordinateurs via CSV";
            } else {
                header("Location: ../ajoutCSVMachines.php?error=invalid_type");
                exit();
            }

            // Vérification que les colonnes requises existent dans l'en-tête
            $columnsFound = array_intersect($header, $requiredColumns);
            if (count($columnsFound) != count($requiredColumns)) {
                header("Location: ../ajoutCSVMachines.php?error=missing_columns");
                exit();
            }

            // Préparation de la connexion
            if (!$connect) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if ($stmt = mysqli_prepare($connect, $insertQuery)) {
                if ($checkStmt = mysqli_prepare($connect, $checkSerialQuery)) {
                    $errorOccurred = false;

                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        // Mapper les données CSV avec les noms de colonnes
                        $dataMap = array_combine($header, $data);

                        // Remplacer les valeurs vides par NULL
                        if ($_POST['type_csv'] == "moniteurs") {
                            $serial = !empty($dataMap['SERIAL']) ? $dataMap['SERIAL'] : NULL;
                            $manufacturer = !empty($dataMap['MANUFACTURER']) ? $dataMap['MANUFACTURER'] : NULL;
                            $model = !empty($dataMap['MODEL']) ? $dataMap['MODEL'] : NULL;
                            $size_inch = !empty($dataMap['SIZE_INCH']) ? $dataMap['SIZE_INCH'] : NULL;
                            $resolution = !empty($dataMap['RESOLUTION']) ? $dataMap['RESOLUTION'] : NULL;
                            $connector = !empty($dataMap['CONNECTOR']) ? $dataMap['CONNECTOR'] : NULL;
                            $attached_to = !empty($dataMap['ATTACHED_TO']) ? $dataMap['ATTACHED_TO'] : NULL;

                            // Vérification de la présence du SERIAL
                            mysqli_stmt_bind_param($checkStmt, 's', $serial);
                        } elseif ($_POST['type_csv'] == "ordinateurs") {
                            $name = !empty($dataMap['NAME']) ? $dataMap['NAME'] : NULL;
                            $serial = !empty($dataMap['SERIAL']) ? $dataMap['SERIAL'] : NULL;
                            $manufacturer = !empty($dataMap['MANUFACTURER']) ? $dataMap['MANUFACTURER'] : NULL;
                            $model = !empty($dataMap['MODEL']) ? $dataMap['MODEL'] : NULL;
                            $type = !empty($dataMap['TYPE']) ? $dataMap['TYPE'] : NULL;
                            $cpu = !empty($dataMap['CPU']) ? $dataMap['CPU'] : NULL;
                            $ram_mb = !empty($dataMap['RAM_MB']) ? $dataMap['RAM_MB'] : NULL;
                            $disk_gb = !empty($dataMap['DISK_GB']) ? $dataMap['DISK_GB'] : NULL;
                            $os = !empty($dataMap['OS']) ? $dataMap['OS'] : NULL;
                            $domain = !empty($dataMap['DOMAIN']) ? $dataMap['DOMAIN'] : NULL;
                            $location = !empty($dataMap['LOCATION']) ? $dataMap['LOCATION'] : NULL;
                            $building = !empty($dataMap['BUILDING']) ? $dataMap['BUILDING'] : NULL;
                            $room = !empty($dataMap['ROOM']) ? $dataMap['ROOM'] : NULL;
                            $macaddr = !empty($dataMap['MACADDR']) ? $dataMap['MACADDR'] : NULL;
                            $purchase_date = !empty($dataMap['PURCHASE_DATE']) ? $dataMap['PURCHASE_DATE'] : NULL;
                            $warranty_end = !empty($dataMap['WARRANTY_END']) ? $dataMap['WARRANTY_END'] : NULL;

                            // Vérification de la présence du NAME
                            mysqli_stmt_bind_param($checkStmt, 's', $name);
                        }

                        mysqli_stmt_execute($checkStmt);
                        mysqli_stmt_bind_result($checkStmt, $count);
                        mysqli_stmt_fetch($checkStmt);
                        mysqli_stmt_free_result($checkStmt);

                        if ($count > 0) {
                            $errorOccurred = true;
                        } else {
                            // Insertion des données dans la base
                            if ($_POST['type_csv'] == "moniteurs") {
                                mysqli_stmt_bind_param($stmt, 'sssissss', $serial, $manufacturer, $model, $size_inch, $resolution, $connector, $attached_to,$statut);
                            } elseif ($_POST['type_csv'] == "ordinateurs") {
                                mysqli_stmt_bind_param($stmt, 'ssssssiisssssssss', $name, $serial, $manufacturer, $model, $type, $cpu, $ram_mb, $disk_gb, $os, $domain, $location, $building, $room, $macaddr, $purchase_date, $warranty_end,$statut);
                            }
                            mysqli_stmt_execute($stmt);
                        }
                    }

                    if ($errorOccurred) {
                        header("Location: ../ajoutCSVMachines.php?error=name_exists");
                        exit();
                    }

                    insertionLog($action);
                    header("Location: ../ajoutCSVMachines.php?success");
                    exit();
                } else {
                    die('Error preparing check serial query: ' . mysqli_error($connect));
                }
            } else {
                die('Error preparing insert query: ' . mysqli_error($connect));
            }

            fclose($handle);
        } else {
            header("Location: ../ajoutCSVMachines.php?error=file_open");
            exit();
        }
    } else {
        header("Location: ../ajoutCSVMachines.php?error=file_upload");
        exit();
    }
} else {
    header("Location: ../pages/ajoutCSVMachines.php?error=form_submit");
    exit();
}

$connect->close();
