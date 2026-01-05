<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";
?>


<?php
include("../fonctions/database.php");
if (isset($_SESSION['login'])) {


    $lignes_par_page = 10;
    $page_actuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page_actuelle - 1) * $lignes_par_page;


    $sql_count = "SELECT COUNT(*) as total FROM journal";
    $result_count = mysqli_query($connect, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_lignes = $row_count['total'];
    $total_pages = ceil($total_lignes / $lignes_par_page);


    $sql = "SELECT Login,ip,role,action,date,heure FROM journal ORDER BY id DESC";
    $result = mysqli_query($connect, $sql);
    echo '<div class="tech-content">';
    echo '<h2>Journal d&apos;activité</h2>';
    echo '<table>
            <thead>
            <tr>
                <th>Login</th>
                <th>Adresse IP</th>   
                <th>Role</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>';

    while ($ligne = mysqli_fetch_row($result)) {
        $dateSQL = $ligne[4];
        $dateFR = date("d-m-Y", strtotime($dateSQL));

        $heureSQL = $ligne[5];
        $heureFR = date("H:i", strtotime($heureSQL));

        $ligne[4] = $dateFR . ' ' . $heureFR;


        echo "<tr>";
        foreach ($ligne as $valeur) {
            echo "<td>" . htmlspecialchars($valeur) . "</td>";
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