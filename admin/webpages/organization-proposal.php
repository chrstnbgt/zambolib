
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
                            <li class="nav-item" role="presentation">
                                <button class="nav-link tab-label" id="affiliated-clubs-tab" data-bs-toggle="tab" data-bs-target="#affiliated-clubs" type="button" role="tab" aria-controls="affiliated-clubs" aria-selected="false">Sent</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">

                        <!-- Library Clubs Table -->
                        <div class="tab-pane fade show active pt-3" id="library-clubs" role="tabpanel" aria-labelledby="library-clubs-tab">
                        <button type="button" class="btn add-btn d-flex justify-content-center align-items-center mb-3" data-bs-toggle="modal" data-bs-target="#sendProposalModal">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-send button-action-icon me-2'></i>
                                Send Request
                            </div>
                        </button>


                        <!-- Send Proposal Modal -->
                        <div class="modal fade" id="sendProposalModal" tabindex="-1" aria-labelledby="sendProposalModalLabel" aria-hidden="true">
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
                        </div>

                        <div class="row">
                            <div class="col-12 scrollable-container-request">
                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>

                                <a href="./proposal-details.php" class="message-card d-flex align-items-center min-w px-3 py-2 mb-2">
                                    <div class="orgClub-logo me-3">
                                        <img src="../images/dict_logo.png" alt="">
                                    </div>
                                    <div class="message-details me-3">
                                        <div class="orgClub-name mb-1">Department of Information, Communication, and Technology</div>
                                        <div class="request-title mb-1">Cyber Security Awareness Webinar</div>
                                        <div class="short-description">Proposing a cybersecurity webinar to educate on threats, prevention, best practices, and emerging trends for organizational security...</div>
                                    </div>
                                    <div class="message-dateTime">11 Jan, 2024</div>
                                </a>
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

</body>