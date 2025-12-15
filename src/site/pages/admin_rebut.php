<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";
include("../fragment/navbarAdmin.php");
include("../fonctions/database.php");
?>

<body>
<?php
if (isset($_SESSION['login'])|| $_SESSION['login'] == 'adminweb') {

    $sql = "SELECT statut FROM config_rebut WHERE id = 1";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $statut_actuel = $row['statut'];

    $est_bloque = ($statut_actuel == 'inactif');

    if (isset($_POST['toggle_blocage'])) {
        $nouveau_statut = $est_bloque ? 'actif' : 'inactif';
        $sql = "UPDATE config_rebut SET statut = ? WHERE id = 1";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $nouveau_statut);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: admin_rebut.php");
        exit;
    }

    echo '<div class="main-content">';
    echo '<h2>Administration de la table de rebut</h2>';

    if ($est_bloque) {
        echo '<div class="status-inactive">';
        echo '<h3> État actuel : INACTIF (BLOQUÉE)</h3>';
        echo '<p>Aucune suppression n\'est possible dans la table de rebut.</p>';
        echo '</div>';
    } else {
        echo '<div class="status-active">';
        echo '<h3> État actuel : ACTIF (DÉBLOQUÉE)</h3>';
        echo '<p>Les suppressions sont autorisées dans la table de rebut.</p>';
        echo '</div>';
    }

    echo '<div class="toggle-button-container">';
    echo '<form method="post">';
    echo '<button type="submit" name="toggle_blocage" class="bouton_ajout">';
    echo $est_bloque ? ' Passer en ACTIF (débloquer)' : ' Passer en INACTIF (bloquer)';
    echo '</button>';
    echo '</form>';
    echo '</div>';

    echo '</div>';
}
?>
</body>
</html>