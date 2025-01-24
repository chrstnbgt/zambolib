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
  $title = 'Clubs';
  $clubs = 'active-1';
  require_once('../include/head.php');
  
  $database = new Database();
    $connection = $database->connect();

    $librarianQuery = "SELECT DISTINCT l.* FROM librarian l
    JOIN club_management cm ON l.librarianID = cm.librarianID
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
                            <p class="pt-3">Clubs</p>
                        </div>

                 


                    </div>

                    
                    <div class="row ps-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label active" id="library-clubs-tab" data-bs-toggle="tab" data-bs-target="#library-clubs" type="button" role="tab" aria-controls="library-clubs" aria-selected="true">Library CLubs</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label" id="affiliated-clubs-tab" data-bs-toggle="tab" data-bs-target="#affiliated-clubs" type="button" role="tab" aria-controls="affiliated-clubs" aria-selected="false">Affiliated Clubs</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                        <!-- Library Clubs Table -->
                        <div class="tab-pane fade show active pt-3" id="library-clubs" role="tabpanel" aria-labelledby="library-clubs-tab">
                        <a href="../forms/add-clubs.php"><button type="button" class="btn add-btn d-flex justify-content-center align-items-center mb-2" data-bs-toggle="modal" data-bs-target="#addClubModal">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-plus-circle button-action-icon me-2'></i>
                                Add Club
                            </div>
                        </button></a>

                            <div class="table-responsive">
                                
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="min-w-200px">#</th>
                                            <th class="min-w-200px">Club Name</th>
                                            <th class="min-w-150px">Description</th>
                                            <th class="min-w-300px">Club Manager</th>
                                            <th class="min-w-200px">Age Range</th>
                                            <!-- <th class="min-w-100px">No. of Members</th> -->
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px">Updated At</th>
                                            <th scope="col" width="5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="clubTableBody">
                                        <?php
                                            include('showclubs.php')
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <!-- Affiliated Clubs Table -->
                        <div class="tab-pane fade active pt-3" id="affiliated-clubs" role="tabpanel" aria-labelledby="affiliated-clubs-tab">
                            <a href="./affiliated-club-request.php"><button type="button" class="btn request-btn d-flex justify-content-center align-items-center mb-2" data-bs-toggle="" data-bs-target="#">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-file action-icon me-2'></i>
                                    Request
                                </div>
                            </button></a>

                        <div class="table-responsive">
                            
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-250px">#</th>
                                        <th class="min-w-250px">Club Name</th>
                                        <th class="min-w-300px">Representative Name</th>
                                        <!-- <th class="min-w-200px">No. of Members</th> -->
                                        <th class="min-w-150px">Email</th>
                                        <th class="min-w-100px">Contact Number</th>
                                        <th class="min-w-100px">Date Affiliated</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="affiliateClubsTableBody">
                                <?php
                                    include('showaffiliateclubs.php')
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


    <?php require_once('../include//js.php'); ?>

</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Check if the URL contains the announcements tab hash
        if (window.location.hash === '#affiliated-clubs') {
            // Scroll to the announcements tab
            var tab = document.querySelector('#affiliated-clubs-tab');
            if (tab) {
                tab.click(); // Activate the tab
                tab.scrollIntoView({ behavior: 'smooth' }); // Scroll to the tab
            }
        }
    });
</script>