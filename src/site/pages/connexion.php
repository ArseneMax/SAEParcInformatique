<?php
include("../fragment/header.html");
include("../fragment/navbar.html");



echo"<body>
<div class='connexion-page'>
    <div class='form-container'>
        <h1 class='form-title'>Connexion</h1>
        <form method='post' action='actionConnexion.php'>";
    include("../fragment/formConnexion.html");

echo"</div>
</div>

</body>

</html>";

?>