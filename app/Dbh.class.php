<?php 
/**
 * Database connection class
 */
class Dbh {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "m_sys";

    protected function dbConnect()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->database;charset=utf8mb4";
        $conn = new PDO($dsn, $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

        return $conn;
    }
}