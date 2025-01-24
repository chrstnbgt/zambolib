<?php

require_once 'database.php';

class Appointment
{
    //attributes
    public $appointmentID;
    public $appointmentDate;
    public $appointmentTime;
    public $customerID;
    public $serviceID;
    public $staffID;
    public $appointmentHeads;
    public $appointmentStatus;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add()
    {
        $sql = "INSERT INTO appointment (appointmentDate,  appointmentTime,  staffID,  appointmentHeads) VALUES 
        (:appointmentDate, :appointmentTime, :staffID, :appointmentHeads);";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentDate', $this->appointmentDate);
        $query->bindParam(':appointmentTime', $this->appointmentTime);
        $query->bindParam(':staffID', $this->staffID);
        $query->bindParam(':appointmentHeads', $this->appointmentHeads);

        if ($query->execute()) {
            $appointmentID = $this->db->connect()->lastInsertId();

            // Insert records into the appointment_services table for each selected service
            foreach ($this->serviceIDs as $serviceID) {
                $this->linkServiceToAppointment($appointmentID, $serviceID);
            }

            return true;
        } else {
            return false;
        }
    }

    // Add a method to link services to an appointment in the appointment_services table
    function linkServiceToAppointment($appointmentID, $serviceID)
    {
        $sql = "INSERT INTO appointment_services (appointmentID, serviceID) VALUES (:appointmentID, :serviceID);";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentID', $appointmentID);
        $query->bindParam(':serviceID', $serviceID);

        return $query->execute();
    }


    function getLastInsertedID()
    {
        return $this->db->connect()->lastInsertId();
    }

    // function getAllAppointments()
    // {
    //     $sql = "SELECT * FROM appointment
    //             JOIN customer ON appointment.customerID = customer.customerID
    //             JOIN service ON appointment.serviceID = service.serviceID
    //             JOIN staff ON appointment.staffID = staff.staffID
    //             ORDER BY appointment.appointmentID DESC;";

    //     $query = $this->db->connect()->prepare($sql);

    //     $data = null;
    //     if ($query->execute()) {
    //         $data = $query->fetchAll();
    //     }

    //     return $data;
    // }

    function show()
    {
        $sql = "SELECT * FROM appointment
                JOIN customer ON appointment.customerID = customer.customerID
                JOIN service ON appointment.serviceID = service.serviceID
                JOIN staff ON appointment.staffID = staff.staffID
                ORDER BY appointment.appointmentID DESC;";

        $query = $this->db->connect()->prepare($sql);

        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll();
        }

        return $data;
    }

    function acceptAppointment($appointmentID)
    {
        $sql = "UPDATE appointment SET appointmentStatus='Accepted' WHERE appointmentID=:appointmentID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentID', $appointmentID);

        return $query->execute();
    }

    function completeAppointment($appointmentID)
    {
        $sql = "UPDATE appointment SET appointmentStatus='Completed' WHERE appointmentID=:appointmentID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentID', $appointmentID);

        return $query->execute();
    }

    function denyAppointment($appointmentID)
    {
        $sql = "UPDATE appointment SET appointmentStatus='Denied' WHERE appointmentID=:appointmentID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentID', $appointmentID);

        return $query->execute();
    }

    function delete($appointmentID)
    {
        $sql = "DELETE FROM appointment WHERE appointmentID=:appointmentID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentID', $appointmentID);

        return $query->execute();
    }

    function fetch($record_id)
    {
        $sql = "SELECT * FROM appointment WHERE appointmentID = :appointmentID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':appointmentID', $record_id);
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }
}

   
?>
