<?php
/**
 * props:
 * 
 * id
 * username
 * email
 * date
 * role
 * login_attempts
 * UserControl():class
 */

// check if all props is defined
if (isset($id, $username, $email, $date, $role, $login_attempts, $userControl) == false) {
    trigger_error("props is set in showUser_inRow");
    die();
}
// should element load
$load = true;

// check for GET key at Lock to function
if (isset($_GET["Lock"]) && $_GET["Lock"] == $id) {
    // runs on database
    $userControl->setloginAttempts($id, 6);
    // set value for view
    $login_attempts = 6;
}

// check for GET key at Unlock to function
if (isset($_GET["Unlock"]) && $_GET["Unlock"] == $id) {
    // runs on database
    $userControl->setloginAttempts($id, 0);
    // set value for view
    $login_attempts = 0;
}

// check for GET key at Delete to function
if (isset($_GET["Delete"]) && $_GET["Delete"] == $id) {
    // runs on database
    $userControl->removeUser($id);
    // set value for view
    $load = false;
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
        <?php if($_SESSION["user"]["role"] == "SuperAdmin") : ?> 
            <a href=<?= "./edit_user.php" . "?user_id=" . $id ?> class="btn btn-info">Edit</a>
        <?php endif ?>


        <!--Too many login attempts or locked by admin-->
        <?php if ($login_attempts == 6) : ?>
            <a href=<?= $_SERVER["PHP_SELF"] . "?Unlock=" . $id ?> class="btn btn-warning">Unlock</a>
        <?php else : ?>
            <a href=<?= $_SERVER["PHP_SELF"] . "?Lock=" . $id ?> class="btn btn-info">Lock</a>
        <?php endif; ?>

        <?php if($role != "SuperAdmin") : ?> 
        <a href=<?= $_SERVER["PHP_SELF"] . "?Delete=" . $id ?> class="btn btn-danger btn-delete">Delete</a>
        <?php endif ?>
    </td>
</tr>

<?php endif; ?>