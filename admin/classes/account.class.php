<?php

require_once ('../classes/database.php');

class Account{

    public $id;
    public $email;
    public $password;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function sign_in_admin(){
        $sql = "SELECT * FROM admin WHERE adminEmail = :adminEmail LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':adminEmail', $this->email);
    
        if ($query->execute()) {
            $accountData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($accountData && password_verify($this->password, $accountData['adminPassword'])) {
                $this->id = $accountData['adminID'];
                return true;
            }
        }
    
        return false;
    } 

}

?>