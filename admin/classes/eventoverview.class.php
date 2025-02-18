<?php

require_once 'database.php';

Class Eventoverview{
    //attributes

    public $eventID;
    public $eventTitle;
    public $eventDescription;
    public $librarianIDs;
    public $eventStartDate;
    public $eventEndDate;
    public $eventStartTime;
    public $eventEndTime;
    public $eventGuestLimit;
    public $eventRegion;
    public $eventProvince;
    public $eventCity;
    public $eventBarangay;
    public $eventStreetName;
    public $eventBuildingName;
    public $eventZipCode;
    public $organizationClubIDs;
    public $eventStatus;
    public $eventCreatedAt;
    public $eventUpdatedAt;
    protected $db;

    function __construct(){
        $this->db = new Database();
    }

    function fetch($eventID){
        $sql = "SELECT * FROM event WHERE eventID = :eventID;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        if($query->execute()){
            $data = $query->fetch();
        }
        return $data;
    }

    function show(){
        $sql = "SELECT * FROM event ORDER BY eventTitle ASC;";
        $query=$this->db->connect()->prepare($sql);
        $data = null;
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }
    function getEventFacilitator($eventID){
        $sql = "SELECT librarian.* FROM event_facilitator 
                JOIN librarian ON event_facilitator.librarianID = librarian.librarianID 
                WHERE event_facilitator.eventID = :eventID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }
    function getEventdatetime(){
        $sql = "SELECT event_datetime.* FROM event 
                JOIN event_datetime ON event.eventID = event_datetime.eventID 
                WHERE event_datetime.eventID = :eventID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }
    public function getEventCollaboration($eventID) {
        $sql = "SELECT * FROM organization_club WHERE organizationClubID IN (SELECT organizationClubID FROM event_orgclub WHERE eventID = :eventID)";
        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':eventID', $eventID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventCollaborationDetails($eventID) {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT oc.ocName AS organizationClubName 
                               FROM event_orgclub AS eoc 
                               JOIN organization_club AS oc ON eoc.organizationClubID = oc.organizationClubID 
                               WHERE eoc.eventID = :eventID");
        $stmt->bindParam(':eventID', $eventID);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function fetchQuestions($eventID) {
        $sql = "SELECT eventRegQuestionID, erQuestion FROM event_regquestion WHERE eventID = ?";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(1, $eventID, PDO::PARAM_INT);
        
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Return an empty array if there's an error
        }
    }
    function updateEventFormQuestion($questionID, $question) {
        $updateSql = "UPDATE event_regquestion SET erQuestion = :question WHERE eventRegQuestionID = :questionID";
        $updateStmt = $this->db->connect()->prepare($updateSql);
        $updateStmt->bindParam(':question', $question, PDO::PARAM_STR);
        $updateStmt->bindParam(':questionID', $questionID, PDO::PARAM_INT);
        return $updateStmt->execute(); // Return true or false
    }
    
    function insertEventFormQuestion($eventID, $question) {
        $insertSql = "INSERT INTO event_regquestion (eventID, erQuestion) VALUES (:eventID, :question)";
        $insertStmt = $this->db->connect()->prepare($insertSql);
        $insertStmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
        $insertStmt->bindParam(':question', $question, PDO::PARAM_STR);
        return $insertStmt->execute(); // Return true or false
    }
    function getEventRegistrant($eventID){
        $sql = "SELECT CONCAT(u.userFirstName, ' ', u.userMiddleName, ' ', u.userLastName) AS fullName,
                    u.userEmail,
                    u.userContactNo,
                    u.userGender,
                    CONCAT(u.userStreetName, ', ', u.userBarangay, ', ', u.userCity, ', ', u.userProvince, ', ', u.userZipCode) AS address,
                    u.userAge,
                    er.erCreatedAt AS dateJoined
                FROM event_registration er
                JOIN user u ON er.userID = u.userID
                WHERE er.eventID = :eventID"; // Corrected cm.cmstatus
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        $data = null;
        
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    function getEventParticipant($eventID){
        $sql = "SELECT CONCAT(u.userFirstName, ' ', u.userMiddleName, ' ', u.userLastName) AS fullName,
                    u.userEmail,
                    u.userContactNo,
                    u.userGender,
                    CONCAT(u.userStreetName, ', ', u.userBarangay, ', ', u.userCity, ', ', u.userProvince, ', ', u.userZipCode) AS address,
                    u.userAge,
                    ea.eaDate AS dateJoined
                FROM event_attendance ea
                JOIN event_attendanceuser eau ON ea.eventAttendanceID = eau.eventAttendanceID
                JOIN user u ON eau.userID = u.userID
                WHERE ea.eventID = :eventID";
                
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        $data = null;
        
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    
    function getEventVolunteers($eventID){
        $sql = "SELECT CONCAT(u.userFirstName, ' ', u.userMiddleName, ' ', u.userLastName) AS fullName,
                    u.userEmail,
                    u.userContactNo,
                    u.userGender,
                    CONCAT(u.userStreetName, ', ', u.userBarangay, ', ', u.userCity, ', ', u.userProvince, ', ', u.userZipCode) AS address,
                    u.userAge
                FROM event_volunteer er
                JOIN user u ON er.userID = u.userID
                WHERE er.eventID = :eventID"; // Corrected cm.cmstatus
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        $data = null;
        
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    
    function fetchImages($eventID) {
        $sql = "SELECT event_ImageID, eventImage FROM event_images WHERE eventID = :eventID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
    
    function insertImage($eventID, $imageFilename) {
        $eventDate = date("Y-m-d"); // Get current date in MySQL format
        $sql = "INSERT INTO event_images (eventID, eventImage, eventDate) VALUES (:eventID, :imageFilename, :eventDate)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        $query->bindParam(':imageFilename', $imageFilename); // Store filename instead of full path
        $query->bindParam(':eventDate', $eventDate);
        return $query->execute();
    }
    public function deleteImage($event_ImageID) {
        $sql = "DELETE FROM event_images WHERE event_ImageID = :event_ImageID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':event_ImageID', $event_ImageID);
        return $query->execute();
    }

    function fetchCertificates($eventID) {
        $sql = "SELECT eventCertificateID, ecName, ecImage FROM event_certificate WHERE eventID = :eventID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
    
    function insertCertificate($eventID, $certificateName, $certificateImage) {
        $eventDate = date("Y-m-d"); // Get current date in MySQL format
        $uploadDir = '../certificate_images/'; // Adjust directory as needed
        $certificateImagePath = $uploadDir . $certificateImage['name']; // Adjust path as needed
    
        move_uploaded_file($certificateImage['tmp_name'], $certificateImagePath);
    
        $sql = "INSERT INTO event_certificate (eventID, ecName, ecImage) VALUES (:eventID, :certificateName, :certificateImage)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);
        $query->bindParam(':certificateName', $certificateName);
        $query->bindParam(':certificateImage', $certificateImage['name']);
        return $query->execute();
    }
    
    public function deleteCertificate($eventCertificateID) {
        $sql = "DELETE FROM event_certificate WHERE eventCertificateID = :eventCertificateID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventCertificateID', $eventCertificateID);
        return $query->execute();
    }

    function getApplication() {
        $sql = "SELECT er.*, u.userEmail, er.eventID 
        FROM event_registration er
        LEFT JOIN user u ON er.userID = u.userID
        ORDER BY CASE 
                    WHEN er.erStatus = 'Pending' THEN 1 
                    WHEN er.erStatus IN ('approved', 'declined') THEN 2 
                END, 
                CASE 
                    WHEN er.erStatus IN ('approved', 'declined') THEN er.erCreatedAt 
                END DESC";

        $query = $this->db->connect()->prepare($sql);
        
        $data = null;
    
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    
    
    function getUserDetails($userID) {
        $sql = "SELECT * FROM user WHERE userID = :userID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':userID', $userID);
        
        $data = null;
    
        if ($query->execute()) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }
    function updateApplicationStatus($eventRegistrationID, $status) {
        $sql = "UPDATE event_registration SET erStatus = :status WHERE eventRegistrationID = :eventRegistrationID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        $query->bindParam(':eventRegistrationID', $eventRegistrationID);
        
        return $query->execute();
    }
    
    
}

?>