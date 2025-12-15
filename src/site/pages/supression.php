<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo"</header>";
if (isset($_SESSION['login'])) {
    include("../fragment/navbarTech.php");
}
include("../fonctions/database.php");


$sql = "SELECT statut FROM config_rebut WHERE id = 1";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$table_bloquee = ($row['statut'] == 'inactif');
?>

<body>
<div class='main-content'>

    <?php
    if ($table_bloquee):
        ?>
        <div class="alert-warning">
            <strong> ATTENTION :</strong> La table de rebut est actuellement en statut INACTIF (bloquée). Aucune modification n'est possible.
        </div>
    <?php
    endif;

    if (isset($_GET['error']) && $_GET['error'] == 'table_bloquee'):
        ?>
        <div class="alert-warning">
            <strong> Action refusée :</strong> La table de rebut est en statut INACTIF. Contactez l'administrateur.
        </div>
    <?php
    endif;
    ?>

    <h2>Supprimer un ordinateur du parc</h2>

    <form method='post' action='actions/actionSupressionMachine.php'>
        <div class='form-group' style='display: inline-block; margin-right: 10px;'>
            <input type='text' name='ordinateur' placeholder='Nom ordinateur' <?php echo $table_bloquee ? 'disabled' : ''; ?>>
        </div>
        <button type='submit' class='bouton_ajout' <?php echo $table_bloquee ? 'disabled' : ''; ?>>Supprimer</button>
    </form>

    <h2>Supprimer un moniteur du parc</h2>

    <form method='post' action='actions/actionSupressionMachine.php'>
        <div class='form-group' style='display: inline-block; margin-right: 10px;'>
            <input type='text' name='moniteur' placeholder='Numéro de série du moniteur' <?php echo $table_bloquee ? 'disabled' : ''; ?>>
        </div>
        <button type='submit' class='bouton_ajout' <?php echo $table_bloquee ? 'disabled' : ''; ?>>Supprimer</button>
    </form>

</div>
</body>

</html>