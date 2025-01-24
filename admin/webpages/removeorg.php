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
// Check if the club ID is provided in the URL
if (isset($_GET['id'])) {
    $clubID = $_GET['id'];

    // Include necessary files and classes
    require_once '../classes/orgclub.class.php';

    // Create a new instance of the OrgClub class
    $clubs = new OrgClub();

    // Call a method to delete the club by ID
    if ($clubs->delete($clubID)) {
        // Club deleted successfully, redirect to the clubs page
        header('location: organizations.php');
        exit();
    } else {
        // An error occurred during deletion
        echo 'Error deleting organization.';
        exit();
    }
} else {
    // Club ID is not provided in the URL
    echo 'Invalid request.';
    exit();
}
?>
