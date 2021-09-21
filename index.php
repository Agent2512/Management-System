<?php
include "inc/autoloader.inc.php";

$userControl = new UserControl();
$userControl->isLoggedIn();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#7952b3">

    <title>Management system</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
    </style>
</head>

<body>

    <?php require_once "./app/view/components/navbarTop.php" ?>


    <div class="container-fluid">
        <div class="row">
            <?php require_once "./app/view/components/sidebarMenu.php" ?>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>

                </div>

                <h2>You are now logged in to Management System &#x1F44D;</h2>

            </main>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        let passwordStrength = 0; {
            $(function() {

                $("#createPassword").keyup(function() {
                    $('#password-test-msg').html(checkStrength($('#createPassword').val()))
                });

                function checkStrength(password) {


                    if (password.length <= 7) {
                        $('#password-test-msg').removeClass().addClass('alert').addClass('alert-danger');

                        return 'Password too short';
                    }

                    if (password.length > 7) passwordStrength += 1;

                    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) passwordStrength += 1;

                    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) passwordStrength += 1;

                    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) passwordStrength += 1;

                    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) passwordStrength += 1

                    if (passwordStrength < 2) {
                        $('#password-test-msg').removeClass().addClass('alert').addClass('alert-warning');
                        return 'Password too Weak'

                    } else if (passwordStrength == 2) {
                        $('#password-test-msg').removeClass().addClass('alert').addClass('alert-primary');
                        return 'Good Password'

                    } else {
                        $('#password-test-msg').removeClass().addClass('alert').addClass('alert-success');
                        return 'Strong password'
                    }



                }




                $(".btn-delete").click(function(e) {

                    e.preventDefault();

                    let deleteprompt = confirm("Are you sure you wish to delete this user?");

                });


            });
            $(".create-user").submit(function(e) {
                if (passwordStrength < 2) {
                    e.preventDefault();

                }
            });
        }
    </script>

</body>

</html>