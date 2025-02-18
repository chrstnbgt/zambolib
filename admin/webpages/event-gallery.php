<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin'){
    header('location: ./index.php');
}
require_once '../classes/events.class.php';
if(isset($_GET['eventID'])){
    $eventID = $_GET['eventID']; // Set eventID from the URL parameter
    $event = new Events();
    $eventRecord = $event->fetch($eventID);
    $event->eventID = $eventRecord['eventID'];
    $images = $event->fetchImages($eventID);
}
if(isset($_POST['deleteImage']) && isset($_POST['event_ImageID'])){
    $event_ImageID = $_POST['event_ImageID'];
    $event->deleteImage($event_ImageID);
    // Redirect back to the event gallery page
    header("Location: ../webpages/event-gallery.php?eventID=$eventID");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['eventID']) && isset($_FILES['image'])) {
        $eventID = $_POST['eventID'];
        $images = $_FILES['image'];

        // Loop through each uploaded image
        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $fileType = exif_imagetype($tmp_name);
            if ($fileType !== false) {
                $uploadDir = '../saved_images/';
                $fileName = uniqid() . '.' . pathinfo($images['name'][$key], PATHINFO_EXTENSION);
                $uploadPath = $uploadDir . $fileName;
                if (move_uploaded_file($tmp_name, $uploadPath)) {
                    $event->insertImage($eventID, $fileName); // Save the filename
                } else {
                    echo "Error uploading image.";
                }
            } else {
                echo "Invalid file type.";
            }
        }
        // Redirect back to the event gallery page
        header("Location: ../webpages/event-gallery.php?eventID=$eventID");
        exit();
    } 
} 
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Gallery';
$events = 'active-1';
require_once('../include/head.php');
?>

<body>
    <div class="main">
        <div class="row">
            <?php
            require_once('../include/nav-panel.php');
            ?>

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
                    <h2>Event Gallery</h2>

                    <div class="row ps-2">
                        <div class="row club-overview-details-container">
                            <div class="row" style="overflow-y: auto; margin-top:10px;">
                                <?php
                                if (isset($images) && !empty($images)) {
                                    foreach ($images as $image) {
                                        $fileName = $image['eventImage']; // Get the filename from the database
                                        $imagePath = '../saved_images/' . $fileName; // Adjust directory if necessary
                                        echo '<div class="col-2">';
                                        echo ' <div class="image-box" style="position: relative;">';
                                        echo '<img src="' . $imagePath . '" class="img-fluid" style="width: 100%; height: auto;" alt="Event Image">';
                                        // Add delete button
                                        echo '<form action="" method="post" style="position: absolute; top: 5px; right: 5px;">';
                                        echo '<input type="hidden" name="event_ImageID" value="' . $image['event_ImageID'] . '">';
                                        echo '<button type="submit" name="deleteImage" class="btn btn-danger" style="padding: 2px 6px; border-radius: 50%; font-size: 14px;">X</button>';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "<p>No images found for this event.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Form to upload images -->
                    <div class="row">
                        <div class="col" style="margin-top: 50px;">
                            <div style="">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Choose Images to Upload:</label>
                                        <input type="file" class="form-control" id="image" name="image[]" accept="image/*" multiple required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload Images</button>
                                </form>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <?php require_once('../include/js2.php'); ?>

</body>
