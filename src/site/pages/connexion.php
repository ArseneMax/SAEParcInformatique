<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
?>
<body>
<div class='connexion-page'>
    <div class='form-container'>
        <h1 class='form-title'>Connexion</h1>
        <form method='post' action='actions/actionConnexion.php'>
    <?php include("../fragment/formConnexion.html"); ?>
    </div>
</div>
<?php
if (isset($_GET['error'])){
    echo"<div>
            <p>Identifiant ou mot de passe incorrect</p>
            
    </div>";
}
?>
</body>

</html>
