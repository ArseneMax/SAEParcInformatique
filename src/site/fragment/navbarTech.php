
    <div class='sub-nav-container'>
        <nav>
            <ul class='sub-nav-menu sub-nav-left'>
                <li><a href='ordinateur.php' class='sub-bouton-nav'>Ordinateur</a></li>
                <li><a href='moniteur.php' class='sub-bouton-nav'>Moniteur</a></li>
                <?php
                if (isset($_SESSION['login'])) {
                    if ($_SESSION['role'] == 'tech') {
                        echo"<li><a href='ajouterMachine.php' class='sub-bouton-nav'>Ajouter Ordinateur</a></li>
                            <li><a href='ajouterMoniteur.php' class='sub-bouton-nav'>Ajouter Moniteur</a></li>                          
                            <li><a href='ajoutCSVMachines.php' class='sub-bouton-nav'>Import machines CSV</a></li>
                            <li><a href='rebut.php' class='sub-bouton-nav'>Liste de rebut</a></li>";
                    }else{
                        echo"<li><a href='rebut.php' class='sub-bouton-nav'>Liste de rebut</a></li>";
                    }
                }
                ?>

            </ul>
        </nav>
    </div>