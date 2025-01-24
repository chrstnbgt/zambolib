
<!DOCTYPE html>
<html lang="en">

<?php
  $title = 'Attendance';
  $attendance = 'active-1';
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
                            <p class="pt-3">Attendance</p>
                        </div>

                    </div>

                    
                    <div class="row ps-2">
                        <button type="button" class="btn download-btn d-flex col-12 col-md-6 col-lg-2 justify-content-center align-items-center mb-3 ms-3">
                            <div class="d-flex align-items-center">
                                <i class='bx bxs-download action-icon-3 me-2'></i>
                                Download
                            </div>
                        </button>
                        <div class="table-responsive">
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 user-table kt-datatable">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-200px">Date</th>
                                        <th class="min-w-150px">Time</th>
                                        <th class="min-w-300px">Name</th>
                                        <th class="min-w-200px">Gender</th>
                                        <th class="min-w-100px">Age</th>
                                        <th class="min-w-100px">School/Office</th>
                                        <th class="min-w-100px">Address</th>
                                        <th class="min-w-100px">Contact No.</th>
                                        <th class="min-w-100px">Purpose</th>
                                        <th class="min-w-100px">Recorded By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2024-02-12</td>
                                        <td>14:27:52</td>
                                        <td>Kim Badilles</td>
                                        <td>LGBTQ+</td>
                                        <td>23</td>
                                        <td>WMSU</td>
                                        <td>San Roque, Zamboanga City</td>
                                        <td>0943-671-2334</td>
                                        <td>Research</td>
                                        <td>Rafael Marcedez</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require_once('../include/js.php'); ?>

</body>