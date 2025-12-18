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

        echo '<form method="post" action="actions/actionAjoutOrdinateur.php" id="ajoutOrdinateur">
                <div class="form-group">
                    <label for="' . $categorie[0] . '">' . $categorie[0] . '</label>
                    <input type="text" name="NAME">
                </div>';

        for ($i = 1; $i < count($categorie); $i++) {
            $type = ($categorie[$i] == 'RAM_MB' || $categorie[$i] == 'DISK_GB') ? 'number' : (($categorie[$i] == 'OS' || $categorie[$i] == 'MANUFACTURER') ? 'select' : 'text');

            echo '<div class="form-group">';
            if ($type == 'select') {
                $table = ($categorie[$i] == 'MANUFACTURER') ? 'constructeur' : 'OS';
                echo '<label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                      <select name="' . $categorie[$i] . '" id="' . $categorie[$i] . '" form="ajoutOrdinateur">
                      <option value="">--choisir un '.$table.'--</option>';
                $sql1 = "SELECT * FROM " . $table;
                $result1 = mysqli_query($connect, $sql1);
                while ($ligne1 = mysqli_fetch_row($result1)) {
                    echo '<option value="' . $ligne1[0] . '">' . $ligne1[0] . '</option>';
                }
                echo '</select>';
            }else{
                echo '<label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                        <input type="' . $type . '" name="' . $categorie[$i] . '" required>';
            }
            echo '</div>';
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
