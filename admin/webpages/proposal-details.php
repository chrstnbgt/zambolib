
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

                        <div class="bell-settings pe-4 d-flex">
                           

                    </div>

                    
                    <div class="row ps-2">
                        <div class="row">
                            <div class="col-12 scrollable-container-request ps-3">
                                <div class="proposal-card mt-4 mx-4">
                                    <div class="row d-flex justify-content-between align-items-center mb-5">
                                        <div class="col-12 col-lg-7">
                                            <div class="proposalTitle mb-2">Cyber Security Awareness Webinar</div>
                                            <div class="orgClubName mb-2">Department of Information, Communication, and Security</div>
                                        </div>

                                        <div class="col-12 col-lg-5 d-flex flex-column align-items-end">
                                            <div class="orgHead d-flex align-items-center mb-3">
                                                <img src="../images/user.png" alt="">
                                                <p class="ms-3 pt-3">Andrei F. De Jesus</p>
                                            </div>

                                            <div class="proposalSentTime">
                                                11 Jan, 2024 03:13 pm
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="proposalDateTime mb-3">Proposed Date and Time: February 12, 2024 (08:00am - 03:00pm)</div>
                                    <div class="proposalDescription">Proposing a comprehensive cybersecurity webinar aimed at educating participants on various aspects, including emerging threats, prevention strategies, best practices, and the latest trends crucial for organizational security enhancement. The webinar will delve into the intricacies of cyber threats, offering insights into effective mitigation techniques and proactive measures. Through interactive sessions and real-world case studies, attendees will gain invaluable knowledge to safeguard their digital assets and mitigate potential risks effectively. Our goal is to empower individuals and organizations with the necessary expertise to navigate the ever-evolving cyber landscape confidently, ensuring resilience and security in the face of emerging challenges.</div>
                                    
                                    <div class="proposalDateTime mt-5">
                                        <p class="d-flex align-items-center label-attached-file"><i class='bx bx-paperclip icon me-2'></i>Attached Files</p>
                                        <div class="files ms-2">
                                            <div class="file-card">
                                                <a href="../files/Clubs.xlsx" target="_blank">Cyber Proposal</a><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-lg-end justify-content-sm-center">
                                        <button class="approve-btn me-3">Approve</button>
                                        <button class="reject-btn">Reject</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require_once('../include/js.php'); ?>

</body>