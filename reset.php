<?php
include "inc/autoloader.inc.php";
$tokenErr;
if (count($_GET) && isset($_GET['token']) && $_GET['token'] != "") {
    $tokenErr = (new UserControl)->validateToken($_GET['token']);
}
else {
    die("error invalid token");
}
// else header("location: index.php");

?>


<!DOCTYPE html>
<html lang="en">

<?php require_once "./app/view/layout/head.php" ?>

<body class="text-center">

    <main class="form-signin">
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
            <h1 class="h3 mb-3 fw-normal">New Password</h1>

            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <?php if ($tokenErr) : ?>
                <div class="err">
                    <p><?= $tokenErr ?></p>
                </div>
            <?php endif ?>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Reset Password</button>
            <p class="mt-5 mb-3 text-muted">Management System &copy;2021</p>
        </form>
    </main>

    <?php require_once "./app/view/layout/scripts.php" ?>
</body>

</html>