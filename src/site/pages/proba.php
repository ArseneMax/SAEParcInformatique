<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
require_once("../fonctions/database.php");
require_once("../fonctions/probaFunctions.php");
echo "</header>"; ?>
<div class="main-content">
<h1>Rapport statistique</h1>

</div>
<?php
$queryDevices = "SELECT * FROM ordinateur";
$resultDevices = mysqli_query($connect, $queryDevices);

if (!$resultDevices) {
    die("Erreur lors de la récupération des appareils : " . mysqli_error($connect));
}

$devices = [];
while ($row = mysqli_fetch_assoc($resultDevices)) {
    $devices[] = $row;
}

$queryConnections = "SELECT * FROM connexions";
$resultConnections = mysqli_query($connect, $queryConnections);

if (!$resultConnections) {
    die("Erreur lors de la récupération des connexions : " . mysqli_error($connect));
}

$connections = [];
while ($row = mysqli_fetch_assoc($resultConnections)) {
    $connections[] = $row;
}

$queryMonitors = "SELECT * FROM moniteur";
$resultMonitors = mysqli_query($connect, $queryMonitors);

if (!$resultMonitors) {
    die("Erreur lors de la récupération des moniteurs : " . mysqli_error($connect));
}

$monitors = [];
while ($row = mysqli_fetch_assoc($resultMonitors)) {
    $monitors[] = $row;
}


$devices_count = count($devices);
$by_manufacturer = [];
$by_type = [];
$by_loc = [];
$by_os = [];
$by_room = [];
$by_build = [];
$ram_list = [];
$disk_list = [];
$devices_by_name = [];

foreach ($devices as $d) {
    $name = isset($d['NAME']) ? $d['NAME'] : (isset($d['Name']) ? $d['Name'] : null);
    if ($name) $devices_by_name[$name] = $d;

    $man = isset($d['MANUFACTURER']) ? $d['MANUFACTURER'] : (isset($d['Manufacturer']) ? $d['Manufacturer'] : 'Unknown');
    $type = isset($d['TYPE']) ? $d['TYPE'] : (isset($d['Type']) ? $d['Type'] : 'Unknown');
    $os = isset($d['OS']) ? $d['OS'] : (isset($d['Os']) ? $d['Os'] : 'Unknown');
    $loc = isset($d['LOCATION']) ? $d['LOCATION'] : (isset($d['LOCATION']) ? $d['LOCATION'] : 'Unknown');
    $build = isset($d['BUILDING']) ? $d['BUILDING'] : (isset($d['BUILDING']) ? $d['BUILDING'] : 'Unknown');

    $by_manufacturer[$man] = ($by_manufacturer[$man] ?? 0) + 1;
    $by_type[$type] = ($by_type[$type] ?? 0) + 1;
    $by_os[$os] = ($by_os[$os] ?? 0) + 1;
    $by_loc[$loc] = ($by_loc[$loc] ?? 0) + 1;
    $by_build[$build] = ($by_build[$build] ?? 0) + 1;

}

$connections_count = count($connections);
$users_set = [];
$total_duration = 0;
$durations = [];
$sessions_per_user = [];
$top_sessions = [];

foreach ($connections as $c) {
    $login = $c['login'] ?? ($c['LOGIN'] ?? ($c['user'] ?? null));
    $ip = $c['ip_address'] ?? ($c['IP_ADDRESS'] ?? ($c['ip'] ?? null));
    $dur = 0;
    if (isset($c['duration_seconds'])) $dur = safe_int($c['duration_seconds']);
    elseif (isset($c['DURATION_SECONDS'])) $dur = safe_int($c['DURATION_SECONDS']);
    elseif (isset($c['duration'])) $dur = safe_int($c['duration']);

    if ($login) {
        $users_set[$login] = true;
        $sessions_per_user[$login] = ($sessions_per_user[$login] ?? 0) + 1;
    }
    $total_duration += $dur;
    if ($dur > 0) $durations[] = $dur;
    $top_sessions[] = ['login' => $login, 'ip' => $ip, 'duration' => $dur];
}
$unique_users = count($users_set);
$avg_duration = $connections_count > 0 ? ($total_duration / $connections_count) : 0;
$median_duration = median($durations);
$ecart_type_duration = ecartType($durations);
$variance_duration = variance($durations);

// ---- Monitors statistics ----
$monitors_count = count($monitors);
$mon_by_size = [];
$mon_by_resolution = [];
$mon_by_connector = [];
$monitors_per_device = [];

