<?php
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

$librarian = new Librarian();

if (isset($_GET['id'])) {
    $record = $librarian->fetch($_GET['id']);
    $librarian->librarianID = $record['librarianID'];
    $librarian->librarianFirstName = $record['librarianFirstName'];
    $librarian->librarianMiddleName = $record['librarianMiddleName'];
    $librarian->librarianLastName = $record['librarianLastName'];
    $librarian->librarianDesignation = $record['librarianDesignation'];
    $librarian->librarianContactNo = $record['librarianContactNo'];
    $librarian->librarianEmail = $record['librarianEmail'];
    $old_email = $librarian->librarianEmail;
    $librarian->librarianEmployment = $record['librarianEmployment'];
}

if (isset($_POST['save'])) {
    // Sanitize inputs
    $librarian->librarianID = $_GET['id'];
    $librarian->librarianFirstName = htmlentities($_POST['librarianFirstName']);
    $librarian->librarianMiddleName = htmlentities($_POST['librarianMiddleName']);
    $librarian->librarianLastName = htmlentities($_POST['librarianLastName']);
    $librarian->librarianDesignation = htmlentities($_POST['librarianDesignation']);
    $librarian->librarianContactNo = htmlentities($_POST['librarianContactNo']);
    $librarian->librarianEmail = htmlentities($_POST['librarianEmail']);
    $librarian->librarianEmployment = isset($_POST['librarianEmployment']) ? htmlentities($_POST['librarianEmployment']) : '';

    // Validate inputs
    if (validate_field($librarian->librarianFirstName) &&
        validate_field($librarian->librarianLastName) &&
        validate_field($librarian->librarianDesignation) &&
        validate_field($librarian->librarianContactNo) &&
        validate_field($librarian->librarianEmail) &&
        validate_field($librarian->librarianEmployment) &&
        validate_librarianemail($librarian->librarianEmail)) {

        // Check if email has changed
        if ($old_email != $librarian->librarianEmail) {
            if (!$librarian->is_email_exist()) {
                if ($librarian->edit()) {
                    header('location: ../webpages/librarians.php');
                    exit; // Stop further execution
                } else {
                    echo 'An error occurred while updating the librarian in the database.';
                }
            } else {
                echo 'Email already exists.';
            }
        } else {
            if ($librarian->edit()) {
                header('location: ../webpages/librarians.php');
                exit; // Stop further execution
            } else {
                echo 'An error occurred while updating the librarian in the database.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Librarians';
  $librarians = 'active-1';
  require_once('../include/head.php');
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">

                <!-- Edit Librarian Modal -->
                <div class="container mt-4">
                    <div class="header-modal d-flex justify-content-between">
                        <h5 class="modal-title mt-4 ms-4" id="editLibrarianModalLabel">Edit Librarian</h5>
                       
                    </div>
                    <div class="modal-body mx-2 mt-2">
                    <form action="" method="POST">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianFirstName" class="label">First Name</label>
                                <input type="text" name="librarianFirstName" id="librarianFirstName" class="input-1" required value="<?php if(isset($_POST['librarianFirstName'])) { echo $_POST['librarianFirstName']; }else if(isset($librarian->librarianFirstName)) { echo $librarian->librarianFirstName; } ?>">
                                <?php
                                    if(isset($_POST['librarianFirstName']) && !validate_field($_POST['librarianFirstName'])){
                                ?>
                                        <p class="text-danger my-1">First name is required</p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianMiddleName" class="label">Middle Name</label>
                                <input type="text" name="librarianMiddleName" id="librarianMiddleName" class="input-1" placeholder="Optional" value="<?php if(isset($_POST['librarianMiddleName'])) { echo $_POST['librarianMiddleName']; }else if(isset($librarian->librarianMiddleName)) { echo $librarian->librarianMiddleName; } ?>">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianLastName" class="label">Last Name</label>
                                <input type="text" name="librarianLastName" id="librarianLastName" class="input-1" required value="<?php if(isset($_POST['librarianLastName'])) { echo $_POST['librarianLastName']; }else if(isset($librarian->librarianLastName)) { echo $librarian->librarianLastName; } ?>">
                                <?php
                                    if(isset($_POST['librarianLastName']) && !validate_field($_POST['librarianLastName'])){
                                ?>
                                        <p class="text-danger my-1">Last name is required</p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianDesignation" class="label">Designation</label>
                                <select name="librarianDesignation" id="librarianDesignation" class="form-select">
                                    <option value="">Select Designation</option>
                                    <option value="Librarian 1" <?php if ($librarian->librarianDesignation == 'Librarian 1') { echo 'selected'; } else if(isset($librarian->librarianDesignation) && $librarian->librarianDesignation == 'Librarian 1') { echo 'selected'; } ?>>Librarian 1</option>
                                    <option value="Librarian 2" <?php if ($librarian->librarianDesignation == 'Librarian 2') { echo 'selected'; } else if(isset($librarian->librarianDesignation) && $librarian->librarianDesignation == 'Librarian 2') { echo 'selected'; } ?>>Librarian 2</option>
                                    <option value="Librarian 3" <?php if ($librarian->librarianDesignation == 'Librarian 3') { echo 'selected'; } else if(isset($librarian->librarianDesignation) && $librarian->librarianDesignation == 'Librarian 3') { echo 'selected'; } ?>>Librarian 3</option>
                                    <option value="Librarian 4" <?php if ($librarian->librarianDesignation == 'Librarian 4') { echo 'selected'; } else if(isset($librarian->librarianDesignation) && $librarian->librarianDesignation == 'Librarian 4') { echo 'selected'; } ?>>Librarian 4</option>
                                </select>
                                <?php
                                    if(isset($_POST['librarianDesignation']) && !validate_field($_POST['librarianDesignation'])){
                                ?>
                                        <p class="text-danger my-1">Select librarian designation</p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianContactNo" class="label">Contact Number</label>
                                <input type="number" name="librarianContactNo" id="librarianContactNo" class="input-1" required value="<?php if(isset($_POST['librarianContactNo'])) { echo $_POST['librarianContactNo']; }else if(isset($librarian->librarianContactNo)) { echo $librarian->librarianContactNo; } ?>">
                                <?php
                                    if(isset($_POST['save']) && isset($_POST['librarianContactNo'])){
                                ?>
                                    <p class='text-danger my-1'>Please enter a valid contact number.</p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="librarianEmail" class="label">Email</label>
                                <input type="email" name="librarianEmail" id="librarianEmail" class="input-1" required value="<?php if(isset($_POST['librarianEmail'])) { echo $_POST['librarianEmail']; }else if(isset($librarian->librarianEmail)) { echo $librarian->librarianEmail; } ?>">
                                <?php
                                    $new_librarian = new Librarian();
                                    if(isset($_POST['librarianEmail'])){
                                         $new_librarian->librarianEmail = htmlentities($_POST['librarianEmail']);
                                    }else{
                                         $new_librarian->librarianEmail = '';
                                    }

                                    if(isset($_POST['librarianEmail']) && strcmp(validate_librarianemail($_POST['librarianEmail']), 'success') != 0){
                                ?>
                                        <p class="text-danger my-1"><?php echo validate_librarianemail($_POST['librarianEmail']) ?></p>
                                <?php
                                    }else if ($new_librarian->is_email_exist() && $_POST['librarianEmail'] && $old_email != $librarian->librarianEmail){
                                ?>
                                        <p class="text-danger my-1">Email already exists</p>
                                <?php      
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                            <label for="employment" class="label mb-2">Employment</label>
                                <div class="d-flex justify-content-center">
                                    <div class="form-check">
                                            <input type="radio" class="form-check-input" id="statusActive" name="librarianEmployment" value="Active" <?php if ($librarian->librarianEmployment == 'Active') { echo 'checked'; } else if(isset($librarian->librarianEmployment) && $librarian->librarianEmployment == 'Active') { echo 'checked'; }?>>
                                            <label class="form-check-label" for="statusActive">Active</label>
                                        </div>
                                        <div class="form-check ms-3">
                                            <input type="radio" class="form-check-input" id="statusDeactivated" name="librarianEmployment" value="No Longer in Service" <?php if ($librarian->librarianEmployment == 'No Longer in Service') { echo 'checked'; } else if(isset($librarian->librarianEmployment) && $librarian->librarianEmployment == 'No Longer in Service') { echo 'checked'; } ?>>
                                            <label class="form-check-label" for="statusDeactivated">No Longer in Service</label>
                                        </div>
                                    </div>
                                    <?php
                                        if((!isset($_POST['librarianEmployment']) && isset($_POST['save'])) || (isset($_POST['librarianEmployment']) && !validate_field($_POST['librarianEmployment']))){
                                    ?>
                                            <p class="text-danger my-1">Select librarian employment</p>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn add-btn-2 mb-3 me-4">Update Librarian</button>
                        </div>
                    </form>
                    </div>
                    
                    </div>
                </div>
                </div>

    <?php
    require_once('../include/js.php')
    ?>
</body>
</html>
