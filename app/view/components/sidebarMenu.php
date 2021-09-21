<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="./">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>


        </ul>

        <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["role"] != "general_use") : ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Admin</span>
                <a class="link-secondary" href="#" aria-label="Admin">
                    <span data-feather="plus-circle"></span>
                </a>
            </h6>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="users.php">
                        <span data-feather="file-text"></span>
                        Users
                    </a>
                </li>
            </ul>

        <?php endif ?>

    </div>
</nav>