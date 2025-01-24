<?php
require_once '../classes/events.class.php';
require_once '../tools/adminfunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $events = new Events();

    $eventsArray = $events->show();
    $counter = 1;

    if ($eventsArray) {
        foreach ($eventsArray as $item) {
            $eventFacilitators = $events->getEventFacilitators($item['eventID']);
            
            ?>
            <tr class="event-row" data-event-id="<?= $item['eventID'] ?>">
                <td><?= $counter ?></td>
                <td><?= $item['eventTitle'] ?></td>
                <td><?= $item['eventDescription'] ?></td>
                <td>
                    <?php
                    foreach ($eventFacilitators as $facilitator) {
                        $middleInitial = $facilitator['librarianMiddleName'] ? substr($facilitator['librarianMiddleName'], 0, 1) . '.' : '';
                        echo $facilitator['librarianFirstName'] . ' ' . $middleInitial . ' ' . $facilitator['librarianLastName'] . '<br>';
                    }
                    ?>
                </td>
                <td><?= $item['eventStartDate'] . ' to ' . $item['eventEndDate'] . '<br>' . $item['eventStartTime'] . ' - ' . $item['eventEndTime'] ?></td>
                <td><?= $item['eventGuestLimit'] ?></td>
                <td><?= $item['eventBuildingName'] ? $item['eventBuildingName'] . ', ' : '' ?><?= $item['eventStreetName'] . ', ' . $item['eventBarangay'] . ', ' . $item['eventCity'] . ', ' . $item['eventProvince'] . ', ' . $item['eventRegion'] . ' ' . $item['eventZipCode'] ?></td>
                <td><?= $item['eventStatus'] ?></td>
                <td><?= $item['eventCreatedAt'] ?></td>
                <td><?= $item['eventUpdatedAt'] ?></td>
                <td class="text-center dropdown">
                    <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-dots-vertical-rounded action-icon' aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="./event-overview.php?id=<?php echo $item['eventID']; ?>" data-bs-toggle="modal">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-info-circle action-icon me-2' aria-hidden="true"></i> Overview
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="../forms/edit-event.php?id=<?php echo $item['eventID']; ?>">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-edit action-icon me-2' aria-hidden="true"></i> Edit
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="./removeevents.php?id=<?php echo $item['eventID']; ?>" onclick="return confirm('Are you sure you want to remove event?')">
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