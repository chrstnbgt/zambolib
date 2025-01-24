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
  $title = 'Dashboard';
  $dashboard = 'active-1';
  require_once('../include/head.php');
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php
$database = new Database();
$connection = $database->connect();

$userQuery = "SELECT COUNT(*) AS userCount FROM user";
$resultUser = $connection->query($userQuery);
$rowUser = $resultUser->fetch(PDO::FETCH_ASSOC);
$userCount = $rowUser['userCount'];

$clubQuery = "SELECT COUNT(*) AS clubCount FROM club";
$resultClub = $connection->query($clubQuery);
$rowClub = $resultClub->fetch(PDO::FETCH_ASSOC);
$clubCount = $rowClub['clubCount'];

$eventQuery = "SELECT COUNT(*) as eventCount FROM event WHERE eventStatus = 'Upcoming'";
$resultEvent = $connection->query($eventQuery);
$rowEvent = $resultEvent->fetch(PDO::FETCH_ASSOC);
$eventCount = $rowEvent['eventCount'];

$proposalQuery = "SELECT COUNT(*) as proposalCount FROM org_proposal WHERE status = 'Pending'";
$resultProposal = $connection->query($proposalQuery);
$rowProposal = $resultProposal->fetch(PDO::FETCH_ASSOC);
$proposalCount = $rowProposal['proposalCount'];
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
                        <div class="heading-name">
                            <p class="pt-3">Dashboard</p>
                        </div>

                        <div class="bell-settings pe-4 d-flex">
                            <!-- Notification Dropdown -->
                            <!-- <div class="dropdown">
                                <button class="btn position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-bell icon"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-icon">
                                        13+
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="notificationDropdown"> -->
                                    <!-- Dropdown items go here -->
                                    <!-- <li><a class="dropdown-item" href="#">Your Monthly Report</a></li>
                                    <li><a class="dropdown-item" href="#">5 New Afilliated CLub Request</a></li> -->
                                    <!-- Add more dropdown items as needed -->
                                <!-- </ul>
                            </div> -->

                            <!-- Settings Button -->
                            <!-- <button type="button" class="btn ms-2">
                                <i class='bx bx-cog icon'></i>
                            </button> -->
                        </div>

                    </div>
                    <div class="row ps-2">

                        <div class="col-6 col-lg-3">
                            <div class="dashboard-card d-flex justify-content-evenly align-items-center pt-3 pb-2 px-4">
                                <div class="content">
                                    <p class="dashcard-label">Total Users</p>
                                    <p class="dashcard-count">
                                    <?php
                                        echo $userCount;
                                    ?>
                                    </p>
                                </div>
                                <div class="dashboard-icon d-flex justify-content-center">
                                    <img src="../images/tot-users.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="dashboard-card d-flex justify-content-evenly align-items-center pt-3 pb-2 px-4">
                                <div class="content">
                                    <p class="dashcard-label">Total Clubs</p>
                                    <p class="dashcard-count">
                                    <?php
                                        echo $clubCount;
                                    ?>
                                    </p>
                                </div>
                                <div class="dashboard-icon d-flex justify-content-center">
                                    <img src="../images/tot-clubs.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="dashboard-card d-flex justify-content-evenly align-items-center pt-3 pb-2 px-4">
                                <div class="content">
                                    <p class="dashcard-label">Upcoming Events</p>
                                    <p class="dashcard-count">
                                    <?php
                                        echo $eventCount;
                                    ?>
                                    </p>
                                </div>
                                <div class="dashboard-icon d-flex justify-content-center">
                                    <img src="../images/upcoming-events.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3">
                            <div class="dashboard-card d-flex justify-content-evenly align-items-center pt-3 pb-2 px-4">
                                <div class="content">
                                    <p class="dashcard-label">Pending Proposal</p>
                                    <p class="dashcard-count">
                                    <?php
                                        echo $proposalCount;
                                    ?>
                                    </p>
                                </div>
                                <div class="dashboard-icon d-flex justify-content-center">
                                    <img src="../images/pending-proposal.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-10 col-md-9 col-lg-12 mt-4">
                            <h1 class="h4">Daily Activities</h1>
                            <canvas id="dailyActivitiesChart"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../include/js.php"></script>

</body>
</html>

<?php
// Define the current date
$currentDate = date('Y-m-d');

// Use the Database class for queries
$database = new Database();
$connection = $database->connect();

// User logged in count
$userLoginQuery = "SELECT COUNT(*) AS userLoginCount FROM user WHERE DATE(userCreatedAt) = ?";
$stmt = $database->prepare($userLoginQuery);
$stmt->execute([$currentDate]);
$userLoginCount = $stmt->fetchColumn();

// Club registration count
$clubRegistrationQuery = "SELECT COUNT(*) AS clubRegistrationCount FROM club_membership WHERE DATE(cmCreatedAt) = ?";
$stmt = $database->prepare($clubRegistrationQuery);
$stmt->execute([$currentDate]);
$clubRegistrationCount = $stmt->fetchColumn();

// Event registration count
$eventRegistrationQuery = "SELECT COUNT(*) AS eventRegistrationCount FROM event_registration WHERE DATE(erCreatedAt) = ?";
$stmt = $database->prepare($eventRegistrationQuery);
$stmt->execute([$currentDate]);
$eventRegistrationCount = $stmt->fetchColumn();

// Upcoming events count
$upcomingEventsQuery = "SELECT COUNT(*) AS upcomingEventsCount FROM event WHERE eventStatus = 'upcoming'";
$stmt = $database->prepare($upcomingEventsQuery);
$stmt->execute();
$upcomingEventsCount = $stmt->fetchColumn();
?>


<script>
    // Get the canvas element
    const ctx = document.getElementById('dailyActivitiesChart').getContext('2d');

    // Data for the bar graph
    const data = {
        labels: ['Users Logged In', 'Club Registration', 'Event Registration', 'Upcoming Events'],
        datasets: [{
            label: 'Count',
            data: [<?php echo $userLoginCount; ?>, <?php echo $clubRegistrationCount; ?>, <?php echo $eventRegistrationCount; ?>, <?php echo $upcomingEventsCount; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configuration options
    const options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Create the bar graph
    const dailyActivitiesChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
</script>