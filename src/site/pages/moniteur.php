<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
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
?>


<body>
<?php
$connect = mysqli_connect("localhost", "admin", "!sae2025!");
$db = mysqli_select_db($connect, "PARKIT");
if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] == 'tech1') {

        $sql = "SELECT * FROM moniteur";
        $result = mysqli_query($connect, $sql);
        echo '<div class="tech-content">';

        echo '<h2>Moniteur</h2>';
        echo '<table>
                <thead>
                <tr>
                    <th>SERIAL</th>
                    <th>MANUFACTURER</th>
                    <th>MODEL</th>
                    <th>SIZE_INCH</th>
                    <th>RESOLUTION</th>
                    <th>CONNECTOR</th>
                    <th>ATTACHED_TO</th>
                </tr>
                </thead>';
        while ($ligne = mysqli_fetch_row($result)) {
            echo "<tr>";
            foreach ($ligne as $valeur) {
                echo "<th>" . $valeur . "</th>";
            }
            echo "</tr>";
        }
        echo "</table>";
        echo '</div>';
    }
}

?>
</body>

</html>
