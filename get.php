<?php
header('Content-Type: application/json; charset=utf-8');
ob_start(); // Workaround for AUTO_DETECT_LINE_ENDINGS Deprecation Warning
ini_set('auto_detect_line_endings', true);
ob_get_clean();
$handle = fopen('veranstaltungsplan.csv', 'r');
$result = [];
$entry = 0;

while (($data = fgetcsv($handle, 1000, ';')) !== false) {
    // Skip empty lines
    if (empty($data[1]) && empty($data[2]) && empty($data[3]) && empty($data[4]) && empty($data[5])) {
        continue;
    }

    if (empty($data[0]) || empty($data[1])) {
        $prev = $entry - 1;
        // Wenn es noch keinen Eintrag gibt, dann überspringen
        if (!isset($result[$prev])) {
            continue;
        }
        $result[$prev]['veranstaltung'] .= empty($data[3]) ? '' : ' ' . $data[3];
        $result[$prev]['information'] .= empty($data[4]) ? '' : ' ' . $data[4];
        $result[$prev]['veranstalter'] .= empty($data[5]) ? '' : ' ' . $data[5];
        continue;
    }
    $datum = DateTime::createFromFormat('d.m.Y', $data[1]);
    $zeiten = preg_split('/(\–|-)/', $data[2], -1, PREG_SPLIT_NO_EMPTY);
    try {
        $startzeit = !empty($zeiten[0]) ? trim(str_replace('Uhr', '', $zeiten[0])) : '';
        $startzeit .= !empty($startzeit) && strpos($startzeit, '.') === false ? '.00' : '';
        $startzeit = !empty($startzeit) ? (new DateTime($startzeit))->format('H:i') : '';
    } catch (\Throwable $th) {
        $startzeit = '';
    }

    try {
        $endzeit = isset($zeiten[1]) ? trim(str_replace('Uhr', '', $zeiten[1])) : '';
        $endzeit .= !empty($endzeit) && strpos($endzeit, '.') === false ? '.00' : '';
        $endzeit = !empty($endzeit) ? (new DateTime($endzeit))->format('H:i') : '';
    } catch (\Throwable $th) {
        $endzeit = '';
    }
    $result[$entry] = [
        'datum' => $datum ? $datum->format('Y-m-d') : '',
        'startzeit' => $startzeit,
        'endzeit' => $endzeit,
        'veranstaltung' => $data[3],
        'information' => $data[4],
        'veranstalter' => $data[5],
    ];
    $entry++;
}
echo json_encode($result, JSON_PRETTY_PRINT);
fclose($handle);