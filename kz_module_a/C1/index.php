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
<<<<<<< HEAD

    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" />
=======
>>>>>>> 9ec4524b291f337ed02d9d77ae1fcd2738c1b8b2
</head>
<body>
    <div class="card">
        <?php if (isset($_SESSION['username'])) { ?>
<<<<<<< HEAD
            <div class="container-sm vh-100">
                <div class="d-flex justify-content-center align-items-center">
                    <h1>
                        Successful login
                    </h1>

                    <p>
                        Hello, <?= htmlspecialchars($_SESSION['username']) ?>!
                    </p>

                    <a class="btn btn-danger" href="index.php?logout=1">
                        Logout
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <div class="container-sm">
                <div class="d-flex flex-column justify-content-center align-items-center min-vh-100">
                    <div class="border rounded p-4">
                        <h1>
                            Login
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
                                Login
                            </button>
                        </form>

                        <p class="message">
                            <?= $message ?>
                        </p>

                        <div class="d-flex justify-content-center">
                            <a class="link-info" href="register.php">
                                Create account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
=======
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
>>>>>>> 9ec4524b291f337ed02d9d77ae1fcd2738c1b8b2
        <?php } ?>
    </div>
</body>
</html>