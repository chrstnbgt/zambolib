<?php
require_once '../classes/attendancechecker.class.php';
require_once '../tools/adminfunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $attendanceChecker = new AttendanceChecker();

    $attendanceCheckerArray = $attendanceChecker->show();
    $counter = 1;

    if ($attendanceCheckerArray) {
        foreach ($attendanceCheckerArray as $item) {
?>
            <tr class="responsive">
                <td><?= $counter ?></td>
                <td><?= $item['acLastName'] . ', ' . $item['acFirstName'] . ' ' . $item['acMiddleName'] ?></td>
                <td><?= $item['acContactNo'] ?></td>
                <td><?= $item['acEmail'] ?></td>
                <td><?= $item['acEmployment'] ?></td>
                <td><?= $item['acCreatedAt'] ?></td>
                <td><?= $item['acUpdatedAt'] ?></td>
                <td class="text-center dropdown">
                    <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-dots-vertical-rounded action-icon' aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="../forms/edit-attendance-checker.php?id=<?php echo $item['attendanceCheckerID']; ?>">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-edit action-icon me-2' aria-hidden="true"></i> Edit
                                </div>
                            </a></li>
                        <li><a class="dropdown-item" href="./removeattendancechecker.php?id=<?php echo $item['attendanceCheckerID']; ?>" onclick="return confirm('Are you sure you want to remove attendance checker?')">
                                <div class="d-flex align-items-center text-danger">
                                    <i class='bx bx-trash action-icon me-2 text-danger' aria-hidden="true"></i> Delete
                                </div>
                            </a></li>
                        <li><a class="dropdown-item" href="#" onclick="downloadRowData()">
                                <div class="d-flex align-items-center text-success">
                                    <i class='bx bxs-download action-icon me-2 text-success' aria-hidden="true"></i> Download
                                </div>
                            </a></li>
                    </ul>
                </td>
            </tr>
<?php
            $counter++;
        }
    }
}
?>
