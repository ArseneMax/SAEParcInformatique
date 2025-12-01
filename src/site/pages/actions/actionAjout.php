<?php
$nom_BD = "parkit";

$connect = mysqli_connect("localhost", "admin", "!sae2025!");
$db = mysqli_select_db($connect, $nom_BD);

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
            header('location:../adminweb.php');
        }
        else{

            header('location:../adminweb.php?error');
        }

    } else {
        header('location:../adminweb.php?error');
    }
}
