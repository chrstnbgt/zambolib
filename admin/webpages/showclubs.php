<?php
require_once '../classes/clubs.class.php';
require_once '../tools/adminfunctions.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $clubs = new Clubs();

    $clubArray = $clubs->show();
    $counter = 1;

    if ($clubArray) {
        foreach ($clubArray as $item) {
            $clubManagers = $clubs->getClubManagers($item['clubID']);
        ?>
            <tr class="club-row" data-event-id="<?= $item['clubID'] ?>">
                <td><?= $counter ?></td>
                <td><?= $item['clubName'] ?></td>
                <td><?= $item['clubDescription'] ?></td>
                <td>
                    <?php
                    foreach ($clubManagers as $manager) {
                        $middleInitial = $manager['librarianMiddleName'] ? substr($manager['librarianMiddleName'], 0, 1) . '.' : '';
                        echo $manager['librarianFirstName'] . ' ' . $middleInitial . ' ' . $manager['librarianLastName'] . '<br>';
                    }
                    ?>
                </td>
                <td><?= ($item['clubMinAge'] == 0 && $item['clubMaxAge'] == 0) ? 'For All Ages' : $item['clubMinAge'] . ' - ' . $item['clubMaxAge'] ?></td>
                <td><?= $item['clubCreatedAt'] ?></td>
                <td><?= $item['clubUpdatedAt'] ?></td>
                
                <td class="text-center dropdown">
                    <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-dots-vertical-rounded action-icon'  aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <!-- <li><a class="dropdown-item" href="./club-overview.php?id=<?php echo $item['clubID']; ?>">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-info-circle action-icon me-2' aria-hidden="true"></i> Overview
                            </div>
                        </a></li> -->
                        <li><a class="dropdown-item" href="../forms/edit-club.php?id=<?php echo $item['clubID']; ?>">
                            <div class="d-flex align-items-center">
                                <i class='bx bx-edit action-icon me-2' aria-hidden="true"></i> Edit
                            </div>
                        </a></li>
                        <li><a class="dropdown-item" href="./removeclubs.php?id=<?php echo $item['clubID']; ?>" onclick="return confirm('Are you sure you want to remove club?')">
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