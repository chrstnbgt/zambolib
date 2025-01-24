<?php
// accept-club.php

require_once('../classes/database.php');
require_once('../classes/orgclub.class.php');
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

if(isset($_POST['organizationClubID'])) {
    $OrgClub = new OrgClub();
    $organizationClubID = $_POST['organizationClubID'];

    // Update the status of the organization club to "Approved"
    $result = $OrgClub->updateStatus($organizationClubID, 'Approved');

    if($result) {
        // Return a success message
        echo "Organization Club with ID $organizationClubID has been approved.";
    } else {
        // Return an error message
        echo "Error updating organization club status.";
    }
} else {
    // Return an error message
    echo "Error: organizationClubID parameter is missing.";
}
?>
