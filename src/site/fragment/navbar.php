<header>
    <div class='nav-container'>
        <nav>
            <ul class='nav-menu nav-left'>
                <li><a href='index.php' class='bouton-nav'>Accueil</a></li>
                <?php
                session_start();
                if (isset($_SESSION['login'])) {
                    echo "<li><a href='inventory.php' class='bouton-nav'>Inventaire</a></li>";
                    echo"<li><a href='proba.php' class='bouton-nav'>Statistiques</a></li>";
                    if ($_SESSION['login'] == 'adminweb') {
                        echo"<li><a href='adminweb.php' class='bouton-nav'>Admin</a></li>";
                    }
                }
                ?>

            </ul>
        </nav>

        <div class='site-name'>ParkIT</div>
        <nav>
            <ul class='nav-menu'>
                <?php
                if (isset($_SESSION['login'])) {
                    echo "<li><a href='logout.php' class='bouton-nav' id='bouton-connexion'> Déconnexion </a></li>";}
                else {
                    echo "<li><a href='connexion.php' class='bouton-nav' id='bouton-connexion'>Connexion</a></li>";
                    echo "<li><a href='creerCompte.php' class='bouton-nav' id='bouton-creation'>Inscription</a></li>";

                }?>
            </ul>
        </nav>
    </div>
