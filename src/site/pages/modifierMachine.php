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
    <h2>Modifier une information d'un Ordinateur</h2>

    <form method='post' action='actions/actionModifierMachine.php'>
        <div class='form-group' style='display: inline-block; margin-right: 10px;'>
            <input type='text' name='NameMachine' placeholder='Nom de la machine'>
        </div>
        <button type='submit' class='bouton_ajout'>Modifier</button>
    </form>

    <h2>Modifier une information d'un Moniteur</h2>

    <form method='post' action='actions/actionModifierMachine.php'>
        <div class='form-group' style='display: inline-block; margin-right: 10px;'>
            <input type='text' name='SerialMoniteur' placeholder='Serial number du moniteur'>
        </div>
        <button type='submit' class='bouton_ajout'>Modifier</button>
    </form>

</div>
</body>

</html>

