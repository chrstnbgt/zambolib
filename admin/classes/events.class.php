<?php

require_once 'database.php';

class Events{
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

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    public function add() {
        $conn = $this->db->connect();
    
        // Calculate eventStatus based on eventStartDate
        $currentDateTime = date('Y-m-d H:i:s'); // Current date and time
        $eventStartDateTime = date('Y-m-d H:i:s', strtotime($this->eventStartDate . ' ' . $this->eventStartTime));
    
        if ($currentDateTime < $eventStartDateTime) {
            $eventStatus = 'Upcoming';
        } elseif ($currentDateTime >= $eventStartDateTime && $currentDateTime <= date('Y-m-d H:i:s', strtotime($this->eventEndDate . ' ' . $this->eventEndTime))) {
            $eventStatus = 'Ongoing';
        } else {
            $eventStatus = 'Completed';
        }
    
        // Insert event with eventStatus
        $stmt = $conn->prepare("INSERT INTO event (eventTitle, eventDescription, eventStartDate, eventEndDate, eventStartTime, eventEndTime, eventGuestLimit, eventRegion, eventProvince, eventCity, eventBarangay, eventStreetName, eventBuildingName, eventZipCode, eventStatus) 
                                VALUES (:eventTitle, :eventDescription, :eventStartDate, :eventEndDate, :eventStartTime, :eventEndTime, :eventGuestLimit, :eventRegion, :eventProvince, :eventCity, :eventBarangay, :eventStreetName, :eventBuildingName, :eventZipCode, :eventStatus)");
        
        $stmt->bindParam(':eventTitle', $this->eventTitle);
        $stmt->bindParam(':eventDescription', $this->eventDescription);
        $stmt->bindParam(':eventStartDate', $this->eventStartDate);
        $stmt->bindParam(':eventEndDate', $this->eventEndDate);
        $stmt->bindParam(':eventStartTime', $this->eventStartTime);
        $stmt->bindParam(':eventEndTime', $this->eventEndTime);
        $stmt->bindParam(':eventGuestLimit', $this->eventGuestLimit);
        $stmt->bindParam(':eventRegion', $this->eventRegion);
        $stmt->bindParam(':eventProvince', $this->eventProvince);
        $stmt->bindParam(':eventCity', $this->eventCity);
        $stmt->bindParam(':eventBarangay', $this->eventBarangay);
        $stmt->bindParam(':eventStreetName', $this->eventStreetName);
        $stmt->bindParam(':eventBuildingName', $this->eventBuildingName);
        $stmt->bindParam(':eventZipCode', $this->eventZipCode);
        $stmt->bindParam(':eventStatus', $eventStatus);  // Store the calculated eventStatus
    
        if ($stmt->execute()) {
            $this->eventID = $conn->lastInsertId();
    
            foreach ($this->librarianIDs as $librarianID) {
                $stmt = $conn->prepare("INSERT INTO event_facilitator (eventID, librarianID) VALUES (:eventID, :librarianID)");
                $stmt->bindParam(':eventID',  $this->eventID);
                $stmt->bindParam(':librarianID', $librarianID);
                $stmt->execute();
            }
    
            // Add event collaborations
            foreach ($this->organizationClubIDs as $organizationClubID) {
                $stmt = $conn->prepare("INSERT INTO event_orgclub (eventID, organizationClubID) VALUES (:eventID, :organizationClubID)");
                $stmt->bindParam(':eventID',  $this->eventID);
                $stmt->bindParam(':organizationClubID', $organizationClubID);
                $stmt->execute();
            }
    
            return true;
        } else {
            return false;
        }
    }
    

    public function edit() {
        $conn = $this->db->connect();
    
        // Calculate eventStatus based on the updated eventStartDate
        $currentDateTime = date('Y-m-d H:i:s'); // Current date and time
        $eventStartDateTime = date('Y-m-d H:i:s', strtotime($this->eventStartDate . ' ' . $this->eventStartTime));
    
        if ($currentDateTime < $eventStartDateTime) {
            $eventStatus = 'Upcoming';
        } elseif ($currentDateTime >= $eventStartDateTime && $currentDateTime <= date('Y-m-d H:i:s', strtotime($this->eventEndDate . ' ' . $this->eventEndTime))) {
            $eventStatus = 'Ongoing';
        } else {
            $eventStatus = 'Completed';
        }
    
        // Update event with new eventStatus
        $stmt = $conn->prepare("UPDATE event 
                                SET eventTitle = :eventTitle, 
                                    eventDescription = :eventDescription, 
                                    eventStartDate = :eventStartDate, 
                                    eventEndDate = :eventEndDate, 
                                    eventStartTime = :eventStartTime, 
                                    eventEndTime = :eventEndTime, 
                                    eventGuestLimit = :eventGuestLimit, 
                                    eventRegion = :eventRegion, 
                                    eventProvince = :eventProvince, 
                                    eventCity = :eventCity, 
                                    eventBarangay = :eventBarangay, 
                                    eventStreetName = :eventStreetName, 
                                    eventBuildingName = :eventBuildingName, 
                                    eventZipCode = :eventZipCode, 
                                    eventStatus = :eventStatus 
                                WHERE eventID = :eventID");
    
        $stmt->bindParam(':eventTitle', $this->eventTitle);
        $stmt->bindParam(':eventDescription', $this->eventDescription);
        $stmt->bindParam(':eventStartDate', $this->eventStartDate);
        $stmt->bindParam(':eventEndDate', $this->eventEndDate);
        $stmt->bindParam(':eventStartTime', $this->eventStartTime);
        $stmt->bindParam(':eventEndTime', $this->eventEndTime);
        $stmt->bindParam(':eventGuestLimit', $this->eventGuestLimit);
        $stmt->bindParam(':eventRegion', $this->eventRegion);
        $stmt->bindParam(':eventProvince', $this->eventProvince);
        $stmt->bindParam(':eventCity', $this->eventCity);
        $stmt->bindParam(':eventBarangay', $this->eventBarangay);
        $stmt->bindParam(':eventStreetName', $this->eventStreetName);
        $stmt->bindParam(':eventBuildingName', $this->eventBuildingName);
        $stmt->bindParam(':eventZipCode', $this->eventZipCode);
        $stmt->bindParam(':eventStatus', $eventStatus);  // Update the eventStatus
        $stmt->bindParam(':eventID', $this->eventID);
    
        if ($stmt->execute()) {
            // Update event facilitators (if necessary)
            $stmt = $conn->prepare("DELETE FROM event_facilitator WHERE eventID = :eventID");
            $stmt->bindParam(':eventID', $this->eventID);
            $stmt->execute();
    
            foreach ($this->librarianIDs as $librarianID) {
                $stmt = $conn->prepare("INSERT INTO event_facilitator (eventID, librarianID) VALUES (:eventID, :librarianID)");
                $stmt->bindParam(':eventID',  $this->eventID);
                $stmt->bindParam(':librarianID', $librarianID);
                $stmt->execute();
            }
    
            // Update event collaborations (if necessary)
            $stmt = $conn->prepare("DELETE FROM event_orgclub WHERE eventID = :eventID");
            $stmt->bindParam(':eventID', $this->eventID);
            $stmt->execute();
    
            foreach ($this->organizationClubIDs as $organizationClubID) {
                $stmt = $conn->prepare("INSERT INTO event_orgclub (eventID, organizationClubID) VALUES (:eventID, :organizationClubID)");
                $stmt->bindParam(':eventID',  $this->eventID);
                $stmt->bindParam(':organizationClubID', $organizationClubID);
                $stmt->execute();
            }
    
            return true;
        } else {
            return false;
        }
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

    public function getEventFacilitators($eventID) {
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

    public function fetchLibrarian($librarianID) {
        $sql = "SELECT * FROM librarian WHERE librarianID = :librarianID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':librarianID', $librarianID);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function getEventCollaboration($organizationClubID){
        $sql = "SELECT organization_club.* FROM event 
                JOIN organization_club ON event.organizationClubID = organization_club.organizationClubID 
                WHERE organization_club.organizationClubID = :organizationClubID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':organizationClubID', $organizationClubID);
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
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
                    er.erCreatedAt AS dateJoined
                FROM event_registration er
                JOIN user u ON er.userID = u.userID
                WHERE er.eventID = :eventID AND er.erStatus = 'approved'"; // Corrected cm.cmstatus
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

    public function show() {
        $sql = "SELECT * FROM event ORDER BY eventCreatedAt ASC";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
    
        if ($query->execute()) {
            $data = $query->fetchAll();
    
            foreach ($data as &$item) {
                $currentDateTime = date('Y-m-d H:i:s'); // Get current date and time in MySQL format
                $eventStartTime = date('Y-m-d H:i:s', strtotime($item['eventStartDate'] . ' ' . $item['eventStartTime']));
                $eventEndTime = date('Y-m-d H:i:s', strtotime($item['eventEndDate'] . ' ' . $item['eventEndTime']));
    
                // Determine event status
                if ($currentDateTime < $eventStartTime) {
                    $item['eventStatus'] = 'Upcoming';
                } elseif ($currentDateTime >= $eventStartTime && $currentDateTime <= $eventEndTime) {
                    $item['eventStatus'] = 'Ongoing';
                } else {
                    $item['eventStatus'] = 'Completed';
                }
            }
        }
        return $data ?: [];
    }
    
    
    public function getAllEvents() {
        $sql = "SELECT * FROM event";
        $query = $this->db->connect()->prepare($sql);

        $events = null;

        if ($query->execute()) {
            $events = $query->fetchAll();
        }

        return $events;
    }

    public function delete($eventID) {
        $sql = "DELETE FROM event WHERE eventID = :eventID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventID', $eventID);

        return $query->execute();
    }

    public function checkEventConflict() {
        $startDateTime = date('Y-m-d H:i:s', strtotime($this->eventStartDate . ' ' . $this->eventStartTime));
        $endDateTime = date('Y-m-d H:i:s', strtotime($this->eventEndDate . ' ' . $this->eventEndTime));
    
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT * FROM event WHERE (eventStartDate < :endDateTime AND eventEndDate > :startDateTime)
        OR (eventStartDate = :startDateTime AND eventEndDate >= :endDateTime)
        OR (eventStartDate <= :startDateTime AND eventEndDate = :endDateTime)");
        $stmt->bindParam(':startDateTime', $startDateTime);
        $stmt->bindParam(':endDateTime', $endDateTime);
        $stmt->execute();
    
        return $stmt->rowCount() > 0;
    }

    function getApprovedOrganizationClubs() {
        $sql = "SELECT * FROM organization_club WHERE ocStatus = 'Approved'";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
    
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return $data ?: [];
    }
    
    public function getEventCollaborations($eventID) {
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
    
    public function getEventStatus($eventStartDate, $eventEndDate, $eventStartTime, $eventEndTime) {
        $currentDateTime = date('Y-m-d H:i:s');
        $startDateTime = date('Y-m-d H:i:s', strtotime($eventStartDate . ' ' . $eventStartTime));
        $endDateTime = date('Y-m-d H:i:s', strtotime($eventEndDate . ' ' . $eventEndTime));
    
        if ($currentDateTime < $startDateTime) {
            return 'Upcoming';
        } elseif ($currentDateTime >= $startDateTime && $currentDateTime <= $endDateTime) {
            return 'Ongoing';
        } else {
            return 'Finished';
        }
    }
    
    
    
}
?>