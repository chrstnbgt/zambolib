<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin'){
    header('location: ./index.php');
}

require_once '../classes/events.class.php';
$event = new Events();


require_once '../classes/event_feedback.class.php';
$feedback = new EventFeedback();
$feedbackData = $feedback->getFeedbackWithDetails();
?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Feedback';
$events = 'active-1';
require_once('../include/head.php');
?>

<style>
    .card {
        transition: transform 0.6s ease, box-shadow 0.6s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<body>

    <div class="main">
        <div class="row">
            <?php
            require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">

                <div class="container mt-4">
                    <div class="header-modal d-flex align-items-center">
                    <a href="../webpages/event-overview.php?eventID=<?php echo isset($_GET['eventID']) ? $_GET['eventID'] : ''; ?>" class="d-flex align-items-center">
                            <i class='bx bx-arrow-back pe-3 back-icon'></i>
                            <span class="back-text"></span>
                        </a>
                        <h2 class="modal-title " id="addAnnouncementModalLabel">User Feedback</h2>
                    </div>

                    <!-- Feedback Cards -->
                    <div class="row mt-4">
                        <?php foreach ($feedbackData as $feedbackItem) { ?>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $feedbackItem['feedback']; ?></h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">User: <?php echo $feedbackItem['userUserName']; ?></span>
                                            <span>
                                               
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php require_once('../include/js.php'); ?>

</body>
