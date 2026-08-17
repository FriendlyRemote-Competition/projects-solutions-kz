<?php
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if ($username === '' || $password === '') {
            $message = 'All fields required!';
        } else {
            $users = json_decode(file_get_contents('users.json'), true);

            $users[] = [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];

            file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));

            $message = 'Register successfully';
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
        <h1>
            Register
        </h1>

        <form method="post">
            <input type="text" name="username" placeholder="Username" />

            <input type="password" name="password" placeholder="******" />

            <button class="btn" type="submit">
                Register
            </button>
        </form>

        <p class="message">
            <?= $message ?>
        </p>

        <a class="link" href="index.php">
            Login
        </a>
    </div>
</body>
</html>