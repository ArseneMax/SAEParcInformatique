<?php
function read_csv_assoc($path, $delimiter = ',') {
    if (!file_exists($path) || !is_readable($path)) {
        return [];
    }
    $rows = [];
    if (($handle = fopen($path, 'r')) !== false) {
        $headers = fgetcsv($handle, 0, $delimiter);
        if ($headers === false) { fclose($handle); return []; }
        // trim headers
        $headers = array_map('trim', $headers);
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            // if row length differs from headers, pad with nulls
            if (count($data) < count($headers)) {
                $data = array_pad($data, count($headers), null);
            }
            $row = [];
            foreach ($headers as $i => $h) {
                $row[$h] = isset($data[$i]) ? trim($data[$i]) : null;
            }
            $rows[] = $row;
        }
        fclose($handle);
    }
    return $rows;
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


