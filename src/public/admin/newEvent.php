<?php
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('Europe/Berlin');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 405 Method Not Allowed');
    exit;
}

/* Receive the RAW post data. */
$content = trim(file_get_contents("php://input"));

/* $decoded can be used the same as you would use $decoded in $.ajax */
$decoded = json_decode($content, true);

/* Send error to Fetch API, if JSON is broken */
if (!is_array($decoded))
    die(json_encode([
        'value' => 0,
        'error' => 'Received JSON is improperly formatted',
        'data' => null,
    ]));

if (!isset($decoded["titel"], $decoded["date"], $decoded["location"], $decoded["beschreibung"], $decoded["ganztag"], $decoded["start"], $decoded["end"])) {
    echo (json_encode(array("error" => "Missing parameters", "data" => $decoded)));
    die();
}

ob_start();
$titel = $decoded["titel"];
$date = $decoded["date"];
$location = $decoded["location"];
$beschreibung = $decoded["beschreibung"];
$ganztag = $decoded["ganztag"];

if ($ganztag) {

    $start = array(
        "date" => $date,
        "timeZone" => "Europe/Berlin"
    );
    $end = $start;
} else {
    $start = array(
        "dateTime" => date("c", strtotime($date . " " . $decoded["start"])),
        "timeZone" => "Europe/Berlin"
    );
    $end = array(
        "dateTime" => date("c", strtotime($date . " " . $decoded["end"])),
        "timeZone" => "Europe/Berlin"
    );
}


require_once("../../vendor/autoload.php");

$client = new Google\Client();
$client->setAuthConfig("../../client_secrets.json");
$client->setApplicationName("Client_Library_Examples");
$client->setScopes(['https://www.googleapis.com/auth/calendar']);

$calendar = new Google\Service\Calendar($client);

$event = new Google_Service_Calendar_Event(array(
    'summary' => $titel,
    'location' => $location,
    'description' => $beschreibung,
    'start' => $start,
    'end' => $end,
    'reminders' => array(
        'useDefault' => TRUE,
    ),
));

$calendarId = "72272fd34fbe8e954ac6740fa063f51be7b2bce01f73fa2d3a08964916756466@group.calendar.google.com";
$event = $calendar->events->insert($calendarId, $event);
echo json_encode(array("message" => "Event created", "dump" => ob_get_clean()));