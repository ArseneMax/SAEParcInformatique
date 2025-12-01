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
        echo '<div class="tech-content">';
        echo '<h1 class="page-title">Gestion du Matériel</h1>';
        echo '<h2>Ordinateur</h2>';
        $sql = "SELECT * FROM ordinateur";
        $result = mysqli_query($connect, $sql);
        echo "<table>";
        echo "<thead>
                <tr>
                    <th>NAME</th>
                    <th>SERIAL</th>
                    <th>MANUFACTURER</th>
                    <th>MODEL</th>
                    <th>TYPE</th>
                    <th>CPU</th>
                    <th>RAM_MB</th>
                    <th>DISK_GB</th>
                    <th>OS</th>
                    <th>DOMAIN</th>
                    <th>LOCATION</th>
                    <th>BUILDING</th>
                    <th>ROOM</th>
                    <th>MACADDR</th>
                    <th>PURCHASE_DATE</th>
                    <th>WARRANTY_END</th>
                </tr>
                </thead>";
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
