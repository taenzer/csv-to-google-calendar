<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalendereinträge importieren</title>
</head>

<body>

    <div>

        <!-- Formular -->
        <form action="#" method="post">
            <p>
                <label for="veranstaltung">Veranstaltungstitel</label>
                <input type="text" name="veranstaltung" id="veranstaltung">
            </p>
            <p>
                <label for="veranstaltung">Datum</label>
                <input type="date" onchange="dateChanged()" name="datum" id="datum">
            </p>
            <p>
                <label for="ganztag">
                    <input type="checkbox" name="ganztag" id="ganztag" onChange="toggleGanztag()"> Ganztägiges Ereignis
                </label>
            </p>
            <p class="hideGanztag">
                <label for="veranstaltung">Startzeit</label>
                <input type="time" name="startzeit" id="startzeit">
            </p>
            <p class="hideGanztag">
                <label for="veranstaltung">Endzeit</label>
                <input type="time" name="endzeit" id="endzeit">
            </p>
            <p>
                <label for="veranstaltung">Location</label>
                <input type="text" name="location" id="location">
            </p>
            <p>
                <label for="veranstaltung">Beschreibung</label>
                <input type="text" name="beschreibung" id="beschreibung">
            </p>

        </form>
        <button onclick="sendToCalendar()">Eintragen</button>
        <button onClick="prevEntry()">Vorheriger Eintrag</button>
        <button onClick="nextEntry()">Nächster Eintrag</button>

        <!-- Ereignisanzeige -->
        <div>

            <h2>Eingetragene Termine am <span id="dtdisplay"></span></h2>
            <p style="color: red">Achtung: Ganztägige Ereignisse werden hier nicht gelistet!</p>
            <div id="display"></div>

        </div>
    </div>
    <script src="main.js"></script>
    <style>
        p {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</body>

</html>