<?php
include "inc/autoloader.inc.php";

$userControl = new UserControl();
$userControl->isLoggedIn();

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["user"]) == false || $_SESSION["user"]["role"] == "general_user") {
    header("Location: ./index.php");
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

                <h2>Users</h2>

                <a href="create_user.php" class="btn btn-info">Create new User</a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Registered</th>
                                <th scope="col">Role</th>
                                <th scope="col">Function</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($userControl->getAllUsers() as $user) {
                                $id = $user->id;
                                $username = $user->username;
                                $email = $user->user_email;
                                $date = $user->user_registered;
                                $role = $user->user_role;
                                $login_attempts = $user->login_attempts;

                                require "./app/view/components/user/showUser_inRow.php";
                            }


                            ?>
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>

    <?php require_once "./app/view/layout/scripts.php" ?>

</body>

</html>