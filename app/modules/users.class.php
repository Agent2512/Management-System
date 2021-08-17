<?php
class Users extends Dbh
{
    /**
     * create a new user on the database
     * @param String $username   
     * @param String $password
     * @param String $email
     */
    public function createUser(String $username, String  $password, String  $email)
    {
        # code...
    }

    /**
     * delete a user from the database
     * @param String $user_id
     */
    public function deleteUser($user_id)
    {
        
    }

    /**
     * update user data on the database
     * @param String $user_id
     * @param Object $userObj
     */
    public function updataUser(string $user_id, Object $userObj)
    {
        # code...
    }

    /**
     * get all users from the database
     * @return Object[] of all users on the database
     */
    public function getAllUsers()
    {
        # code...
    }

    /**
     * gets a user from the database
     * @param String $user_id
     * @return Object of one user
     */
    public function getUser(String $user_id)
    {
        # code...
    }

    /**
     * checks for a user in the database
     * @param String $username   
     * @param String $password
     * @return Object of one user
     */
    public function checkUser(String $username, String $password)
    {
        # code...
    }
}
