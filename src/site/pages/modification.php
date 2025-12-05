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

    $sql = "SELECT * FROM ordinateur WHERE NAME = '" . $_POST['NameMachine'] . "'";
    $result = mysqli_query($connect, $sql);

    echo "<div class='form-container'>
            <h1 class='form-title'>Modification de la machine ".$_POST['NameMachine']."</h1>";

    while ($ligne = mysqli_fetch_row($result)) {

        echo '<form method="post" action="actions/actionModifierOrdinateur.php" id="modifierOrdinateur">
                <div class="form-group">
                    <label>' . $categorie[0] . '</label>
                    <input type="text" name="NAME" value="' . $_POST['NameMachine'] . '" readonly>
                </div>';

        for ($i = 1; $i < count($categorie); $i++) {

            $type = ($categorie[$i] == 'RAM_MB' || $categorie[$i] == 'DISK_GB') ? 'number' : (($categorie[$i] == 'OS' || $categorie[$i] == 'MANUFACTURER') ? 'select' : 'text');

            echo '<div class="form-group">';
            if ($type == 'select') {
                echo '<label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                      <select name="' . $categorie[$i] . '" id="' . $categorie[$i] . '" form="modifierOrdinateur">';
                $table = ($categorie[$i] == 'MANUFACTURER') ? 'constructeur' : 'OS';

                $sql1 = "SELECT * FROM " . $table;
                $result1 = mysqli_query($connect, $sql1);
                while ($ligne1 = mysqli_fetch_row($result1)) {
                    echo '<option value="' . $ligne1[0] . '">' . $ligne1[0] . '</option>';
                }
                echo '</select>';
            }else{
                echo '<label>' . $categorie[$i] . '</label>
                        <input type="' . $type . '" name="' . $categorie[$i] . '" 
                           value="' . $ligne[$i] . '" required>';
            }

            echo  '</div>';
        }

        echo '<button type="submit" class="form-button" name="modifier">Modifier</button>
              </form>
            </div>';
    }
}


if (isset($_SESSION['login']) && isset($_POST['SerialMoniteur'])) {

    $categorieMoniteur = [
        'SERIAL', 'MANUFACTURER', 'MODEL',
        'SIZE_INCH', 'RESOLUTION', 'CONNECTOR', 'ATTACHED_TO'
    ];

    $sql = "SELECT * FROM moniteur WHERE SERIAL = '" . $_POST['SerialMoniteur'] . "'";
    $result = mysqli_query($connect, $sql);

    echo "<div class='form-container'>
            <h1 class='form-title'>Modification du moniteur ".$_POST['SerialMoniteur']."</h1>";

    while ($ligne = mysqli_fetch_row($result)) {

        echo '<form method="post" action="actions/actionModifierMoniteur.php">
                <div class="form-group">
                    <label>' . $categorieMoniteur[0] . '</label>
                    <input type="text" name="SERIAL" value="' . $_POST['SerialMoniteur'] . '" readonly>
                </div>';

        for ($i = 1; $i < count($categorieMoniteur); $i++) {

            $type = ($categorieMoniteur[$i] == 'SIZE_INCH') ? 'number' : 'text';

            echo '<div class="form-group">
                    <label>' . $categorieMoniteur[$i] . '</label>
                    <input type="' . $type . '" name="' . $categorieMoniteur[$i] . '" 
                           value="' . $ligne[$i] . '" required>
                </div>';
        }

        echo '<button type="submit" class="form-button" name="modifier">Modifier</button>
              </form>
            </div>';
    }
}

?>
</body>
</html>
