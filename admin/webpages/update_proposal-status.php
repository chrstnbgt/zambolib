<?php
// update_status.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../classes/database.php');
    $db = new Database();
    $conn = $db->connect();

    $orgProposalID = $_POST['orgProposalID'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 'Approved' : 'Rejected';

    $query = "UPDATE org_proposal SET status = :status WHERE org_proposalID = :orgProposalID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':orgProposalID', $orgProposalID);
    $stmt->execute();

    // You can echo a response if needed
    echo 'Status updated successfully';
}
?>
