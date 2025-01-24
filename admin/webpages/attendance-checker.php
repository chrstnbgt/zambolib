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
  $title = 'Attendance Checker';
  $checker = 'active-1';
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
                            <p class="pt-3">Attendance Checker</p>
                        </div>

                    </div>

                    
                    <div class="row ps-2">
                        <div class="container ps-0 mb-2 ps-3 d-flex justify-content-between">
                                <div class="d-flex">
                                    <a href="../forms/add-attendance-checker.php"><button type="button" class="btn add-btn justify-content-center align-items-center me-2" data-bs-toggle="modal" data-bs-target="#addLibrarianModal">
                                        <div class="d-flex align-items-center">
                                            <i class='bx bx-plus-circle button-action-icon me-2'></i>
                                            Add Attendance Checker
                                        </div>
                                    </button></a>

                                </div>

                                <div class="d-flex">
                                    <div class="form-group col-12 col-lg-12 flex-sm-grow-1 flex-lg-grow-0 ps-2">
                                        <select name="checker-employment" id="checker-employment" class="form-select status-filter">
                                            <option value="">All Employment</option>
                                            <option value="Active">Active</option>
                                            <option value="No Longer in Service">No Longer in Service</option>
                                        </select>
                                    </div>

                                </div>      
                            </div>

                            <!-- Include for the Librarian modal -->

                        <div class="table-responsive">
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 user-table kt-datatable">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-200px">#</th>
                                        <th class="min-w-200px">Checker Name</th>
                                        <th class="min-w-300px">Contact Number</th>
                                        <th class="min-w-200px">Email</th>
                                        <th class="min-w-100px">Employment</th>
                                        <th class="min-w-100px">Created At</th>
                                        <th class="min-w-100px">Updated At</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="checkerTableBody">
                                <?php
                                    include('showchecker.php')
                                ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php require_once('../include/js.php'); ?>
    <script>
    $(document).ready(function() {
        var table = $('#kt_datatable_both_scrolls').DataTable();

        $('#checker-employment').on('change', function() {
            var status = $(this).val();
            table.column(5).search(status).draw();
        });
    });
</script>

</body>
</html>