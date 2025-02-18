<?php

require_once 'database.php';

Class ClubOverview {
    private $db;

    public $clubID;
    public $clubName;
    public $clubDescription;
    public $clubMinAge;
    public $clubMaxAge;
    public $librarianIDs;

    public function __construct() {
        $this->db = new Database();
        $this->librarianIDs = [];
    }

    function fetch($record_id) {
        $sql = "SELECT * FROM user WHERE userID = :userID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userID', $record_id);
        if($query->execute()) {
            $data = $query->fetch();
            return $data;
        } else {
            return false;
        }
    }

    function getMemberCount($clubID){
        $sql = "SELECT COUNT(*) AS member_count FROM club_membership WHERE clubID = :clubID AND cmstatus = 'approved'";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubID', $clubID);
        $memberCount = 0;
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $memberCount = $result['member_count'];
        }
        return $memberCount;
    }   

    function getClubMembers($clubID){
        $sql = "SELECT CONCAT(u.userFirstName, ' ', u.userMiddleName, ' ', u.userLastName) AS fullName,
                    u.userEmail,
                    u.userContactNo,
                    u.userGender,
                    CONCAT(u.userStreetName, ', ', u.userBarangay, ', ', u.userCity, ', ', u.userProvince, ', ', u.userZipCode) AS address,
                    cm.cmCreatedAt AS dateJoined
                FROM club_membership cm
                JOIN user u ON cm.userID = u.userID
                WHERE cm.clubID = :clubID AND cm.cmstatus = 'approved'"; // Corrected cm.cmstatus
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubID', $clubID);
        $data = null;
        
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getClubManagers($clubID)
    {
        $sql = "SELECT librarian.* FROM club_management 
                JOIN librarian ON club_management.librarianID = librarian.librarianID 
                WHERE club_management.clubID = :clubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubID', $clubID);
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }

    function getUserInfo($clubMembershipID) {
        $sql = "SELECT u.*, cm.clubID FROM user u JOIN club_membership cm ON u.userID = cm.userID WHERE cm.clubMembershipID = :clubMembershipID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubMembershipID', $clubMembershipID);
        if ($query->execute()) {
            $userInfo = $query->fetch(PDO::FETCH_ASSOC);
            return $userInfo;
        } else {
            return false;
        }
    }

    function getClubInfo($clubID) {
        $sql = "SELECT clubName FROM club WHERE clubID = :clubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubID', $clubID);
        if ($query->execute()) {
            $clubInfo = $query->fetch(PDO::FETCH_ASSOC);
            return $clubInfo;
        } else {
            return false;
        }
    }

    function getFormQuestions($clubID) {
        $sql = "SELECT cfQuestion FROM club_formquestion WHERE clubID = :clubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubID', $clubID);
        if ($query->execute()) {
            $formQuestions = $query->fetchAll(PDO::FETCH_COLUMN);
            return $formQuestions;
        } else {
            return false;
        }
    }

    function getFormAnswers($clubMembershipID) {
        $sql = "SELECT cfAnswer FROM club_formanswer WHERE clubMembershipID = :clubMembershipID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':clubMembershipID', $clubMembershipID);
        if ($query->execute()) {
            $formAnswers = $query->fetchAll(PDO::FETCH_COLUMN);
            return $formAnswers;
        } else {
            return false;
        }
    }
}
?>
