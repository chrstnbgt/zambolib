<?php
require_once('../classes/database.php');
//resume session here to fetch session values
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
?>

<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Events & Announcements';
  $events = 'active-1';
  require_once('../include/head.php');

  $database = new Database();
  $connection = $database->connect();

  $librarianQuery = "SELECT DISTINCT l.* FROM librarian l
  JOIN event_facilitator ef ON l.librarianID = ef.librarianID
  WHERE l.librarianEmployment = 'Active';";
  $librarianResult = $connection->query($librarianQuery);
?>

<body>


    <div class="main">
        <div class="row">
            <?php
                require_once('../include/nav-panel.php');
            ?>

            <div class="col-12 col-md-8 col-lg-9">
                
                <div class="row pt-3 ps-4">
                    <div class="col-12 dashboard-header d-flex align-items-center justify-content-between">
                        <div class="heading-name">
                            <p class="pt-3">Events & Announcements</p>
                        </div>


                    </div>

                    
                    <div class="row ps-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="events" aria-selected="true">Events</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements" type="button" role="tab" aria-controls="announcements" aria-selected="false">Announcements</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                        <!-- Events Table -->
                        <div class="tab-pane fade show active pt-3" id="events" role="tabpanel" aria-labelledby="events-tab">

                        <div class="container ps-0 mb-2 d-flex justify-content-between">
                            <div class="d-flex">
                                <a href="../forms/add-event.php"><button type="button" class="btn add-btn justify-content-center align-items-center me-2" data-bs-toggle="modal" data-bs-target="#addEventModal">
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-plus-circle button-action-icon me-2'></i>
                                        Add Event
                                    </div>
                                </button></a>

                                <button type="button" class="btn add-btn justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#calendarModal">
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-calendar button-action-icon me-2'></i>
                                    </div>
                                </button>

                                <button type="button" class="btn add-btn justify-content-center align-items-center ms-2">
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-file button-action-icon me-2'></i>
                                        Generate Report
                                    </div>
                                </button>
                            </div>

                            <div class="d-flex">
                                <div class="form-group col-12 col-lg-12 flex-sm-grow-1 flex-lg-grow-0">
                                    <select name="event-status" id="event-status" class="form-select status-filter">
                                        <option value="">All Status</option>
                                        <option value="Upcoming">Upcoming</option>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar Modal -->
                        <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-calendar modal-dialog-centered">
                            <div class="modal-content modal-modification modal-calendar-body">
                            <div class="header-modal d-flex justify-content-between">
                                <h5 class="modal-title mt-4 ms-4" id="calendarModalLabel">Calendar of Activities</h5>
                                <button type="button" class="btn-close mt-4 me-4" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body mx-2 mt-2">
                                CALENDAR
                            </div>
                            <div class="modal-action-btn d-flex justify-content-end">
                                <button type="button" class="btn add-btn-2 mb-3 me-4" data-bs-dismiss="modal">Dismiss</button>
                            </div>
                            </div>
                        </div>
                        </div>


                        <div class="table-responsive">
                            
                            <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-200px">#</th>
                                        <th class="min-w-200px">Event Name</th>
                                        <th class="min-w-350px description-width">Description</th>
                                        <th class="min-w-300px">Event Facilitators</th>
                                        <th class="min-w-200px">Date and Time</th>
                                        <th class="min-w-100px">Participant Limit</th>
                                        <th class="min-w-150px">Venue</th>
                                        <!-- <th class="min-w-150px">Collaboration Width</th> -->
                                        <th class="min-w-150px">Status</th>
                                        <th class="min-w-150px">Created At</th>
                                        <th class="min-w-150px">Updated at</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="eventTableBody">
                                     <?php
                                     include('showevents.php')
                                     ?>   
                                </tbody>
                            </table>
                        </div>
                        </div>

                        <!-- Announcements Table -->
l
                        <div class="tab-pane fade active pt-3" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
                        <a href="../forms/add-announcement.php"><button type="button" class="btn request-btn d-flex justify-content-center align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-plus-circle action-icon me-2'></i>
                                Add Announcement
                            </div>
                        </button></a>

                        <div class="table-responsive">
                            
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-250px">#</th>
                                        <th class="min-w-250px">Announcement Title</th>
                                        <th class="min-w-150px">Description</th>
                                        <th class="min-w-300px">Date</th>
                                        <th class="min-w-200px">Time</th>
                                        <th class="min-w-100px">Created At</th>
                                        <th class="min-w-150px">Updated At</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="announcementTableBody">
                                    <?php
                                        include('showannouncements.php')
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


    <?php require_once('../include/js.php'); ?>

</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the URL contains the announcements tab hash
        if (window.location.hash === '#announcements') {
            // Scroll to the announcements tab
            var tab = document.querySelector('#announcements-tab');
            if (tab) {
                tab.click(); // Activate the tab
                tab.scrollIntoView({ behavior: 'smooth' }); // Scroll to the tab
            }
        }
    });
</script>

