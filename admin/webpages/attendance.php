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
                        <div class="dropdown">
                            <button class="btn download-btn dropdown-toggle" type="button" id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bxs-download action-icon-3 me-2'></i>Download
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="downloadDropdown">
                                <li><a class="dropdown-item" href="#" onclick="downloadAsPdf()">Download as PDF</a></li>
                                <li><a class="dropdown-item" href="#" onclick="downloadAsExcel()">Download as Excel</a></li>
                            </ul>
                        </div>
                        
                        <?php
                            require_once '../classes/attendance.class.php';
                        
                            $attendance = new Attendance();
                            $attendances = $attendance->show();
                        ?>
                        
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
                                        <th class="min-w-100px">Checked By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($attendances as $attendance): ?>
                                    <tr>
                                        <td><?php echo $attendance['dateEntered']; ?></td>
                                        <td><?php echo $attendance['timeEntered']; ?></td>
                                        <td><?php echo $attendance['userFirstName'] . ' ' . $attendance['userMiddleName'] . ' ' . $attendance['userLastName']; ?></td>
                                        <td><?php echo $attendance['userGender']; ?></td>
                                        <td><?php echo $attendance['userAge']; ?></td>
                                        <td><?php echo $attendance['userSchoolOffice']; ?></td>
                                        <td><?php echo $attendance['userStreetName'] . ', ' . $attendance['userBarangay'] . ', ' . $attendance['userCity']; ?></td>
                                        <td><?php echo $attendance['userContactNo']; ?></td>
                                        <td><?php echo $attendance['purpose']; ?></td>
                                        <td><?php echo $attendance['acFirstName'] . ' ' . $attendance['acMiddleName'] . ' ' . $attendance['acLastName']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
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
    function downloadAsPdf() {
        window.jsPDF = window.jspdf.jsPDF;

        const doc = new jsPDF();
        doc.autoTable({html: '#kt_datatable_both_scrolls'});
        doc.save('attendance.pdf');
    }

    function downloadAsExcel() {
        const table = document.getElementById('kt_datatable_both_scrolls');
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, 'attendance.xlsx');
    }
</script>

</body>