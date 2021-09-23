<?php
include "inc/autoloader.inc.php";

$userControl = new UserControl();
$userControl->isLoggedIn();

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

                <h2>You are now logged in to Management System &#x1F44D;</h2>

            </main>

        </div>
    </div>

    <?php require_once "./app/view/layout/scripts.php" ?>

</body>

</html>