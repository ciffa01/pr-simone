<?php

class Connect extends PDO {
    public function __construct() {
        parent::__construct("mysql:host=localhost;dbname=api", 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }
}


/*<?php

class Connect {
    private $host="127.0.0.1";
    private $db_name="api";
    private $username="root";
    private $password="";
    public $conn;
 

    public function getConnection() {
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host.";dbname=".$this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Database could not be connected: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>*/