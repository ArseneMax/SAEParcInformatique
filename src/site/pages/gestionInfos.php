<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";

if (!isset($_SESSION['login']) || $_SESSION['login'] != 'adminweb') {
    header('Location: index.php');

}
?>
<body>
<div class='main-content'>
    <h1>Gestion des informations</h1>
    <?php
    if (isset($_GET['error'])){
        echo"<div class='duplication-error'>
            Deja cet OS dans la liste
    </div>";
    }
    if (isset($_GET['success'])){
        echo"<div class='success'>
            OS bien ajouté
    </div>";
    }
    if (isset($_GET['errorC'])){
        echo"<div class='duplication-error'>
            Deja ce constructeur dans la liste
    </div>";
    }
    if (isset($_GET['successC'])){
        echo"<div class='success'>
            Constructeur bien ajouté
    </div>";
    }
    ?>

    <div class="main-content">
        <h2>Systèmes d'exploitation</h2>

        <form method='post' action='actions/actionAjoutOS.php' style='margin-bottom: 30px;'>
            <div class='form-group' style='display: inline-block; margin-right: 10px;'>
                <input type='text' name='OSname' placeholder='Nom du système (ex: Windows 11)' required style='width: 300px;'>
            </div>
            <button type='submit' class='bouton_ajout'>Ajouter</button>
        </form>

        <?php
        include("../fonctions/database.php");


        $query = "SELECT * FROM OS ORDER BY OSname";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<div class="tech-content">';
            echo "<table>";
            echo "<thead><tr><th>Système d'exploitation</th></tr></thead>";
            echo "<tbody>";
            while ($os = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($os['OSname']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<p style='color: #999; font-style: italic;'>Aucun système d'exploitation enregistré</p>";
        }
        ?>
    </div>

    <div class="main-content">
        <h2>Constructeurs</h2>

        <form method='post' action='actions/actionAjoutConstructeur.php' style='margin-bottom: 30px;'>
            <div class='form-group' style='display: inline-block; margin-right: 10px;'>
                <input type='text' name='Cname' placeholder='Nom du constructeur (ex: DELL)' required style='width: 300px;'>
            </div>
            <button type='submit' class='bouton_ajout'>Ajouter</button>
        </form>

        <?php
        include("../fonctions/database.php");


        $query = "SELECT * FROM constructeur ORDER BY Cname";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<div class="tech-content">';
            echo "<table>";
            echo "<thead><tr><th>Constructeurs</th></tr></thead>";
            echo "<tbody>";
            while ($Constr = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($Constr['Cname']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<p style='color: #999; font-style: italic;'>Aucun système d'exploitation enregistré</p>";
        }
        ?>
    </div>




</div>

</body>
</html>