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
                            <p class="pt-3">Organizations</p>
                        </div>        
                    </div>
                    <div class="row ps-2">
                        <a href="organization-proposal.php" class="btn add-btn col-12 col-md-6 col-lg-2 d-flex justify-content-center align-items-center mb-2 ms-3">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-file button-action-icon me-2'></i>
                                Proposals
                            </div>
                        </a>
                    <div class="col-lg-5 col-md-4">
                        <a href="./org-request.php"><button type="button" class="btn request-btn d-flex justify-content-center align-items-center mb-2" data-bs-toggle="" data-bs-target="#">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-file action-icon me-2'></i>
                                Request
                            </div>
                        </button></a>

                        <div class="dropdown d-flex">
                        <button class="btn download-btn dropdown-toggle" type="button" id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Download
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                            <li><a class="dropdown-item" href="#" onclick="downloadAsPdfOrg()">Download as PDF</a></li>
                            <li><a class="dropdown-item" href="#" onclick="downloadAsExcelOrg()">Download as Excel</a></li>
                        </ul>
                    </div>
                    </div>

                        <div class="table-responsive">
                            <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7 user-table kt-datatable">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800">
                                        <th class="min-w-200px">#</th>
                                        <th class="min-w-200px">Organization Name</th>
                                        <th class="min-w-150px">Representative Name</th>
                                        <th class="min-w-300px">Email</th>
                                        <th class="min-w-200px">Contact No.</th>
                                        <th class="min-w-100px">Date Affiliated</th>
                                        <th scope="col" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="orgTableBody">
                                    <?php
                                        include('showorgs.php')
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

</body>
</html>
<script>
    function downloadAsPdfOrg() {
        window.jsPDF = window.jspdf.jsPDF;

        const doc = new jsPDF();
        doc.autoTable({html: '#kt_datatable_horizontal_scroll'});
        doc.save('orgs.pdf');
    }

    function downloadAsExcelOrg() {
        const table = document.getElementById('kt_datatable_horizontal_scroll');
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, 'orgs.xlsx');
    }
</script>