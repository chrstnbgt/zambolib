<?php

require_once 'database.php';

class AttendanceChecker {
    //attributes
    public $attendanceCheckerID ;
    public $acFirstName;
    public $acMiddleName;
    public $acLastName;
    public $acContactNo;
    public $acEmail;
    public $acPassword;
    public $acImage;
    public $acEmployment;
    

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add()
    {
        $sql = "INSERT INTO attendance_checker (acFirstName,  acMiddleName,  acLastName, acContactNo,  acEmail,  acPassword,  acEmployment) VALUES 
        (:acFirstName, :acMiddleName, :acLastName, :acContactNo, :acEmail, :acPassword, :acEmployment);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':acFirstName', $this->acFirstName);
        $query->bindParam(':acMiddleName', $this->acMiddleName);
        $query->bindParam(':acLastName', $this->acLastName);
        $query->bindParam(':acContactNo', $this->acContactNo);
        $query->bindParam(':acEmail', $this->acEmail);
        // Hash the password securely using password_hash
        $hashedPassword = password_hash($this->acPassword, PASSWORD_DEFAULT);
        $query->bindParam(':acPassword', $hashedPassword);
        $query->bindParam(':acEmployment', $this->acEmployment);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function edit()
    {
        $sql = "UPDATE attendance_checker SET acFirstName = :acFirstName, acMiddleName = :acMiddleName, acLastName = :acLastName, acContactNo = :acContactNo, acEmail = :acEmail, acEmployment = :acEmployment WHERE attendanceCheckerID = :attendanceCheckerID";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':acFirstName', $this->acFirstName);
        $query->bindParam(':acMiddleName', $this->acMiddleName);
        $query->bindParam(':acLastName', $this->acLastName);
        $query->bindParam(':acContactNo', $this->acContactNo);
        $query->bindParam(':acEmail', $this->acEmail);
        $query->bindParam(':acEmployment', $this->acEmployment);
        $query->bindParam(':attendanceCheckerID', $this->attendanceCheckerID);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete($attendanceCheckerID)
    {
        $sql = "DELETE FROM attendance_checker WHERE attendanceCheckerID = :attendanceCheckerID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':attendanceCheckerID', $attendanceCheckerID);

        return $query->execute();
    }

    function fetch($attendanceCheckerID)
    {
        $sql = "SELECT * FROM attendance_checker WHERE attendanceCheckerID = :attendanceCheckerID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':attendanceCheckerID', $attendanceCheckerID);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function show()
    {
        $sql = "SELECT * FROM attendance_checker ORDER BY acLastName ASC, acFirstName ASC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function is_email_exist(){
        $sql = "SELECT * FROM attendance_checker WHERE acEmail = :acEmail;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':acEmail', $this->acEmail);
        if($query->execute()){
            if($query->rowCount()>0){
                return true;
            }
        }
        return false;
    }

    // Additional method to get available attendance checkers (similar to getAvailableBarbers in the previous class)
    function getAvailableAttendanceCheckers() {
        // You need to implement logic to get available attendance checkers based on date and time
        // Example: SELECT * FROM attendance_checker WHERE availability = 'Available'
        $sql = "SELECT * FROM attendance_checker WHERE acEmployment = 'Active'";
        $query = $this->db->connect()->prepare($sql);

        $attendanceCheckers = null;

        if ($query->execute()) {
            $attendanceCheckers = $query->fetchAll();
        }

        return $attendanceCheckers;
    }
}

?>
