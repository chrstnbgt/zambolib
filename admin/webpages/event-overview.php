<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin'){
    header('location: ./index.php');
    exit; // Make sure to exit after a header redirect
}

require_once '../classes/eventoverview.class.php';

// Check if eventID is set in the GET parameters
if(isset($_GET['eventID'])){
    $event =  new Eventoverview();
    $eventRecord = $event->fetch($_GET['eventID']);
    if ($eventRecord) { // Check if event record is fetched successfully
        $event->eventID = $eventRecord['eventID'];
        $event->eventTitle= $eventRecord['eventTitle'];
        $event->eventStartDate= $eventRecord['eventStartDate'];
        $event->eventEndDate= $eventRecord['eventEndDate'];
        $event->eventStartTime= $eventRecord['eventStartTime'];
        $event->eventEndTime= $eventRecord['eventEndTime'];
        $event->eventGuestLimit= $eventRecord['eventGuestLimit'];      
        $event->eventBuildingName= $eventRecord['eventBuildingName'];
        $event->eventStreetName= $eventRecord['eventStreetName'];
        $event->eventBarangay= $eventRecord['eventBarangay'];
        $event->eventCity= $eventRecord['eventCity'];
        $event->eventProvince= $eventRecord['eventProvince'];
        $event->eventRegion= $eventRecord['eventRegion'];
        $event->eventZipCode= $eventRecord['eventZipCode'];
        $eventFacilitators = $event->getEventFacilitator($_GET['eventID']);
        $event->eventStatus= $eventRecord['eventStatus'];
        $event->eventDescription= $eventRecord['eventDescription'];
        $registrants = $event->getEventRegistrant($_GET['eventID']);
        $participants = $event->getEventParticipant($_GET['eventID']);
        $volunteers = $event->getEventVolunteers($_GET['eventID']);
    } else {
        // Handle the case where the event record is not found
        echo "Event not found.";
        exit; // Stop execution
    }
} else {
    // Handle the case where eventID is not set
    echo "Event ID not provided.";
    exit; // Stop execution
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Event Overview'; // Set the correct title here
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
                            <a href="" class="d-flex align-items-center">
                                    <i class='bx bx-arrow-back pe-3 back-icon'></i>
                                    <span class="back-text">Back</span>
                                </a>
                            </button>

                                <p class="pt-3">Event Overview</p>
                            </div>

                           

                    </div>

                    <div class="row ps-2">
                        
                    <div class="col-12 col-md-6 col-lg-6 club-overview-labels mb-4 ps-3">
                        <div class="overflow-auto" style="max-height: 100px;">
                            <h4 class="club-name pb-1"><span class="label-club pe-3">Event Title</span><?php echo $event->eventTitle; ?></h4>
                            <h4 class="dateTime pb-1"><span class="label-club pe-3">Date & Time</span><?php 
                                $startDate = date('F j, Y', strtotime($event->eventStartDate));
                                $endDate = date('F j, Y', strtotime($event->eventEndDate));
                                $startTime = date('h:i A', strtotime($event->eventStartTime));
                                $endTime = date('h:i A', strtotime($event->eventEndTime));
                                echo $startDate;
                                if ($startDate != $endDate) {
                                    echo ' - ' . $endDate;
                                }
                                echo ' ' . $startTime . ' - ' . $endTime; 
                            ?></h4>
                            <h4 class="venue pb-1"><span class="label-club pe-3">Venue</span><?php
                                $venueParts = array();
                                if ($event->eventBuildingName) {
                                    $venueParts[] = $event->eventBuildingName;
                                }
                                if ($event->eventStreetName) {
                                    $venueParts[] = $event->eventStreetName;
                                }
                                if ($event->eventBarangay) {
                                    $venueParts[] = $event->eventBarangay;
                                }
                                if ($event->eventCity) {
                                    $venueParts[] = $event->eventCity;
                                }
                                if ($event->eventProvince) {
                                    $venueParts[] = $event->eventProvince;
                                }
                                if ($event->eventRegion) {
                                    $venueParts[] = $event->eventRegion;
                                }
                                if ($event->eventZipCode) {
                                    $venueParts[] = $event->eventZipCode;
                                }
                                echo implode(', ', $venueParts);
                            ?></h4>

                            <h4 class="eventFacilitators pb-1"><span class="label-club pe-3">Event Facilitators</span><?php
                                foreach ($eventFacilitators as $facilitator) {
                                    $middleInitial = $facilitator['librarianMiddleName'] ? substr($facilitator['librarianMiddleName'], 0, 1) . '.' : '';
                                    echo $facilitator['librarianFirstName'] . ' ' . $middleInitial . ' ' . $facilitator['librarianLastName'] . '<br>';
                                }?></h4>
                            <h4 class="status pb-1"><span class="label-club pe-3">Status</span><?php echo $event->eventStatus; ?></h4>
                        </div>
                    </div>

                    <?php
                    require_once '../classes/eventoverview.class.php';
                    require_once '../tools/functions.php';

                    $events = new Eventoverview();
                    $eventsArray = $events->show();

                    // Make sure $eventID is set before using it
                    if (isset($_GET['eventID'])) {
                        $eventID = $_GET['eventID'];

                        ?>
                        <div class="col-12 col-md-6 col-lg-6 club-overview-labels">
                            <div class="overflow-auto" style="max-height: 100px;">
                                <h3 class="description-label"><span class="label-club pb-1 pe-3">Description</span></h3>
                                <h4 class="description-club mb-2"><?php echo $event->eventDescription; ?></h4>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "Event ID not provided.";
                    }
                    ?>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-label active" id="event-registrants-tab" data-bs-toggle="tab" data-bs-target="#event-registrants" type="button" role="tab" aria-controls="event-registrants" aria-selected="true">Registrants</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-label" id="event-participants-tab" data-bs-toggle="tab" data-bs-target="#event-participants" type="button" role="tab" aria-controls="event-participants" aria-selected="false">Participants</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link tab-label" id="event-volunteers-tab" data-bs-toggle="tab" data-bs-target="#event-volunteers" type="button" role="tab" aria-controls="event-volunteers" aria-selected="false">Volunteers</button>
                        </li>
                    </ul> 

                    <div class="tab-content" id="myTabContent">
                        <!-- Registrants -->
                        <div class="tab-pane fade show active pt-3" id="event-registrants" role="tabpanel" aria-labelledby="event-registrants-tab">
                        <div class="dropdown d-flex">
                                <button class="btn download-btn dropdown-toggle" type="button" id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Download
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                    <li><a class="dropdown-item" href="#" onclick="downloadAsPdfEvents()">Download as PDF</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="downloadAsExcelEvents()">Download as Excel</a></li>
                                </ul>
                            </div>
                            <div class="table-responsive mt-2">
                                
                                <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 club-member">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                        <?php $counter = 1;?>
                                            <th class="min-w-50px" id="number-row">#</th> <!-- Add a column for the list numbers -->
                                            <th class="min-w-250px">Name</th>
                                            <th class="min-w-150px">Email Address</th>
                                            <th class="min-w-300px">Contact Number</th>
                                            <th class="min-w-200px">Gender</th>
                                            <th class="min-w-200px">Address</th>
                                            <th class="min-w-200px">Age</th>
                                            <th class="min-w-100px">Date Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($registrants as $registrant) {
                                        ?>
                                        <tr>
                                            <td><?= $counter ?></td>
                                            <td><?php echo $registrant['fullName']; ?></td>
                                            <td><?php echo $registrant['userEmail']; ?></td>
                                            <td><?php echo $registrant['userContactNo']; ?></td>
                                            <td><?php echo $registrant['userGender']; ?></td>
                                            <td><?php echo $registrant['address']; ?></td>
                                            <td><?php echo $registrant['userAge']; ?></td>
                                            <td><?php echo $registrant['dateJoined']; ?></td>
                                        </tr>

                                        <?php
                                        $counter++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
            
                                </div>
                        </div>

                        <!-- Participants -->
                        <div class="tab-pane fade  active pt-3" id="event-participants" role="tabpanel" aria-labelledby="event-participants-tab">
                            <div class="container ps-0 mb-2 d-flex justify-content-between">
                                
                                <div class="d-flex">
                                    
                                    <button type="button" class="btn add-btn justify-content-center align-items-center me-2" onclick="window.location.href = 'event-certificate.php?eventID=<?php echo $event->eventID; ?>';">
                                        
                                    <div class="d-flex align-items-center">
                                            <i class='bx bx-certification button-action-icon me-2'></i>
                                            Certificate
                                    </div>
                                    </button>

                                    <button type="button" class="btn add-btn justify-content-center align-items-center">
                                        <a href="event-gallery.php?eventID=<?php echo $event->eventID; ?>" class="d-flex align-items-center" style="text-decoration: none; color: inherit;">
                                            <i class='bx bx-photo-album button-action-icon me-2'></i>
                                            Gallery
                                        </a>
                                    </button>

                                    <button type="button" class="btn add-btn justify-content-center align-items-center ms-2">
                                    <a href="event-feedbacks.php?eventID=<?php echo $event->eventID; ?>" class="d-flex align-items-center" style="text-decoration: none; color: inherit;">

                                            <i class='bx bx-message-alt-detail button-action-icon me-2'></i>
                                            Feedback
                                    </a>
                                    </button>
                                   
                                </div>
                            </div>

                            <div class="table-responsive mt-2">
                                
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7 club-member">
                                    <thead>
                                    
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="min-w-250px">Name</th>
                                            <th class="min-w-150px">Email Address</th>
                                            <th class="min-w-300px">Contact Number</th>
                                            <th class="min-w-200px">Gender</th>
                                            <th class="min-w-200px">Address</th>
                                            <th class="min-w-200px">Age</th>
                                            <th class="min-w-100px">Date Particpated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Loop through each member
                                        foreach ($participants as $participant) {
                                            ?>
                                        <tr>
                                        
                                            <td><?php echo $participant['fullName']; ?></td>
                                            <td><?php echo $participant['userEmail']; ?></td>
                                            <td><?php echo $participant['userContactNo']; ?></td>
                                            <td><?php echo $participant['userGender']; ?></td>
                                            <td><?php echo $participant['address']; ?></td>
                                            <td><?php echo $participant['userAge']; ?></td>
                                            <td><?php echo $participant['dateJoined']; ?></td>
                                        </tr>

                                            <?php
                                        
                                        }
                                        ?>
                                    </tbody>
                                </table>
            
                                </div>
                        </div>
                
                       <!-- Volunteers -->
                       <div class="tab-pane fade show active pt-3" id="event-volunteers" role="tabpanel" aria-labelledby="event-volunteers-tab">
                            <div class="table-responsive mt-2">
                                
                                <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 club-member">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                        <?php $counter = 1;?>
                                            <th class="min-w-50px" id="number-row">#</th> <!-- Add a column for the list numbers -->
                                            <th class="min-w-250px">Name</th>
                                            <th class="min-w-150px">Email Address</th>
                                            <th class="min-w-300px">Contact Number</th>
                                            <th class="min-w-200px">Gender</th>
                                            <th class="min-w-200px">Address</th>
                                            <th class="min-w-200px">Age</th>
                                            <th class="min-w-100px">Date Volunteered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($volunteers as $volunteer) {
                                            ?>
                                            <tr>
                                                <td><?= $counter ?></td>
                                                <td><?php echo $volunteer['fullName']; ?></td>
                                                <td><?php echo $volunteer['userEmail']; ?></td>
                                                <td><?php echo $volunteer['userContactNo']; ?></td>
                                                <td><?php echo $volunteer['userGender']; ?></td>
                                                <td><?php echo $volunteer['address']; ?></td>
                                                <td><?php echo $volunteer['userAge']; ?></td>
                                                <td><?php echo $volunteer['dateJoined']; ?></td>
                                            </tr>

                                            <?php
                                            $counter++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
            
                            </div>
                        </div>

                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <?php require_once('../include/js3.php'); ?>

</body>