<?php
require_once('../classes/database.php');
require_once('../classes/orgclub.class.php');

session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    header('location: ./index.php');
    exit(); // Always exit after a header redirect
}

$db = new Database();
$conn = $db->connect();

// Initialize OrgClub class
$orgClub = new OrgClub();

// Fetch organization proposals
$query = "SELECT org_proposalID, organizationClubID, proposalID, status FROM org_proposal";
$stmt = $conn->prepare($query);
$stmt->execute();
$org_proposals = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                    <div class="heading-name d-flex">
                        <button class="back-btn me-4" onclick="goBack()">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-arrow-back pe-3 back-icon'></i>
                                <span class="back-text">Back</span>
                            </div>
                        </button>

                        <p class="pt-3">Organization Proposals</p>
                    </div>

                </div>


                <div class="row ps-2">
                    <div class="row">
                        <div class="col-12 scrollable-container-request ps-3">
                            <?php foreach ($org_proposals as $org_proposal): ?>
                                <?php
                                // Fetch proposal details
                                $proposal_id = $org_proposal['proposalID'];
                                $query = "SELECT * FROM proposal WHERE proposalID = :proposal_id";
                                $stmt = $conn->prepare($query);
                                $stmt->bindParam(':proposal_id', $proposal_id);
                                $stmt->execute();
                                $proposal = $stmt->fetch(PDO::FETCH_ASSOC);

                                // Fetch user details
                                $user_id = isset($proposal['userID']) ? $proposal['userID'] : null; // Assuming the userID associated with Andrei F. De Jesus is stored in the proposal table
                                if ($user_id) {
                                    $query = "SELECT userFirstName, userLastName FROM users WHERE userID = :user_id";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bindParam(':user_id', $user_id);
                                    $stmt->execute();
                                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                                }

                                // Check if the proposal is already approved or rejected
                                $statusText = '';
                                $statusColor = '';
                                if ($org_proposal['status'] === 'Approved') {
                                    $statusText = 'APPROVED';
                                    $statusColor = 'text-success'; // Green text
                                } elseif ($org_proposal['status'] === 'Rejected') {
                                    $statusText = 'REJECTED';
                                    $statusColor = 'text-danger'; // Red text
                                }
                                ?>
                                <div class="proposal-card mt-4 mx-4">
                                    <div class="row d-flex justify-content-between align-items-center mb-5">
                                        <div class="col-12 col-lg-7">
                                            <div class="proposalSubject mb-2"><strong>SUBJECT: </strong><?= $proposal['proposalSubject']; ?></div>
                                            <?php
                                            $orgClubID = $org_proposal['organizationClubID'];
                                            $orgClubDetails = $orgClub->fetch($orgClubID); // Assuming fetch method retrieves organization details by organizationClubID
                                            if ($orgClubDetails && isset($orgClubDetails['ocName'])): ?>
                                                <div class="ocName mb-2"><strong>ORGANIZATION NAME: </strong><?= $orgClubDetails['ocName']; ?></div>
                                            <?php else: ?>
                                                <div class="ocName mb-2"><strong>ORGANIZATION NAME: </strong>No Name Available</div>
                                            <?php endif; ?>
                                        </div>


                                        <div class="col-12 col-lg-5 d-flex flex-column align-items-end">
                                        <div class="orgHead d-flex align-items-center mb-3">
                                            <?php
                                            $userID = $orgClubDetails['userID'];
                                            $query = "SELECT u.userFirstName, u.userLastName 
                                                    FROM user u
                                                    JOIN organization_club oc ON u.userID = oc.userID
                                                    WHERE oc.userID = :userID";
                                            $stmt = $conn->prepare($query);
                                            $stmt->bindParam(':userID', $userID);
                                            $stmt->execute();
                                            $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
                                            if ($userDetails && isset($userDetails['userFirstName']) && isset($userDetails['userLastName'])): ?>
                                                <p class="ms-3 pt-3"><?= $userDetails['userFirstName'] . ' ' . $userDetails['userLastName']; ?></p>
                                            <?php else: ?>
                                                <p class="ms-3 pt-3">No User Name Available</p>
                                            <?php endif; ?>
                                        </div>


                                            <div class="proposalCreatedAT">
                                                <?= date('d M, Y h:i A', strtotime($proposal['proposalCreatedAt'])); ?>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="proposalDescription"><?= $proposal['proposalDescription']; ?></div>
                                    <div class="proposalFile mt-5">
                                        <p class="d-flex align-items-center label-attached-file"><i class='bx bx-paperclip icon me-2'></i>Attached Files</p>
                                        <div class="files ms-2">
                                            <div class="file-card">
                                                <?php
                                                $file_path = '../../ZamboLib/User/files/' . $proposal['proposalFile'];
                                                $file_name = basename($file_path);
                                                if (file_exists($file_path)) {
                                                    echo '<a href="' . $file_path . '" target="_blank">' . $file_name . '</a><br>';
                                                } else {
                                                    echo 'File not found';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-lg-end justify-content-sm-center">
                                        <?php if (empty($statusText)): ?>
                                            <button class="approve-btn me-3" data-org-proposal-id="<?= $org_proposal['org_proposalID']; ?>">Approve</button>
                                            <button class="reject-btn" data-org-proposal-id="<?= $org_proposal['org_proposalID']; ?>">Reject</button>
                                        <?php else: ?>
                                            <p class="<?= $statusColor; ?> font-weight-bold fs-5"><strong><?= $statusText; ?></strong></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.approve-btn, .reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                const orgProposalID = this.getAttribute('data-org-proposal-id');
                const action = this.classList.contains('approve-btn') ? 'approve' : 'reject';

                // Send AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_proposal-status.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Reload the page or update the status dynamically
                        location.reload(); // Reload the page for example
                    }
                };
                xhr.send(`orgProposalID=${orgProposalID}&action=${action}`);
            });
        });
    });
</script>

<?php require_once('../include/js.php'); ?>

</body>
</html>
