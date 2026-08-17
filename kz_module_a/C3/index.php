<?php

// php cannot write in table json. expert, i used this command:
// chown www-data:www-data table.json

$file = __DIR__ . '/table.json';
$rows = json_decode(file_get_contents($file), true);

$fields = array_keys($rows[0]);

if (isset($_POST['add'])) {
    $rows[] = array_fill_keys($fields, '');
    file_put_contents($file, json_encode($rows, JSON_PRETTY_PRINT));
    header('Location: index.php');
    exit;
}

if (isset($_POST['delete'])) {
    unset($rows[(int) $_POST['delete']]);
    file_put_contents($file, json_encode(array_values($rows), JSON_PRETTY_PRINT));
    header('Location: index.php');
    exit;
}

if (isset($_POST['save'])) {
    $newRows = [];

    foreach ($_POST['rows'] ?? [] as $row) {
        $item = [];

        foreach ($_POST['fields'] as $index => $name) {
            $value = $row[$index];
            $item[$name] = is_numeric($value) ? (int) $value : $value;
        }

        $newRows[] = $item;
    }

    file_put_contents($file, json_encode($newRows, JSON_PRETTY_PRINT));
    header('Location: index.php');
    exit;
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>C3</title>
</head>
<body>
    <form method="post" action="index.php">
        <table>
            <tr>

                <?php foreach ($fields as $index => $name) { ?>
                    <th>
                        <input type="text" name="fields[<?= $index ?>]" value="<?= htmlspecialchars($name) ?>" />
                    </th>
                <?php } ?>

                <th>
                    Delete
                </th>
            </tr>

            <?php foreach ($rows as $rowIndex => $row) { ?>
                <tr>
                    <?php foreach (array_values($row) as $index => $value) { ?>
                        <td>
                            <input type="text" name="rows[<?= $rowIndex ?>][<?= $index ?>]" value="<?= htmlspecialchars($value) ?>" />
                        </td>
                    <?php } ?>

                    <td>
                        <button class="red" type="submit" name="delete" value="<?= $rowIndex ?>">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div class="buttons">
            <button class="gray" type="submit" name="add" value="1">
                Add row
            </button>

            <button class="blue" type="submit" name="save" value="1">
                Save
            </button>
        </div>
    </form>
</body>
</html>