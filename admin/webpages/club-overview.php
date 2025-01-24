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

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: ./clubs.php');
    exit;
}

$clubID = $_GET['id'];

$database = new Database();
$connection = $database->connect();

$clubQuery = "SELECT * FROM club WHERE clubID = :clubID";
$clubStatement = $connection->prepare($clubQuery);
$clubStatement->bindParam(':clubID', $clubID);
$clubStatement->execute();
$club = $clubStatement->fetch(PDO::FETCH_ASSOC);

if (!$club) {
    echo "Club not found";
    exit;
}

$clubManagementQuery = "SELECT l.librarianFirstName, l.librarianLastName FROM librarian l
JOIN club_management cm ON l.librarianID = cm.librarianID
WHERE cm.clubID = :clubID";

$clubManagementStatement = $connection->prepare($clubManagementQuery);
$clubManagementStatement->bindParam(':clubID', $clubID);
$clubManagementStatement->execute();
$clubManagementResult = $clubManagementStatement->fetchAll(PDO::FETCH_ASSOC);

$membershipQuery = "SELECT u.userFirstName, u.userLastName, cm.cmStatus FROM user u
JOIN club_membership cm ON u.userID = cm.userID
WHERE cm.clubID = :clubID";

$membershipStatement = $connection->prepare($membershipQuery);
$membershipStatement->bindParam(':clubID', $clubID);
$membershipStatement->execute();
$membershipResult = $membershipStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = 'Dashboard';
$clubs = 'active-1';
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
                                <a href="./clubs.php" class="d-flex align-items-center">
                                    <i class='bx bx-arrow-back pe-3 back-icon'></i>
                                    <span class="back-text">Back</span>
                                </a>
                            </button>
                            <p class="pt-3">Club Overview</p>
                        </div>
                        <div class="bell-settings pe-4 d-flex">
                            <div class="dropdown">
                                <button class="btn position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-bell icon"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-icon">
                                        13+
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
                                    <li><a class="dropdown-item" href="#">Your Monthly Report</a></li>
                                    <li><a class="dropdown-item" href="#">5 New Afilliated CLub Request</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn ms-2">
                                <i class='bx bx-cog icon'></i>
                            </button>
                        </div>
                    </div>
                    <div class="row ps-2">
                        <div class="col-12 col-md-6 col-lg-5 club-overview-labels mb-4 ps-3">
                            <h3 class="club-name pb-1"><span class="label-club pe-3">Club Name</span><?php echo $club['clubName']; ?></h3>
                            <h4 class="members pb-1"><span class="label-club pe-3">Members</span>35</h4>
                            <h4 class="ageLimit pb-1"><span class="label-club pe-3">Age Limit</span><?php echo $club['clubMinAge'] . ' - ' . $club['clubMaxAge']; ?></h4>
                            <h4 class="clubManager pb-1"><span class="label-club pe-3">Manage By</span><?php foreach ($clubManagementResult as $manager) {
                                echo "{$manager['librarianFirstName']} {$manager['librarianLastName']}<br>";
                            } ?></h4>
                        </div>
                        <div class="col-12 col-md-6 col-lg-7 club-overview-labels">
                            <h3 class="description-label"><span class="label-club pb-1 pe-3">Description</span></h3>
                            <h4 class="description-club"><?php echo $club['clubDescription']; ?></h4>
                        </div>
                        <div class="table-responsive">
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 club-member">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-50px" id="number-row">#</th>
                                        <th class="min-w-250px">Name</th>
                                        <th class="min-w-150px">Email Address</th>
                                        <th class="min-w-300px">Contact Number</th>
                                        <th class="min-w-200px">Gender</th>
                                        <th class="min-w-200px">Address</th>
                                        <th class="min-w-100px">Date Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($membershipResult as $index => $member) { ?>
                                        <tr>
                                            <td class="list-number" id="number-row"><?php echo $index + 1; ?></td>
                                            <td><?php echo "{$member['userFirstName']} {$member['userLastName']}"; ?></td>
                                            <td><?php echo $member['email']; ?></td>
                                            <td><?php echo $member['contactNumber']; ?></td>
                                            <td><?php echo $member['gender']; ?></td>
                                            <td><?php echo $member['address']; ?></td>
                                            <td><?php echo $member['dateJoined']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('../include/js2.php'); ?>
</body>
</html>
