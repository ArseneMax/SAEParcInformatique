<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";
include("../fragment/navbarTech.php");
?>


<?php
include("../fonctions/database.php");
if (isset($_SESSION['login'])) {


    $lignes_par_page = 10;
    $page_actuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page_actuelle - 1) * $lignes_par_page;


    $sql_count = "SELECT COUNT(*) as total FROM moniteur WHERE statut = 'inactif'";
    $result_count = mysqli_query($connect, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_lignes = $row_count['total'];
    $total_pages = ceil($total_lignes / $lignes_par_page);


    $sql = "SELECT * FROM moniteur WHERE statut = 'inactif' LIMIT $lignes_par_page OFFSET $offset";
    $result = mysqli_query($connect, $sql);

    echo '<div class="tech-content">';
    echo '<h2>Moniteur</h2>';
    echo '<table>
            <thead>
            <tr>
                <th>SERIAL</th>
                <th>MANUFACTURER</th>
                <th>MODEL</th>
                <th>SIZE_INCH</th>
                <th>RESOLUTION</th>
                <th>CONNECTOR</th>
                <th>ATTACHED_TO</th>
            </tr>
            </thead>
            <tbody>';

    while ($ligne = mysqli_fetch_row($result)) {
        array_pop($ligne);
        echo "<tr>";
        foreach ($ligne as $valeur) {
            echo "<td>" . htmlspecialchars($valeur) . "</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table>";

    #bouton pour télécharger le csv des moniteurs en rebut

    echo '<div class="csv-download">';
    echo '<a href="ActionCsvDownload.php?type=moniteur" class="btn-csv">📥 Telecharge CSV Moniteurs</a>';
    echo '</div>';


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

    $sql_count = "SELECT COUNT(*) as total FROM ordinateur WHERE statut = 'inactif'";
    $result_count = mysqli_query($connect, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_lignes = $row_count['total'];
    $total_pages = ceil($total_lignes / $lignes_par_page);

    $sql = "SELECT * FROM ordinateur WHERE statut = 'inactif' LIMIT  $lignes_par_page OFFSET $offset";
    $result = mysqli_query($connect, $sql);

    echo '<div class="tech-content">';
    echo '<h2>Ordinateur</h2>';

    echo "<table>";
    echo "<thead>
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
            </tr>
            </thead>
            <tbody>";

    while ($ligne = mysqli_fetch_row($result)) {
        array_pop($ligne);
        echo "<tr>";
        foreach ($ligne as $valeur) {
            echo "<td>" . htmlspecialchars($valeur) . "</td>";
        }
        echo "</tr>";
    }

    echo "</tbody></table>";

    #bouton pour télécharger le csv des ordinateurs en rebut

    echo '<div class="csv-download">';
    echo '<a href="ActionCsvDownload.php?type=ordinateur" class="btn-csv"> Telecharge CSV Ordinateurs </a>';
    echo '</div>';


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

        // Bouton Suivant
        if ($page_actuelle < $total_pages) {
            echo '<a href="?page=' . ($page_actuelle + 1) . '">Suivant »</a>';
        } else {
            echo '<span class="page-disabled">Suivant »</span>';
        }


        echo '<div class="page-jump">';
        echo '<form method="get" action="" style="display: inline-flex; gap: 5px; align-items: center;">';
        echo '<span>Page :</span>';
        echo '<input type="number" name="page" min="1" max="' . $total_pages . '" value="' . $page_actuelle . '">';
        echo '<button type="submit">Aller</button>';
        echo '</form>';
        echo '</div>';

        echo '</div>';

    }
}
?>

</body>

</html>