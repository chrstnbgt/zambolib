<?php

require_once 'database.php';

class User {
    public $userID;
    public $userFirstName;
    public $userMiddleName;
    public $userLastName;
    public $userUserName;
    public $userBirthdate;
    public $userAge;
    public $userEmail;
    public $userGender;
    public $userCivilStatus;
    public $userContactNo;
    public $userPassword;
    public $userSchoolOffice;
    public $userIDCard;
    public $userRegion;
    public $userProvince;
    public $userCity;
    public $userBarangay;
    public $userStreetName;
    public $userZipCode;
    public $guardianFirstName;
    public $guardianMiddleName;
    public $guardianLastName;
    public $guardianRole;
    public $guardianContactNo;
    public $guardianEmail;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function signup()
    {
        $sql = "INSERT INTO user (userFirstName, userMiddleName, userLastName, userBirthdate, userAge, userGender, userEmail, userPassword, userContactNo, userOccupation, userSector, userAccountType, userSchoolOffice, userIDCard, userRegion, userProvince, userCity, userBarangay, userStreetName, userZipCode, guardianFirstName, guardianMiddleName, guardianLastName, guardianRole, guardianContactNo, guardianEmail) VALUES 
        (:userFirstName, :userMiddleName, :userLastName, :userBirthdate, :userAge, :userGender, :userEmail, :userPassword, :userContactNo, :userOccupation, :userSector, :userAccountType, :userSchoolOffice, :userIDCard, :userRegion, :userProvince, :userCity, :userBarangay, :userStreetName, :userZipCode, :guardianFirstName, :guardianMiddleName, :guardianLastName, :guardianRole, :guardianContactNo, :guardianEmail);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userFirstName', $this->userFirstName);
        $query->bindParam(':userMiddleName', $this->userMiddleName);
        $query->bindParam(':userLastName', $this->userLastName);
        $query->bindParam(':userBirthdate', $this->userBirthdate);
        $query->bindParam(':userAge', $this->userAge);
        $query->bindParam(':userGender', $this->userGender);
        $query->bindParam(':userEmail', $this->userEmail);
        // Hash the password securely using password_hash
        $hashedPassword = password_hash($this->userPassword, PASSWORD_DEFAULT);
        $query->bindParam(':userPassword', $hashedPassword);
        $query->bindParam(':userContactNo', $this->userContactNo);
        $query->bindParam(':userOccupation', $this->userOccupation);
        $query->bindParam(':userSector', $this->userSector);
        $query->bindParam(':userAccountType', $this->userAccountType);
        $query->bindParam(':userSchoolOffice', $this->userSchoolOffice);
        $query->bindParam(':userIDCard', $this->userIDCard);
        $query->bindParam(':userRegion', $this->userRegion);
        $query->bindParam(':userProvince', $this->userProvince);
        $query->bindParam(':userCity', $this->userCity);
        $query->bindParam(':userBarangay', $this->userBarangay);
        $query->bindParam(':userStreetName', $this->userStreetName);
        $query->bindParam(':userZipCode', $this->userZipCode);
        $query->bindParam(':guardianFirstName', $this->guardianFirstName);
        $query->bindParam(':guardianMiddleName', $this->guardianMiddleName);
        $query->bindParam(':guardianLastName', $this->guardianLastName);
        $query->bindParam(':guardianRole', $this->guardianRole);
        $query->bindParam(':guardianContactNo', $this->guardianContactNo);
        $query->bindParam(':guardianEmail', $this->guardianEmail);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function signIn()
    {
        $sql = "SELECT * FROM user WHERE userEmail = :userEmail LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userEmail', $this->userEmail);
    
        if ($query->execute()) {
            $accountData = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($accountData && password_verify($this->userPassword, $accountData['userPassword'])) {
                $this->userID = $accountData['userID'];
                return true;
            }
        }
    
        return false;
    }

    
    function edit()
    {
        $sql = "UPDATE user SET userFirstName=:userFirstName, userMiddleName=:userMiddleName, userLastName=:userLastName, userBirthdate=:userBirthdate, userAge=:userAge, userGender=:userGender, userEmail=:userEmail, userContactNo=:userContactNo, userOccupation=:userOccupation, userSector=:userSector, userAccountType=:userAccountType, userSchoolOffice=:userSchoolOffice, userIDCard=:userIDCard, userRegion=:userRegion, userProvince=:userProvince, userCity=:userCity, userBarangay=:userBarangay, userStreetName=:userStreetName, userZipCode=:userZipCode, guardianFirstName=:guardianFirstName, guardianMiddleName=:guardianMiddleName, guardianLastName=:guardianLastName, guardianRole=:guardianRole, guardianContactNo=:guardianContactNo, guardianEmail=:guardianEmail WHERE userID=:userID;";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userFirstName', $this->userFirstName);
        $query->bindParam(':userMiddleName', $this->userMiddleName);
        $query->bindParam(':userLastName', $this->userLastName);
        $query->bindParam(':userBirthdate', $this->userBirthdate);
        $query->bindParam(':userAge', $this->userAge);
        $query->bindParam(':userGender', $this->userGender);
        $query->bindParam(':userEmail', $this->userEmail);
        $query->bindParam(':userContactNo', $this->userContactNo);
        $query->bindParam(':userOccupation', $this->userOccupation);
        $query->bindParam(':userSector', $this->userSector);
        $query->bindParam(':userAccountType', $this->userAccountType);
        $query->bindParam(':userSchoolOffice', $this->userSchoolOffice);
        $query->bindParam(':userIDCard', $this->userIDCard);
        $query->bindParam(':userRegion', $this->userRegion);
        $query->bindParam(':userProvince', $this->userProvince);
        $query->bindParam(':userCity', $this->userCity);
        $query->bindParam(':userBarangay', $this->userBarangay);
        $query->bindParam(':userStreetName', $this->userStreetName);
        $query->bindParam(':userZipCode', $this->userZipCode);
        $query->bindParam(':guardianFirstName', $this->guardianFirstName);
        $query->bindParam(':guardianMiddleName', $this->guardianMiddleName);
        $query->bindParam(':guardianLastName', $this->guardianLastName);
        $query->bindParam(':guardianRole', $this->guardianRole);
        $query->bindParam(':guardianContactNo', $this->guardianContactNo);
        $query->bindParam(':guardianEmail', $this->guardianEmail);
        $query->bindParam(':userID', $this->userID);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete($userID)
    {
        $sql = "DELETE FROM user WHERE userID = :userID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userID', $userID);

        return $query->execute();
    }

    function fetch($userID)
    {
        $sql = "SELECT * FROM user WHERE userID = :userID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userID', $userID);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function show()
    {
        $sql = "SELECT * FROM user ORDER BY userLastName ASC, userFirstName ASC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function isEmailExist()
    {
        $sql = "SELECT * FROM user WHERE userEmail = :userEmail;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userEmail', $this->userEmail);
        if ($query->execute()) {
            if ($query->rowCount() > 0) {
                return true;
            }
        }
        return false;
    }

    function checkPassword() {
        $sql = "SELECT userPassword FROM user WHERE userID = :userID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userID', $this->userID);
        $query->execute();

        // Check if the user exists
        if ($query->rowCount() > 0) {
            $hashedPassword = $query->fetchColumn();
            // Use password_verify to check if the entered password matches the hashed password
            return password_verify($this->userPassword, $hashedPassword);
        } else {
            return false; // user not found
        }
    }

}

?>
