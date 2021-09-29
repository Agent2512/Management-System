<?php
class UserControl extends Users
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * make a new user account and save it to the database 
     * @param  string $username
     * @param  string $password
     * @param  string $email
     * @param  boolean $sendEmail
     */
    public function makeNewUser($username, $password, $email, $sendEmail)
    {
        // validate password
        if ($this->validatePassword($password) == false) {
            return "Password must be at least 8 characters long and contain at least one number and one letter and least one special character";
        }
        // validate email
        if ($this->validateEmail($email) == false) {
            return "Invalid email address";
        }
        // validate username is not empty
        if (str_replace(' ', '', $username) == '') {
            return "Username cannot be empty";
        }
        // check if email already in use by another user 
        if ($this->checkUser($email)) {
            return "Email address already in use";
        }

        // hash password
        $hashedPassword = $this->encryptPass($password);

        // create new user
        if ($this->createUser($username, $hashedPassword, $email)) {
            // send email
            if ($sendEmail) {
                // mail($email, "Welcome to the site", "You have successfully created an account on the site you pasword is: $password");
            }

            header("Location: users.php");
        } else {
            return "Error creating user";
        }
    }


    /**
     *  check if user is logged in 
     *  else sends dem to the login page 
     */
    public function isLoggedIn()
    {
        if (!isset($_SESSION["user"])) {
            // echo "test";
            header("location: ./login.php");
        }
    }

    /**
     * login function
     * makes a userArr in session
     *  sends user to index page 
     * 
     * @param String $email
     * @param String $password
     * @return void
     */
    public function login(String $email, String $password)
    {
        // validates user input
        if ($this->validateEmail($email)) {
            // gets user from the database
            $user = $this->checkUser($email);

            if ($user) {
                // user is deactive, return
                if ($user->login_attempts == 6) {
                    return "user is deactive";
                }

                // if user password is correct send user to index page, return
                if ($this->validatePassword($password) && $this->decryptPass($password, $user->user_pass)) {
                    $user->login_attempts != 0 && $this->setloginAttempts($user->id, 0);

                    $this->makeUserArr($user);

                    header("location: index.php");
                    return;
                }


                // ad one to the login attempt in the database
                $new_login_attempts = $user->login_attempts + 1;
                $this->setloginAttempts($user->id, $new_login_attempts);

                // if login attempts has reached 6 send email to user 
                if ($new_login_attempts == 6) {
                    $token = md5($user->id . date("Y-m-dH:i:s"));
                    $this->addResetToken($user->id, $token);
                    // mail($user->user_email, "Management-System reset password", "http://localhost/code/Management-System/reset.php?token=$token");
                }
            }


            return "worng email or password";
        }
        return "invalid email";
    }


    /**
     * unsets userArr in session
     *
     * @return void
     */
    public function logOut()
    {
        unset($_SESSION["user"]);
        // send user to login page
        header("location: ./login.php");
    }

    /**
     * sets a userArr in session
     *
     * @param Object $user
     * @return void
     */
    private function makeUserArr(Object $user)
    {
        $userArr = array();
        $userArr["id"] = $user->id;
        $userArr["email"] = $user->user_email;
        $userArr["username"] = $user->username;
        $userArr["role"] = $user->user_role;

        $_SESSION["user"] = $userArr;
    }

    /**
     * takes a password and validates it
     *
     * @param String $password the password that the user gives
     * @return Bool
     */
    private function validatePassword(String $password)
    {
        $number = preg_match('@[0-9]@', $password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
            // echo "Password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character.";
            return false;
        } else {
            // echo "Your password is strong.";
            return true;
        }
    }

    /**
     * takes an email address and validates it
     *
     * @param String $email the email that the user gives
     * @return Bool valid or invalid
     */
    private function validateEmail(String $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * makes a hashed password for the database
     *
     * @param String $normalValue the password that the user gives
     * @return String hashed password
     */
    private function encryptPass(String $normalValue)
    {
        return password_hash($normalValue, PASSWORD_DEFAULT);
    }

    /**
     * @param String $normalValue the password that the user gives
     * @param String $hashed_password the hash from the database
     * @return Bool
     */
    private function decryptPass(String $normalValue, String $hashed_password)
    {
        return password_verify($normalValue, $hashed_password);
    }


    /**
     * validate token 
     * if token is not valid return error
     * @param String $token
     * @return string
     */
    public function validateToken(String $token)
    {

        $dataToken = $this->getResetToken($token);

        if ($dataToken) {
            // is the token still active?
            if ($dataToken->active == 0) {
                // token is not active
                return "token is not active";
            }

            // is the token to old
            $requested_time = new DateTime($dataToken->requested_time);
            $time = new DateTime();

            if (date_diff($requested_time, $time)->d >= 1) {
                // token is to old 
                // disable old token 
                $this->setResetToken_active($dataToken->id, 0);
                // send new mail
                $token = md5($dataToken->user_id . date("Y-m-dH:i:s"));
                // mail($user->user_email, "Management-System reset password", "http://localhost/code/Management-System/reset.php?token=$token");
                // make new token
                $this->addResetToken($dataToken->user_id, $token);

                return "token is to old";
            }
        } else {
            die("error invalid token");
        }
    }

    /**
     * delete a user from the database
     * but not superAdmin
     * @param String $user_id
     */
    public function removeUser($user_id)
    {
        $user = $this->getUser($user_id);

        if ($user && $user->user_role != "SuperAdmin") {
            $this->deleteUser($user_id);
        }
    }

    /**
     * edit a user on the database
     * 
     * @param String $user_id
     * @param String $username
     * @param String $password
     * @param bool $send_email
     * 
     */
    public function editUser($user_id, $username, $password, $send_email)
    {
        $user = $this->getUser($user_id);

        if ($user) {
            // check if the username is the same
            if ($user->username != $username) {
                $this->setUsername($user_id, $username);
            }

            // check if the password is valid and if the password is the same
            // if not change the password
            if ($password && $this->validatePassword($password) && $this->decryptPass($password, $user->user_pass) == false) {
                $this->setPassword($user_id, $this->encryptPass($password));
            }

            // send email to user
            if ($send_email) {
                // mail($user->user_email, "Management-System profile changes", "username=$username  password=$password email=$user->user_email");
            }
        } else {
            return "user not found";
        }
    }

    /**
     * edit profile of a user from the database 
     * @param String $user_id
     * @param String $username
     * @param String $password
     * @param String $email
     * 
     */
    public function editProfile($user_id, $username, $password, $email)
    {
        $user = $this->getUser($user_id);

        if ($user) {
            // validate email 
            if (
                $email &&
                $this->validateEmail($email) &&
                $this->checkUser($email) == false
            ) {

                $this->setEmail($user_id, $email);
            }

            $this->editUser($user_id, $username, $password, true);

            // if password is changed logout user
            if ($password) {
                header("Location: logout.php");
            }
        } else {
            return "user not found";
        }
    }

    /**
     * handle the reset password 
     * with a token 
     * @param String $token
     * @param String $password
     */
    public function resetPassword($token, $password)
    {
        // get tokenData from the database
        $dataToken = $this->getResetToken($token);

        if ($dataToken) {
            // validate password
            if ($this->validatePassword($password) == false) {
                return "password is not strong";
            }

            // set new password
            $this->setPassword($dataToken->user_id, $this->encryptPass($password));

            // reset login_attempts
            $this->setloginAttempts($dataToken->user_id, 0);

            // delete token
            $this->setResetToken_active($dataToken->id, 0);

            // sends user to login page
            header("Location: login.php");
        }
    }

    public function test($var)
    {
        return empty($var);
    }
}
