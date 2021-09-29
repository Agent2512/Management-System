<?php
include "inc/autoloader.inc.php";

$userControl = new UserControl();
$userControl->isLoggedIn();

if (!isset($_SESSION)) {
    session_start();
}



// handle form
if (count($_POST) == 5 && isset($_POST["id"]) && $_POST["id"] == $_SESSION["user"]["id"]) {
    // check for all form fields
    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password2"])) {
        // check if passwords match
        if ($_POST["password"] == $_POST["password2"]) {
            // edit profile
            $userControl->editProfile($_POST["id"], $_POST["username"], $_POST["password"], $_POST["email"]);
            
        }
    }
}



$user = $userControl->getUser($_SESSION["user"]["id"]);

if (!$user) {
    header("Location: logout.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<?php require_once "./app/view/layout/head.php" ?>


<body>

    <?php require_once "./app/view/layout/navbarTop.php" ?>


    <div class="container-fluid">
        <div class="row">
            <?php require_once "./app/view/layout/sidebarMenu.php" ?>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>

                </div>

                <h2>Edit Profile</h2>
                <div class="container">
                    <div class="row">

                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

                                <div class="form-group">
                                    <input name="id" class="form-control mx-sm-6" type="text" value="<?= $user->id ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="username">username</label>
                                    <input name="username" type="text" class="form-control" id="username" aria-describedby="username" value="<?= $user->username ?>">

                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= $user->user_email ?>">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword2">Gentag Password</label>
                                    <input name="password2" type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                                </div>

                                <button type="submit" class="btn btn-primary">Gem</button>
                            </form>


                        </div>

                    </div>
                    <!--/.row-->

                </div>
                <!--/.container-->

            </main>

        </div>
    </div>

    <?php require_once "./app/view/layout/scripts.php" ?>

</body>

</html>