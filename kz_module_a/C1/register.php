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
<<<<<<< HEAD

    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" />
</head>
<body>
    <div class="container-sm">
        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="border rounded p-4">
                <h1>
                    Register
                </h1>

                <hr />

                <form method="post">
                    <div class="mb-3">
                        <input type="text" name="username" placeholder="Username" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <input type="password" name="password" placeholder="******" class="form-control" />
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        Register
                    </button>
                </form>

                <p class="message">
                    <?= $message ?>
                </p>

                <div class="d-flex justify-content-center">
                    <a class="link-info" href="index.php">
                        Login
                    </a>
                </div>
            </div>
        </div>
=======
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
>>>>>>> 9ec4524b291f337ed02d9d77ae1fcd2738c1b8b2
    </div>
</body>
</html>