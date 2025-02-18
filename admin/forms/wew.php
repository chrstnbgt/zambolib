<?php
require_once '../classes/events.class.php';
require_once '../classes/librarian.class.php';
require_once '../tools/adminfunctions.php';

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    header('location: ./index.php');
}

$events = new Events();
$organizationClubs = $events->getApprovedOrganizationClubs();
$librarian = new Librarian();
$librarians = $librarian->getAvailablelibrarian();

if (isset($_GET['id'])) {
    $record = $events->fetch($_GET['id']);
    if ($record) {
        $event = [
            'eventID' => $record['eventID'],
            'eventTitle' => $record['eventTitle'],
            'eventDescription' => $record['eventDescription'],
            'eventStartDate' => $record['eventStartDate'],
            'eventEndDate' => $record['eventEndDate'],
            'eventStartTime' => $record['eventStartTime'],
            'eventEndTime' => $record['eventEndTime'],
            'eventGuestLimit' => $record['eventGuestLimit'],
            'eventRegion' => $record['eventRegion'],
            'eventProvince' => $record['eventProvince'],
            'eventCity' => $record['eventCity'],
            'eventBarangay' => $record['eventBarangay'],
            'eventStreetName' => $record['eventStreetName'],
            'eventBuildingName' => $record['eventBuildingName'],
            'eventZipCode' => $record['eventZipCode'],
            'eventStatus' => $record['eventStatus'],
            'librarianIDs' => isset($record['librarianIDs']) ? explode(',', $record['librarianIDs']) : [],
            'organizationClubIDs' => isset($record['organizationClubIDs']) ? explode(',', $record['organizationClubIDs']) : []
        ];
    } else {
        echo "Event not found";
        exit;
    }
} else {
    $event = [
        'eventID' => isset($_GET['id']) ? $_GET['id'] : '',
        'eventTitle' => '',
        'eventDescription' => '',
        'eventStartDate' => '',
        'eventEndDate' => '',
        'eventStartTime' => '',
        'eventEndTime' => '',
        'eventGuestLimit' => '',
        'eventRegion' => '',
        'eventProvince' => '',
        'eventCity' => '',
        'eventBarangay' => '',
        'eventStreetName' => '',
        'eventBuildingName' => '',
        'eventZipCode' => '',
        'eventStatus' => '',
        'librarianIDs' => [],
        'organizationClubIDs' => []
    ];
}

if (isset($_POST['save'])) {
    $eventID = $_GET['id'];
    $eventTitle = htmlentities($_POST['eventTitle']);
    $eventDescription = htmlentities($_POST['eventDescription']);
    $eventStartDate = htmlentities($_POST['eventStartDate']);
    $eventEndDate = htmlentities($_POST['eventEndDate']);
    $eventStartTime = htmlentities($_POST['eventStartTime']);
    $eventEndTime = htmlentities($_POST['eventEndTime']);
    $eventGuestLimit = htmlentities($_POST['eventGuestLimit']);
    $eventRegion = htmlentities($_POST['eventRegion']);
    $eventProvince = htmlentities($_POST['eventProvince']);
    $eventCity = htmlentities($_POST['eventCity']);
    $eventBarangay = htmlentities($_POST['eventBarangay']);
    $eventStreetName = htmlentities($_POST['eventStreetName']);
    $eventBuildingName = htmlentities($_POST['eventBuildingName']);
    $eventZipCode = htmlentities($_POST['eventZipCode']);
    $eventStatus = htmlentities($_POST['eventStatus']);

    $selectedLibrarianIDs = isset($_POST['librarianIDs']) ? $_POST['librarianIDs'] : [];
    $selectedOrganizationClubIDs = isset($_POST['organizationClubIDs']) ? $_POST['organizationClubIDs'] : [];

    if (validate_field($eventTitle) &&
        validate_field($eventDescription) &&
        validate_field($eventStartDate) &&
        validate_field($eventEndDate) &&
        validate_field($eventStartTime) &&
        validate_field($eventEndTime) &&
        validate_field($eventGuestLimit) &&
        validate_field($eventRegion) &&
        validate_field($eventProvince) &&
        validate_field($eventCity) &&
        validate_field($eventBarangay) &&
        validate_field($eventStreetName) &&
        validate_field($eventZipCode) &&
        validate_field($eventStatus)) {

        if ($events->edit($eventID, $eventTitle, $eventDescription, $selectedLibrarianIDs, $selectedOrganizationClubIDs, $eventStartDate, $eventEndDate, $eventStartTime, $eventEndTime, $eventGuestLimit, $eventRegion, $eventProvince, $eventCity, $eventBarangay, $eventStreetName, $eventBuildingName, $eventZipCode, $eventStatus)) {
            header('location: ../webpages/events.php');
        } else {
            echo 'An error occurred while editing event in the database.';
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
                
                <!-- Edit Event Modal -->
                <div class="container mt-4" id="editEvent">
                        <h5 class="modal-title mt-4" id="editEventModalLabel">Edit Event</h5>
                        
                    </div>
                    <div class="modal-body mx-2 mt-2">
                    <form method="post" action="../forms/edit-event.php?id=<?php echo $event['eventID']; ?>" id="clubForm" onsubmit="return validateForm()">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventTitle" class="label">Event Title</label>
                                <input type="text" name="eventTitle" id="eventTitle" class="input-1" required value="<?php echo isset($event) ? $event['eventTitle'] : ''; ?>">
                                <?php if(isset($_POST['eventTitle']) && !validate_field($_POST['eventTitle'])) : ?>
                                    <p class="text-danger my-1">Event title is required</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventDescription" class="label">Description</label>
                                <input type="text" id="eventDescription" name="eventDescription" class="input-1" rows="4" cols="50" required value="<?php echo isset($event) ? $event['eventDescription'] : ''; ?>">
                                <?php if(isset($_POST['eventDescription']) && !validate_field($_POST['eventDescription'])) : ?>
                                    <p class="text-danger my-1">Event description is required</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianID" class="label">Select Event Facilitators/s</label>
                                <br>
                                <?php
                                foreach ($librarians as $librarian) {
                                    $isChecked = is_array($event['librarianIDs']) && in_array($librarian['librarianID'], $event['librarianIDs']) ? 'checked' : '';
                                    echo '<div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="librarianIDs[]" id="librarian' . $librarian['librarianID'] . '" value="' . $librarian['librarianID'] . '" ' . $isChecked . '>
                                            <label class="form-check-label" for="librarian' . $librarian['librarianID'] . '">' . $librarian['librarianFirstName'] . ' ' . $librarian['librarianLastName'] . '</label>
                                        </div>';
                                }                           
                                ?>
                            </div>
                        </div>

                        <!-- other fields -->

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="organizationClubID" class="label">Collaboration with</label>
                                <br>
                                <?php
                                foreach ($organizationClubs as $events) {
                                    $isChecked = is_array($event['organizationClubIDs']) && in_array($events['organizationClubID'], $event['organizationClubIDs']) ? 'checked' : '';
                                    echo '<div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="organizationClubIDs[]" id="organizationClub' . $events['organizationClubID'] . '" value="' . $events['organizationClubID'] . '" ' . $isChecked . '>
                                            <label class="form-check-label" for="organizationClub' . $events['organizationClubID'] . '">' . $events['organizationClubName'] . '</label>
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn add-btn-2 mb-3 me-4">Update Event</button>
                        </div>
                    </form>
                    </div>

                    </div>
                </div>
                </div>
                
            <?php require_once('../include/js.php'); ?>
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
</body>
</html>