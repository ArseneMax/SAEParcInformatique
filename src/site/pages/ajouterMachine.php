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

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'tech') {
        $categorie = [
                'NAME', 'SERIAL', 'MANUFACTURER', 'MODEL', 'TYPE', 'CPU',
                'RAM_MB', 'DISK_GB', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING',
                'ROOM', 'MACADDR', 'PURCHASE_DATE', 'WARRANTY_END'
        ];

        echo "<div class='form-container'>
            <h1 class='form-title'>Ajouter un ordinateur </h1>";

        echo '<form method="post" action="actions/actionAjoutOrdinateur.php">
                <div class="form-group">
                    <label>' . $categorie[0] . '</label>
                    <input type="text" name="NAME">
                </div>';

        for ($i = 1; $i < count($categorie); $i++) {

            $type = ($categorie[$i] == 'RAM_MB' || $categorie[$i] == 'DISK_GB') ? 'number' : 'text';

            echo '<div class="form-group">
                    <label>' . $categorie[$i] . '</label>
                    <input type="' . $type . '" name="' . $categorie[$i] . '" required>
                </div>';
        }

        echo '<button type="submit" class="form-button" name="ajouter">Ajouter</button>
              </form>';
        if (isset($_GET['error'])){
            echo"<div class='connexion-error'>
                Erreur lors de l'ajout d'un ordinateur
            </div>";
}
           echo"</div>";

    }
}
?>

</body>
</html>
