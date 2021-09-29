<?php
include "inc/autoloader.inc.php";

$userControl = new UserControl();
$userControl->isLoggedIn();

if (!isset($_SESSION)) {
    session_start();
}
// page auth
if (isset($_SESSION["user"]) == false || $_SESSION["user"]["role"] == "general_user") {
    header("Location: ./users.php");
}

// handle form 
if ($_POST) {
    var_dump($_POST);
    // check if all fields set 
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
        // make new user
        $res = $userControl->makeNewUser($_POST["username"], $_POST["password"], $_POST["email"], isset($_POST["sendEmail"]));
        if ($res) {
            print_r($res);
        }
    }
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

                <h2>Create User</h2>
                <p>(Kun Super Admin og Admin skal kunne oprette brugere)</p>
                <div class="container">
                    <div class="row">

                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" aria-describedby="Username" name="username" placeholder="username" required>

                                </div>

                                <div class="form-group">
                                    <label for="Email">Email address</label>
                                    <input type="email" class="form-control" id="Email" name="email" placeholder="Email" required aria-describedby="emailHelp" placeholder="Email">

                                </div>

                                <div class="form-group">
                                    <label for="Password">Password</label>
                                    <input type="password" class="form-control" name="password" id="Password" placeholder="Password" required>
                                    <br>
                                    <span id="password-test-msg"></span>

                                </div>

                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="sendEmail" name="sendEmail">
                                    <label class="form-check-label" for="sendEmail">Send loginoplysninger til bruger</label>
                                </div>

                                <button type="submit" class="btn btn-primary create-user">Opret</button>
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