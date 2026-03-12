<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo"</header>";
include("../fragment/navbarTech.php");
?>

<body>
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


    $sql_count = "SELECT COUNT(*) as total FROM ordinateur";
    $result_count = mysqli_query($connect, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_lignes = $row_count['total'];
    $total_pages = ceil($total_lignes / $lignes_par_page);

    // Construction des paramètres filtre (GET pour persistance pagination)
    $filter_params = $_GET;
    unset($filter_params['page']);
    $filter_query = http_build_query($filter_params);
    $base_url = $filter_query ? '?' . $filter_query . '&' : '?';

    if (isset($_GET['MANUFACTURER'], $_GET['OS'], $_GET['DOMAIN'], $_GET['LOCATION'], $_GET['BUILDING'], $_GET['ROOM'])) {
        $MANUFACTURER = ($_GET['MANUFACTURER'] == "") ? "" : "AND MANUFACTURER='" . mysqli_real_escape_string($connect, $_GET['MANUFACTURER']) . "'";
        $OS           = ($_GET['OS'] == "")           ? "" : "AND OS='"           . mysqli_real_escape_string($connect, $_GET['OS'])           . "'";
        $DOMAIN       = ($_GET['DOMAIN'] == "")       ? "" : "AND DOMAIN='"       . mysqli_real_escape_string($connect, $_GET['DOMAIN'])       . "'";
        $LOCATION     = ($_GET['LOCATION'] == "")     ? "" : "AND LOCATION='"     . mysqli_real_escape_string($connect, $_GET['LOCATION'])     . "'";
        $BUILDING     = ($_GET['BUILDING'] == "")     ? "" : "AND BUILDING='"     . mysqli_real_escape_string($connect, $_GET['BUILDING'])     . "'";
        $ROOM         = ($_GET['ROOM'] == "")         ? "" : "AND ROOM='"         . mysqli_real_escape_string($connect, $_GET['ROOM'])         . "'";

        $sql = "SELECT * FROM ordinateur WHERE statut = 'actif' $MANUFACTURER $OS $DOMAIN $LOCATION $BUILDING $ROOM LIMIT $lignes_par_page OFFSET $offset";
    } else {
        $sql = "SELECT * FROM ordinateur WHERE statut = 'actif' LIMIT $lignes_par_page OFFSET $offset";
    }
    $result = mysqli_query($connect, $sql);

    echo '<div class="tech-content">';
    echo '<h1 class="page-title">Gestion du Matériel</h1>';

    // Alertes pour le statut de la table rebut
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
        'MANUFACTURER', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING',
        'ROOM'
    ];

    echo "<div class='filter-form-container'>
            <h1 class='form-title'>Filtrer les Ordinateurs</h1>";

    echo '<form method="get" action="ordinateur.php" id="filtrerOrdinateur">';

    for ($i = 0; $i < count($categorie); $i++) {
        $selected_val = isset($_GET[$categorie[$i]]) ? $_GET[$categorie[$i]] : '';
        echo '<div class="form-group">';
        echo '<label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                  <select name="' . $categorie[$i] . '" id="' . $categorie[$i] . '" form="filtrerOrdinateur">
                  <option value="">--choisir--</option>';
        $sql1 = "SELECT DISTINCT($categorie[$i]) FROM ordinateur";
        $result1 = mysqli_query($connect, $sql1);
        while ($ligne1 = mysqli_fetch_row($result1)) {
            $sel = ($ligne1[0] == $selected_val) ? ' selected' : '';
            echo '<option value="' . htmlspecialchars($ligne1[0]) . '"' . $sel . '>' . htmlspecialchars($ligne1[0]) . '</option>';
        }
        echo '</select>';
        echo '</div>';
    }

    echo '<button type="submit" class="form-button" name="filtrer">Filtrer</button>
              </form>
              </div>';


    echo "<table>
    <caption>
        Table des Ordinateurs
      </caption>
        <thead>
            <tr>
                <th>NAME</th>
                <th>SERIAL</th>
                <th>MANUFACTURER</th>
                <th>MODEL</th>
                <th>TYPE</th>
                <th>CPU</th>
                <th>RAM_MB</th>
                <th>DISK_GB</th>
                <th>OS</th>
                <th>DOMAIN</th>
                <th>LOCATION</th>
                <th>BUILDING</th>
                <th>ROOM</th>
                <th>MACADDR</th>
                <th>PURCHASE_DATE</th>
                <th>WARRANTY_END</th>
                <th>MODIFICATION</th>";
    if ($_SESSION['role'] == 'tech') {
        echo '<th>SUPPRESSION</th>';
    }

    echo "</tr>
    </thead>
    <tbody>";

    while ($ligne = mysqli_fetch_row($result)) {
        array_pop($ligne);
        echo "<tr>";
        foreach ($ligne as $valeur) {
            echo "<td>" . htmlspecialchars($valeur) . "</td>";
        }
        echo "<td>
                <form method='post' action='modification.php'>
                    <input type='hidden' name='NameMachine' value='". htmlspecialchars($ligne[0]);
        echo "'>    
                    <button type='submit' class='bouton_ajout'>Modifier</button>
                </form></td>";

        if ($_SESSION['role'] == 'tech') {
            echo "<td>
                <form method='post' action='actions/actionSupressionMachine.php'
                    onsubmit=\"return confirm('Supprimer ce moniteur ?');\">
                    <input type='hidden' name='ordinateur' value='". htmlspecialchars($ligne[0]) ."'>
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
            echo '<a href="' . $base_url . 'page=' . ($page_actuelle - 1) . '">« Précédent</a>';
        } else {
            echo '<span class="page-disabled">« Précédent</span>';
        }

        $range = 2;

        if ($page_actuelle > $range + 2) {
            echo '<a href="' . $base_url . 'page=1">1</a>';
            echo '<span class="page-dots">...</span>';
        }

        for ($i = max(1, $page_actuelle - $range); $i <= min($total_pages, $page_actuelle + $range); $i++) {
            if ($i == $page_actuelle) {
                echo '<span class="page-active">' . $i . '</span>';
            } else {
                echo '<a href="' . $base_url . 'page=' . $i . '">' . $i . '</a>';
            }
        }

        if ($page_actuelle < $total_pages - $range - 1) {
            echo '<span class="page-dots">...</span>';
            echo '<a href="' . $base_url . 'page=' . $total_pages . '">' . $total_pages . '</a>';
        }

        if ($page_actuelle < $total_pages) {
            echo '<a href="' . $base_url . 'page=' . ($page_actuelle + 1) . '">Suivant »</a>';
        } else {
            echo '<span class="page-disabled">Suivant »</span>';
        }

        echo '<div class="page-jump">';
        echo '<form method="get" action="">';
        foreach ($filter_params as $k => $v) {
            echo '<input type="hidden" name="' . htmlspecialchars($k) . '" value="' . htmlspecialchars($v) . '">';
        }
        echo '<span>Page :</span>';
        echo '<input type="number" name="page" min="1" max="' . $total_pages . '" value="' . $page_actuelle . '">';
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