<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo"</header>";
include("../fragment/navbarTech.php");
?>
<div class='connexion-page'>
    <div class='csv-upload-form'>
        <form action="actions/actionAjoutCSV.php" method="post" enctype="multipart/form-data">
            <label for="csv_file">Choisissez un fichier CSV à importer :</label>
            <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
            <label>Selectionner le type du CSV:</label>
            <select name="type_csv">
                <option value="connexions">Connexions</option>
                <!---<option value="moniteurs">Moniteurs</option>
                <option value="ordinateurs">Ordinateurs</option> --->
            </select>
            <button type="submit" name="submit">Importer</button>
        </form>
        <?php
        if (isset($_GET['error'])){
            if ($_GET['error']=="invalid_columns"){
                echo"<div class='connexion-error'>
                    Nombre de colonnes du fichier invalide
                </div>";
            }
            if ($_GET['error']=="serial_exists"){
                echo"<div class='connexion-error'>
                    Numéro de série deja existant
                </div>";
            }

        }
        ?>
    </div>
</div>
