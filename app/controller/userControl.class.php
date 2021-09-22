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
        if ($this->validateEmail($email) && $this->validatePassword($password)) {
            // gets user from the database
            $user = $this->checkUser($email);

            if ($user) {
                // user is deactive, return
                if ($user->login_attempts == 6) {
                    return "user is deactive";
                }

                // if user password is correct send user to index page, return
                if ($this->decryptPass($password, $user->user_pass)) {
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
        return "invalid email or password";
    }


    /**
     * unsets userArr in session
     *
     * @return void
     */
    public function logOut()
    {
        unset($_SESSION["user"]);
        return header("location: index.php");
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
     * @return void
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
     * Undocumented function
     *
     * @param String $token
     * @return void
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

        }
        else {
            die("error invalid token");
        }
    }

    /**
     * delete a user from the database
     * but not superAdmin
     * @param String $user_id
     */
    public function removeUser($user_id) {
        
    }


    public function test($var)
    {
        return $this->encryptPass($var);
    }
}
