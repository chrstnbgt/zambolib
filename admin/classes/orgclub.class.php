<?php

require_once 'database.php';

class OrgClub {
    protected $db;

    public $organizationClubID;
    public $ocName;
    public $userID;
    public $organizationClubType;
    public $ocEmail;
    public $ocContactNumber;
    public $ocCreatedAt;

    function __construct()
    {
        $this->db = new Database();
    }

    // Method to delete organization club
    function delete($organizationClubID)
    {
        $sql = "DELETE FROM organization_club WHERE organizationClubID = :organizationClubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':organizationClubID', $organizationClubID);

        return $query->execute();
    }

    // Method to fetch organization club
    function fetch($organizationClubID)
    {
        $sql = "SELECT * FROM organization_club WHERE organizationClubID = :organizationClubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':organizationClubID', $organizationClubID);
        if ($query->execute()) {
            $data = $query->fetch();
            return $data;
        }
        return null;
    }

    // Method to show all organization clubs
    function show()
    {
        $sql = "SELECT o.*, u.userFirstName, u.userMiddleName, u.userLastName
                FROM organization_club o
                JOIN user u ON o.userID = u.userID
                ORDER BY o.ocName";
        $query = $this->db->connect()->prepare($sql);
        if ($query->execute()) {
            $data = $query->fetchAll();
            return $data;
        }
        return null;
    }

    public function fetchAll() {
        $sql = "SELECT organizationClubID, ocName FROM organization_club";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }
    
    public function getOrganizationClubs() {
        $sql = "SELECT organizationClubID, ocName, ocCreatedAt FROM organization_club";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getOrganizationClubDetails() {
        $sql = "SELECT organization_club.organizationClubID, organization_club.ocName, user.userFirstName, user.userLastName, organization_club.ocEmail, organization_club.ocContactNumber, organization_club.ocStatus, organization_club.ocCreatedAt FROM organization_club JOIN user ON organization_club.userID = user.userID WHERE organizationClubType='Club'";
        $query = $this->db->connect()->prepare($sql);
        
        $organizationClubs = null;
        
        if ($query->execute()) {
            $organizationClubs = $query->fetchAll();
        }
        
        return $organizationClubs;
    }
    
    public function updateStatus($organizationClubID, $status) {
        $sql = "UPDATE organization_club SET ocStatus = :status WHERE organizationClubID = :organizationClubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':organizationClubID', $organizationClubID);
        $query->bindParam(':status', $status);
        return $query->execute();
    }


}

?>
