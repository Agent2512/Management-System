<?php
include "inc/autoloader.inc.php";

$userControl = new UserControl();
$userControl->isLoggedIn();

if (!isset($_SESSION)) {
    session_start();
}
// page auth
if (isset($_SESSION["user"]) == false || $_SESSION["user"]["role"] != "SuperAdmin") {
    header("Location: ./users.php");
}


// handle POST form data
if (count($_POST) >= 4 && isset($_POST["id"]) && $_POST["id"] != "") {

    if (isset($_POST["password"], $_POST["password2"], $_POST["username"]) && $_POST["password"] == $_POST["password2"] && $_POST["username"] != "") {

        $userControl->editUser($_POST["id"], $_POST["username"], $_POST["password"], isset($_POST["sendEmail"]));
    }
}

// user object 
$editUser;

// get get user from database
// or go´s the users page
if (isset($_GET["user_id"]) && $_GET["user_id"] != "" && $editUser = $userControl->getUser($_GET["user_id"])) {
} else {
    header("Location: ./users.php");
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

                <h2>Edit User</h2>

                <p>(Kun Super Admin skal kunne redigere brugere)</p>

                <div class="container">
                    <div class="row">

                        <div class="col-md-6 col-lg-6 col-xl-4">
                            <form action="<?= $_SERVER['PHP_SELF'] . "?user_id=" . $editUser->id ?>" method="POST">

                                <div class="form-group">
                                    <label for="id">id</label>
                                    <input name="id" class="form-control mx-sm-6" type="text" id="id" value=<?= $editUser->id ?> readonly required>
                                </div>

                                <div class="form-group">
                                    <label for="user_name">User name</label>
                                    <input name="username" type="text" class="form-control" id="user_name" aria-describedby="User name" value="<?= $editUser->username  ?>">
                                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="createPassword">Password</label>
                                    <input name="password" type="password" class="form-control" id="createPassword" placeholder="Password">
                                    <br>
                                    <span id="password-test-msg"></span>

                                </div>

                                <div class="form-group">
                                    <label for="createPassword2">gentag Password</label>
                                    <input name="password2" type="password" class="form-control" id="createPassword2" placeholder="Password">
                                    <p>(skal kun ændres, hvis nyt password sættes)</p>
                                </div>

                                <div class="form-check">
                                    <input name="sendEmail" type="checkbox" class="form-check-input" id="sendEmail">
                                    <label class="form-check-label" for="sendEmail">Send nyt password til brugeren</label>
                                    <p>(Hvis bruger ændrer eget password skal der sendes en mail til brugeren om, at password er skiftet)</p>
                                </div>

                                <button type="submit" class="btn btn-primary eidt-user">Gem</button>
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