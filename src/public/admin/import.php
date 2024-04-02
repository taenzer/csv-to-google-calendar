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
        <p class="mb-4 flex items-center gap-1">Eintrag <span id="countNow"></span> von <span id="countMax"></span>
            <svg onClick="goToEntryAlert()" class="inline fill-indigo-500 cursor-pointer"
                xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18">
                <path
                    d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
            </svg>
        </p>
        <!-- Formular -->
        <form action="#" method="post" id="form">
            <p class="flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <label class="font-semibold mb-1" for="veranstaltung">Veranstaltungstitel</label>
                <input type="text" name="veranstaltung" id="veranstaltung"
                    class="validateAll px-4 py-2 rounded border [&.invalid]:border-red-500" onChange="validateMe(this)">
            </p>
            <p class="flex flex-col mb-4 has-[.invalid]:text-red-500 ">
                <span class="flex items-center gap-1 mb-1">
                    <label class="font-semibold " for="veranstaltung">Datum</label>
                    <svg onClick="jumpToDateAlert()" class="inline fill-indigo-500 cursor-pointer"
                        xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18">
                        <path
                            d="M440-440v-160h80v80h80v80H440Zm280 0v-80h80v-80h80v160H720ZM440-720v-160h160v80h-80v80h-80Zm360 0v-80h-80v-80h160v160h-80ZM136-80l-56-56 224-224H120v-80h320v320h-80v-184L136-80Z" />
                    </svg></span>

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

        <button onclick="newEvent()" class="bg-green-500 text-white rounded px-2 py-1 mt-2">+ Neuer Eintrag</button>
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