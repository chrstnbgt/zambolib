<?php
require_once '../classes/orgclub.class.php';
require_once '../tools/adminfunctions.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $clubs = new OrgClub();

    $clubArray = $clubs->show();
    $counter = 1;

    if ($clubArray) {
        foreach ($clubArray as $item) {
            // Only show rows where organizationClubType is "Club"
            if ($item['organizationClubType'] == "Club" && $item['ocStatus'] == "Approved") {
                $userFullName = $item['userFirstName'] . ' ' . ($item['userMiddleName'] ? $item['userMiddleName'] . ' ' : '') . $item['userLastName'];
                ?>
                <tr class="club-row" data-event-id="<?= $item['organizationClubID'] ?>">
                    <td><?= $counter ?></td>
                    <td><?= $item['ocName'] ?></td>
                    <td><?= $userFullName ?></td>
                   
                    <td><?= $item['ocEmail'] ?></td>
                    <td><?= $item['ocContactNumber'] ?></td>
                    <td><?= $item['ocCreatedAt'] ?></td>

                    <td class="text-center dropdown">
                        <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-dots-vertical-rounded action-icon'  aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            
                            <li><a class="dropdown-item" href="./removeaffiliateclub.php?id=<?php echo $item['organizationClubID']; ?>" onclick="return confirm('Are you sure you want to remove club?')">
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
}
?>
