<?php

// php cannot write in table json. expert, i used this command:
// chown www-data:www-data users.json

session_start();

$message = '';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username === '' || $password === '') {
        $message = 'All fields required!';
    } else {
        $users = json_decode(file_get_contents('users.json'), true);

        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                $_SESSION['username'] = $username;
                header('Location: index.php');
                exit;
            }
        }

        $message = 'Invalid username or password';
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
    <title>C1</title>
</head>
<body>
    <div class="card">
        <?php if (isset($_SESSION['username'])) { ?>
            <h1>
                Successful login
            </h1>

            <p>
                Hello, <?= htmlspecialchars($_SESSION['username']) ?>!
            </p>

            <a class="btn" href="index.php?logout=1">
                Logout
            </a>
        <?php } else { ?>
            <h1>
                Login
            </h1>

            <form method="post">
                <input type="text" name="username" placeholder="Username" />

                <input type="password" name="password" placeholder="******" />

                <button class="btn" type="submit">
                    Login
                </button>
            </form>

            <p class="message">
                <?= $message ?>
            </p>

            <a class="link" href="register.php">
                Create account
            </a>
        <?php } ?>
    </div>
</body>
</html>