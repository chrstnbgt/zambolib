<?php

require_once 'database.php';

class Attendance {
    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    function fetch($libraryAttendanceID)
    {
        $sql = "SELECT la.*, u.userFirstName, u.userMiddleName, u.userLastName, u.userAge, u.userGender, u.userContactNo, u.userSchoolOffice, u.userRegion, u.userProvince, u.userCity, u.userBarangay, u.userStreetName, u.userZipCode, ac.acFirstName, ac.acMiddleName, ac.acLastName
                FROM lib_attendanceuser la
                JOIN user u ON la.userID = u.userID
                JOIN attendance_checker ac ON la.libraryAttendanceID = ac.attendanceCheckerID
                WHERE la.libraryAttendanceID = :libraryAttendanceID;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':libraryAttendanceID', $libraryAttendanceID);
        if ($query->execute()) {
            $data = $query->fetch();
            return $data;
        }
        return null;
    }



    function show()
    {
        $sql = "SELECT la.*, u.userFirstName, u.userMiddleName, u.userLastName, u.userAge, u.userGender, u.userContactNo, u.userSchoolOffice, u.userRegion, u.userProvince, u.userCity, u.userBarangay, u.userStreetName, u.userZipCode, ac.acFirstName, ac.acMiddleName, ac.acLastName
                FROM lib_attendanceuser la
                JOIN user u ON la.userID = u.userID
                JOIN attendance_checker ac ON la.libraryAttendanceID = ac.attendanceCheckerID
                ORDER BY la.dateEntered ASC, la.timeEntered ASC;";
        $query = $this->db->connect()->prepare($sql);
        if ($query->execute()) {
            $data = $query->fetchAll();
            return $data;
        }
        return null;
    }
}
?>
