<?php
include("../fragment/header.html");
include("../fragment/navbar.php");

if (isset($_SESSION['login'])) {
if ($_SESSION['login'] == 'tech1') {
    echo " 
            <div id='topBlackBar'/>
            <div class='sub-nav-container'>
                <nav>
                    <ul class='sub-nav-menu sub-nav-left'>
                        <li><a href='ordinateur.php' class='sub-bouton-nav'>Ordinateur</a></li>
                        <li><a href='moniteur.php' class='sub-bouton-nav'>Moniteur</a></li>
                    </ul>
                </nav>
            </div>
        </header>";
    }
}
?>


<body>

</body>

</html>

