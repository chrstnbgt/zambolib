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

$events = new Events();
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
            'librarianIDs' => isset($record['librarianIDs']) ? explode(',', $record['librarianIDs']) : []
        ];
    } else {
        // Handle the case when the event ID is not found in the database
        echo "Event not found";
        exit;
    }
} else {
    // Set default values for $event when it's not set
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
        'librarianIDs' => []
    ];
}

if (isset($_POST['save'])) {
    // Sanitize
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
    $events->librarianIDs = $selectedLibrarianIDs;

    // Validate
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

        if ($events->edit($eventID, $eventTitle, $eventDescription, $eventStartDate, $eventEndDate, $eventStartTime, $eventEndTime, $eventGuestLimit, $eventRegion, $eventProvince, $eventCity, $eventBarangay, $eventStreetName, $eventBuildingName, $eventZipCode, $eventStatus)) {
            $eventID = $events->eventID;
            $conn = $events->db->connect();
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
                                    echo '<input type="checkbox" name="librarianIDs[]" value="' . $librarian['librarianID'] . '" ' . $isChecked . '> ' . $librarian['librarianFirstName'] . ' ' . $librarian['librarianLastName'] . ' <br>';
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
                                        <input type="date" name="eventStartDate" id="eventStartDate" class="input-1 col-lg-12" placeholder="From" required value="<?php echo isset($event) ? $event['eventStartDate'] : ''; ?>">
                                    </div>

                                    <div class="col-6">
                                        <label for="eventEndDate" class="label-2">End Date</label>
                                        <input type="date" name="eventEndDate" id="eventEndDate" class="input-1 col-lg-12" placeholder="To" required value="<?php echo isset($event) ? $event['eventEndDate'] : ''; ?>">
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
                                        <input type="time" name="eventStartTime" id="eventStartTime" class="input-1 col-lg-12" placeholder="From" required value="<?php echo isset($event) ? $event['eventStartTime'] : ''; ?>">
                                    </div>

                                    <div class="col-6">
                                        <label for="eventEndTime" class="label-2">End Time</label>
                                        <input type="time" name="eventEndTime" id="eventEndTime" class="input-1 col-lg-12" placeholder="To" required value="<?php echo isset($event) ? $event['eventEndTime'] : ''; ?>">
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="guestLimit" class="label">Guest Limit</label>
                                <input type="number" name="guestLimit" id="guestLimit" class="input-1" required value="<?php echo isset($event) ? $event['eventGuestLimit'] : ''; ?>">
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
                            <label for="place" class="label">Place of Event</label>
                            <div class="input-group flex-column mb-3">
                                <label for="eventRegion" class="label ps-2">Region</label>
                                <select name="eventRegion" id="eventRegion" class="input-1">
                                    <option value="">Select Region</option>
                                    <?php
                                    $regions = ['Region I', 'Region II', 'Region III', 'Region IV', 'Region V', 'Region VI', 'Region VII', 'Region VIII', 'Region IX', 'Region X', 'Region XI', 'Region XII', 'Region XIII', 'MIMAROPA', 'NCR', 'CAR', 'BARMM'];
                                    foreach ($regions as $region) {
                                        echo '<option value="' . $region . '"';
                                        if(isset($_POST['eventRegion']) && $_POST['eventRegion'] == $region) { echo ' selected'; }
                                        else if(isset($event['eventRegion']) && $event['eventRegion'] == $region) { echo ' selected'; }
                                        echo '>' . $region . '</option>';
                                    }
                                    ?>
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
                                <select name="eventProvince" id="eventProvince" class="input-1" >
                                    <option value="">Select Province</option>
                                    <?php
                                    $provinces = ['Abra', 'Agusan del Norte', 'Agusan del Sur', 'Aklan', 'Albay', 'Antique', 'Apayao', 'Aurora', 'Basilan', 'Bataan', 'Batanes', 'Batangas', 'Benguet', 'Biliran', 'Bohol', 'Bukidnon', 'Bulacan', 'Cagayan', 'Camarines Norte', 'Camarines Sur', 'Camiguin', 'Capiz', 'Catanduanes', 'Cavite', 'Cebu', 'Cotabato', 'Davao de Oro (Compostela Valley)', 'Davao del Norte', 'Davao del Sur', 'Davao Occidental', 'Davao Oriental', 'Dinagat Islands', 'Eastern Samar', 'Guimaras', 'Ifugao', 'Ilocos Norte', 'Ilocos Sur', 'Iloilo', 'Isabela', 'Kalinga', 'La Union', 'Laguna', 'Lanao del Norte', 'Lanao del Sur', 'Leyte', 'Maguindanao del Norte (partitioned recently from Maguindanao)', 'Maguindanao del Sur (partitioned recently from Maguindanao)', 'Marinduque', 'Masbate', 'Misamis Occidental', 'Misamis Oriental', 'Mountain Province', 'Negros Occidental', 'Negros Oriental', 'Northern Samar', 'Nueva Ecija', 'Nueva Vizcaya', 'Occidental Mindoro', 'Oriental Mindoro', 'Palawan', 'Pampanga', 'Pangasinan', 'Quezon', 'Quirino', 'Rizal', 'Romblon', 'Samar', 'Sarangani', 'Siquijor', 'Sorsogon', 'South Cotabato', 'Southern Leyte', 'Sultan Kudarat', 'Sulu', 'Surigao del Norte', 'Surigao del Sur', 'Tarlac', 'Tawi-Tawi', 'Zambales', 'Zamboanga del Norte', 'Zamboanga del Sur', 'Zamboanga Sibugay'];
                                    foreach ($provinces as $province) {
                                        echo '<option value="' . $province . '"';
                                        if(isset($_POST['eventProvince']) && $_POST['eventProvince'] == $province) { echo ' selected'; }
                                        else if(isset($event['eventProvince']) && $event['eventProvince'] == $province) { echo ' selected'; }
                                        echo '>' . $province . '</option>';
                                    }
                                    ?>
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
                                <input type="text" name="eventCity" id="eventCity" class="input-1" required value="<?php echo isset($event) ? $event['eventCity'] : '';?>">
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
                                <input type="text" name="eventBarangay" id="eventBarangay" class="input-1" required value="<?php echo isset($event) ? $event['eventBarangay'] : '';?>">
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
                                    <input type="text" name="eventStreetName" id="eventStreetName" class="input-1 col-lg-12" required value="<?php echo isset($event) ? $event['eventStreetName'] : ''; ?>">
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
                                    <input type="text" name="eventBuildingName" id="eventBuildingName" class="input-1 col-lg-12" placeholder="Optional" value="<?php echo isset($event) ? $event['eventBuildingName'] : '';?>">
                                </div>
                            </div>

                        </div>

                        <div class="input-group flex-column mb-3 my-2">
                            <label for="eventZipCode" class="label">Zip Code</label>
                            <input type="number" name="eventZipCode" id="eventZipCode" class="input-1" required value="<?php echo isset($event) ? $event['eventZipCode'] : '';?>">
                            <?php
                            if(isset($_POST['eventZipCode']) && !validate_field($_POST['eventZipCode'])){
                                ?>
                                <p class="text-danger my-1">Zip Code is required</p>
                                <?php
                            }
                            ?>
                        </div>

                        <!-- <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="description" class="label">Collaboration with</label>

                                <div class="checkbox-container d-flex align-items-center my-1">
                                    <label class="cyberpunk-checkbox-label">
                                    <input type="checkbox" class="cyberpunk-checkbox librarian-name-checkbox ms-2">None</label>
                                </div>

                                <div class="checkbox-container d-flex align-items-center my-1">
                                    <label class="cyberpunk-checkbox-label">
                                    <input type="checkbox" class="cyberpunk-checkbox librarian-name-checkbox ms-2">Department of Information, Communications, and Technology</label>
                                </div>

                                <div class="checkbox-container d-flex align-items-center my-1">
                                    <label class="cyberpunk-checkbox-label">
                                    <input type="checkbox" class="cyberpunk-checkbox librarian-name-checkbox ms-2">Bookworm Club</label>
                                </div>
                            </div>
                        </div> -->

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                            <label for="eventStatus" class="label mb-2">Status</label>
                                <div class="d-flex justify-content-center">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="statusUpcoming" name="eventStatus" value="Upcoming" <?php echo isset($event) && $event['eventStatus'] == 'Upcoming' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="statusUpcoming">Upcoming</label>
                                    </div>
                                    <div class="form-check ms-3">
                                        <input type="radio" class="form-check-input" id="statusOngoing" name="eventStatus" value="Ongoing" <?php echo isset($event) && $event['eventStatus'] == 'Ongoing' ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="statusOngoing">Ongoing</label>
                                    </div>
                                    <div class="form-check ms-3">
                                        <input type="radio" class="form-check-input" id="statusCompleted" name="eventStatus" value="Completed" <?php echo isset($event) && $event['eventStatus'] == 'Completed' ? 'checked' : ''; ?>>
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
                        </div>

                        <!-- Registration Form Modal Button -->
                        <div class="row d-flex justify-content-center my-1">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventRegistrationForm">
                                Update Registration Form?
                            </button>
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