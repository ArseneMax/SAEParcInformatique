<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>"
?>
<div class='connexion-page'>
    <div class='form-container'>
        <h1 class='form-title'>Créer un technicien</h1>
        <form method='post' action='actions/actionAjout.php'>
            <?php include("../fragment/formConnexion.html"); ?>
            <button type="submit" class="form-button" name="creation">Créer</button>
        </form>
        <?php
        if (isset($_GET['error'])){
            echo"<div class='connexion-error'>
            Identifiant existant !
    </div>";
        }
        ?>
    </div>
</div>
</body>
