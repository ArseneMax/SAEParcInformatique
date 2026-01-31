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
    echo '<h2>Gestion des suppressions - Table de rebut</h2>';

    echo '<div class="info-box">';
    echo '<p><strong>Cette page permet de contrôler les suppressions dans la table de rebut.</strong></p>';
    echo '<ul>';
    echo '<strong>INACTIF (BLOQUÉ)</strong> : Aucun élément ne peut être ajouté/supprimé de la table de rebut';
    echo '<br>';
    echo '<strong>ACTIF (DÉBLOQUÉ)</strong> : Les suppressions/ajouts sont autorisées dans la table de rebut';
    echo '</ul>';
    echo '</div>';

    if ($est_bloque) {
        echo '<div class="status-inactive">';
        echo '<h3> État actuel : INACTIF (BLOQUÉ)</h3>';
        echo '<p><strong>Les modifications sont actuellement INTERDITES.</strong></p>';
        echo '<p>Aucun utilisateur ne peut modifier des éléments de la table de rebut.</p>';
        echo '</div>';
    } else {
        echo '<div class="status-active">';
        echo '<h3> État actuel : ACTIF (DÉBLOQUÉ)</h3>';
        echo '<p><strong>Les modifications sont actuellement AUTORISÉES.</strong></p>';
        echo '<p>Les utilisateurs peuvent mofifier des éléments de la table de rebut.</p>';
        echo '</div>';
    }

    echo '<div class="toggle-button-container">';
    echo '<form method="post">';
    echo '<button type="submit" name="toggle_blocage" class="bouton_ajout">';
    echo $est_bloque ? ' DÉBLOQUER - Autoriser les modifications' : ' BLOQUER - Interdire les modifications';
    echo '</button>';
    echo '</form>';
    echo '</div>';


    echo '</div>';
}
?>
</body>
</html>