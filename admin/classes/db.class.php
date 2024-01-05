<?php
class Db
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "sepetim";

    protected function connect()
    {
        try
        {
            $dsn = "mysql:host=".$this->host.";dbname=".$this->dbname;
            $pdo = new PDO($dsn,$this->username,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $pdo;
        }
        catch(PDOException $e)
        {
            echo "Bağlantı Hatası: ".$e->getMessage();
        }
    }
}
?>