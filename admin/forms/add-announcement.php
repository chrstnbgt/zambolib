
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

if (isset($_POST['save'])) {
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
            header('location: ../webpages/events.php#announcements'); // Redirect to announcements tab
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

?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
                <!-- Add Announcement Modal -->
                <div class="container mt-4">
                    <div class="header-modal d-flex justify-content-between">
                        <h5 class="modal-title mt-4 ms-1" id="addAnnouncementModalLabel">Add Announcement</h5>
                      
                    </div>
                    <div class=" modal-body mt-2">
                    <form method="post" action="">
                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eaTitle" class="label">Announcement Title</label>
                                <input type="text" name="eaTitle" id="eaTitle" class="input-1" placeholder="Enter Announcement Title" required value="<?php if(isset($_POST['eaTitle'])) { echo $_POST['eaTitle']; } ?>">
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
                                <input type="text" id="eaDescription" name="eaDescription" class="input-1" rows="4" cols="50" placeholder="Write brief description" value="<?php if(isset($_POST['eaDescription'])) { echo $_POST['eaDescription']; } ?>">
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center my-1">
                            <div class="input-group flex-column mb-3">
                                <label for="eventDate" class="label">Date</label>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="eaStartDate" class="label-2">Start Date</label>
                                        <input type="date" name="eaStartDate" id="eaStartDate" class="input-1 col-lg-12" placeholder="From" required value="<?php if(isset($_POST['eaStartDate'])) { echo $_POST['eaStartDate']; } ?>">
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
                                        <input type="date" name="eaEndDate" id="eaEndDate" class="input-1 col-lg-12" placeholder="To" required value="<?php if(isset($_POST['eaEndDate'])) { echo $_POST['eaEndDate']; } ?>">
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
                                        <input type="time" name="eaStartTime" id="eaStartTime" class="input-1 col-lg-12" placeholder="From" value="<?php if(isset($_POST['eaStartTime'])) { echo $_POST['eaStartTime']; } ?>">
                                    </div>

                                    <div class="col-6">
                                        <label for="eaEndTime" class="label-2">End Time</label>
                                        <input type="time" name="eaEndTime" id="eaEndTime" class="input-1 col-lg-12" placeholder="To" value="<?php if(isset($_POST['eaEndTime'])) { echo $_POST['eaEndTime']; } ?>">
                                    </div>
                                </div>
                                <div></div>
                            </div>
                        </div>
                        <div class="modal-action-btn d-flex justify-content-end">
                            <button type="button" class="btn cancel-btn mb-4 me-4" onclick="window.history.back();" aria-label="Close">Cancel</button>
                            <button type="submit" name="save" class="btn request-btn-2 mb-3 me-4" data-bs-dismiss="modal">Done</button>
                        </div>
                    </form>
                    </div>
                    
                    </div>
                </div>
                </div>


    <?php require_once('../include/js.php'); ?>

</body>