<?php

require_once 'database.php';

class Account{

    public $customerID;
    public $customerEmail;
    public $customerPassword;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function sign_in_customer(){
        $sql = "SELECT * FROM customer WHERE customerEmail = :customerEmail LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':customerEmail', $this->customerEmail);
    
        if ($query->execute()) {
            $accountData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($accountData && password_verify($this->customerPassword, $accountData['customerPassword'])) {
                $this->customerID = $accountData['customerID'];
                return true;
            }
        }
    
        return false;
    } 

}

?>