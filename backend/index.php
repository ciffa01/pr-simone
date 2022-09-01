<?php

require_once __DIR__.'/config.php';

class API {
    private $db_table = "api";
    private $conn;

    public $id;
    public $name;
    public $age;
    function Select() {
        $db = new Connect;
        $users = array();
        $data = $db->prepare('SELECT * FROM users ORDER BY id');
        $data->execute();

        while($OutputData = $data->fetch(PDO::FETCH_ASSOC)) {
            $users[$OutputData['id']] = array(
                'id' => $OutputData['id'],
                'name' => $OutputData['name'],
                'age' => $OutputData['age']
            );
        }

        return json_encode($users);
    }

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
        $data = $db->prepare($query);

        $output = array(
            'message' => 'Data Inserted'
        );

        echo json_encode($data);
    }

}

$API = new API;
header('Content-Type: apllication/json');
//header('Access-Control-Allow-Origin: *');
echo($API->insert());
?>