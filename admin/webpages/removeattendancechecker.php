<?php
//resume session here to fetch session values
session_start();
/*
    if the user is not logged in, then redirect to the login page,
    this is to prevent users from accessing pages that require
    authentication such as the dashboard
*/
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    header('location: ./index.php');
}
//if the above code is false then the HTML below will be displayed

// Check if the staff ID is provided in the URL
if (isset($_GET['id'])) {
    $attendanceCheckerID = $_GET['id'];

    // Include necessary files and classes
    require_once '../classes/attendancechecker.class.php';

    // Create a new instance of the staff class
    $AttendanceChecker = new AttendanceChecker();

    // Call a method to delete the staff by ID
    if ($AttendanceChecker->delete($attendanceCheckerID)) {
        // staff deleted successfully, redirect to the staffs page
        header('location: attendance-checker.php');
        exit();
    } else {
        // An error occurred during deletion
        echo 'Error deleting attendance checker.';
        exit();
    }
} else {
    // staff ID is not provided in the URL
    echo 'Invalid request.';
    exit();
}
?>


