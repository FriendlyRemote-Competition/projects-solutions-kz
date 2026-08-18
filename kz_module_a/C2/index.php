<?php
$storageFile = __DIR__ . '/tasks.json';

// php cannot write in table json. expert, i used this command:
// chown www-data:www-data tasks.json

function loadTasks(string $file): array
{
    if (!is_file($file)) {
        return [];
    }

    $handle = fopen($file, 'r');
    flock($handle, LOCK_SH);
    $raw = stream_get_contents($handle);
    flock($handle, LOCK_UN);
    fclose($handle);

    $tasks = json_decode($raw, true);

    return is_array($tasks) ? $tasks : [];
}

function saveTasks(string $file, array $tasks): void
{
    $handle = fopen($file, 'c');
    flock($handle, LOCK_EX);
    ftruncate($handle, 0);
    rewind($handle);
    fwrite($handle, json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    fflush($handle);
    flock($handle, LOCK_UN);
    fclose($handle);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recurring = isset($_POST['recurring']);
    $tasks = loadTasks($storageFile);

    $nextId = 1;
    foreach ($tasks as $task) {
        $nextId = max($nextId, (int)$task['id'] + 1);
    }

    $tasks[] = [
        'id' => $nextId,
        'title' => (string)$_POST['title'],
        'task_date' => (string)$_POST['task_date'],
        'type' => $recurring ? (string)$_POST['type'] : null,
        'cycle' => $recurring ? max(1, (int)$_POST['cycle']) : null,
        'end_date' => $recurring && $_POST['end_date'] !== '' ? (string)$_POST['end_date'] : null,
    ];

    saveTasks($storageFile, $tasks);

    header('Location: index.php?year=' . (int)$_POST['year'] . '&month=' . (int)$_POST['month']);
    exit;
}

$year = (int)($_GET['year'] ?? date('Y'));
$month = (int)($_GET['month'] ?? date('n'));

$firstDay = mktime(0, 0, 0, $month, 1, $year);
$gridStart = strtotime('-' . date('w', $firstDay) . ' days', $firstDay);
$gridEnd = strtotime('+41 days', $gridStart);

function buildDate($year, $month, $day)
{
    $year += intdiv($month - 1, 12);
    $month = ($month - 1) % 12 + 1;
    $lastDay = (int)date('t', mktime(0, 0, 0, $month, 1, $year));

    return mktime(0, 0, 0, $month, min($day, $lastDay), $year);
}

$events = [];

foreach (loadTasks($storageFile) as $task) {
    $taskTime = strtotime($task['task_date']);

    if ($taskTime === false) {
        continue;
    }

    $endTime = !empty($task['end_date']) ? strtotime($task['end_date']) : $gridEnd;

    $startYear = (int)date('Y', $taskTime);
    $startMonth = (int)date('n', $taskTime);
    $startDay = (int)date('j', $taskTime);

    $cycle = max(1, (int)($task['cycle'] ?? 1));

    for ($step = 0; ; $step++) {
        $shift = $cycle * $step;

        if (empty($task['type'])) {
            $time = $taskTime;
        } elseif ($task['type'] === 'day') {
            $time = strtotime("+$shift days", $taskTime);
        } elseif ($task['type'] === 'week') {
            $time = strtotime("+$shift weeks", $taskTime);
        } elseif ($task['type'] === 'month') {
            $time = buildDate($startYear, $startMonth + $shift, $startDay);
        } else {
            $time = buildDate($startYear + $shift, $startMonth, $startDay);
        }

        if ($time > $endTime || $time > $gridEnd) {
            break;
        }

        if ($time >= $gridStart) {
            $events[date('Y-m-d', $time)][] = $task['title'];
        }

        if (empty($task['type'])) {
            break;
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>C2</title>

    <link rel="stylesheet" href="./style.css" />
</head>
<body>
    <div class="page">
        <form class="bar" method="get">
            <label>Year <input type="number" name="year" value="<?= $year ?>"></label>
            <label>Month <input type="number" name="month" min="1" max="12" value="<?= $month ?>"></label>
            <button type="submit">Change</button>
        </form>

        <table class="calendar">
            <tr>
                <th>Sun</th>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
            </tr>

            <?php for ($week = 0; $week < 6; $week++): ?>
                <tr>
                    <?php for ($weekDay = 0; $weekDay < 7; $weekDay++):
                        $time = strtotime('+' . ($week * 7 + $weekDay) . ' days', $gridStart);
                        $date = date('Y-m-d', $time);
                        $otherMonth = (int)date('n', $time) !== $month;
                        ?>
                        <td class="<?= $otherMonth ? 'other' : '' ?>">
                            <div class="number"><?= date('j', $time) ?></div>

                            <?php foreach ($events[$date] ?? [] as $title): ?>
                                <div class="event"><?= htmlspecialchars($title) ?></div>
                            <?php endforeach; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>

        <form class="add" method="post">
            <input type="hidden" name="year" value="<?= $year ?>">
            <input type="hidden" name="month" value="<?= $month ?>">

            <label>Title <input type="text" name="title" required></label>
            <label>Task date <input type="date" name="task_date" required></label>
            <label><input type="checkbox" name="recurring" id="recurring"> Is recurring</label>

            <fieldset id="recurringFields" disabled>
                <label>Type
                    <select name="type">
                        <option value="day">Day</option>
                        <option value="week">Week</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select>
                </label>
                <label>Cycle <input type="number" name="cycle" min="1" value="1"></label>
                <label>End date <input type="date" name="end_date"></label>
            </fieldset>

            <button type="submit">Create</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>