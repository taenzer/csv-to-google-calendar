<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veranstaltungskalender Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex justify-center p-10">

    <div class="bg-slate-100 p-10 w-full max-w-3xl">
        <h1 class="text-2xl font-bold mb-4">Veranstaltungskalender Administration</h1>
        <p>Über den folgenden Button können EInträge aus der "alten Tabelle" in den digitalen Kalender übernommen
            werden:
        </p>
        <a href="import.php"><button class="bg-indigo-500 text-white rounded px-2 py-1 mt-2">CSV-Import</button></a>

        <p class="mt-6 text-xs">&copy; TNZ Dienstleistungen <?php echo date("Y"); ?></p>

    </div>
</body>

</html>