foreach ($monitors as $m) {
    // column names as in preview: SERIAL, MANUFACTURER, MODEL, SIZE_INCH, RESOLUTION, CONNECTOR, ATTACHED_TO
    $size = $m['SIZE_INCH'] ?? ($m['Size_inch'] ?? $m['Size'] ?? null);
    $res  = $m['RESOLUTION'] ?? ($m['Resolution'] ?? null);
    $conn = $m['CONNECTOR'] ?? ($m['Connector'] ?? null);

    if ($size !== null) {
        $mon_by_size[$size] = ($mon_by_size[$size] ?? 0) + 1;
    } else {
        $mon_by_size['Unknown'] = ($mon_by_size['Unknown'] ?? 0) + 1;
    }
    if ($res !== null) {
        $mon_by_resolution[$res] = ($mon_by_resolution[$res] ?? 0) + 1;
    }
    if ($conn !== null) {
        $mon_by_connector[$conn] = ($mon_by_connector[$conn] ?? 0) + 1;
    }
}
arsort($monitors_per_device);
$top_devices_by_monitors = array_slice($monitors_per_device, 0, 10, true);
?>
<div class="statistique">
<div class="card card-resume">
    <h2>Résumé global</h2>
    <div class="row">
        <div class="col">
            <div class="block pack">
                <strong>Devices :</strong> <?php echo h($devices_count); ?>
            </div>

            <div class="block pack">
                <strong>Moniteurs :</strong> <?php echo h($monitors_count); ?>
            </div>

            <div class="block pack">
                <strong>Connexions (sessions) :</strong> <?php echo h($connections_count); ?>
            </div>
        </div>
        <div class="col">
            <div class="block pack">
                <strong>Utilisateurs uniques (connexions) :</strong> <?php echo h($unique_users); ?>
            </div>

            <div class="block pack">
                <strong>Durée totale des sessions :</strong> <?php echo secondsToTime($total_duration); ?>
            </div>

            <div class="block pack">
                <strong>Durée moyenne par session :</strong> <?php echo secondsToTime($avg_duration); ?>
            </div>
        </div>
        <div class="col">
            <div class="block pack">
                <strong>Durée médiane par session :</strong> <?php echo secondsToTime($median_duration); ?>
            </div>

            <div class="block pack">
                <strong>Ecart type de la durée des sessions :</strong> <?php echo secondsToTime($ecart_type_duration); ?>
            </div>

            <div class="block pack">
                <strong>Variance de la durée des sessions :</strong> <?php echo secondsToTime($variance_duration); ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <h2>Devices — répartitions & agrégats</h2>
    <div class="row">
        <div class="col">
            <h3>Par Manufacturer</h3>
            <table>
                <thead><tr><th>Fabricant</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($by_manufacturer as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col">
            <h3>Par Type</h3>
            <table>
                <thead><tr><th>Type</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($by_type as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col">
            <h3>Par Operating System</h3>
            <table>
                <thead><tr><th>Systeme d'exploitation</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($by_os as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col">
            <h3>Par Location</h3>
            <table>
                <thead><tr><th>Location</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($by_loc as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col">
            <h3>Par Building</h3>
            <table>
                <thead><tr><th>Building</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($by_build as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="card card-resume">
        <h2>Connexions — analyses</h2>
        <div class="row">
            <div class="col">
                <div class="block pack">
                    <strong>Sessions totales :</strong> <?php echo h($connections_count); ?>
                </div>

                <div class="block pack">
                    <strong>Utilisateurs uniques :</strong> <?php echo h($unique_users); ?>
                </div>

                <div class="block pack">
                    <strong>Durée totale :</strong> <?php echo secondsToTime($total_duration); ?>
                </div>
            </div>
            <div class="col">
                <div class="block pack">
                    <strong>Durée totale :</strong> <?php echo secondsToTime($total_duration); ?>
                </div>
                <div class="block pack">
                    <strong>Durée moyenne :</strong> <?php echo secondsToTime($avg_duration); ?>
                </div>

            </div>
            <div class="col">
                <div class="block pack">
                    <strong>Durée médiane :</strong> <?php echo secondsToTime($median_duration); ?>
                </div>
                <div class="block pack">
                    <strong>Ecart type de la durée des sessions :</strong> <?php echo secondsToTime($ecart_type_duration); ?>
                </div>

                <div class="block pack">
                    <strong>Variance de la durée des sessions: </strong><?php echo secondsToTime($variance_duration)?>
                </div>
            </div>
        </div>
    </div>

<div class="card">
    <h2>Moniteurs — analyses</h2>
    <div style="display:flex; gap:14px; flex-wrap:wrap;">
        <div style="flex:1; min-width:260px;">
            <h3>Par taille (inch)</h3>
            <table>
                <thead><tr><th>Taille</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($mon_by_size as $k=>$v): ?>
                    <tr><td><?php echo h($k),'"'; ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="flex:1; min-width:260px;">
            <h3>Par connecteur</h3>
            <table>
                <thead><tr><th>Connecteur</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($mon_by_connector as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div style="flex:1; min-width:260px;">
            <h3>Par résolution</h3>
            <table>
                <thead><tr><th>Résolution</th><th>Nombre</th></tr></thead>
                <tbody>
                <?php foreach ($mon_by_resolution as $k=>$v): ?>
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
</div>
</body>
</html>
