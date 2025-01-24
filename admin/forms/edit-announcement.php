<?php
require_once '../tools/adminfunctions.php';
require_once '../classes/announcement.class.php';

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

$announcement = new Announcement();

if (isset($_GET['id'])) {
    $record = $announcement->fetch($_GET['id']);
    $announcement->eventAnnouncementID = $record['eventAnnouncementID'];
    $announcement->eaTitle = $record['eaTitle'];
    $announcement->eaDescription = $record['eaDescription'];
    $announcement->eaStartDate = $record['eaStartDate'];
    $announcement->eaEndDate = $record['eaEndDate'];
    $announcement->eaStartTime = $record['eaStartTime'];
    $announcement->eaEndTime = $record['eaEndTime'];
}

if (isset($_POST['save'])) {
    // Sanitize inputs
    $announcement->eventAnnouncementID = $_GET['id'];
    $announcement->eaTitle = htmlentities($_POST['eaTitle']);
    $announcement->eaDescription = htmlentities($_POST['eaDescription']);
    $announcement->eaStartDate = htmlentities($_POST['eaStartDate']);
    $announcement->eaEndDate = htmlentities($_POST['eaStartTime']);
    $announcement->eaStartTime = htmlentities($_POST['eaStartDate']);
    $announcement->eaEndTime = htmlentities($_POST['eaEndTime']);

    // Validate inputs
    if (validate_field($announcement->eaTitle) &&
        validate_field($announcement->eaStartDate) &&
        validate_field($announcement->eaEndDate)) {

        if ($announcement->edit()) {
            header('location: ../webpages/events.php#announcements');
            exit; // Stop further execution
        } else {
            echo 'An error occurred while updating the announcement in the database.';
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
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
                <!-- Edit Announcement Modal -->
                <div class="container mt-4">
                    <div class="header-modal d-flex justify-content-between">
                        <h5 class="modal-title mt-4 ms-4" id="editAnnouncementModalLabel">Edit Announcement</h5>
                        
                    </div>
                    <div class="modal-body mt-2">
                    <form action="">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eaTitle" class="label">Announcement Title</label>
                                <input type="text" name="eaTitle" id="eaTitle" class="input-1" required value="<?php if(isset($_POST['eaTitle'])) { echo $_POST['eaTitle']; }else if(isset($announcement->eaTitle)) { echo $announcement->eaTitle; } ?>">
                                <?php
                                    if(isset($_POST['eaTitle']) && !validate_field($_POST['eaTitle'])){
                                ?>
                                        <p class="text-danger my-1">Title is required</p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eaDescription" class="label">Description</label>
                                <input type="text" id="eaDescription" name="eaDescription" class="input-1" rows="4" cols="50" value="<?php if(isset($_POST['eaDescription'])){ echo $_POST['eaDescription']; }else if(isset($announcement->eaDescription)) { echo $announcement->eaDescription; } ?>">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventDate" class="label">Date</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="eaStartDate" class="label-2">Start Date</label>
                                        <input type="date" name="eaStartDate" id="eaStartDate" class="input-1 col-lg-12" placeholder="From" required value="<?php if(isset($_POST['eaStartDate'])) { echo $_POST['eaStartDate']; }else if(isset($announcement->eaStartDate)) { echo $announcement->eaStartDate; } ?>">
                                        <?php
                                            if(isset($_POST['eaStartDate']) && !validate_field($_POST['eaStartDate'])){
                                        ?>
                                                <p class="text-danger my-1">Start date is required</p>
                                        <?php
                                            }
                                        ?>
                                    </div>

                                    <div class="col-6">
                                        <label for="eaEndDate" class="label-2">End Date</label>
                                        <input type="date" name="eaEndDate" id="eaEndDate" class="input-1 col-lg-12" placeholder="To" required value="<?php if(isset($_POST['eaEndDate'])) { echo $_POST['eaEndDate']; }else if(isset($announcement->eaEndDate)) { echo $announcement->eaEndDate; } ?>">
                                        <?php
                                            if(isset($_POST['eaEndDate']) && !validate_field($_POST['eaEndDate'])){
                                        ?>
                                                <p class="text-danger my-1">End date is required</p>
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
                                <label for="eventTime" class="label">Time</label>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="eaStartTime" class="label-2">Start Time</label>
                                        <input type="time" name="eaStartTime" id="eaStartTime" class="input-1col-lg-12" placeholder="From" value="<?php if(isset($_POST['eaStartTime'])) { echo $_POST['eaStartTime']; }else if(isset($announcement->eaStartTime)) { echo $announcement->eaStartTime; } ?>">
                                    </div>

                                    <div class="col-6">
                                        <label for="eaEndTime" class="label-2">End Time</label>
                                        <input type="time" name="eaEndTime" id="eaEndTime" class="input-1 col-lg-12" placeholder="To" value="<?php if(isset($_POST['eaEndTime'])) { echo $_POST['eaEndTime']; }else if(isset($announcement->eaEndTime)) { echo $announcement->eaEndTime; } ?>">
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn request-btn-2 mb-3 me-4">Update</button>
                        </div>
                    </div>
                    </form>
                    </div>
                    
                </div>
                </div>

    <?php require_once('../include/js.php'); ?>

</body>