<?php

include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";
if (isset($_SESSION['login'])) {
    include("../fragment/navbarTech.php");
}

include("../fonctions/database.php");
if (isset($_SESSION['login']) && isset($_POST['NameMachine'])) {
    $categorie = array('NAME', 'SERIAL', 'MANUFACTURER', 'MODEL', 'TYPE', 'CPU', 'RAM_MB', 'DISK_GB', 'OS', 'DOMAIN', 'LOCATION', 'BUILDING', 'ROOM', 'MACADDR', 'PURCHASE_DATE', 'WARRANTY_END');
    echo '<div class="tech-content">';
    $sql = "SELECT * FROM ordinateur WHERE NAME ='" . $_POST['NameMachine'] . "'";
    $result = mysqli_query($connect, $sql);
    echo "<div class='form-container'>
                <h1 class='form-title'>Modification de la machine ".$_POST['NameMachine']."</h1>";
    while ($ligne = mysqli_fetch_row($result)) {
        echo '<form method="post" action="actions/actionModifierOrdinateur.php">
                <div class="form-group">
                    <label for="' . $categorie[0] . '">' . $categorie[0] . '</label>
                    <input type="text" name="NAME" value="' .$_POST['NameMachine']. '" readonly>
                </div>';
        if (count($ligne) == count($categorie)) {
            for ($i = 1; $i < count($categorie); $i++) {
                if ($categorie[$i] == 'RAM_MB' || $categorie[$i] == 'DISK_GB') {
                    $type = 'number';
                }else{
                    $type = 'text';
                }
                echo '<div class="form-group">
                        <label for="' . $categorie[$i] . '">' . $categorie[$i] . '</label>
                        <input type="' . $type . '"  name="' . $categorie[$i] . '" value="' . $ligne[$i] . '" required>
                    </div>
                ';
            }
        }
        echo '<button type="submit" class="form-button" name="modifier">Modifier</button>
            </form>
            </div>';
    }
}



if (isset($_SESSION['login']) && isset($_POST['SerialMoniteur'])) {
    $categorieMoniteur = array('SERIAL', 'MANUFACTURER', 'MODEL', 'SIZE_INCH', 'RESOLUTION', 'CONNECTOR','ATTACHED_TO');
    echo '<div class="tech-content">';
    $sql = "SELECT * FROM moniteur WHERE SERIAL ='" . $_POST['SerialMoniteur'] . "'";
    $result = mysqli_query($connect, $sql);
    echo "<div class='form-container'>
                <h1 class='form-title'>Modification du moniteur ".$_POST['SerialMoniteur']."</h1>";
    while ($ligne = mysqli_fetch_row($result)) {
        echo '<form method="post" action="actions/actionModifierMoniteur.php">
                <div class="form-group">
                    <label for="' . $categorieMoniteur[0] . '">' . $categorieMoniteur[0] . '</label>
                    <input type="text" name="SERIAL" value="' .$_POST['SerialMoniteur']. '" readonly>
                </div>';
        if (count($ligne) == count($categorieMoniteur)) {
            for ($i = 1; $i < count($categorieMoniteur); $i++) {
                if ($categorieMoniteur[$i] == 'SIZE_INCH') {
                    $type = 'number';
                }else{
                    $type = 'text';
                }
                echo '<div class="form-group">
                        <label for="' . $categorieMoniteur[$i] . '">' . $categorieMoniteur[$i] . '</label>
                        <input type="' . $type . '"  name="' . $categorieMoniteur[$i] . '" value="' . $ligne[$i] . '" required>
                    </div>
                ';
            }
        }
        echo '<button type="submit" class="form-button" name="modifier">Modifier</button>
            </form>
            </div>';
    }
}
?>
</body>

</html>
