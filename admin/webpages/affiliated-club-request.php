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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                            <p class="pt-3">Club Requests</p>
                        </div>

                        <div class="bell-settings pe-4 d-flex">
                            <!-- Notification Dropdown -->


                    </div>

                    

                    <div class="row">
                        <div class="col-12">
                            <?php
                            // Check if organization clubs are fetched
                            if (!empty($organizationClubs)) {
                                // Loop through organization clubs and display them
                                foreach ($organizationClubs as $OrgClub) {
                                    $from = $OrgClub["userFirstName"] . " " . $OrgClub["userLastName"];
                                    echo "<a href=\"#\" class=\"message-card d-flex align-items-center min-w px-3 py-2 mb-2\">
                                            <div class=\"orgClub-logo me-3\">
                                                <img src=\"../images/dict_logo.png\" alt=\"\">
                                            </div>
                                            <div class=\"message-details me-3\">
                                                <div class=\"request-title mb-1\">" . $OrgClub["ocName"] . "</div>
                                                <div class=\"short-description\">From: " . $from . "</div>
                                                <div class=\"short-description\">Email: " . $OrgClub["ocEmail"] . "</div>
                                                <div class=\"short-description\">Contact Number: " . $OrgClub["ocContactNumber"] . "</div>
                                                <div class=\"short-description\">Date: " . $OrgClub["ocCreatedAt"] . "</div>
                                            </div>
                                            <div class=\"ml-auto\">
                                                <button class=\"btn btn-success me-2 accept-club\" data-club-id=\"" . $OrgClub["organizationClubID"] . "\">Accept</button>
                                                <button class=\"btn btn-danger reject-club\" data-club-id=\"" . $OrgClub["organizationClubID"] . "\">Reject</button>
                                            </div>
                                        </a>";
                                }
                            } else {
                                echo "<p>No affiliated clubs found</p>";
                            }
                            ?>
                        </div>
                    </div>
                        </div>

                        <!-- Affiliated Clubs Table -->
                        <div class="tab-pane fade active pt-3" id="affiliated-clubs" role="tabpanel" aria-labelledby="affiliated-clubs-tab">

                        </div>

                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>


    <?php require_once('../include/js.php'); ?>
<script>
    $(document).ready(function() {
    // Handle accept button click
    $('.accept-club').click(function() {
        var organizationClubID = $(this).data('organizationclubid');
        var card = $(this).closest('.message-card');
        $.ajax({
            url: 'accept-club.php',
            method: 'POST',
            data: { organizationClubID: organizationClubID },
            success: function(response) {
                // Handle success response
                console.log(response);
                card.remove(); // Remove the card from the DOM
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });

    // Handle reject button click
    $('.reject-club').click(function() {
        var organizationClubID = $(this).data('organizationclubid');
        var card = $(this).closest('.message-card');
        $.ajax({
            url: 'reject-club.php',
            method: 'POST',
            data: { organizationClubID: organizationClubID },
            success: function(response) {
                // Handle success response
                console.log(response);
                card.remove(); // Remove the card from the DOM
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(xhr.responseText);
            }
        });
    });

});

</script>

</body>
</html>
