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
        <form action="#">
            <p>
                <label for="veranstaltung">Veranstaltungstitel</label>
                <input type="text" name="veranstaltung" id="veranstaltung">
            </p>
            <p>
                <label for="veranstaltung">Datum</label>
                <input type="date" name="datum" id="datum">
            </p>
            <p>
                <label for="veranstaltung">Startzeit</label>
                <input type="time" name="startzeit" id="startzeit">
            </p>
            <p>
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
            <button>Eintragen</button>
        </form>
        <button onClick="prevEntry()">Vorheriger Eintrag</button>
        <button onClick="nextEntry()">Nächster Eintrag</button>

        <!-- Ereignisanzeige -->
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