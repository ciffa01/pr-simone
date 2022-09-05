<?php
class Items {   
    
    private $usersTable = "users";      
    public $id;
    public $name;
    public $age;
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function read(){	
		if($this->id) {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->usersTable." WHERE id = ?");
			$stmt->bind_param("i", $this->id);					
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->usersTable);		
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function create(){
		
		$stmt = $this->conn->prepare("
			INSERT INTO ".$this->usersTable."(`name`, `age`)
			VALUES(?,?)");
		
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->age = htmlspecialchars(strip_tags($this->age));
		
		$stmt->bind_param("si", $this->name, $this->age);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}
		
	function update(){
		if($this->id) { 
			$stmt = $this->conn->prepare("
				UPDATE ".$this->usersTable." 
				SET name= ?, age = ?
				WHERE id = ?");
				//$this->id = htmlspecialchars(strip_tags($this->id));
				$this->name = htmlspecialchars(strip_tags($this->name));
				$this->age = htmlspecialchars(strip_tags($this->age));
		
				$stmt->bind_param("sii", $this->name, $this->age, $this->id);
		}
		
		/* if($stmt->execute()){
			return true;
		}
		return false; */
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function delete(){
		
		$stmt = $this->conn->prepare("
			DELETE FROM ".$this->usersTable." 
			WHERE id = ?");
			
		$this->id = htmlspecialchars(strip_tags($this->id));
	 
		$stmt->bind_param("i", $this->id);
	 
		if($stmt->execute()){
			$result = $stmt->get_result();	
		}
	 
		return $result;	 
	}
}
?>