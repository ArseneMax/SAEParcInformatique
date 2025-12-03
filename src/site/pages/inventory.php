<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo"</header>";
if (isset($_SESSION['login'])) {
    include("../fragment/navbarTech.php");
}
?>



<body>
<div class="main-content">
<h1>Bienvenue dans l'inventaire</h1>
</div>
</body>

</html>

