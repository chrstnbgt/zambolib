<?php
require_once '../classes/events.class.php';
require_once '../classes/librarian.class.php';
require_once '../tools/adminfunctions.php';

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

// Function to check if there is a conflicting event
function hasConflictingEvent($startDateTime, $endDateTime, $eventStreetName, $eventBuildingName, $existingEvents) {
    foreach ($existingEvents as $event) {
        $eventStart = strtotime($event['eventStartDate'] . ' ' . $event['eventStartTime']);
        $eventEnd = strtotime($event['eventEndDate'] . ' ' . $event['eventEndTime']);
        $start = strtotime($startDateTime);
        $end = strtotime($endDateTime);

        // Check if the start date and time fall within the range of an existing event
        // or if the end date and time fall within the range of an existing event
        // or if the existing event's dates and times fall within the range of the input dates and times
        if (($start >= $eventStart && $start < $eventEnd) || ($end > $eventStart && $end <= $eventEnd) ||
            ($eventStart >= $start && $eventStart < $end) || ($eventEnd > $start && $eventEnd <= $end)) {
            // Check if the street name and building name are the same
            if ($event['eventStreetName'] === $eventStreetName && $event['eventBuildingName'] === $eventBuildingName) {
                return true; // Conflicting event found
            }
        }
    }
    return false; // No conflicting event found
}

if (isset($_POST['save'])) {
    // Create an instance of the Events class
    $event = new Events();

    // Set the event details
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
    // $event->eventStatus = htmlentities($_POST['eventStatus']);

    // Retrieve selected librarian IDs from the form
    $selectedLibrarianIDs = isset($_POST['librarianIDs']) ? $_POST['librarianIDs'] : [];
    $event->librarianIDs = $selectedLibrarianIDs;

    // Retrieve selected organization/club IDs from the form
    $selectedOrganizationClubIDs = isset($_POST['organizationClubIDs']) ? $_POST['organizationClubIDs'] : [];
    $event->organizationClubIDs = $selectedOrganizationClubIDs;

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
            validate_field($event->eventZipCode)) {

            // Get all existing events
            $existingEvents = $event->getAllEvents();

            if (strtotime($event->eventStartDate) > strtotime($event->eventEndDate)) {
                echo '<div class="alert alert-danger" role="alert">The event start date cannot be greater than the end date. Please check the dates.</div>';
            } elseif (strtotime($event->eventStartDate) == strtotime($event->eventEndDate)) {
                // Check if the start time is greater than the end time on the same day
                if (strtotime($event->eventStartTime) >= strtotime($event->eventEndTime)) {
                    echo '<div class="alert alert-danger" role="alert">The event start time cannot be greater than or equal to the end time. Please check the times.</div>';
                } else {
                    // Proceed with checking for conflicting events
                    if (hasConflictingEvent($startDateTime, $endDateTime, $event->eventStreetName, $event->eventBuildingName, $existingEvents)) {
                        echo '<div class="alert alert-danger" role="alert">This event conflicts with an existing event. Please choose a different date or time.</div>';
                    } else {
                        // Proceed with adding the event
                        if ($event->add()) {
                            echo 'Event added successfully.';
                            // Redirect to events page
                            header('location: ../webpages/events.php');
                            exit(); // Exit to prevent further output
                        } else {
                            echo 'An error occurred while adding event in the database.';
                        }
                    }
                }
            } else {
                // Proceed with checking for conflicting events
                if (hasConflictingEvent($startDateTime, $endDateTime, $event->eventStreetName, $event->eventBuildingName, $existingEvents)) {
                    echo '<div class="alert alert-danger" role="alert">This event conflicts with an existing event. Please choose a different date or time.</div>';
                } else {
                    // Proceed with adding the event
                    if ($event->add()) {
                        echo 'Event added successfully.';
                        // Redirect to events page
                        header('location: ../webpages/events.php');
                        exit(); // Exit to prevent further output
                    } else {
                        echo 'An error occurred while adding event in the database.';
                    }
                }
            }
        }
}

$librarian = new Librarian();
$librarians = $librarian->getAvailablelibrarian();

