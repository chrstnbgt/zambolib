<?php 
require_once '../classes/clubs.class.php';
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

if (isset($_POST['save'])) {
    $clubs = new Clubs();
    $clubs->clubName = htmlentities($_POST['clubName']);
    $clubs->clubDescription = htmlentities($_POST['clubDescription']);
    $clubs->clubMinAge = htmlentities($_POST['clubMinAge']);
    $clubs->clubMaxAge = htmlentities($_POST['clubMaxAge']);

    // Check if clubMinAge is smaller than clubMaxAge
    if ($clubs->clubMinAge > $clubs->clubMaxAge) {
        $errorMsg = 'Minimum age must be smaller than or equal to maximum age.';
    } else {
        // Retrieve selected librarian IDs from the form
        $selectedLibrarianIDs = isset($_POST['librarianIDs']) ? $_POST['librarianIDs'] : [];
        $clubs->librarianIDs = $selectedLibrarianIDs;

        if (validate_field($clubs->clubName) &&
            validate_field($clubs->clubDescription) &&
            validate_field($clubs->clubMinAge) &&
            validate_field($clubs->clubMaxAge) &&
            validate_clubname($clubs->clubName) && !$clubs->is_name_exist()) {
            
            if (!$clubs->is_name_exist()) {
                if ($clubs->add()) {
                    header('location: ../webpages/clubs.php');
                    exit; // Stop further execution
                } else {
                    $errorMsg = 'An error occurred while adding club in the database.';
                }
            } else {
                $errorMsg = 'Club name already exists';
            }
        }
    }

}

$librarian = new Librarian();
$librarians = $librarian->getAvailablelibrarian();
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
                
                <div class="container mt-4">
                    <div class="header d-flex justify-content-between">
                        <h5 class="modal-title mt-4 ms-2 my-4" id="addClubModalLabel">Add New Club</h5>
                        
                    </div>
                    <div class="modal-body mt-2">
                    
                    <form method="post" action="" id="addClubForm" onsubmit="return validateForm()">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="clubName" class="label">Club Name</label>
                                <input type="text" name="clubName" id="clubName" class="input-1" placeholder="Name of the Club" required value="<?php if(isset($_POST['clubName'])) { echo $_POST['clubName']; } ?>">
                                <?php
                                    $new_club = new Clubs();
                                    if(isset($_POST['clubName'])){
                                            $new_club->clubName = htmlentities($_POST['clubName']);
                                    }else{
                                            $new_club->clubName = '';
                                    }

                                    if(isset($_POST['clubName']) && strcmp(validate_clubname($_POST['clubName']), 'success') != 0){
                                ?>
                                        <p class="text-danger my-1"><?php echo validate_clubname($_POST['clubName']) ?></p>
                                <?php
                                    }else if ($new_club->is_name_exist() && $_POST['clubName']){
                                ?>
                                        <p class="text-danger my-1">Club name already exists</p>
                                <?php      
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="clubDescription" class="label">Description</label>
                                <input type="text" id="clubDescription" name="clubDescription" class="input-1" rows="4" cols="50" placeholder="Write brief description" required value="<?php if(isset($_POST['clubDescription'])) { echo $_POST['clubDescription']; } ?>">
                                <?php
                                if(isset($_POST['clubDescription']) && !validate_field($_POST['clubDescription'])){
                                    ?>
                                    <p class="text-danger my-1">Club description is required</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianID" class="label">Select Club Manager/s</label>
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
                                <label for="ageRange" class="label">Age Range</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="clubMinAge" class="label-2">Minimum</label>
                                        <input type="number" name="clubMinAge" id="clubMinAge" class="input-1 col-lg-12" placeholder="Min" required value="<?php if(isset($_POST['clubMinAge'])) { echo $_POST['clubMinAge']; } ?>">
                                        <?php
                                        if(isset($_POST['clubMinAge']) && !validate_field($_POST['clubMinAge'])){
                                            ?>
                                            <p class="text-danger my-1">Minimum age is required</p>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="clubMaxAge" class="label-2">Maximum</label>
                                        <input type="number" name="clubMaxAge" id="clubMaxAge" class="input-1 col-lg-12" placeholder="Max" required value="<?php if(isset($_POST['clubMaxAge'])) { echo $_POST['clubMaxAge']; } ?>">
                                        <?php
                                        if(isset($_POST['clubMaxAge']) && !validate_field($_POST['clubMaxAge'])){
                                            ?>
                                            <p class="text-danger my-1">Maximum age is required</p>
                                        <?php
                                        }
                                        if (isset($errorMsg)) {
                                            ?>
                                            <p class="text-danger my-1"><?php echo $errorMsg; ?></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn add-btn-2 mb-3 me-4" id="addClubButton">Add Club</button>
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
</html>
