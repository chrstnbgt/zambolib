<?php

require_once 'database.php';

class Announcement {
    //attributes

    public $eventAnnouncementID;
    public $eaTitle;
    public $eaDescription;
    public $eaStartDate;
    public $eaEndDate;
    public $eaStartTime;
    public $eaEndTime;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add()
    {
        $sql = "INSERT INTO event_announcement (eaTitle, eaDescription, eaStartDate, eaEndDate, eaStartTime, eaEndTime) VALUES 
        (:eaTitle, :eaDescription, :eaStartDate, :eaEndDate, :eaStartTime, :eaEndTime);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eaTitle', $this->eaTitle);
        $query->bindParam(':eaDescription', $this->eaDescription);
        $query->bindParam(':eaStartDate', $this->eaStartDate);
        $query->bindParam(':eaEndDate', $this->eaEndDate);
        $query->bindParam(':eaStartTime', $this->eaStartTime);
        $query->bindParam(':eaEndTime', $this->eaEndTime);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function edit()
    {
        $sql = "UPDATE event_announcement SET eaTitle = :eaTitle, eaDescription = :eaDescription, eaStartDate = :eaStartDate, eaEndDate = :eaEndDate, eaStartTime = :eaStartTime, eaEndTime = :eaEndTime WHERE eventAnnouncementID = :eventAnnouncementID";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eaTitle', $this->eaTitle);
        $query->bindParam(':eaDescription', $this->eaDescription);
        $query->bindParam(':eaStartDate', $this->eaStartDate);
        $query->bindParam(':eaEndDate', $this->eaEndDate);
        $query->bindParam(':eaStartTime', $this->eaStartTime);
        $query->bindParam(':eaEndTime', $this->eaEndTime);
        $query->bindParam(':eventAnnouncementID', $this->eventAnnouncementID);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function delete($announcementID)
    {
        $sql = "DELETE FROM event_announcement WHERE eventAnnouncementID = :eventAnnouncementID";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventAnnouncementID', $announcementID);

        return $query->execute();
    }

    function fetch($announcementID)
    {
        $sql = "SELECT * FROM event_announcement WHERE eventAnnouncementID = :eventAnnouncementID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':eventAnnouncementID', $announcementID);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    function show()
    {
        $sql = "SELECT * FROM event_announcement ORDER BY eaUpdatedAt DESC;";
        $query = $this->db->connect()->prepare($sql);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }
        return $data;
    }
}

?>
