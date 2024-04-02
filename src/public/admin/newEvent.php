<?php
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Europe/Berlin');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit();
}

/* Receive the RAW post data. */
$content = trim(file_get_contents('php://input'));

/* $decoded can be used the same as you would use $decoded in $.ajax */
$decoded = json_decode($content, true);

/* Send error to Fetch API, if JSON is broken */
if (!is_array($decoded)) {
    die(
        json_encode([
            'value' => 0,
            'error' => 'Received JSON is improperly formatted',
            'data' => null,
        ])
    );
}

if (!isset($decoded['titel'], $decoded['date'], $decoded['location'], $decoded['beschreibung'], $decoded['ganztag'], $decoded['start'], $decoded['end'])) {
    echo json_encode(['error' => 'Missing parameters', 'data' => $decoded]);
    die();
}

ob_start();
$titel = $decoded['titel'];
$date = $decoded['date'];
$location = $decoded['location'];
$beschreibung = $decoded['beschreibung'];
$ganztag = $decoded['ganztag'];

if ($ganztag) {
    $start = [
        'date' => $date,
        'timeZone' => 'Europe/Berlin',
    ];
    $end = $start;
} else {
    $startDt = new DateTime("$date {$decoded['start']}");
    $endDt = new DateTime("$date {$decoded['end']}");

    if($endDt < $startDt) {
        $endDt->modify('+1 day');
    }

    $start = [
        'dateTime' => $startDt->format('c'),
        'timeZone' => 'Europe/Berlin',
    ];
    $end = [
        'dateTime' => $endDt->format('c'),
        'timeZone' => 'Europe/Berlin',
    ];
}

try {
    require_once '../../vendor/autoload.php';

    $client = new Google\Client();
    $client->setAuthConfig('../../client_secrets.json');
    $client->setApplicationName('Client_Library_Examples');
    $client->setScopes(['https://www.googleapis.com/auth/calendar']);

    $calendar = new Google\Service\Calendar($client);

    $event = new Google_Service_Calendar_Event([
        'summary' => $titel,
        'location' => $location,
        'description' => $beschreibung,
        'start' => $start,
        'end' => $end,
        'reminders' => [
            'useDefault' => true,
        ],
    ]);

    $calendarId = '72272fd34fbe8e954ac6740fa063f51be7b2bce01f73fa2d3a08964916756466@group.calendar.google.com';
    $event = $calendar->events->insert($calendarId, $event);
} catch (\Throwable $th) {
    http_response_code(400);
    echo json_encode(['error' => $th->getMessage(), 'dump' => ob_get_clean()]);
    die();
}

echo json_encode(['message' => 'Event created', 'dump' => ob_get_clean()]);