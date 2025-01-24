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

if(isset($_POST['save'])){

    $attendanceChecker = new AttendanceChecker();
    //sanitize
    $attendanceChecker->acFirstName = htmlentities($_POST['acFirstName']);
    $attendanceChecker->acMiddleName = htmlentities($_POST['acMiddleName']);
    $attendanceChecker->acLastName = htmlentities($_POST['acLastName']);
    $attendanceChecker->acContactNo = htmlentities($_POST['acContactNo']);
    $attendanceChecker->acEmail = htmlentities($_POST['acEmail']);
    $attendanceChecker->acPassword = htmlentities($_POST['acPassword']);
    if(isset($_POST['acEmployment'])){
        $attendanceChecker->acEmployment = htmlentities($_POST['acEmployment']);
    }else{
        $attendanceChecker->acEmployment = '';
    }

    //validate
    if (validate_field($attendanceChecker->acFirstName) &&
        validate_field($attendanceChecker->acLastName) &&
        validate_field($attendanceChecker->acContactNo) &&
        validate_field($attendanceChecker->acEmail) &&
        validate_field($attendanceChecker->acPassword) &&
        validate_field($attendanceChecker->acEmployment) &&
        validate_attendancecheckerpassword($attendanceChecker->acPassword) &&
        validate_attendancecheckeremail($attendanceChecker->acEmail) && !$attendanceChecker->is_email_exist()){
            if($attendanceChecker->add()){
                header('location: ../webpages/attendance-checker.php');
            }else{
                echo 'An error occurred while adding in the database.';
            }
        }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Attendance Checker';
  $attendance = 'active-1';
  require_once('../include/head.php');
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
            <!-- Add Attendance Checker Modal -->
            <div class="container mt-4">
                <div class="header-modal d-flex align-items-center">
                    
                    <h4 class="modal-title " id="addAnnouncementModalLabel">Add Checker</h4>
                </div>
                <div class="modal-body mt-4 col-lg-10">
                <form method="post" action="">
                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                            <label for="acFirstName" class="label">First Name</label>
                            <input type="text" name="acFirstName" id="acFirstName" class="input-1" placeholder="Enter First Name" required value="<?php if(isset($_POST['acFirstName'])) { echo $_POST['acFirstName']; } ?>">
                            <?php
                                if(isset($_POST['acFirstName']) && !validate_field($_POST['acFirstName'])){
                            ?>
                                    <p class="text-danger my-1">First name is required</p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                            <label for="acMiddleName" class="label">Middle Name</label>
                            <input type="text" name="acMiddleName" id="acMiddleName" class="input-1" placeholder="Optional" value="<?php if(isset($_POST['acMiddleName'])){ echo $_POST['acMiddleName']; } ?>">
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                            <label for="acLastName" class="label">Last Name</label>
                            <input type="text" name="acLastName" id="acLastName" class="input-1" placeholder="Enter Last Name" required value="<?php if(isset($_POST['acLastName'])) { echo $_POST['acLastName']; } ?>">
                            <?php
                                if(isset($_POST['acLastName']) && !validate_field($_POST['acLastName'])){
                            ?>
                                    <p class="text-danger my-1">Last name is required</p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                            <label for="acContactNo" class="label">Contact Number</label>
                            <input type="number" name="acContactNo" id="acContactNo" class="input-1" placeholder="Enter Contact Number" value="<?php if(isset($_POST['acContactNo'])){ echo $_POST['acContactNo']; } ?>">
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                            <label for="acEmail" class="label">Email</label>
                            <input type="email" name="acEmail" id="acEmail" class="input-1" placeholder="example@gmail.com" required value="<?php if(isset($_POST['acEmail'])) { echo $_POST['acEmail']; } ?>">
                            <?php
                                $new_attendance_checker = new AttendanceChecker();
                                if(isset($_POST['acEmail'])){
                                    
                                    $new_attendance_checker->acEmail = htmlentities($_POST['acEmail']);
                                }else{
                                    $new_attendance_checker->acEmail = '';
                                }

                                if(isset($_POST['acEmail']) && strcmp(validate_attendancecheckeremail($_POST['acEmail']), 'success') != 0){
                            ?>
                                    <p class="text-danger my-1"><?php echo validate_attendancecheckeremail($_POST['acEmail']) ?></p>
                            <?php
                                }else if ($new_attendance_checker->is_email_exist() && $_POST['acEmail']){
                            ?>
                                    <p class="text-danger my-1">Email already exists</p>
                            <?php      
                                }
                            ?>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                            <label for="acPassword" class="label">Password</label>
                            <input type="password" name="acPassword" id="acPassword" class="input-1" placeholder="Atleast 8 Character" required value="<?php if(isset($_POST['acPassword'])) { echo $_POST['acPassword']; } ?>">
                            <?php
                                if(isset($_POST['acPassword']) && strcmp(validate_attendancecheckerpassword($_POST['acPassword']), 'success') != 0){
                            ?>
                                    <p class="text-danger my-1"><?php echo validate_attendancecheckerpassword($_POST['acPassword']) ?></p>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center my-1">
                        <div class="input-group flex-column mb-3">
                        <label for="acEmployment" class="label mb-2">Employment</label>
                            <div class="d-flex justify-content-center">
                                <div class="form-check">
                                        <input type="radio" class="form-check-input" id="statusActive" name="acEmployment" value="Active" <?php if(isset($_POST['acEmployment']) && $_POST['acEmployment'] == 'Active') { echo 'checked'; } ?>>
                                        <label class="form-check-label" for="statusActive">Active</label>
                                    </div>
                                    <div class="form-check ms-3">
                                        <input type="radio" class="form-check-input" id="statusDeactivated" name="acEmployment" value="No Longer in Service" <?php if(isset($_POST['acEmployment']) && $_POST['acEmployment'] == 'Deactivated') { echo 'checked'; } ?>>
                                        <label class="form-check-label" for="statusDeactivated">No Longer in Service</label>
                                    </div>
                                </div>
                                <?php
                                    if((!isset($_POST['acEmployment']) && isset($_POST['save'])) || (isset($_POST['acEmployment']) && !validate_field($_POST['acEmployment']))){
                                ?>
                                        <p class="text-danger my-1">Select attendance checker employment</p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-action-btn d-flex justify-content-end">
                        <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                        <button type="submit" name="save" class="btn add-btn-2 mb-3 me-4">Add Checker</button>
                    </div>
                </form>
                </div>
                
                </div>
            </div>
            </div>

    <?php require_once('../include/js.php'); ?>

</body>
</html>