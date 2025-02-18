<?php

require_once '../classes/clubs.class.php';
require_once '../classes/librarian.class.php';
require_once '../tools/adminfunctions.php';

// Resume session here to fetch session values
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    header('location: ./index.php');
}

// Initialize Clubs and Librarian objects
$clubs = new Clubs();
$librarian = new Librarian();
$librarians = $librarian->getAvailableLibrarian();

// Check if the form is submitted for club editing
if (isset($_POST['save'])) {
    $clubs->clubName = htmlentities($_POST['clubName']);
    $clubs->clubDescription = htmlentities($_POST['clubDescription']);
    $clubs->clubMinAge = htmlentities($_POST['clubMinAge']);
    $clubs->clubMaxAge = htmlentities($_POST['clubMaxAge']);

    // Retrieve selected librarian IDs from the form
    $selectedLibrarianIDs = isset($_POST['librarianIDs']) ? $_POST['librarianIDs'] : [];
    $clubs->librarianIDs = $selectedLibrarianIDs;

    // Validate club fields
    if (validate_field($clubs->clubName) &&
        validate_field($clubs->clubDescription) &&
        validate_field($clubs->clubMinAge) &&
        validate_field($clubs->clubMaxAge)) {

        // Get the club ID from the URL
        $clubID = $_GET['id'];

        // Edit the club in the database
        if ($clubs->edit($clubID, $clubs->clubName, $clubs->clubDescription, $clubs->librarianIDs, $clubs->clubMinAge, $clubs->clubMaxAge)) {
            header('location: ../webpages/clubs.php');
            exit;
        } else {
            echo 'An error occurred while updating the club in the database.';
        }
    }
}

// Get the club details for editing
if (isset($_GET['id'])) {
    $record = $clubs->fetch($_GET['id']);
    if ($record) {
        $club = [
            'clubID' => $record['clubID'],
            'clubName' => $record['clubName'],
            'clubDescription' => $record['clubDescription'],
            'clubMinAge' => $record['clubMinAge'],
            'clubMaxAge' => $record['clubMaxAge'],
            'librarianIDs' => isset($record['librarianIDs']) ? explode(',', $record['librarianIDs']) : []
        ];
    } else {
        // Handle the case when the club ID is not found in the database
        echo "Club not found";
        exit;
    }
} else {
    // Set default values for $club when it's not set
    $club = [
        'clubID' => isset($_GET['id']) ? $_GET['id'] : '',
        'clubName' => '',
        'clubDescription' => '',
        'clubMinAge' => '',
        'clubMaxAge' => '',
        'librarianIDs' => []
    ];
}

// Get the club details for editing
if (isset($_GET['id'])) {
    $record = $clubs->fetch($_GET['id']);
    if ($record) {
        $club = [
            'clubID' => $record['clubID'],
            'clubName' => $record['clubName'],
            'clubDescription' => $record['clubDescription'],
            'clubMinAge' => $record['clubMinAge'],
            'clubMaxAge' => $record['clubMaxAge'],
            'librarianIDs' => isset($record['librarianIDs']) ? explode(',', $record['librarianIDs']) : [] // Set default value to an empty array
        ];
    } else {
        // Handle the case when the club ID is not found in the database
        echo "Club not found";
        exit;
    }
} else {
    // Set default values for $club when it's not set
    $club = [
        'clubID' => isset($_GET['id']) ? $_GET['id'] : '',
        'clubName' => '',
        'clubDescription' => '',
        'clubMinAge' => '',
        'clubMaxAge' => '',
        'librarianIDs' => [] // Set default value to an empty array
    ];
}


?>
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Clubs';
  $clubs = 'active-1';
  require_once('../include/head.php');
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
            
            <!-- Edit Club Modal -->
            <div class="container mt-4">
                    <div class="header-modal d-flex justify-content-between">
                        <h5 class="modal-title mt-4 ms-4" id="editClubModalLabel">Edit Club</h5>
                        
                    </div>
                    <div class="modal-body mx-2 mt-2">
                    <form method="post" action="../forms/edit-club.php?id=<?php echo $club['clubID']; ?>" id="clubForm" onsubmit="return validateForm()">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="clubName" class="label">Club Name</label>
                                <input type="text" name="clubName" id="clubName" class="input-1" required value="<?php echo $club['clubName']; ?>">
                                <?php
                                $new_club = new Clubs();
                                if(isset($_POST['clubName'])){
                                    $new_club->clubName = htmlentities($_POST['clubName']);
                                }else{
                                    $new_club->clubName = '';
                                }

                                if(isset($_POST['clubName']) && validate_clubname($_POST['clubName']) != 'success'){
                                    ?>
                                    <p class="text-danger my-1"><?php echo validate_clubname($_POST['clubName']) ?></p>
                                    <?php
                                }else if ($new_club->is_name_exist() && $_POST['clubName'] != $club['clubName']){
                                    ?>
                                    <p class="text-danger my-1">Club name already exists</p>
                                    <?php
                                    // Set the club name to the submitted value if it already exists
                                    $club['clubName'] = $_POST['clubName'];
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="clubDescription" class="label">Description</label>
                                <input type="text" id="clubDescription" name="clubDescription" class="input-1" rows="4" cols="50" required value="<?php echo $club['clubDescription']; ?>">
                                <?php if (isset($_POST['clubDescription']) && !validate_field($_POST['clubDescription'])) : ?>
                                    <p class="text-danger my-1">Club description is required</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianID" class="label">Select Club Manager/s</label>
                                <br>
                                <?php
                                foreach ($librarians as $librarian) {
                                    $checked = in_array($librarian['librarianID'], $club['librarianIDs']) ? 'checked' : '';
                                    echo '<div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="librarianIDs[]" id="librarian' . $librarian['librarianID'] . '" value="' . $librarian['librarianID'] . '" ' . $checked . '>
                                            <label class="form-check-label" for="librarian' . $librarian['librarianID'] . '">' . $librarian['librarianFirstName'] . ' ' . $librarian['librarianLastName'] . '</label>
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="ageRange" class="label">Age Range</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="clubMinAge" class="label-2">Minimum</label>
                                        <input type="number" name="clubMinAge" id="clubMinAge" class="input-1" required value="<?php echo $club['clubMinAge']; ?>">
                                        <?php if (isset($_POST['clubMinAge']) && !validate_field($_POST['clubMinAge'])) : ?>
                                            <p class="text-danger my-1">Minimum age is required</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="clubMaxAge" class="label-2">Maximum</label>
                                        <input type="number" name="clubMaxAge" id="ageRanclubMaxAgegeMax" class="input-1" required value="<?php echo $club['clubMaxAge']; ?>">
                                        <?php if (isset($_POST['clubMaxAge']) && !validate_field($_POST['clubMaxAge'])) : ?>
                                            <p class="text-danger my-1">Maximum age is required</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn add-btn-2 mb-3 me-4">Update Club</button>
                        </div>

                    </form>
                    </div>
                    </div>
                </div>
                <script>
                    function validateForm() {
                        var selectedLibrarians = document.querySelectorAll('input[name="librarianIDs[]"]:checked');
                        if (selectedLibrarians.length === 0) {
                            alert('Please select at least one club manager.');
                            return false; // Prevent form submission
                        }
                        return true; // Allow form submission
                    }
                </script>
                </div>

    <?php require_once('../include/js.php'); ?>

</body>