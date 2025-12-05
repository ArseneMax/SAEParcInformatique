<?php
include("../fragment/header.html");
echo "<link rel='stylesheet' href='../css/style.css'>";
include("../fragment/navbar.php");

echo "</header>";

if (isset($_SESSION['login'])) {
    include("../fragment/navbarTech.php");
}

include("../fonctions/database.php");

echo '<div class="tech-content">';

if (isset($_SESSION['login']) && isset($_POST['NameMachine'])) {

    $categorie = [
        'NAME', 'SERIAL', 'MANUFACTURER', 'MODEL', 'TYPE', 'CPU',
        'RAM_MB', 'DISK_GB', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING',
        'ROOM', 'MACADDR', 'PURCHASE_DATE', 'WARRANTY_END'
    ];

    echo "<div class='form-container'>
            <h1 class='form-title'>Ajout d'une machine </h1>";

        echo '<form method="post" action="actions/actionAjouterOrdinateur.php">
                <div class="form-group">
                    <label>' . $categorie[0] . '</label>
                    <input type="text" name="NAME">
                </div>';

        for ($i = 1; $i < count($categorie); $i++) {

            $type = ($categorie[$i] == 'RAM_MB' || $categorie[$i] == 'DISK_GB') ? 'number' : 'text';

            echo '<div class="form-group">
                    <label>' . $categorie[$i] . '</label>
                    <input type="' . $type . '" name="' . $categorie[$i] .' " required>
                </div>';
        }

        echo '<button type="submit" class="form-button" name="ajouter">Ajouter</button>
              </form>
            </div>';
}


if (isset($_SESSION['login']) && isset($_POST['SerialMoniteur'])) {

    $categorieMoniteur = [
        'SERIAL', 'MANUFACTURER', 'MODEL',
        'SIZE_INCH', 'RESOLUTION', 'CONNECTOR', 'ATTACHED_TO'
    ];

    $sql = "SELECT * FROM moniteur WHERE SERIAL = '" . $_POST['SerialMoniteur'] . "'";
    $result = mysqli_query($connect, $sql);

    echo "<div class='form-container'>
            <h1 class='form-title'>Ajouter un moniteur </h1>";

    while ($ligne = mysqli_fetch_row($result)) {

        echo '<form method="post" action="actions/actionAjouterMoniteur.php">
                <div class="form-group">
                    <label>' . $categorieMoniteur[0] . '</label>
                    <input type="text" name="SERIAL" value="' . $_POST['SerialMoniteur'] . '">
                </div>';

        for ($i = 1; $i < count($categorieMoniteur); $i++) {

            $type = ($categorieMoniteur[$i] == 'SIZE_INCH') ? 'number' : 'text';

            echo '<div class="form-group">
                    <label>' . $categorieMoniteur[$i] . '</label>
                    <input type="' . $type . '" name="' . $categorieMoniteur[$i] . '" required>
                </div>';
        }

        echo '<button type="submit" class="form-button" name="ajouter">Ajouter</button>
              </form>
            </div>';
    }
}

?>
</body>
</html>
