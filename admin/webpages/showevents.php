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

            // Check if eventGuestLimit is zero, then display "Open to All"
            $guestLimit = $item['eventGuestLimit'] == 0 ? 'Open to All' : $item['eventGuestLimit'];

            // Determine event status
            if ($item['eventStatus'] === null) {
                // Calculate event status based on current date and time
                $currentDateTime = date('Y-m-d H:i:s'); // Get current date and time in MySQL format
                $eventStartDateTime = $item['eventStartDate'] . ' ' . $item['eventStartTime'];
                $eventEndDateTime = $item['eventEndDate'] . ' ' . $item['eventEndTime'];

                if ($currentDateTime < $eventStartDateTime) {
                    $eventStatus = 'Upcoming';
                } elseif ($currentDateTime >= $eventStartDateTime && $currentDateTime <= $eventEndDateTime) {
                    $eventStatus = 'Ongoing';
                } else {
                    $eventStatus = 'Completed';
                }
            } else {
                $eventStatus = $item['eventStatus']; // Use the inputted status
            }
            ?>

            <tr class="event-row" data-event-id="<?= $item['eventID'] ?>">
                <td><?= $counter ?></td>
                <td><?= $item['eventTitle'] ?></td>
                <td><?= $item['eventDescription'] ?></td>
                <td>
                    <?php
                    $facilitatorNames = [];
                    foreach ($eventFacilitators as $facilitator) {
                        $middleInitial = $facilitator['librarianMiddleName'] ? substr($facilitator['librarianMiddleName'], 0, 1) . '.' : '';
                        $facilitatorNames[] = $facilitator['librarianFirstName'] . ' ' . $middleInitial . ' ' . $facilitator['librarianLastName'];
                    }
                    echo implode(', ', $facilitatorNames);
                    ?>
                </td>

                <td>
                    <?php
                    if ($item['eventStartDate'] === $item['eventEndDate']) {
                        echo date('F j, Y', strtotime($item['eventStartDate']));
                    } else {
                        echo date('F j, Y', strtotime($item['eventStartDate'])) . ' to ' . date('F j, Y', strtotime($item['eventEndDate']));
                    }
                    ?>
                    <br>
                    <?php
                    $startTime = date('g:i A', strtotime($item['eventStartTime']));
                    $endTime = date('g:i A', strtotime($item['eventEndTime']));
                    echo $startTime . ' - ' . $endTime;
                    ?>
                </td>
                <td><?= $guestLimit ?></td>
                <td><?= $item['eventBuildingName'] ? $item['eventBuildingName'] . ', ' : '' ?><?= $item['eventStreetName'] . ', ' . $item['eventBarangay'] . ', ' . $item['eventCity'] . ', ' . $item['eventProvince'] . ', ' . $item['eventRegion'] . ' ' . $item['eventZipCode'] ?></td>
                <td>
                    <?php
                    $collaborations = $events->getEventCollaborationDetails($item['eventID']);
                    if (!empty($collaborations)) {
                        foreach ($collaborations as $key => $collaboration) {
                            echo $collaboration['organizationClubName'];
                            if ($key < count($collaborations) - 1) {
                                echo ', ';
                            }
                        }
                    }
                    ?>
                </td>

                <td><?= $eventStatus ?></td>
                <td><?= $item['eventCreatedAt'] ?></td>
                <td><?= $item['eventUpdatedAt'] ?></td>
                <td class="text-center dropdown">
                    <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-dots-vertical-rounded action-icon' aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="../webpages/event-overview.php?eventID=<?php echo $item['eventID']; ?>">
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

                    </ul>
                </td>
            </tr>
            <?php
            $counter++;
        }
    }
}
?>
