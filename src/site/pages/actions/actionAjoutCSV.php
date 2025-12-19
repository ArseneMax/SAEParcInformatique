<?php
require_once("../../fonctions/database.php");

if (isset($_POST['submit']) && isset($_POST['type_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];

        $insertLog = "INSERT INTO journal (login,ip,role,action,date) VALUES (?,?,?,?,?)";
        $stmt2 = mysqli_prepare($connect,$insertLog);

        session_start();
        $login=$_SESSION['login'];
        $role=$_SESSION['role'];
        $date = date("Y-m-d");
        $ip =  $_SERVER['REMOTE_ADDR'];



        if (($handle = fopen($file, 'r')) !== FALSE) {
            fgetcsv($handle);

            if ($_POST['type_csv'] == "moniteurs") {
                $insert = "INSERT INTO moniteur (SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO) VALUES (?,?,?,?,?,?,?)";
                $checkSerialQuery = "SELECT COUNT(*) FROM moniteur WHERE SERIAL = ?";

                if (!$connect) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $action = "Import de moniteurs via CSV";

                if ($stmt = mysqli_prepare($connect, $insert)) {
                    if ($checkStmt = mysqli_prepare($connect, $checkSerialQuery)) {
                        $errorOccurred = false;

                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            if (count($data) == 7) {
                                mysqli_stmt_bind_param($checkStmt, 's', $data[0]);

                                mysqli_stmt_execute($checkStmt);

                                mysqli_stmt_bind_result($checkStmt, $count);
                                mysqli_stmt_fetch($checkStmt);

                                mysqli_stmt_free_result($checkStmt);

                                if ($count > 0) {
                                    $errorOccurred = true;
                                } else {
                                    mysqli_stmt_bind_param($stmt, 'sssisss', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
                                    mysqli_stmt_execute($stmt);
                                }
                            } else {
                                header("Location: ../ajoutCSVMachines.php?error=invalid_columns");
                                exit();
                            }
                        }

                        if ($errorOccurred) {
                            header("Location: ../ajoutCSVMachines.php?error=serial_exists");
                            exit();
                        }
                        mysqli_stmt_bind_param($stmt2,"sssss",$login,$ip,$role,$action,$date);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_close($stmt2);

                        header("Location: ../ajoutCSVMachines.php?sucess");
                        exit();
                    } else {
                        die('Error preparing check serial query: ' . mysqli_error($connect));
                    }
                } else {
                    die('Error preparing insert query: ' . mysqli_error($connect));
                }
            }

            if ($_POST['type_csv'] == "ordinateurs") {
                $insert = "INSERT INTO ordinateur (NAME, SERIAL, MANUFACTURER, MODEL, TYPE, CPU, RAM_MB, DISK_GB, OS, DOMAIN, LOCATION, BUILDING, ROOM, MACADDR, PURCHASE_DATE, WARRANTY_END) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $checkSerialQuery = "SELECT COUNT(*) FROM ordinateur WHERE NAME = ?";

                if (!$connect) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $action = "Import d'ordinateurs via CSV";

                if ($stmt = mysqli_prepare($connect, $insert)) {
                    if ($checkStmt = mysqli_prepare($connect, $checkSerialQuery)) {
                        $errorOccurred = false;

                        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            if (count($data) == 16) {
                                mysqli_stmt_bind_param($checkStmt, 's', $data[0]);

                                mysqli_stmt_execute($checkStmt);

                                mysqli_stmt_bind_result($checkStmt, $count);
                                mysqli_stmt_fetch($checkStmt);

                                mysqli_stmt_free_result($checkStmt);

                                if ($count > 0) {
                                    $errorOccurred = true;
                                } else {
                                    mysqli_stmt_bind_param($stmt, 'ssssssiissssssss', $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6],$data[7],$data[8],$data[9],$data[10],$data[11],$data[12],$data[13],$data[14],$data[15]);
                                    mysqli_stmt_execute($stmt);
                                }
                            } else {
                                header("Location: ../ajoutCSVMachines.php?error=invalid_columns");
                                exit();
                            }
                        }

                        if ($errorOccurred) {
                            header("Location: ../ajoutCSVMachines.php?error=serial_exists");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt2,"sssss",$login,$ip,$role,$action,$date);
                        mysqli_stmt_execute($stmt2);
                        mysqli_stmt_close($stmt2);
                        header("Location: ../ajoutCSVMachines.php?sucess");
                        exit();
                    } else {
                        die('Error preparing check serial query: ' . mysqli_error($connect));
                    }
                } else {
                    die('Error preparing insert query: ' . mysqli_error($connect));
                }
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
