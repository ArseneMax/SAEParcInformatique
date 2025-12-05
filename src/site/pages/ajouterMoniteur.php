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

        $categorieMoniteur = [
            'SERIAL', 'MANUFACTURER', 'MODEL',
            'SIZE_INCH', 'RESOLUTION', 'CONNECTOR', 'ATTACHED_TO'
        ];
        echo "<div class='form-container'>
                    <h1 class='form-title'>Ajouter un moniteur </h1>";

            echo '<form method="post" action="actions/actionAjoutMoniteur.php">
                        <div class="form-group">
                            <label>' . $categorieMoniteur[0] . '</label>
                            <input type="text" name="SERIAL">
                        </div>';

            for ($i = 1; $i < count($categorieMoniteur); $i++) {

                $type = ($categorieMoniteur[$i] == 'SIZE_INCH') ? 'number' : 'text';

                echo '<div class="form-group">
                            <label>' . $categorieMoniteur[$i] . '</label>
                            <input type="' . $type . '" name="' . $categorieMoniteur[$i].'" required>
                        </div>';
            }

            echo '<button type="submit" class="form-button" name="ajouter">Ajouter</button>
                      </form>';
if (isset($_GET['error'])){
    echo"<div class='connexion-error'>
            Erreur lors de l'ajout d'un moniteur'
    </div>";
}
echo"</div>";
        }

}
?>