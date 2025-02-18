<?php

require_once 'database.php';

class EventFeedback {
    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function getFeedbackWithDetails() {
        $sql = "SELECT ef.*, e.eventTitle, u.userUserName 
                FROM event_feedback ef
                INNER JOIN event e ON ef.eventID = e.eventID
                INNER JOIN user u ON ef.userID = u.userID";
        $query = $this->db->connect()->prepare($sql);
        if($query->execute()) {
            $feedbackData = $query->fetchAll(PDO::FETCH_ASSOC);
            return $feedbackData;
        } else {
            return false;
        }
    }
}

?>
