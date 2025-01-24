<?php
require_once('../classes/database.php');
require_once('../classes/orgclub.class.php');
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
// Create an instance of the Clubs class
$OrgClub = new OrgClub();

// Fetch organization club details
$organizationClubs = $OrgClub->getOrganizationClubDetails();

?>
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Clubs';
  $clubs = 'active-1';
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
                        <div class="heading-name d-flex">
                        <button class="back-btn me-4" onclick="goBack()">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-arrow-back pe-3 back-icon'></i>
                                <span class="back-text">Back</span>
                            </div>
                        </button>

                            <p class="pt-3">Club Request</p>
                        </div>

                        <div class="bell-settings pe-4 d-flex">
                            <!-- Notification Dropdown -->


                    </div>

                    
                    <div class="row ps-2">
                        <div class="row">
                            <div class="col-12 scrollable-container-request ps-3">
                                <?php
                                    // Check if organization clubs are fetched
                                    if (!empty($organizationClubs)) {
                                        // Loop through organization clubs and display them
                                        foreach ($organizationClubs as $OrgClub) {
                                            echo "<div class=\"proposal-card mt-4 mx-4\">
                                                    <div class=\"row d-flex justify-content-between align-items-center mb-5\">
                                                        <div class=\"col-12 col-lg-7\">
                                                            <div class=\"proposalTitle mb-2\">" . $OrgClub["ocName"] . "</div>
                                                            
                                                        </div>
                                                        <div class=\"col-12 col-lg-5 d-flex flex-column align-items-end\">
                                                            <div class=\"orgHead d-flex align-items-center mb-3\">
                                                                <img src=\"../images/user.png\" alt=\"\">
                                                                <p class=\"ms-3 pt-3\">" . $OrgClub["userName"] . "</p>
                                                            </div>
                                                            <div class=\"proposalSentTime\">" . $OrgClub["ocCreatedAt"] . "</div>
                                                        </div>
                                                    </div>
                                                    <div class=\"proposalDescription\">" . $OrgClub["ocEmail"] . "</div>
                                                    <div class=\"proposalDescription\">" . $OrgClub["ocContactNumber"] . "</div>
                                                    <div class=\"proposalDescription\">" . $OrgClub["ocStatus"] . "</div>
                                                    <div class=\"col-12 d-flex justify-content-lg-end justify-content-sm-center\">
                                                        <button class=\"approve-btn me-3\">Approve</button>
                                                        <button class=\"reject-btn\">Reject</button>
                                                    </div>
                                                </div>";
                                        }
                                    } else {
                                        echo "<p>No organization clubs found</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require_once('../include/js.php'); ?>

</body>
