<?php

require_once __DIR__.'/config.php';

class Insert {
    private $db_table = "api";
    private $conn;

    public $id;
    public $name;
    public $age;

    function insert(){
        // sanitize
            $data = array(
            ':name' => $this->name,
            ':age' => $this->age
        );

        $query = "
            INSERT INTO api 
            (name, age) 
            VALUES (:name, :age)
        ";
        $db = new Connect();
        $output = $db->prepare($query);

        $output = array(
            'message' => 'Data Inserted'
        );

        echo json_encode($output);
    }

}

$Insert = new Insert;
header('Content-Type: apllication/json');
//header('Access-Control-Allow-Origin: *');
echo($Insert->insert());
?>