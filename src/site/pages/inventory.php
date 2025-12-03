<?php
include("../fragment/header.html");
include("../fragment/navbar.php");

if (isset($_SESSION['login'])) {
    include("../fragment/navbarTech.php");
}
            ?>
</header>


<body>
<h1>Bienvenue dans l'inventaire</h1>
</body>

</html>

