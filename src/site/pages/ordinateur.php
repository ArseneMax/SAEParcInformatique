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

    $lignes_par_page = 10;
    $page_actuelle = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page_actuelle - 1) * $lignes_par_page;


    $sql_count = "SELECT COUNT(*) as total FROM ordinateur";
    $result_count = mysqli_query($connect, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_lignes = $row_count['total'];
    $total_pages = ceil($total_lignes / $lignes_par_page);

    if (isset($_POST['MANUFACTURER'],$_POST['OS'],$_POST['DOMAIN'],$_POST['LOCATION'], $_POST['BUILDING'], $_POST['ROOM'])) {
        if ($_POST['MANUFACTURER'] == "") {
            $MANUFACTURER="";
        }else{
            $MANUFACTURER = "AND MANUFACTURER='" . $_POST['MANUFACTURER'] . "'";
        }
        if ($_POST['OS'] == "") {
            $OS="";
        }else{
            $OS = "AND OS='" .$_POST['OS']. "'";
        }if($_POST['DOMAIN']==""){
            $DOMAIN="";
        }else{
            $DOMAIN = "AND DOMAIN='" . $_POST['DOMAIN'] . "'";
        }if($_POST['LOCATION']==""){
            $LOCATION="";
        }else{
            $LOCATION = "AND LOCATION='" . $_POST['LOCATION'] . "'";
        }
        if($_POST['BUILDING']==""){
            $BUILDING="";
        }else{
            $BUILDING = "AND BUILDING='" . $_POST['BUILDING'] . "'";
        }
        if($_POST['ROOM']==""){
            $ROOM="";
        }else{
            $ROOM = "AND ROOM='" . $_POST['ROOM'] . "'";
        }
        $sql = "SELECT * FROM ordinateur WHERE statut = 'actif' $MANUFACTURER $OS $DOMAIN $LOCATION $BUILDING $ROOM LIMIT $lignes_par_page OFFSET $offset";
    }else{
        $sql = "SELECT * FROM ordinateur WHERE statut = 'actif' LIMIT $lignes_par_page OFFSET $offset";
    }
    $result = mysqli_query($connect, $sql);

    echo '<div class="tech-content">';
    echo '<h1 class="page-title">Gestion du Matériel</h1>';


/*                                formulaire pour les filtre                                   */
    $categorie = [
            'MANUFACTURER', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING',
            'ROOM'
    ];

    echo "<div class='form-container'>
            <h1 class='form-title'>Filtrer les Ordinateurs </h1>";

    echo '<form method="post" action="ordinateur.php" id="filtrerOrdinateur">';

    for ($i = 0; $i < count($categorie); $i++) {

        echo '<div class="form-group">';
        echo '<label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                  <select name="' . $categorie[$i] . '" id="' . $categorie[$i] . '" form="filtrerOrdinateur">
                  <option value="">--choisir un '.$categorie[$i].'--</option>';
        $sql1 = "SELECT DISTINCT($categorie[$i]) FROM ordinateur";
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
                    <button type='submit' class='bouton_ajout'>Supprimer</button>
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

    echo '</div>';
}
?>
</body>

</html>