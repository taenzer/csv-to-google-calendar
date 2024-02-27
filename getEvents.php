<?php 
header('Content-Type: application/json; charset=utf-8');
if(!isset($_GET["date"])){
    die("No date given");
}
$date = new DateTime($_GET["date"]);
$dtStart = date("c", strtotime($date->format("Y-m-d")." 00:00:00"));
$dtEnd = date("c", strtotime($date->format("Y-m-d")." 23:59:59"));


require_once("./vendor/autoload.php");
$calendarId = "72272fd34fbe8e954ac6740fa063f51be7b2bce01f73fa2d3a08964916756466@group.calendar.google.com";
$client = new Google\Client();
$client->setAuthConfig("./client_secrets.json");
$client->setApplicationName("Client_Library_Examples");
$client->setScopes(['https://www.googleapis.com/auth/calendar']);

$calendar = new Google\Service\Calendar($client);
$events = $calendar->events->listEvents($calendarId, array("timeMin" => $dtStart, "timeMax" => $dtEnd));
$result = array();
foreach ($events->getItems() as $event) {
    $result[] = array(
        "titel" => $event->getSummary(),
        "start" => $event->start->dateTime,
        "end" => $event->end->dateTime,
        "location" => $event->getLocation(),
        "description" => $event->getDescription(),
        "repeat" => $event->getRecurrence(),
    );
  }

  echo json_encode($result, JSON_PRETTY_PRINT);