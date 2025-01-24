<?php

require_once('database.php');

Class Admin{
    //attributes

    public $adminID;
    public $adminEmail;
    public $adminPassword;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add(){
        $sql = "INSERT INTO admin (adminEmail, adminPassword) VALUES 
        (:adminEmail, :adminPassword);";

        $query=$this->db->connect()->prepare($sql);
        // $query->bindParam(':adminFirstName', $this->adminFirstName);
        // $query->bindParam(':adminLastName', $this->adminLastName);
        $query->bindParam(':adminEmail', $this->adminEmail);
        // Hash the password securely using password_hash
        $hashedPassword = password_hash($this->adminPassword, PASSWORD_DEFAULT);
        $query->bindParam(':adminPassword', $hashedPassword);
        
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }	
    }

    function is_email_exist(){
        $sql = "SELECT * FROM admin WHERE adminEmail = :adminEmail;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':adminEmail', $this->adminEmail);
        if($query->execute()){
            if($query->rowCount()>0){
                return true;
            }
        }
        return false;
    }
}

?>