<?php
include("../fragment/header.html");
include("../fragment/navbar.php");

echo"
<body>
<div class='connexion-page'>
    <div class='form-container'>
        <h1 class='form-title'>Connexion</h1>
        <form method='post' action='actions/actionConnexion.php'>";
    include("../fragment/formConnexion.html");
echo"</div>
</div>

</body>

</html>";

?>