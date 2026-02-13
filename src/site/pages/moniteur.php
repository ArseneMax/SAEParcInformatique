<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";
include("../fragment/navbarTech.php");
?>


<?php
include("../fonctions/database.php");
if (isset($_SESSION['login'])) {

    // Vérification du statut de la table rebut
    $sql_rebut = "SELECT statut FROM config_rebut WHERE id = 1";
    $result_rebut = mysqli_query($connect, $sql_rebut);
    $row_rebut = mysqli_fetch_assoc($result_rebut);
    $table_bloquee = ($row_rebut['statut'] == 'inactif');

    $lignes_par_page = 10;
    $page_actuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page_actuelle - 1) * $lignes_par_page;


    $sql_count = "SELECT COUNT(*) as total FROM moniteur";
    $result_count = mysqli_query($connect, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_lignes = $row_count['total'];
    $total_pages = ceil($total_lignes / $lignes_par_page);

    if (isset($_POST['MANUFACTURER'], $_POST['MODEL'], $_POST['SIZE_INCH'], $_POST['RESOLUTION'], $_POST['CONNECTOR'])) {
        if ($_POST['MANUFACTURER'] == "") {
            $MANUFACTURER="";
        }else{
            $MANUFACTURER = "AND MANUFACTURER='" . $_POST['MANUFACTURER'] . "'";
        }
        if ($_POST['MODEL'] == "") {
            $MODEL="";
        }else{
            $MODEL = "AND MODEL='" . $_POST['MODEL'] . "'";
        }
        if ($_POST['SIZE_INCH'] == "") {
            $SIZE_INCH="";
        }else{
            $SIZE_INCH = "AND SIZE_INCH='" . $_POST['SIZE_INCH'] . "'";
        }
        if ($_POST['RESOLUTION'] == "") {
            $RESOLUTION="";
        }else{
            $RESOLUTION = "AND RESOLUTION='" . $_POST['RESOLUTION'] . "'";
        }
        if ($_POST['CONNECTOR'] == "") {
            $CONNECTOR="";
        }else{
            $CONNECTOR = "AND CONNECTOR='" . $_POST['CONNECTOR'] . "'";
        }

        $sql = "SELECT * FROM moniteur WHERE statut = 'actif' $MANUFACTURER $MODEL $SIZE_INCH $RESOLUTION $CONNECTOR LIMIT $lignes_par_page OFFSET $offset";
    }else{
        $sql = "SELECT * FROM moniteur WHERE statut = 'actif' LIMIT $lignes_par_page OFFSET $offset";
    }

    $result = mysqli_query($connect, $sql);

    echo '<div class="tech-content">
    <h1 class="page-title">Gestion du Matériel</h1>';

    if ($table_bloquee) {
        echo '<div class="alert-warning">
                <strong>⚠ ATTENTION :</strong> La table de rebut est actuellement en statut INACTIF (bloquée). Aucune suppression n\'est possible.
              </div>';
    }

    if (isset($_GET['error']) && $_GET['error'] == 'table_bloquee') {
        echo '<div class="alert-warning">
                <strong>⚠ Action refusée :</strong> La table de rebut est en statut INACTIF. Contactez l\'administrateur.
              </div>';
    }

    /*                                formulaire pour les filtre                                   */
    $categorie = [
            'MANUFACTURER', 'MODEL', 'SIZE_INCH', 'RESOLUTION', 'CONNECTOR'
    ];

    echo "<div class='form-container'>
            <h1 class='form-title'>Filtrer les Moniteurs </h1>";

    echo '<form method="post" action="moniteur.php" id="filtrerMoniteur">';

    for ($i = 0; $i < count($categorie); $i++) {
        echo '<div class="form-group">';
        echo '<label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                  <select name="' . $categorie[$i] . '" id="' . $categorie[$i] . '" form="filtrerMoniteur">
                  <option value="">--choisir un '.$categorie[$i].'--</option>';
        $sql1 = "SELECT DISTINCT($categorie[$i]) FROM moniteur";
        $result1 = mysqli_query($connect, $sql1);
        while ($ligne1 = mysqli_fetch_row($result1)) {
            echo '<option value="' . $ligne1[0] . '">' . $ligne1[0] . '</option>';
        }
        echo '</select>';
        echo '</div>';
    }

    echo '<button type="submit" class="form-button" name="filtrer">Filtrer</button>
              </form>
              </div>';

    echo'<table>
        <caption>
        Table des Moniteurs
        </caption>
            <thead>
            <tr>
                <th>SERIAL</th>
                <th>MANUFACTURER</th>
                <th>MODEL</th>
                <th>SIZE_INCH</th>
                <th>RESOLUTION</th>
                <th>CONNECTOR</th>
                <th>ATTACHED_TO</th>
                <th>MODIFICATION</th>';
    if ($_SESSION['role'] == 'tech') {
        echo '<th>SUPPRESSION</th>';
    }

    echo '</tr>
        </thead>
        <tbody>';

    while ($ligne = mysqli_fetch_row($result)) {
        array_pop($ligne);
        echo "<tr>";
        foreach ($ligne as $valeur) {
            echo "<td>" . htmlspecialchars($valeur) . "</td>";
        }
        echo "<td>
                <form method='post' action='modification.php'>
                    <input type='hidden' name='SerialMoniteur' value='". htmlspecialchars($ligne[0]);
        echo "'>    
                    <button type='submit' class='bouton_ajout'>Modifier</button>
                </form></td>";

        if ($_SESSION['role'] == 'tech') {
            echo "<td>
                        <form method='post' action='actions/actionSupressionMachine.php'
                            onsubmit=\"return confirm('Supprimer ce moniteur ?');\">
                            <input type='hidden' name='moniteur' value='". htmlspecialchars($ligne[0]) ."'>
                            <button type='submit' class='bouton_ajout' " . ($table_bloquee ? 'disabled' : '') . ">Supprimer</button>
                        </form>
                    </td>";
        }

        echo "</tr>";
    }

    echo "</tbody></table>";


    if ($total_pages > 1) {
        echo '<div class="pagination">';


        if ($page_actuelle > 1) {
            echo '<a href="?page=' . ($page_actuelle - 1) . '">« Précédent</a>';
        } else {
            echo '<span class="page-disabled">« Précédent</span>';
        }


        $range = 2;


        if ($page_actuelle > $range + 2) {
            echo '<a href="?page=1">1</a>';
            echo '<span class="page-dots">...</span>';
        }


        for ($i = max(1, $page_actuelle - $range); $i <= min($total_pages, $page_actuelle + $range); $i++) {
            if ($i == $page_actuelle) {
                echo '<span class="page-active">' . $i . '</span>';
            } else {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        }


        if ($page_actuelle < $total_pages - $range - 1) {
            echo '<span class="page-dots">...</span>';
            echo '<a href="?page=' . $total_pages . '">' . $total_pages . '</a>';
        }


        if ($page_actuelle < $total_pages) {
            echo '<a href="?page=' . ($page_actuelle + 1) . '">Suivant »</a>';
        } else {
            echo '<span class="page-disabled">Suivant »</span>';
        }


        echo '<div class="page-jump">';
        echo '<form method="get" action="" style="display: inline-flex; gap: 5px; align-items: center;">';
        echo '<span>Page :</span>';
        echo '<input type="number" name="page" min="1" max="' . $total_pages . '" value="' . $page_actuelle . '" style="width: 60px; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">';
        echo '<button type="submit">Aller</button>';
        echo '</form>';
        echo '</div>';

        echo '</div>';
    }

    echo '</div>';
}
?>
</body>

</html>