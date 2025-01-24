<?php
require_once '../classes/attendancechecker.class.php'; 
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

$attendanceChecker = new AttendanceChecker(); 

if (isset($_GET['id'])) {
    $record = $attendanceChecker->fetch($_GET['id']); 
    $attendanceChecker->attendanceCheckerID = $record['attendanceCheckerID']; 
    $attendanceChecker->acFirstName = $record['acFirstName'];
    $attendanceChecker->acMiddleName = $record['acMiddleName'];
    $attendanceChecker->acLastName = $record['acLastName'];
    $attendanceChecker->acContactNo = $record['acContactNo'];
    $attendanceChecker->acEmail = $record['acEmail'];
    $old_email = $attendanceChecker->acEmail;
    $attendanceChecker->acEmployment = $record['acEmployment'];
}

if (isset($_POST['save'])) {
    $attendanceChecker->attendanceCheckerID = $_GET['id'];
    $attendanceChecker->acFirstName = htmlentities($_POST['acFirstName']);
    $attendanceChecker->acMiddleName = htmlentities($_POST['acMiddleName']);
    $attendanceChecker->acLastName = htmlentities($_POST['acLastName']);
    $attendanceChecker->acContactNo = htmlentities($_POST['acContactNo']);
    $attendanceChecker->acEmail = htmlentities($_POST['acEmail']);
    $attendanceChecker->acEmployment = isset($_POST['acEmployment']) ? htmlentities($_POST['acEmployment']) : '';

    if (validate_field($attendanceChecker->acFirstName) &&
        validate_field($attendanceChecker->acLastName) &&
        validate_field($attendanceChecker->acContactNo) &&
        validate_field($attendanceChecker->acEmail) &&
        validate_field($attendanceChecker->acEmployment) &&
        validate_attendancecheckeremail($attendanceChecker->acEmail)) {

        if (!$attendanceChecker->is_email_exist()) {
            if ($attendanceChecker->edit()) {
                header('location: ../webpages/attendance-checker.php');
                exit;
            } else {
                echo 'An error occurred while updating the attendance checker in the database.';
            }
        } else {
            echo 'Email already exists.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Attendance Checker';
$checker = 'active-1';
require_once('../include/head.php');
?>

<body>


    <div class="main">
        <div class="row">
            <?php
            require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">

                <!-- Edit Attendance Checker Modal -->
                <div class="container mt-4">
                    <div class="header-modal d-flex justify-content-between">
                        <h5 class="modal-title mt-4 ms-4" id="editAttendanceCheckerModalLabel">Edit Attendance Checker</h5>
                    </div>
                    <div class="modal-body mx-2 mt-2">
                        <form method="post" action="">
                            <div class="row d-flex justify-content-center my-1">
                                <div class="input-group flex-column mb-3">
                                    <label for="acFirstName" class="label">First Name</label>
                                    <input type="text" name="acFirstName" id="acFirstName" class="input-1" required value="<?php echo isset($_POST['acFirstName']) ? $_POST['acFirstName'] : $attendanceChecker->acFirstName; ?>">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center my-1">
                                <div class="input-group flex-column mb-3">
                                    <label for="acMiddleName" class="label">Middle Name</label>
                                    <input type="text" name="acMiddleName" id="acMiddleName" class="input-1" placeholder="Optional" value="<?php echo isset($_POST['acMiddleName']) ? $_POST['acMiddleName'] : $attendanceChecker->acMiddleName; ?>">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center my-1">
                                <div class="input-group flex-column mb-3">
                                    <label for="acLastName" class="label">Last Name</label>
                                    <input type="text" name="acLastName" id="acLastName" class="input-1" required value="<?php echo isset($_POST['acLastName']) ? $_POST['acLastName'] : $attendanceChecker->acLastName; ?>">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center my-1">
                                <div class="input-group flex-column mb-3">
                                    <label for="acContactNo" class="label">Contact Number</label>
                                    <input type="text" name="acContactNo" id="acContactNo" class="input-1" required value="<?php echo isset($_POST['acContactNo']) ? $_POST['acContactNo'] : $attendanceChecker->acContactNo; ?>">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center my-1">
                                <div class="input-group flex-column mb-3">
                                    <label for="acEmail" class="label">Email</label>
                                    <input type="email" name="acEmail" id="acEmail" class="input-1" required value="<?php echo isset($_POST['acEmail']) ? $_POST['acEmail'] : $attendanceChecker->acEmail; ?>">
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center my-1">
                                <div class="input-group flex-column mb-3">
                                    <label for="acEmployment" class="label mb-2">Employment</label>
                                    <div class="d-flex justify-content-center">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="statusActive" name="acEmployment" value="Active" <?php if ($attendanceChecker->acEmployment == 'Active') {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                            <label class="form-check-label" for="statusActive">Active</label>
                                        </div>
                                        <div class="form-check ms-3">
                                            <input type="radio" class="form-check-input" id="statusDeactivated" name="acEmployment" value="No Longer in Service" <?php if ($attendanceChecker->acEmployment == 'No Longer in Service') {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                            <label class="form-check-label" for="statusDeactivated">No Longer in Service</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-action-btn d-flex justify-content-end">
                                <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                                <button type="submit" class="btn add-btn mb-4 me-4" name="save">Update Checker</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <?php
    require_once('../include/scripts.php');
    ?>
</body>

</html>
