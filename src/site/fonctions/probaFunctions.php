<?php
function read_csv_assoc($file) {
    $rows = [];
    if (($handle = fopen($file, 'r')) !== false) {
        $header = fgetcsv($handle);  // Lecture de l'entête
        while (($data = fgetcsv($handle)) !== false) {
            $rows[] = array_combine($header, $data);
        }
        fclose($handle);
    }
    return $rows;
}

function getUploadedCSV($fieldName) {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    return $_FILES[$fieldName]['tmp_name'];
}

// Utility functions
function safe_int($v) {
    if ($v === null || $v === '') return 0;
    // remove non-digits
    return (int) preg_replace('/\D+/', '', $v);
}
function median($arr) {
    if (empty($arr)) return 0;
    sort($arr, SORT_NUMERIC);
    $c = count($arr);
    $mid = intval($c / 2);
    if ($c % 2) {
        return $arr[$mid];
    } else {
        return ($arr[$mid - 1] + $arr[$mid]) / 2;
    }
}
function ecartType($arr) {
    return sqrt(variance($arr));
}

function variance($arr) {
    $n = count($arr);

    // Si le tableau est vide, retourne null (pas de variance possible)
    if ($n === 0) {
        return null;
    }

    // Calcul de la moyenne
    $avg = array_sum($arr) / $n;

    // Somme des carrés des écarts à la moyenne
    $sumSquares = array_sum(array_map(
        function ($v) use ($avg) {
            return pow($v - $avg, 2);
        },
        $arr
    ));

    // Variance pour un échantillon (diviser par n-1 pour éviter le biais)
    return $sumSquares / ($n - 1);
}

function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function secondsToTime($seconds) {
    $years   = floor($seconds / (365 * 24 * 3600));
    $seconds %= 365 * 24 * 3600;

    $months  = floor($seconds / (30 * 24 * 3600));
    $seconds %= 30 * 24 * 3600;

    $days    = floor($seconds / (24 * 3600));
    $seconds %= 24 * 3600;

    $hours   = floor($seconds / 3600);
    $seconds %= 3600;

    $minutes = floor($seconds / 60);
    $seconds = $seconds % 60;

    // Construction dynamique
    $parts = [];

    if ($years > 0)   $parts[] = $years . " ans";
    if ($months > 0)  $parts[] = $months . " mois";
    if ($days > 0)    $parts[] = $days . " jours";
    if ($hours > 0)   $parts[] = $hours. " heures";
    if ($minutes > 0) $parts[] = $minutes. " minutes";
    if ($seconds > 0 || empty($parts)) $parts[] = sprintf("%02d s", $seconds);

    return implode(", ", $parts);
}


