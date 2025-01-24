<?php
require_once('../classes/database.php');
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
?>
<?php
require_once '../classes/events.class.php';
require_once '../classes/librarian.class.php';
require_once '../tools/adminfunctions.php';
require_once '../classes/announcement.class.php';

//resume session here to fetch session values
// session_start();
// /*
//     if the user is not logged in, then redirect to the login page,
//     this is to prevent users from accessing pages that require
//     authentication such as the dashboard
// */
// if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
//     header('location: ./index.php');
// }
//if the above code is false then the HTML below will be displayed

if (isset($_POST['save'])) {
    $event = new Events();
    $event->eventTitle = htmlentities($_POST['eventTitle']);
    $event->eventDescription = htmlentities($_POST['eventDescription']);
    $event->eventStartDate = htmlentities($_POST['eventStartDate']);
    $event->eventEndDate = htmlentities($_POST['eventEndDate']);
    $event->eventStartTime = htmlentities($_POST['eventStartTime']);
    $event->eventEndTime = htmlentities($_POST['eventEndTime']);
    $event->eventGuestLimit = htmlentities($_POST['eventGuestLimit']);
    $event->eventRegion = htmlentities($_POST['eventRegion']);
    $event->eventProvince = htmlentities($_POST['eventProvince']);
    $event->eventCity = htmlentities($_POST['eventCity']);
    $event->eventBarangay = htmlentities($_POST['eventBarangay']);
    $event->eventStreetName = htmlentities($_POST['eventStreetName']);
    $event->eventBuildingName = htmlentities($_POST['eventBuildingName']);
    $event->eventZipCode = htmlentities($_POST['eventZipCode']);
    $event->eventStatus = htmlentities($_POST['eventStatus']);

    // Retrieve selected librarian IDs from the form
    $selectedLibrarianIDs = isset($_POST['librarianIDs']) ? $_POST['librarianIDs'] : [];
    $event->librarianIDs = $selectedLibrarianIDs;

    if (validate_field($event->eventTitle) &&
        validate_field($event->eventDescription) &&
        validate_field($event->eventStartDate) &&
        validate_field($event->eventEndDate) &&
        validate_field($event->eventStartTime) &&
        validate_field($event->eventEndTime) &&
        validate_field($event->eventGuestLimit) &&
        validate_field($event->eventRegion) &&
        validate_field($event->eventProvince) &&
        validate_field($event->eventCity) &&
        validate_field($event->eventBarangay) &&
        validate_field($event->eventStreetName) &&
        validate_field($event->eventZipCode) &&
        validate_field($event->eventStatus)) {

        if ($event->add()) {
            header('location: events.php#events');
        } else {
            echo 'An error occurred while adding event in the database.';
        }
    }
}


$librarian = new Librarian();
$librarians = $librarian->getAvailablelibrarian();
                        


if (isset($_POST['saveAnnouncement'])) {
    $announcement = new Announcement();
    $announcement->eaTitle = htmlentities($_POST['eaTitle']);
    $announcement->eaDescription = htmlentities($_POST['eaDescription']);
    $announcement->eaStartDate = htmlentities($_POST['eaStartDate']);
    $announcement->eaEndDate = htmlentities($_POST['eaEndDate']);
    $announcement->eaStartTime = htmlentities($_POST['eaStartTime']);
    $announcement->eaEndTime = htmlentities($_POST['eaEndTime']);

    // Validate input fields
    if (validate_field($announcement->eaTitle) &&
        validate_field($announcement->eaStartDate) &&
        validate_field($announcement->eaEndDate)) {

        // Add the announcement to the database
        if ($announcement->add()) {
            header('location: events.php#announcements'); // Redirect to announcements tab
            exit; // Stop script execution after redirect
        } else {
            echo 'An error occurred while adding the announcement in the database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Events & Announcements';
  $events = 'active-1';
  require_once('../include/head.php');

  $database = new Database();
  $connection = $database->connect();

  $librarianQuery = "SELECT DISTINCT l.* FROM librarian l
  JOIN event_facilitator ef ON l.librarianID = ef.librarianID
  WHERE l.librarianEmployment = 'Active';";
  $librarianResult = $connection->query($librarianQuery);
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
            <!-- Event Registration Form Modal -->
            <div class="container mt-4">
                <div class="header-modal d-flex justify-content-between">
                    <h5 class="modal-title mt-4 ms-4" id="eventRegistrationForm">Create Registration form (Name of the Event)</h5>
                    
                </div>
                <div class="modal-body mx-2 mt-2">
                <form action="" >

                </form>
                </div>
                <div class="modal-action-btn d-flex justify-content-end">
                    <button type="button" class="btn cancel-btn mb-3 me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn add-btn-2 mb-3 me-4">Create Registration Form</button>
                </div>
                </div>
                </div>
            </div>

    <?php require_once('../include/js.php'); ?>

</body>