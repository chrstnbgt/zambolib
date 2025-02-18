<?php
require_once('../classes/database.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    header('location: ./index.php');
    exit; // Ensure no further code is executed after redirection
}

$title = 'Dashboard';
$dashboard = 'active-1';
require_once('../include/head.php');
?>

<body>
    <div class="main">
        <div class="row">
            <?php require_once('../include/nav-panel.php'); ?>
            <div class="col-12 col-md-7 col-lg-9">
                <div class="row pt-4 ps-4">
                    <div class="col-12 dashboard-header d-flex align-items-center justify-content-between">
                        <div class="heading-name">
                            <p class="pt-3">Dashboard</p>
                        </div>
                        <div class="bell-settings pe-4 d-flex"></div>
                    </div>
                    <div class="row ps-2">
                        <div class="col-6 col-lg-3">
                            <div class="dashboard-card d-flex justify-content-evenly align-items-center pt-3 pb-2 px-4">
                                <div class="content">
                                    <p class="dashcard-label">Total Users</p>
                                    <p class="dashcard-count">
                                        <?php
                                        $database = new Database();
                                        $connection = $database->connect();

                                        $userQuery = "SELECT COUNT(*) AS userCount FROM user";
                                        $resultUser = $connection->query($userQuery);
                                        $userCount = $resultUser->fetchColumn();
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
                                        $clubQuery = "SELECT COUNT(*) AS clubCount FROM club";
                                        $resultClub = $connection->query($clubQuery);
                                        $clubCount = $resultClub->fetchColumn();
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
                                        $eventQuery = "SELECT COUNT(*) as eventCount FROM event WHERE eventStatus = 'Upcoming'";
                                        $resultEvent = $connection->query($eventQuery);
                                        $eventCount = $resultEvent->fetchColumn();
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
                                    <p class="dashcard-label">Pending Proposals</p>
                                    <p class="dashcard-count">
                                        <?php
                                        $proposalQuery = "SELECT COUNT(*) as proposalCount FROM org_proposal WHERE status = 'Pending'";
                                        $resultProposal = $connection->query($proposalQuery);
                                        $proposalCount = $resultProposal->fetchColumn();
                                        echo $proposalCount;
                                        ?>
                                    </p>
                                </div>
                                <div class="dashboard-icon d-flex justify-content-center">
                                    <img src="../images/pending-proposal.png" alt="">
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('dailyActivitiesChart').getContext('2d');
            const data = {
                labels: ['Users Logged In', 'Club Registration', 'Event Registration'],
                datasets: [{
                    label: 'Count',
                    data: [
                        <?php
                        $currentDate = date('Y-m-d');
                        $userLoginQuery = "SELECT COUNT(*) AS userLoginCount FROM user WHERE DATE(userCreatedAt) = ?";
                        $stmt = $connection->prepare($userLoginQuery);
                        $stmt->execute([$currentDate]);
                        $userLoginCount = $stmt->fetchColumn();

                        $clubRegistrationQuery = "SELECT COUNT(*) AS clubRegistrationCount FROM club_membership WHERE DATE(cmCreatedAt) = ?";
                        $stmt = $connection->prepare($clubRegistrationQuery);
                        $stmt->execute([$currentDate]);
                        $clubRegistrationCount = $stmt->fetchColumn();

                        $eventRegistrationQuery = "SELECT COUNT(*) AS eventRegistrationCount FROM event_registration WHERE DATE(erCreatedAt) = ?";
                        $stmt = $connection->prepare($eventRegistrationQuery);
                        $stmt->execute([$currentDate]);
                        $eventRegistrationCount = $stmt->fetchColumn();

                     

                        echo "$userLoginCount, $clubRegistrationCount, $eventRegistrationCount";
                        ?>
                    ],
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
            const options = {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            };
            new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        });
    </script>
</body>
</html>
