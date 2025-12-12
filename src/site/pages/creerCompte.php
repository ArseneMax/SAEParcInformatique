<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>"
?>
<body>
<div class='connexion-page'>
    <div class='form-container'>
        <h1 class='form-title'>Inscription</h1>
        <form method='post' action='actions/actionInscription.php'>
            <?php include("../fragment/formConnexion.html"); ?>
            <button type="submit" class="form-button" name="inscription">S'inscrire</button>
        </form>
        <?php
        if (isset($_GET['error'])){
            echo"<div class='connexion-error'>
            Identifiant deja existant
    </div>";
        }
        ?>
    </div>
</div>
</body>

</html>
