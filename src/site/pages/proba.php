<?php
include("../fragment/header.html");
include("../fragment/navbar.php");
require_once("../fonctions/probaFunctions.php");
echo "</header>";


$pathConnections = '../csv/connections.csv';
$pathDevices     = '../csv/inventory_devices.csv';
$pathMonitors    = '../csv/inventory_monitors2.csv';


$connections = read_csv_assoc($pathConnections);
$devices     = read_csv_assoc($pathDevices);
$monitors    = read_csv_assoc($pathMonitors);

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

<h1>Rapport statistiques — CSV</h1>

<div class="card">
    <h2>Résumé global</h2>
    <div class="row">
        <div class="col">
            <strong>Devices :</strong> <?php echo h($devices_count); ?><br>
            <strong>Moniteurs :</strong> <?php echo h($monitors_count); ?><br>
            <strong>Connexions (sessions) :</strong> <?php echo h($connections_count); ?><br>
        </div>
        <br>
        <div class="col">
            <strong>Utilisateurs uniques (connexions) :</strong> <?php echo h($unique_users); ?><br>
            <strong>Durée totale des sessions :</strong> <?php echo secondsToTime($total_duration); ?><br>
            <strong>Durée moyenne par session :</strong> <?php echo secondsToTime($avg_duration); ?><br>
            <br>
        </div>
    </div>
</div>

<div class="card">
    <h2>Devices — répartitions & agrégats</h2>
    <div class="row">
        <div class="col">
            <h3>Par fabricant</h3>
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
            <h3>Par type</h3>
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
            <h3>Par Systeme d'exploitation</h3>
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
<!--        <div class="col">-->
<!--            <h3>Par Salle</h3>-->
<!--            <table>-->
<!--                <thead><tr><th>Salle</th><th>Nombre</th></tr></thead>-->
<!--                <tbody>-->
<!--                --><?php //foreach ($by_room as $k=>$v): ?>
<!--                    <tr><td>--><?php //echo h($k); ?><!--</td><td>--><?php //echo h($v); ?><!--</td></tr>-->
<!--                --><?php //endforeach; ?>
<!--                </tbody>-->
<!--            </table>-->
<!--        </div>-->
    </div>


<div class="card">
    <h2>Connexions — analyses</h2>
    <div class="row">
        <div class="col">
            <strong>Sessions totales :</strong> <?php echo h($connections_count); ?><br>
            <strong>Utilisateurs uniques :</strong> <?php echo h($unique_users); ?><br>
            <br>
            <strong>Durée totale (s) :</strong> <?php echo secondsToTime($total_duration); ?><br>
            <strong>Durée moyenne (s) :</strong> <?php echo secondsToTime($avg_duration); ?><br>
            <strong>Durée médiane (s) :</strong> <?php echo secondsToTime($median_duration); ?><br>
            <br>
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
                    <tr><td><?php echo h($k); ?></td><td><?php echo h($v); ?></td></tr>
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
            <h3>Par résolution (extraits)</h3>
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
</body>
</html>