$event = new Events();
$organizationsClubs = $event->getApprovedOrganizationClubs();
?>
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Events & Announcements';
  $events = 'active-1';
  require_once('../include/head.php');
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
                <!-- Add Event Modal -->
                <div class="container mt-4">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-4 ms-2" id="addEventLabel">Add Event</h5>
                        
                    </div>
                    <div class="modal-body mt-2">
                    <form method="post" action="" id="addClubForm" onsubmit="return validateForm()">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventTitle" class="label">Event Title</label>
                                <input type="text" name="eventTitle" id="eventTitle" class="input-1" placeholder="Title of the Event" required value="<?php if(isset($_POST['eventTitle'])) { echo $_POST['eventTitle']; } ?>">
                                <?php
                                if(isset($_POST['eventTitle']) && !validate_field($_POST['eventTitle'])){
                                    ?>
                                    <p class="text-danger my-1">Event title is required</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventDescription" class="label">Description</label>
                                <input type="text" id="eventDescription" name="eventDescription" class="input-1" rows="4" cols="50" placeholder="Write brief description" required value="<?php if(isset($_POST['eventDescription'])) { echo $_POST['eventDescription']; } ?>">
                                <?php
                                if(isset($_POST['eventDescription']) && !validate_field($_POST['eventDescription'])){
                                    ?>
                                    <p class="text-danger my-1">Event description is required</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianID" class="label">Select Event Facilitators/s</label>
                                <br>
                                <?php
                                foreach ($librarians as $librarian) {
                                    echo '<div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="librarianIDs[]" id="librarian' . $librarian['librarianID'] . '" value="' . $librarian['librarianID'] . '>
                                            <label class="form-check-label" for="librarian' . $librarian['librarianID'] . '">' . $librarian['librarianFirstName'] . ' ' . $librarian['librarianLastName'] . '</label>
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventDate" class="label">Date of the Event</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="eventStartDate" class="label-2">Start Date</label>
                                        <input type="date" name="eventStartDate" id="eventStartDate" class="input-1 col-lg-12" placeholder="From" required value="<?php if(isset($_POST['eventStartDate'])) { echo $_POST['eventStartDate']; } ?>">
                                        <?php
                                        if(isset($_POST['eventStartDate']) && !validate_field($_POST['eventStartDate'])){
                                            ?>
                                            <p class="text-danger my-1">Event start date is required</p>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="eventEndDate" class="label-2">End Date</label>
                                        <input type="date" name="eventEndDate" id="eventEndDate" class="input-1 col-lg-12" placeholder="To" required value="<?php if(isset($_POST['eventEndDate'])) { echo $_POST['eventEndDate']; } ?>">
                                        <?php
                                        if(isset($_POST['eventEndDate']) && !validate_field($_POST['eventEndDate'])){
                                            ?>
                                            <p class="text-danger my-1">Event end date is required</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventTime" class="label">Time of the Event</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="eventStartTime" class="label-2">Start Time</label>
                                        <input type="time" name="eventStartTime" id="eventStartTime" class="input-1 col-lg-12" placeholder="From" required value="<?php if(isset($_POST['eventStartTime'])) { echo $_POST['eventStartTime']; } ?>">
                                        <?php
                                        if(isset($_POST['eventStartTime']) && !validate_field($_POST['eventStartTime'])){
                                            ?>
                                            <p class="text-danger my-1">Event start time is required</p>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="eventEndTime" class="label-2">End Time</label>
                                        <input type="time" name="eventEndTime" id="eventEndTime" class="input-1 col-lg-12" placeholder="To" required value="<?php if(isset($_POST['eventEndTime'])) { echo $_POST['eventEndTime']; } ?>">
                                        <?php
                                        if(isset($_POST['eventEndTime']) && !validate_field($_POST['eventEndTime'])){
                                            ?>
                                            <p class="text-danger my-1">Event end time is required</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventGuestLimit" class="label">Guest Limit</label>
                                <input type="number" name="eventGuestLimit" id="eventGuestLimit" class="input-1" placeholder="Number of Guest Limit" required value="<?php if(isset($_POST['eventGuestLimit'])) { echo $_POST['eventGuestLimit']; } ?>">
                                <?php
                                if(isset($_POST['eventGuestLimit']) && !validate_field($_POST['eventGuestLimit'])){
                                    ?>
                                    <p class="text-danger my-1">Guest limit is required</p>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center mt-1">
                            <label for="eventRegion" class="label">Place of Event</label>
                            <div class="input-group flex-column mb-3">
                                <label for="eventRegion" class="label ps-2">Region</label>
                                <select name="eventRegion" id="eventRegion" class="input-1">
                                    <option value="">Select Region</option>
                                    <option value="Region I" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region I') { echo 'selected'; } ?>>Region I</option>
                                    <option value="Region II" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region II') { echo 'selected'; } ?>>Region II</option>
                                    <option value="Region III" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region III') { echo 'selected'; } ?>>Region III</option>
                                    <option value="Region IV" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region IV') { echo 'selected'; } ?>>Region IV</option>
                                    <option value="Region V" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region V') { echo 'selected'; } ?>>Region V</option>
                                    <option value="Region VI" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region VI') { echo 'selected'; } ?>>Region VI</option>
                                    <option value="Region VII" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region VII') { echo 'selected'; } ?>>Region VII</option>
                                    <option value="Region VIII" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region VIII') { echo 'selected'; } ?>>Region VIII</option>
                                    <option value="Region IX" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region IX') { echo 'selected'; } ?>>Region IX</option>
                                    <option value="Region X" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region X') { echo 'selected'; } ?>>Region X</option>
                                    <option value="Region XI" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region XI') { echo 'selected'; } ?>>Region XI</option>
                                    <option value="Region XII" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region XII') { echo 'selected'; } ?>>Region XII</option>
                                    <option value="Region XIII" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'Region XIII') { echo 'selected'; } ?>>Region XIII</option>
                                    <option value="MIMAROPA" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'MIMAROPA') { echo 'selected'; } ?>>MIMAROPA</option>
                                    <option value="NCR" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'NCR') { echo 'selected'; } ?>>NCR</option>
                                    <option value="CAR" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'CAR') { echo 'selected'; } ?>>CAR</option>
                                    <option value="BARMM" <?php if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == 'BARMM') { echo 'selected'; } ?>>BARMM</option>
                                </select>
                                <?php
                                    if(isset($_POST['eventRegion']) && !validate_field($_POST['eventRegion'])){
                                ?>
                                        <p class="text-danger my-1">Select a region</p>
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="input-group flex-column mb-3">
                                <label for="eventProvince" class="label ps-2">Province</label>
                                <select name="eventProvince" id="eventProvince" class="input-1" disabled>
                                    <option value="">Select Province</option>
                                    <option value="Abra" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Abra') { echo 'selected'; } ?>>Abra</option>
                                    <option value="Agusan del Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Agusan del Norte') { echo 'selected'; } ?>>Agusan del Norte</option>
                                    <option value="Agusan del Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Agusan del Sur') { echo 'selected'; } ?>>Agusan del Sur</option>
                                    <option value="Aklan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Aklan') { echo 'selected'; } ?>>Aklan</option>
                                    <option value="Albay" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Albay') { echo 'selected'; } ?>>Albay</option>
                                    <option value="Antique" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Antique') { echo 'selected'; } ?>>Antique</option>
                                    <option value="Apayao" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Apayao') { echo 'selected'; } ?>>Apayao</option>
                                    <option value="Aurora" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Aurora') { echo 'selected'; } ?>>Aurora</option>
                                    <option value="Basilan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Basilan') { echo 'selected'; } ?>>Basilan</option>
                                    <option value="Bataan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Bataan') { echo 'selected'; } ?>>Bataan</option>
                                    <option value="Batanes" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Batanes') { echo 'selected'; } ?>>Batanes</option>
                                    <option value="Batangas" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Batangas') { echo 'selected'; } ?>>Batangas</option>
                                    <option value="Benguet" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Benguet') { echo 'selected'; } ?>>Benguet</option>
                                    <option value="Biliran" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Biliran') { echo 'selected'; } ?>>Biliran</option>
                                    <option value="Bohol" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Bohol') { echo 'selected'; } ?>>Bohol</option>
                                    <option value="Bukidnon" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Bukidnon') { echo 'selected'; } ?>>Bukidnon</option>
                                    <option value="Bulacan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Bulacan') { echo 'selected'; } ?>>Bulacan</option>
                                    <option value="Cagayan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Cagayan') { echo 'selected'; } ?>>Cagayan</option>
                                    <option value="Camarines Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Camarines Norte') { echo 'selected'; } ?>>Camarines Norte</option>
                                    <option value="Camarines Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Camarines Sur') { echo 'selected'; } ?>>Camarines Sur</option>
                                    <option value="Camiguin" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Camiguin') { echo 'selected'; } ?>>Camiguin</option>
                                    <option value="Capiz" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Capiz') { echo 'selected'; } ?>>Capiz</option>
                                    <option value="Catanduanes" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Catanduanes') { echo 'selected'; } ?>>Catanduanes</option>
                                    <option value="Cavite" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Cavite') { echo 'selected'; } ?>>Cavite</option>
                                    <option value="Cebu" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Cebu') { echo 'selected'; } ?>>Cebu</option>
                                    <option value="Cotabato" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Cotabato') { echo 'selected'; } ?>>Cotabato</option>
                                    <option value="Davao de Oro (Compostela Valley)" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Davao de Oro (Compostela Valley)') { echo 'selected'; } ?>>Davao de Oro (Compostela Valley)</option>
                                    <option value="Davao del Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Davao del Norte') { echo 'selected'; } ?>>Davao del Norte</option>
                                    <option value="Davao del Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Davao del Sur') { echo 'selected'; } ?>>Davao del Sur</option>
                                    <option value="Davao Occidental" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Davao Occidental') { echo 'selected'; } ?>>Davao Occidental</option>
                                    <option value="Davao Oriental" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Davao Oriental') { echo 'selected'; } ?>>Davao Oriental</option>
                                    <option value="Dinagat Islands" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Dinagat Islands') { echo 'selected'; } ?>>Dinagat Islands</option>
                                    <option value="Eastern Samar" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Eastern Samar') { echo 'selected'; } ?>>Eastern Samar</option>
                                    <option value="Guimaras" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Guimaras') { echo 'selected'; } ?>>Guimaras</option>
                                    <option value="Ifugao" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Ifugao') { echo 'selected'; } ?>>Ifugao</option>
                                    <option value="Ilocos Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Ilocos Norte') { echo 'selected'; } ?>>Ilocos Norte</option>
                                    <option value="Ilocos Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Ilocos Sur') { echo 'selected'; } ?>>Ilocos Sur</option>
                                    <option value="Iloilo" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Iloilo') { echo 'selected'; } ?>>Iloilo</option>
                                    <option value="Isabela" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Isabela') { echo 'selected'; } ?>>Isabela</option>
                                    <option value="Kalinga" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Kalinga') { echo 'selected'; } ?>>Kalinga</option>
                                    <option value="La Union" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'La Union') { echo 'selected'; } ?>>La Union</option>
                                    <option value="Laguna" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Laguna') { echo 'selected'; } ?>>Laguna</option>
                                    <option value="Lanao del Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Lanao del Norte') { echo 'selected'; } ?>>Lanao del Norte</option>
                                    <option value="Lanao del Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Lanao del Sur') { echo 'selected'; } ?>>Lanao del Sur</option>
                                    <option value="Leyte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Leyte') { echo 'selected'; } ?>>Leyte</option>
                                    <option value="Maguindanao del Norte (partitioned recently from Maguindanao)" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Maguindanao del Norte (partitioned recently from Maguindanao)') { echo 'selected'; } ?>>Maguindanao del Norte (partitioned recently from Maguindanao)</option>
                                    <option value="Maguindanao del Sur (partitioned recently from Maguindanao)" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Maguindanao del Sur (partitioned recently from Maguindanao)') { echo 'selected'; } ?>>Maguindanao del Sur (partitioned recently from Maguindanao)</option>
                                    <option value="Marinduque" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Marinduque') { echo 'selected'; } ?>>Marinduque</option>
                                    <option value="Masbate" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Masbate') { echo 'selected'; } ?>>Masbate</option>
                                    <option value="Misamis Occidental" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Misamis Occidental') { echo 'selected'; } ?>>Misamis Occidental</option>
                                    <option value="Misamis Oriental" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Misamis Oriental') { echo 'selected'; } ?>>Misamis Oriental</option>
                                    <option value="Mountain Province" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Mountain Province') { echo 'selected'; } ?>>Mountain Province</option>
                                    <option value="Negros Occidental" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Negros Occidental') { echo 'selected'; } ?>>Negros Occidental</option>
                                    <option value="Negros Oriental" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Negros Oriental') { echo 'selected'; } ?>>Negros Oriental</option>
                                    <option value="Northern Samar" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Northern Samar') { echo 'selected'; } ?>>Northern Samar</option>
                                    <option value="Nueva Ecija" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Nueva Ecija') { echo 'selected'; } ?>>Nueva Ecija</option>
                                    <option value="Nueva Vizcaya" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Nueva Vizcaya') { echo 'selected'; } ?>>Nueva Vizcaya</option>
                                    <option value="Occidental Mindoro" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Occidental Mindoro') { echo 'selected'; } ?>>Occidental Mindoro</option>
                                    <option value="Oriental Mindoro" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Oriental Mindoro') { echo 'selected'; } ?>>Oriental Mindoro</option>
                                    <option value="Palawan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Palawan') { echo 'selected'; } ?>>Palawan</option>
                                    <option value="Pampanga" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Pampanga') { echo 'selected'; } ?>>Pampanga</option>
                                    <option value="Pangasinan" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Pangasinan') { echo 'selected'; } ?>>Pangasinan</option>
                                    <option value="Quezon" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Quezon') { echo 'selected'; } ?>>Quezon</option>
                                    <option value="Quirino" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Quirino') { echo 'selected'; } ?>>Quirino</option>
                                    <option value="Rizal" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Rizal') { echo 'selected'; } ?>>Rizal</option>
                                    <option value="Romblon" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Romblon') { echo 'selected'; } ?>>Romblon</option>
                                    <option value="Samar" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Samar') { echo 'selected'; } ?>>Samar</option>
                                    <option value="Sarangani" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Sarangani') { echo 'selected'; } ?>>Sarangani</option>
                                    <option value="Siquijor" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Siquijor') { echo 'selected'; } ?>>Siquijor</option>
                                    <option value="Sorsogon" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Sorsogon') { echo 'selected'; } ?>>Sorsogon</option>
                                    <option value="South Cotabato" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'South Cotabato') { echo 'selected'; } ?>>South Cotabato</option>
                                    <option value="Southern Leyte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Southern Leyte') { echo 'selected'; } ?>>Southern Leyte</option>
                                    <option value="Sultan Kudarat" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Sultan Kudarat') { echo 'selected'; } ?>>Sultan Kudarat</option>
                                    <option value="Sulu" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Sulu') { echo 'selected'; } ?>>Sulu</option>
                                    <option value="Surigao del Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Surigao del Norte') { echo 'selected'; } ?>>Surigao del Norte</option>
                                    <option value="Surigao del Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Surigao del Sur') { echo 'selected'; } ?>>Surigao del Sur</option>
                                    <option value="Tarlac" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Tarlac') { echo 'selected'; } ?>>Tarlac</option>
                                    <option value="Tawi-Tawi" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Tawi-Tawi') { echo 'selected'; } ?>>Tawi-Tawi</option>
                                    <option value="Zambales" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Zambales') { echo 'selected'; } ?>>Zambales</option>
                                    <option value="Zamboanga del Norte" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Zamboanga del Norte') { echo 'selected'; } ?>>Zamboanga del Norte</option>
                                    <option value="Zamboanga del Sur" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Zamboanga del Sur') { echo 'selected'; } ?>>Zamboanga del Sur</option>
                                    <option value="Zamboanga Sibugay" <?php if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == 'Zamboanga Sibugay') { echo 'selected'; } ?>>Zamboanga Sibugay</option>
                                </select>
                                <?php
                                    if(isset($_POST['eventProvince']) && !validate_field($_POST['eventProvince'])){
                                ?>
                                        <p class="text-danger my-1">Select a province</p>
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="input-group flex-column mb-3">
                                <label for="eventCity" class="label ps-2">City</label>
                                <input type="text" name="eventCity" id="eventCity" class="input-1" placeholder="Enter City" required value="<?php if(isset($_POST['eventCity'])) { echo $_POST['eventCity']; } ?>">
                                <?php
                                    if(isset($_POST['eventCity']) && !validate_field($_POST['eventCity'])){
                                ?>
                                        <p class="text-danger my-1">City is required</p>
                                <?php
                                    }
                                ?>
                            </div>

                            <div class="input-group flex-column mb-3">
                                <label for="eventBarangay" class="label ps-2">Barangay</label>
                                <input type="text" name="eventBarangay" id="eventBarangay" class="input-1" placeholder="Enter Barangay" required value="<?php if(isset($_POST['eventBarangay'])) { echo $_POST['eventBarangay']; } ?>">
                                <?php
                                if(isset($_POST['eventBarangay']) && !validate_field($_POST['eventBarangay'])){
                                    ?>
                                    <p class="text-danger my-1">Barangay is required</p>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="eventStreetName" class="label-2">Street Name</label>
                                    <input type="text" name="eventStreetName" id="eventStreetName" class="input-1 col-lg-12" placeholder="Street Name" required value="<?php if(isset($_POST['eventStreetName'])) { echo $_POST['eventStreetName']; } ?>">
                                    <?php
                                    if(isset($_POST['eventStreetName']) && !validate_field($_POST['eventStreetName'])){
                                        ?>
                                        <p class="text-danger my-1">Street Name is required</p>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="col-6">
                                    <label for="eventBuildingName" class="label-2">Building Name</label>
                                    <input type="text" name="eventBuildingName" id="eventBuildingName" class="input-1 col-lg-12" placeholder="Building Name" value="<?php if(isset($_POST['eventBuildingName'])) { echo $_POST['eventBuildingName']; } ?>">
                                </div>
                            </div>

                        </div>

                        <div class="input-group flex-column mb-3 my-2">
                            <label for="eventZipCode" class="label">Zip Code</label>
                            <input type="number" name="eventZipCode" id="eventZipCode" class="input-1" placeholder="Enter Zip Code" required value="<?php if(isset($_POST['eventZipCode'])) { echo $_POST['eventZipCode']; } ?>">
                            <?php
                            if(isset($_POST['eventZipCode']) && !validate_field($_POST['eventZipCode'])){
                                ?>
                                <p class="text-danger my-1">Zip Code is required</p>
                                <?php
                            }
                            ?>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="organizationClubID" class="label">Collaboration with</label>

                                <?php
                                $approvedOrganizationClubs = $event->getApprovedOrganizationClubs(); // Assuming you have a method to fetch approved organization clubs
                                if (empty($approvedOrganizationClubs)) {
                                    echo '<p>No affiliated organizations or clubs.</p>';
                                } else {
                                    foreach ($approvedOrganizationClubs as $organizationClub) {
                                        echo '<div class="checkbox-container d-flex align-items-center my-1">
                                                <input type="checkbox" class="form-check-input" name="organizationClubIDs[]" id="orgClub' . $organizationClub['organizationClubID'] . '" value="' . $organizationClub['organizationClubID'] . '">
                                                <label class="form-check-label" for="orgClub' . $organizationClub['organizationClubID'] . '">' . $organizationClub['ocName'] . '</label>
                                            </div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
<!-- 
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                            <label for="eventStatus" class="label mb-2">Status</label>
                            <div class="d-flex">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="statusUpcoming" name="eventStatus" value="Upcoming" <?php if(isset($_POST['eventStatus']) && $_POST['eventStatus'] == 'Upcoming') { echo 'checked'; } ?>>
                                    <label class="form-check-label" for="statusUpcoming">Upcoming</label>
                                </div>
                                <div class="form-check ms-3">
                                    <input type="radio" class="form-check-input" id="statusOngoing" name="eventStatus" value="Ongoing" <?php if(isset($_POST['eventStatus']) && $_POST['eventStatus'] == 'Ongoing') { echo 'checked'; } ?>>
                                    <label class="form-check-label" for="statusOngoing">Ongoing</label>
                                </div>
                                <div class="form-check ms-3">
                                    <input type="radio" class="form-check-input" id="statusCompleted" name="eventStatus" value="Completed" <?php if(isset($_POST['eventStatus']) && $_POST['eventStatus'] == 'Completed') { echo 'checked'; } ?>>
                                    <label class="form-check-label" for="statusCompleted">Completed</label>
                                </div>
                            </div>
                            <?php
                                if((!isset($_POST['eventStatus']) && isset($_POST['save'])) || (isset($_POST['eventStatus']) && !validate_field($_POST['eventStatus']))){
                            ?>
                                    <p class="text-danger my-1">Select event status</p>
                            <?php
                                }
                            ?>
                            </div>
                        </div> -->

                        <!-- Registration Form Modal Button -->
                        <!-- <div class="row d-flex justify-content-center my-1">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventRegistrationForm">
                                Create Registration Form?
                            </button>
                        </div> -->
                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn add-btn-2 mb-3 me-4">Add Event</button>
                        </div>
                    </form>
                    </div>
                    </div>
                </div>
                <script>
                        $(document).ready(function() {
                            const regions = {
                                "Region I": ["Ilocos Norte", "Ilocos Sur", "La Union", "Pangasinan"],
                                "Region II": ["Batanes", "Cagayan", "Isabela", "Nueva Vizcaya", "Quirino"],
                                "Region III": ["Aurora", "Bataan", "Bulacan", "Nueva Ecija", "Pampanga", "Tarlac", "Zambales"],
                                "Region IV": ["Batangas", "Cavite", "Laguna", "Quezon", "Rizal"],
                                "Region V": ["Albay", "Camarines Norte", "Camarines Sur", "Catanduanes", "Masbate", "Sorsogon"],
                                "Region VI": ["Aklan", "Antique", "Capiz", "Guimaras", "Iloilo", "Negros Occidental"],
                                "Region VII": ["Bohol", "Cebu", "Negros Oriental", "Siquijor"],
                                "Region VIII": ["Biliran", "Eastern Samar", "Leyte", "Northern Samar", "Samar", "Southern Leyte"],
                                "Region IX": ["Zamboanga del Norte", "Zamboanga del Sur", "Zamboanga Sibugay"],
                                "Region X": ["Bukidnon", "Camiguin", "Lanao del Norte", "Misamis Occidental", "Misamis Oriental"],
                                "Region XI": ["Davao de Oro", "Davao del Norte", "Davao del Sur", "Davao Occidental", "Davao Oriental"],
                                "Region XII": ["North Cotabato", "Sarangani", "South Cotabato", "Sultan Kudarat"],
                                "Region XIII": ["Agusan del Norte", "Agusan del Sur", "Surigao del Norte", "Surigao del Sur", "Dinagat Islands"],
                                "MIMAROPA": ["Marinduque", "Occidental Mindoro", "Oriental Mindoro", "Palawan"],
                                "CAR": ["Abra", "Apayao", "Benguet", "Ifugao", "Kalinga", "Mountain Province"],
                                "NCR": ["Manila", "Caloocan", "Las Piñas", "Makati", "Malabon", "Mandaluyong", "Marikina", "Muntinlupa", "Navotas", "Parañaque", "Pasay", "Pasig", "Quezon City", "San Juan", "Taguig", "Valenzuela", "Pateros"],
                                "BARMM": ["Basilan", "Lanao del Sur", "Maguindanao", "Sulu", "Tawi-Tawi"]
                            };

                            $('#eventRegion').change(function() {
                                const selectedRegion = $(this).val();
                                const provinces = regions[selectedRegion] || [];

                                $('#eventProvince').empty().append($('<option>', { value: '', text: 'Select Province' }));

                                if (provinces.length > 0) {
                                    provinces.forEach(function(eventProvince) {
                                        $('#eventProvince').append($('<option>', { value: eventProvince, text: eventProvince }));
                                    });

                                    $('#eventProvince').prop('disabled', false);
                                } else {
                                    $('#eventProvince').prop('disabled', true);
                                }
                            });

                        });
                </script>
                    <script>
                        function validateForm() {
                            var selectedLibrarians = document.querySelectorAll('input[name="librarianIDs[]"]:checked');
                            if (selectedLibrarians.length === 0) {
                                alert('Please select at least one event facilitator.');
                                return false; // Prevent form submission
                            }
                            return true; // Allow form submission
                        }
                    </script>
                </div>

    <?php require_once('../include/js.php'); ?>

</body>
</html>