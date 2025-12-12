<?php
require_once("../../fonctions/database.php");

if (isset($_POST['submit']) && isset($_POST['type_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];

        if (($handle = fopen($file, 'r')) !== FALSE) {
            fgetcsv($handle);

            if ($_POST['type_csv'] == "connexions") {
                $insert = "INSERT INTO connexions (login, ip_address, duration_seconds) VALUES (?, ?, ?)";
                if ($stmt = $connect->prepare($insert)) {
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        if (count($data) == 3) {
                            $stmt->bind_param('sss', $data[0], $data[1], $data[2]);
                            $stmt->execute();
                        } else {
                            header("Location: ../ajoutCSVMachines.php?error=invalid_columns");
                            exit();
                        }
                    }
                    header("Location: ../ajoutCSVMachines.php");
                    exit();
                }
            }

//            if ($_POST['type_csv'] == "moniteurs") {
//                $insert = "INSERT INTO moniteur (SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO) VALUES (?,?,?,?,?,?,?)";
//                //$insert = "INSERT INTO moniteur (SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO, statut) VALUES (?,?,?,?,?,?,?,?)";
//                $checkSerialQuery = "SELECT COUNT(*) FROM moniteur WHERE SERIAL = ?";
//
//                if ($stmt = $connect->prepare($insert) && $checkStmt = $connect->prepare($checkSerialQuery)) {
//                    $errorOccurred = false;
//
//                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
//                        if (count($data) == 7) {
//                            $checkStmt->bind_param('s', $data[0]);
//                            $checkStmt->execute();
//                            $checkStmt->bind_result($count);
//                            $checkStmt->fetch();
//
//                            if ($count > 0) {
//                                $errorOccurred = true;
//                            } else {
//                                //$status = "actif";
//                                //$stmt->bind_param('ssssssss', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $status);
//                                $stmt->bind_param('sssisss', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
//                                $stmt->execute();
//                            }
//                        } else {
//                            header("Location: ../ajoutCSVMachines.php?error=invalid_columns");
//                            exit();
//                        }
//                    }
//
//                    if ($errorOccurred) {
//                        header("Location: ../ajoutCSVMachines.php?error=serial_exists");
//                        exit();
//                    }
//
//                    header("Location: ../ajoutCSVMachines.php");
//                    exit();
//                }
//            }

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
?>
