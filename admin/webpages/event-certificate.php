<?php
session_start();
require_once '../classes/events.class.php';

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin'){
    header('location: ./index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['eventID']) && isset($_FILES['certificateImage'])) {
        $eventID = $_POST['eventID'];
        $certificateName = $_POST['certificateName'];
        $certificateImage = $_FILES['certificateImage'];

        $event = new Events();
        $inserted = $event->insertCertificate($eventID, $certificateName, $certificateImage);

        if ($inserted) {
           
        } else {
            echo "Error adding certificate. Please try again.";
        }
    } elseif (isset($_POST['deleteCertificate']) && isset($_POST['eventCertificateID'])) {
        $eventCertificateID = $_POST['eventCertificateID'];
        $event = new Events();
        $deleted = $event->deleteCertificate($eventCertificateID);
        if ($deleted) {
        } else {
            echo "Error deleting certificate. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Event Certificate';
  $events = 'active-1';
  require_once('../include/head.php');
?>


<body>
    <div class="main">
        <div class="row">
            <?php require_once('../include/nav-panel.php'); ?>

            <div class="col-12 col-md-7 col-lg-9">
                <div class="row pt-4 ps-4">
                    <div class="col-12 dashboard-header d-flex align-items-center justify-content-between">
                        <div class="heading-name d-flex">
                            <button class="back-btn me-4">
                            <a href="../webpages/event-overview.php?eventID=<?php echo isset($_GET['eventID']) ? $_GET['eventID'] : ''; ?>" class="d-flex align-items-center">
                                    <i class='bx bx-arrow-back pe-3 back-icon'></i>
                                    <span class="back-text">Back</span>
                                </a>
                            </button>
                        </div>
                       
                       
                    </div>
                    <h2>Event Certificate</h2>

                    <!-- Display existing certificates -->
                    <div class="row ps-2">
                        <div class="row club-overview-details-container">
                            <div class="row" style="overflow-y: auto; margin-top: 10px;">
                                <?php
                                $event = new Events();
                                $eventID = isset($_GET['eventID']) ? $_GET['eventID'] : null;
                                if ($eventID) {
                                    $certificates = $event->fetchCertificates($eventID);
                                    if (!empty($certificates)) {
                                        foreach ($certificates as $certificate) {
                                            $certificateImagePath = '../certificate_images/' . $certificate['ecImage'];
                                            echo '<div class="col-2">';
                                            echo '<div class="image-name-wrapper" style="position: relative; text-align: center;">'; // Wrapper for image and name
                                            echo '<img src="' . $certificateImagePath . '" class="img-fluid" style="width: 100%; height: auto;" alt="Certificate Image">';
                                            echo '<p class="certificate-name" style="padding-top: 10px; background-color: rgba(255, 255, 255, 0.8); color: #333;">' . $certificate['ecName'] . '</p>'; // Display certificate name
                                            echo '<form action="" method="post" style="position: absolute; top: 5px; right: 5px;">';
                                            echo '<input type="hidden" name="eventCertificateID" value="' . $certificate['eventCertificateID'] . '">';
                                            echo '<button type="submit" name="deleteCertificate" class="btn btn-danger" style="padding: 2px 6px; border-radius: 50%; font-size: 14px;">X</button>';
                                            echo '</form>';
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo "<p>No certificates found for this event.</p>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Form to upload certificates -->
                    <div class="row mt-4">
                        <div class="col" style="margin-top: 50px;">
                            <div style="">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-auto">
                                            <label for="certificateName" class="col-form-label">Certificate Name:</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="text" id="certificateName" name="certificateName" class="form-control" required>
                                        </div>
                                        <div class="col-auto">
                                            <label for="certificateImage" class="col-form-label">Certificate Image:</label>
                                        </div>
                                        <div class="col-auto">
                                            <input type="file" id="certificateImage" name="certificateImage" class="form-control" accept="image/*" required>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Add Certificate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('../include/js2.php'); ?>
</body>
