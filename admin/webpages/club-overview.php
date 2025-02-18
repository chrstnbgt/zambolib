<?php

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin'){
    header('location: ./index.php');
}
require_once '../classes/clubs.class.php';
if(isset($_GET['clubID'])){
    $club =  new Clubs();
    $record = $club->fetch($_GET['clubID']);
    $club->clubID = $record['clubID'];
    $club->clubName = $record['clubName'];
    $club->clubMinAge = $record['clubMinAge'];
    $club->clubMaxAge = $record['clubMaxAge'];
    $club->clubDescription = $record['clubDescription'];
    $clubManagers = $club->getClubManagers($_GET['clubID']);
    $memberCount = $club->getMemberCount($_GET['clubID']);
    $members = $club->getClubMembers($_GET['clubID']);
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Club Overview';
$clubs = 'active-1';
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
                            <a href="./clubs.php" class="d-flex align-items-center">
                                <i class='bx bx-arrow-back pe-3 back-icon'></i>
                                <span class="back-text">Back</span>
                            </a>
                        </button>

                        <p class="pt-3">Club Overview</p>
                    </div>



                </div>

                <div class="row ps-2">

                    <div class="row club-overview-details-container">
                        <div class="col-12 col-md-6 col-lg-5 club-overview-labels mb-4 ps-3">
                            <h4 class="club-name pb-1"><span class="label-club pe-3">Club Name</span><?php echo isset($club) ? $club->clubName : ''; ?></h4>
                            <h4 class="members pb-1"><span class="label-club pe-3">Members</span><?php echo isset($memberCount) ? $memberCount : ''; ?></h4>
                            <h4 class="ageLimit pb-1"><span class="label-club pe-3">Age Limit</span><?php echo (isset($club) && isset($club->clubMinAge) && isset($club->clubMaxAge)) ? $club->clubMinAge . "-" . $club->clubMaxAge : ''; ?></h4>
                            <h4 class="clubManager pb-1"><span class="label-club pe-3">Manage By
                                <?php
                                if (isset($clubManagers) && is_array($clubManagers)) {
                                    foreach ($clubManagers as $manager) {
                                        echo $manager['librarianFirstName'] . ' ' . $manager['librarianLastName'];
                                    }
                                }
                                ?>
                            </span>
                            </h4>
                        </div>

                        <div class="col-12 col-md-6 col-lg-7 club-overview-labels">
                            <h3 class="description-label"><span class="label-club pb-1 pe-3">Description</span></h3>
                            <h4 class="description-club"><?php echo isset($club) ? $club->clubDescription : ''; ?></h4>
                        </div>
                    </div>
                    <div class="table-responsive">



                        <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 club-member">
                            <thead>
                            <tr class="fw-semibold fs-6 text-gray-800">
                                <?php $counter = 1;?>
                                <th class="min-w-10px" id="number-row">#</th> <!-- Add a column for the list numbers -->
                                <th class="min-w-150px">Name</th>
                                <th class="min-w-150px">Email Address</th>
                                <th class="min-w-150px">Contact Number</th>
                                <th class="min-w-200px">Gender</th>
                                <th class="min-w-200px">Address</th>
                                <th class="min-w-100px">Date Joined</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Loop through each member
                            if(isset($members) && is_array($members)) {
                                foreach ($members as $member) {
                                    ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?php echo $member['fullName']; ?></td>
                                        <td><?php echo $member['userEmail']; ?></td>
                                        <td><?php echo $member['userContactNo']; ?></td>
                                        <td><?php echo $member['userGender']; ?></td>
                                        <td><?php echo $member['address']; ?></td>
                                        <td><?php echo $member['dateJoined']; ?></td>
                                    </tr>
                                    <?php
                                }
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
<?php require_once('../include/js2.php'); ?>

</body>
</html>