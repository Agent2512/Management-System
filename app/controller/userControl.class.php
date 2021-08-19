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
     * makes a user Object in session
     *
     * @param String $email
     * @param String $password
     * @return void
     */
    public function login(String $email, String $password)
    {
        if ($this->validateEmail($email) && $this->validatePassword($password)) {
            # code...
        }
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
}
