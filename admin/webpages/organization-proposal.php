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

// Fetch organization proposals from the database
$database = new Database();
$db = $database->connect();

// Initialize OrgClub class
$orgClub = new OrgClub();

// Fetch organization proposals
$orgProposals = $orgClub->getOrganizationProposals();

// Fetch organization proposal statuses
$proposalStatuses = $orgClub->getProposalStatus();
?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Organization';
$organization = 'active-1';
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
                            <p class="pt-3">Organization Proposals</p>
                        </div>

                    </div>


                    <div class="row ps-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label active" id="library-clubs-tab" data-bs-toggle="tab" data-bs-target="#library-clubs" type="button" role="tab" aria-controls="library-clubs" aria-selected="true">Inbox</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label" id="affiliated-clubs-tab" data-bs-toggle="tab" data-bs-target="#affiliated-clubs" type="button" role="tab" aria-controls="affiliated-clubs" aria-selected="false">Sent</button>
                            </li> -->
                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <!-- Library Clubs Table -->
                            <div class="tab-pane fade show active pt-3" id="library-clubs" role="tabpanel" aria-labelledby="library-clubs-tab">
                                <!-- <button type="button" class="btn add-btn d-flex justify-content-center align-items-center mb-3" data-bs-toggle="modal" data-bs-target="#sendProposalModal">
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-send button-action-icon me-2'></i>
                                        Send Request
                                    </div>
                                </button> -->


                                <!-- Send Proposal Modal -->
                                <!-- <div class="modal fade" id="sendProposalModal" tabindex="-1" aria-labelledby="sendProposalModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content modal-modification">
                                            <div class="header-modal d-flex justify-content-between">
                                                <h5 class="modal-title mt-4 ms-4" id="sendProposalModalLabel">Send Request</h5>
                                                <button type="button" class="btn-close mt-4 me-4" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body mx-2 mt-2">
                                                SEND REQUEST
                                            </div>
                                            <div class="modal-action-btn d-flex justify-content-end">
                                                <button type="button" class="btn cancel-btn mb-3 me-3" data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn add-btn-2 mb-3 me-4">Send Request</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row">
                                <div class="col-12 scrollable-container-request">
                                    <?php foreach ($orgProposals as $key => $proposal): ?>
                                        <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2 <?= getStatusClass($proposalStatuses[$key]['status']); ?>">
                                            <div class="orgClub-logo me-3">
                                                <img src="../images/dict_logo.png" alt="">
                                            </div>
                                            <?php if (isset($proposal['proposalCreatedAt'])): ?>
                                                <div class="message-details me-auto">
                                                    <?php if (isset($proposal['ocName'])): ?>
                                                        <div class="orgClub-name mb-1"><strong>Organization Name: </strong><?php echo $proposal['ocName']; ?></div>
                                                    <?php else: ?>
                                                        <div class="orgClub-name mb-1">No Name Available</div>
                                                    <?php endif; ?>
                                                    <?php if (isset($proposal['proposalSubject'])): ?>
                                                        <div class="proposal-subject mb-1"><strong>Subject: </strong><?php echo $proposal['proposalSubject']; ?></div>
                                                    <?php endif; ?>
                                                    <?php if (isset($proposal['proposalDescription'])): ?>
                                                        <div class="proposal-description"><strong>Description: </strong><?php echo $proposal['proposalDescription']; ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="proposal-createdAt ms-auto"><strong>Date Sent: </strong><?php echo $proposal['proposalCreatedAt']; ?></div>
                                            <?php endif; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                </div>

                                <?php
                                function getStatusClass($status)
                                {
                                    switch ($status) {
                                        case 'Approved':
                                            return 'bg-success';
                                        case 'Rejected':
                                            return 'bg-danger';
                                        default:
                                            return '';
                                    }
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

</html>
