<?php

require_once 'database.php';

class OrgClub {
    protected $db;

    public $organizationClubID;
    public $ocName;
    public $userID;
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

    public function getOrganizationClubDetails($status) {
        $sql = "SELECT organization_club.organizationClubID, organization_club.ocName, user.userFirstName, user.userLastName, organization_club.ocEmail, organization_club.ocContactNumber, organization_club.ocStatus, organization_club.ocCreatedAt FROM organization_club JOIN user ON organization_club.userID = user.userID WHERE ocStatus = :status";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        
        $organizationClubs = null;
        
        if ($query->execute()) {
            $organizationClubs = $query->fetchAll();
        }
        
        return $organizationClubs;
    }

    public function getOrganizationDetails($status) {
        $sql = "SELECT organization_club.organizationClubID, organization_club.ocName, user.userFirstName, user.userLastName, organization_club.ocEmail, organization_club.ocContactNumber, organization_club.ocStatus, organization_club.ocCreatedAt FROM organization_club JOIN user ON organization_club.userID = user.userID WHERE ocStatus = :status";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        
        $organizationClubs = null;
        
        if ($query->execute()) {
            $organizationClubs = $query->fetchAll();
        }
        
        return $organizationClubs;
    }
    
    
    public function updateStatus($organizationClubID, $status) {
        $sql = "UPDATE organization_club SET ocStatus = :status WHERE organizationClubID = :organizationClubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        $query->bindParam(':organizationClubID', $organizationClubID);
        return $query->execute();
    }

    public function getOrganizationProposals() {
        $sql = "SELECT org_proposal.organizationClubID, proposal.proposalSubject, proposal.proposalDescription, proposal.proposalCreatedAt, organization_club.orgClubImage, organization_club.ocName, organization_club.userID
                FROM org_proposal
                JOIN proposal ON org_proposal.proposalID = proposal.proposalID
                JOIN organization_club ON org_proposal.organizationClubID = organization_club.organizationClubID";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getUserFullName($userID) {
        $sql = "SELECT CONCAT(userFirstName, ' ', userLastName) AS fullName FROM user WHERE userID = :userID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userID', $userID);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['fullName'] ?? null;
    }    

    public function updateProposalStatus($orgProposalID, $status) {
        $sql = "UPDATE org_proposal SET status = :status WHERE org_proposalID = :orgProposalID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        $query->bindParam(':orgProposalID', $orgProposalID);
        return $query->execute();
    }
    
    public function getProposalStatus()
    {
        $sql = "SELECT oc.organizationClubID, oc.ocName, op.status
                FROM organization_club oc
                JOIN org_proposal op ON oc.organizationClubID = op.organizationClubID";
        
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
    
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    
}

?>
