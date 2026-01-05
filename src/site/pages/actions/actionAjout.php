<?php
$nom_BD = "PARKIT";

include("../../fonctions/database.php");
include("../../fonctions/fonctionsLog.php");

if (isset($_POST['login'], $_POST['password'], $_POST['creation'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $role = "tech";

    if ($login != "" && $password != "") {
        $select = "SELECT * FROM users WHERE login = '$login'";
        $requete_log = mysqli_query($connect,$select);
        if (mysqli_num_rows($requete_log) < 1 ) {
            $insert = "INSERT INTO users VALUES (?,?,?)";
            $requete = mysqli_prepare($connect, $insert);
            mysqli_stmt_bind_param($requete, "sss", $login, $password,$role);
            mysqli_stmt_execute($requete);
            mysqli_stmt_close($requete);
            $action = "Ajout d'un technicien";
            insertionLog($action);

            header('location:../adminweb.php?success');
        }
        else{

            header('location:../adminweb.php?error');
        }

    } else {
        header('location:../adminweb.php?error');
    }
}
