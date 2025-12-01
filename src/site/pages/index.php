<?php

include("../fragment/header.html");
include("../fragment/navbar.php");
echo "</header>";


echo"<body>
    <div class='main-content'>";
if (isset($_SESSION['login'])){
    echo"<h1>Bienvenue ".$_SESSION['login']." </h1>";
}else {
    echo "<h1>Bienvenue</h1>";
}

echo"<p class='welcome-text'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam culpa eaque ipsa iusto quae quos repellat saepe sapiente similique velit. Consectetur incidunt itaque neque odit!</p>
    </div>
  </body>

</html>";