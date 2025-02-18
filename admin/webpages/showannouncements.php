<?php
require_once '../classes/announcement.class.php';
require_once '../tools/adminfunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $announcement = new Announcement();

    $announcementArray = $announcement->show();
    $counter = 1;

    if ($announcementArray) {
        foreach ($announcementArray as $item) {
            // Format the date range
            $formattedDateRange = date("F j, Y", strtotime($item['eaStartDate']));
            if ($item['eaStartDate'] != $item['eaEndDate']) {
                $formattedDateRange .= " to " . date("F j, Y", strtotime($item['eaEndDate']));
            }
            // Format the time range
            $formattedTimeRange = date("g:i A", strtotime($item['eaStartTime'])) . " - " . date("g:i A", strtotime($item['eaEndTime']));

?>
            <tr class="responsive">
                <td><?= $counter ?></td>
                <td><?= $item['eaTitle'] ?></td>
                <td><?= $item['eaDescription'] ?></td>
                <td><?= $formattedDateRange ?></td>
                <td><?= $formattedTimeRange ?></td>
                <td><?= $item['eaCreatedAt'] ?></td>
                <td><?= $item['eaUpdatedAt'] ?></td>
                <td class="text-center dropdown">
                    <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-dots-vertical-rounded action-icon' aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="../forms/edit-announcement.php?id=<?php echo $item['eventAnnouncementID']; ?>">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-edit action-icon me-2' aria-hidden="true"></i> Edit
                                </div>
                            </a></li>
                        <li><a class="dropdown-item" href="./removeannouncement.php?id=<?php echo $item['eventAnnouncementID']; ?>" onclick="return confirm('Are you sure you want to remove announcement?')">
                                <div class="d-flex align-items-center text-danger">
                                    <i class='bx bx-trash action-icon me-2 text-danger' aria-hidden="true"></i> Delete
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
