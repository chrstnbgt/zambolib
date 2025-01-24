<?php

require_once 'database.php';

class AdminAccount{

    public $adminID;
    public $adminEmail;
    public $adminPassword;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function sign_in_admin(){
        $sql = "SELECT * FROM admin WHERE adminEmail = :adminEmail LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':adminEmail', $this->adminEmail);
    
        if ($query->execute()) {
            $accountData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($accountData && password_verify($this->adminPassword, $accountData['adminPassword'])) {
                $this->adminID = $accountData['adminID'];
                return true;
            }
        }
    
        return false;
    }

}

?>