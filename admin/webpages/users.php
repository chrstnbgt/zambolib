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
  $title = 'Users';
  $users = 'active-1';
  require_once('../include/head.php');
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
                            <p class="pt-3">Users</p>
                        </div>

                        <div class="bell-settings pe-4 d-flex">
                            <!-- Notification Dropdown -->
                            <div class="dropdown">
                                <button class="btn position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-bell icon"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-icon">
                                        13+
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
                                    <!-- Dropdown items go here -->
                                    <li><a class="dropdown-item" href="#">Your Monthly Report</a></li>
                                    <li><a class="dropdown-item" href="#">5 New Afilliated CLub Request</a></li>
                                    <!-- Add more dropdown items as needed -->
                                </ul>
                            </div>

                            <!-- Settings Button -->
                            <button type="button" class="btn ms-2">
                                <i class='bx bx-cog icon'></i>
                            </button>
                        </div>

                    </div>

                    
                    <div class="row ps-2">
                        <div class="table-responsive">
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 user-table">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-200px">#</th>
                                        <th class="min-w-200px">Name</th>
                                        <th class="min-w-150px">Gender</th>
                                        <th class="min-w-300px">Date of Birth</th>
                                        <th class="min-w-200px">Age</th>
                                        <th class="min-w-100px">Contact Number</th>
                                        <th class="min-w-100px">School/Office</th>
                                        <th class="min-w-100px">Civil Status</th>
                                        <th class="min-w-100px">Address</th>
                                        <th class="min-w-150px">Created At</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                <?php
                                require_once '../classes/user.class.php';

                                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                                    $user = new User();

                                    $userArray = $user->show();
                                    $counter = 1;

                                    if ($userArray) {
                                        foreach ($userArray as $item) {
                                            ?>
                                            <tr class="responsive">
                                                <td><?= $counter ?></td>
                                                <td><?= $item['userLastName'] . ', ' . $item['userFirstName'] . ' ' . $item['userMiddleName'] ?></td>
                                                <td><?= $item['userGender'] ?></td>
                                                <td><?= $item['userBirthdate'] ?></td>
                                                <td><?= $item['userAge'] ?></td>
                                                <td><?= $item['userContactNo'] ?></td>
                                                <td><?= $item['userSchoolOffice'] ?></td>
                                                <td><?= $item['userCivilStatus'] ?></td>
                                                <td><?= $item['userStreetName'] . ($item['userStreetName'] ? ', ' : '') . $item['userBarangay'] . ($item['userBarangay'] ? ', ' : '') . $item['userCity'] . ($item['userCity'] ? ', ' : '') . $item['userProvince'] . ($item['userProvince'] ? ', ' : '') . $item['userRegion'] . ($item['userRegion'] ? ' ' : '') . $item['userZipCode'] ?></td>
                                                <td><?= $item['userCreatedAt'] ?></td>
                                            
                                            </tr>
                                            <?php
                                            $counter++;
                                        }
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


    <?php require_once('../include//js.php'); ?>

</body>