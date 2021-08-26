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
        $sql = "INSERT INTO `sys_user` (`username`, `user_pass`, `user_email`, `user_registered`, `password_set`, `user_role`)
                                VALUES (?, ?, ?, current_timestamp(), current_timestamp(), 'general_user')";
        $stmt = $this->dbConnect()->prepare($sql);;

        try {
            return $stmt->execute([$username, $password, $email]);
        } catch (Throwable $th) {
            // throw $th;
            return false;
        }
    }

    /**
     * delete a user from the database
     * @param String $user_id
     */
    public function deleteUser($user_id)
    {
        $sql = "DELETE FROM `sys_user` WHERE `sys_user`.`id` = ?";
        $stmt = $this->dbConnect()->prepare($sql);

        return $stmt->execute([$user_id]);
    }

    /**
     * update user data on the database
     * @param String $user_id
     * @param Object $userArr
     * @return Bool
     */
    public function updataUser(string $user_id, Object $userArr)
    {
        $sql = "
        UPDATE `sys_user` SET 
            username = '$userArr[´username´]',
            user_pass = '$userArr[´pass´]',
            user_email = '$userArr[´email´]',
            password_set = '$userArr[´password_set´]',
            user_role = '$userArr[´user_role´]' 
            WHERE id = $user_id
        ";

        return $this->dbConnect()->query($sql) ? true : false;
    }

    /**
     * get all users from the database
     * @return Object[]|false of all users on the database
     */
    public function getAllUsers(int $limit = 0, int $offset = 0)
    {
        $sql = "SELECT * FROM `sys_user`";

        if ($limit != 0) {
            $sql .= "LIMIT $limit";
        }
        if ($offset != 0) {
            $sql .= "OFFSET $offset";
        }

        return $this->dbConnect()->query($sql)->fetchAll();
    }

    /**
     * gets a user from the database
     * @param String $user_id
     * @return Object|false of one user
     */
    public function getUser(String $user_id)
    {
        $sql = "SELECT * FROM `sys_user` WHERE id = $user_id";
        return $this->dbConnect()->query($sql)->fetch();
    }

    /**
     * checks for a user in the database by email
     * @param String $email   
     * @return Object|false of one user
     */
    public function checkUser(String $email)
    {
        $sql = "SELECT * FROM `sys_user` WHERE user_email = '$email'";
        return $this->dbConnect()->query($sql)->fetch();
    }

    /**
     * sets the users login attempts to $num value
     *
     * @param Int $user_id what user to change 
     * @param Int $num number to set
     * @return void
     */
    public function setloginAttempts(Int $user_id, Int $num)
    {

        $sql = "UPDATE `sys_user` SET `login_attempts` = '$num' WHERE `sys_user`.`id` = $user_id";
    
        $this->dbConnect()->query($sql);
    }


    // reset token stuff


    /**
     * adds a reset_password_token to the database  
     *
     * @param Int $user_id the id of the user to reset
     * @param String $token 
     * @return void
     */
    public function addPasswordResetToken(Int $user_id, String $token)
    {
        $sql = "INSERT INTO `reset_password_token` (`user_id`, `requested_time`, `token`) VALUES ('$user_id', current_timestamp(), '$token');";
        return $this->dbConnect()->query($sql);
    }
    
    /**
     * gets a token from the database
     *
     * @param String $token
     * @return Object|false
     */
    public function getPasswordResetToken(String $token)
    {
        $sql = "SELECT * FROM `reset_password_token` WHERE token = '$token'";
        return $this->dbConnect()->query($sql)->fetch();
    }
}
