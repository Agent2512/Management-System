<?php
include "inc/autoloader.inc.php";
$tokenErr;

$userControl = new UserControl();

// validate token
if (count($_GET) && isset($_GET['token']) && $_GET['token'] != "") {
    $tokenErr = $userControl->validateToken($_GET['token']);
    if ($tokenErr) {
        die($tokenErr);
    }
} else {
    die("error invalid token");
}

// handle form
if (count($_POST) && isset($_POST['password'])) {
    $userControl->resetPassword($_GET['token'], $_POST['password']);
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management system</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .err {
            background-color: #f00;
            border-radius: 3px;
        }

        .err>p {
            color: #000;
            font-size: 1.3rem;
            font-weight: 500;
        }
    </style>
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="<?= $_SERVER['PHP_SELF'] . "?token=" . $_GET['token'] ?>" method="POST">
            <h1 class="h3 mb-3 fw-normal">New Password</h1>

            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="createPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                <br>
                <span id="password-test-msg"></span>
            </div>

            <button class="w-100 btn btn-lg btn-primary mt-5" type="submit">Reset Password</button>
            <p class="mt-5 mb-3 text-muted">Management System &copy;2021</p>
        </form>
    </main>

    <?php require_once "./app/view/layout/scripts.php" ?>
</body>

</html>