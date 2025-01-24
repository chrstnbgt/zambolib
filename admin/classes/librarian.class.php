<?php

require_once 'database.php';

class Librarian {
    //attributes

    public $librarianID ;
    public $librarianFirstName;
    public $librarianMiddleName;
    public $librarianLastName;
    public $librarianDesignation;
    public $librarianContactNo;
    public $librarianEmail;
    public $librarianPassword;
    public $librarianImage;
    public $librarianEmployment;
    

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add()
    {
        $sql = "INSERT INTO librarian (librarianFirstName,  librarianMiddleName,  librarianLastName, librarianDesignation, librarianContactNo,  librarianEmail,  librarianPassword,  librarianEmployment) VALUES 
        (:librarianFirstName, :librarianMiddleName, :librarianLastName, :librarianDesignation, :librarianContactNo, :librarianEmail, :librarianPassword, :librarianEmployment);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':librarianFirstName', $this->librarianFirstName);
        $query->bindParam(':librarianMiddleName', $this->librarianMiddleName);
        $query->bindParam(':librarianLastName', $this->librarianLastName);
        $query->bindParam(':librarianDesignation', $this->librarianDesignation);
        $query->bindParam(':librarianContactNo', $this->librarianContactNo);
        $query->bindParam(':librarianEmail', $this->librarianEmail);
        // Hash the password securely using password_hash
        $hashedPassword = password_hash($this->librarianPassword, PASSWORD_DEFAULT);
        $query->bindParam(':librarianPassword', $hashedPassword);
        $query->bindParam(':librarianEmployment', $this->librarianEmployment);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function edit()
    {
        $sql = "UPDATE librarian SET librarianFirstName = :librarianFirstName, librarianMiddleName = :librarianMiddleName, librarianLastName = :librarianLastName, librarianDesignation = :librarianDesignation, librarianContactNo = :librarianContactNo, librarianEmail = :librarianEmail, librarianEmployment = :librarianEmployment WHERE librarianID = :librarianID";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':librarianFirstName', $this->librarianFirstName);
        $query->bindParam(':librarianMiddleName', $this->librarianMiddleName);
        $query->bindParam(':librarianLastName', $this->librarianLastName);
        $query->bindParam(':librarianDesignation', $this->librarianDesignation);
        $query->bindParam(':librarianContactNo', $this->librarianContactNo);
        $query->bindParam(':librarianEmail', $this->librarianEmail);
        $query->bindParam(':librarianEmployment', $this->librarianEmployment);
        $query->bindParam(':librarianID', $this->librarianID);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete($librarianID)
    {
        $sql = "DELETE FROM librarian WHERE librarianID = :librarianID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':librarianID', $librarianID);

        return $query->execute();
    }

    function fetch($librarianID)
    {
        $sql = "SELECT * FROM librarian WHERE librarianID = :librarianID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':librarianID', $librarianID);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function show()
    {
        $sql = "SELECT * FROM librarian ORDER BY librarianLastName ASC, librarianFirstName ASC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function is_email_exist(){
        $sql = "SELECT * FROM librarian WHERE librarianEmail = :librarianEmail;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':librarianEmail', $this->librarianEmail);
        if($query->execute()){
            if($query->rowCount()>0){
                return true;
            }
        }
        return false;
    }

    // Additional method to get available librarian (similar to getAvailableBarbers in the previous class)
    function getAvailablelibrarian() {
        // You need to implement logic to get available librarian based on date and time
        // Example: SELECT * FROM librarian WHERE availability = 'Available'
        $sql = "SELECT * FROM librarian WHERE librarianEmployment = 'Active'";
        $query = $this->db->connect()->prepare($sql);

        $librarians = null;

        if ($query->execute()) {
            $librarians = $query->fetchAll();
        }

        return $librarians;
    }
}

?>
