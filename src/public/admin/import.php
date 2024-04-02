<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veranstaltungskalender Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="/admin/main.js"></script>
</head>

<body class="flex justify-center p-10">

    <div class="bg-slate-100 p-10 w-full max-w-3xl">
        <h1 class="text-2xl font-bold">Kalendereintrag aus Datei Importieren</h1>
        <p class="mb-4">Eintrag <span id="countNow"></span> von <span id="countMax"></span></p>
        <!-- Formular -->
        <form action="#" method="post" id="form">
            <p class="flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Veranstaltungstitel</label>
                <input type="text" name="veranstaltung" id="veranstaltung"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500" onChange="validateMe(this)">
            </p>
            <p class="flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Datum</label>
                <input type="date" onchange="dateChanged()" name="datum" id="datum" onChange="validateMe(this)"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500">
            </p>
            <p class="flex flex-col mb-4">
                <label class="font-semibold mb-1" for="ganztag">
                    <input type="checkbox" name="ganztag" id="ganztag" onChange="toggleGanztag()"
                        class="px-4 py-2 rounded"> Ganztägiges Ereignis
                </label>
            </p>
            <p class="hideGanztag flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Startzeit</label>
                <input type="time" name="startzeit" id="startzeit" onChange="validateMe(this)"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500">
            </p>
            <p class="hideGanztag flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Endzeit</label>
                <input type="time" name="endzeit" id="endzeit" onChange="validateMe(this)"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500">
            </p>
            <p class="flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Location</label>
                <input type="text" name="location" id="location" onChange="validateMe(this)"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500">
            </p>
            <p class="flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Beschreibung</label>
                <textarea type="text" rows="4" name="beschreibung" onChange="validateMe(this)" id="beschreibung"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500"></textarea>
            </p>

        </form>

        <button onclick="sendToCalendar()" class="bg-indigo-500 text-white rounded px-2 py-1 mt-2">Eintragen</button>
        <button onClick="prevEntry()" class="bg-indigo-500 text-white rounded px-2 py-1 mt-2">Vorheriger
            Eintrag</button>
        <button onClick="nextEntry()" class="bg-indigo-500 text-white rounded px-2 py-1 mt-2">Nächster Eintrag</button>

        <p class="mt-6 text-xs">&copy; TNZ Dienstleistungen <?php echo date("Y"); ?></p>

    </div>

    <!-- Ereignisanzeige -->
    <div class="bg-slate-100 p-10 w-full max-w-3xl">

        <h2 class="text-2xl font-bold">Eingetragene Termine am <span id="dtdisplay"></span></h2>
        <p class="text-red-500  mb-4">Achtung: Ganztägige Ereignisse werden hier nicht gelistet!</p>
        <div id="display"></div>

    </div>
</body>

</html>