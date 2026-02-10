<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";
include("../fragment/navbarAdmin.php");
?>
<div class='connexion-page'>
    <div class='form-container'>
        <h1 class='form-title'>Créer un technicien</h1>
        <form method='post' action='actions/actionAjout.php'>
            <?php include("../fragment/formConnexion.html"); ?>


            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password"
                       class="form-input" placeholder="Confirmez le mot de passe"
                       minlength="3" required>
            </div>

            <button type="submit" class="form-button" name="creation">Créer</button>
        </form>
        <?php
        if (isset($_GET['error'])){
            $errorMsg = "Erreur lors de la création !";
            if ($_GET['error'] == 'exists') {
                $errorMsg = "Identifiant existant !";
            } elseif ($_GET['error'] == 'length') {
                $errorMsg = "Le login et le mot de passe doivent contenir au moins 3 caractères !";
            } elseif ($_GET['error'] == 'password_mismatch') {
                $errorMsg = "Les mots de passe ne correspondent pas !";
            } elseif ($_GET['error'] == 'empty') {
                $errorMsg = "Tous les champs sont obligatoires !";
            }
            echo"<div class='connexion-error'>
                $errorMsg
            </div>";
        }
        if (isset($_GET['success'])) {
            echo "<div class='success'>
                Utilisateur bien ajouté
            </div>";
        }
        ?>
    </div>
</div>

<!-- Validation côté client avec JavaScript -->
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const login = document.querySelector('input[name="login"]').value;
        const password = document.querySelector('input[name="password"]').value;
        const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

        // Vérification de la longueur
        if (login.length < 3 || password.length < 3) {
            e.preventDefault();
            alert('Le login et le mot de passe doivent contenir au moins 3 caractères !');
            return false;
        }

        // Vérification de la correspondance des mots de passe
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Les mots de passe ne correspondent pas !');
            return false;
        }
    });
</script>

</body>