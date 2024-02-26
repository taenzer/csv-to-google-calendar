<?php ini_set('auto_detect_line_endings', TRUE);
$handle = fopen("veranstaltungsplan.csv", "r");
?>
<html>

<body>
    <style>
        table {
            border-collapse: collapse;
        }

        table td {
            border: 1px solid;
        }
    </style>
    <table>
        <thead>
            <tr>
                <td>Tag</td>
                <td>Datum</td>
                <td>Uhrzeit</td>
                <td>Veranstaltung</td>
                <td>Information</td>
                <td>Veranstalter</td>
            </tr>
        </thead>
        <tbody>
            <?php
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                if (empty($data[1])) {
                    continue;
                }

            ?>
                <tr>
                    <td><?= $data[0] ?></td>
                    <td><?= $data[1] ?></td>
                    <td><?= $data[2] ?></td>
                    <td><?= $data[3] ?></td>
                    <td><?= $data[4] ?></td>
                    <td><?= $data[5] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>

<?php


fclose($handle);
