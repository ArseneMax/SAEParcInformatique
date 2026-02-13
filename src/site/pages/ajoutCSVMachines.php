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
                <option value="moniteurs">Moniteurs (numéro de série obligatoire)</option>
                <option value="ordinateurs">Ordinateurs (nom et numéro série obligatoire)</option>
            </select>
            <button type="submit" name="submit">Importer</button>
        </form>
        <?php
        if (isset($_GET['error'])){
            if ($_GET['error']=="invalid_type"){
                echo"<div class='connexion-error'>
                    Type du fichier invalide
                </div>";
            }
            if ($_GET['error']=="missing_columns"){
                echo"<div class='connexion-error'>
                    Colonnes manquantes
                </div>";
            }
            if ($_GET['error']=="name_exists"){
                echo"<div class='connexion-error'>
                    Numéro de série ou Nom déja existant
                </div>";
            }

            if ($_GET['error']=="file_open"){
                echo"<div class='connexion-error'>
                    Erreur lors de l'ouverture du fichier
                </div>";
            }

            if ($_GET['error']=="file_upload"){
                echo"<div class='connexion-error'>
                    Erreur lors du téléversement du fichier'
                </div>";
            }

            if ($_GET['error']=="form_submit"){
                echo"<div class='connexion-error'>
                    Erreur lors de la soumission du formulaire
                </div>";
            }

        }
        if (isset($_GET['success'])){
            echo"<div class='connexion-success'>
                    Ajout(s) effectué(s)
                </div>";
        }
        ?>
    </div>
</div>
