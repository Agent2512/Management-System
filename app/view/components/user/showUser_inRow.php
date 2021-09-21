<?php
// props
// id, username, email, date, role, login_attempts, UserControl()
if (isset($id, $username, $email, $date, $role, $login_attempts, $userControl) == false) {
    trigger_error("props is set in showUser_inRow");
    die();
}

$load = true;

if (isset($_GET["Lock"]) && $_GET["Lock"] == $id) {
    $userControl->setloginAttempts($id, 6);
    $login_attempts = 6;
}

if (isset($_GET["Unlock"]) && $_GET["Unlock"] == $id) {
    $userControl->setloginAttempts($id, 0);
    $login_attempts = 0;
}

if (isset($_GET["Delete"]) && $_GET["Delete"] == $id) {
    $userControl->deleteUser($id);
    $load = false ;
}


?>

<?php if ($load) : ?>
<tr>
    <td><?= $id ?></td>
    <td><?= $username ?></td>
    <td><?= $email ?></td>
    <td><?= $date ?></td>
    <td><?= $role ?></td>
    <td>
        <a href="./edit_user.php" class="btn btn-info">Edit</a>



        <!--Too many login attempts or locked by admin-->
        <?php if ($login_attempts == 6) : ?>
            <a href=<?= $_SERVER["PHP_SELF"] . "?Unlock=" . $id ?> class="btn btn-warning">Unlock</a>
        <?php else : ?>
            <a href=<?= $_SERVER["PHP_SELF"] . "?Lock=" . $id ?> class="btn btn-info">Lock</a>
        <?php endif; ?>

        <a href=<?= $_SERVER["PHP_SELF"] . "?Delete=" . $id ?> class="btn btn-danger btn-delete">Delete</a>
    </td>
</tr>

<?php endif; ?>