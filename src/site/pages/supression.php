<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo"</header>";
if (isset($_SESSION['login'])) {
    include("../fragment/navbarTech.php");
}
?>



<body>
<div class='main-content'>
    <h2>Supprimer un ordinateur du parc</h2>

    <form method='post' action='actions/actionSupressionMachine.php'>
        <div class='form-group' style='display: inline-block; margin-right: 10px;'>
            <input type='text' name='ordinateur' placeholder='Nom ordinateur'>
        </div>
        <button type='submit' class='bouton_ajout'>Supprimer</button>
    </form>

    <h2>Supprimer un moniteur du parc</h2>

    <form method='post' action='actions/actionSupressionMachine.php'>
        <div class='form-group' style='display: inline-block; margin-right: 10px;'>
            <input type='text' name='moniteur' placeholder='Numéro de série du moniteur'>
        </div>
        <button type='submit' class='bouton_ajout'>Supprimer</button>
    </form>

</div>
</body>

</html>

