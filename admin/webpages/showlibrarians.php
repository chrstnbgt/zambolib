<?php
    require_once '../classes/librarian.class.php';
    require_once '../tools/adminfunctions.php';

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $librarian = new Librarian();

        $librarianArray = $librarian->show();
        $counter = 1;

        if ($librarianArray) {
            foreach ($librarianArray as $item) {
    ?>
                <tr class="responsive">
                    <td><?= $counter ?></td>
                    <td><?= $item['librarianLastName'] . ', ' . $item['librarianFirstName'] . ' ' . $item['librarianMiddleName'] ?></td>
                    <td><?= $item['librarianDesignation'] ?></td>
                    <td><?= $item['librarianContactNo'] ?></td>
                    <td><?= $item['librarianEmail'] ?></td>

                    <td><?= $item['librarianEmployment'] ?></td>
                    <td><?= $item['librarianCreatedAt'] ?></td>
                    <td><?= $item['librarianUpdatedAt'] ?></td>
                    <td class="text-center dropdown">
                        <a href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bx bx-dots-vertical-rounded action-icon'  aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="../forms/edit-librarian.php?id=<?php echo $item['librarianID']; ?>" data-bs-toggle="" data-bs-target="#editLibrarian">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-edit action-icon me-2' aria-hidden="true"></i> Edit
                                </div>
                            </a></li>
                            <li><a class="dropdown-item" href="./removelibrarian.php?id=<?php echo $item['librarianID']; ?>" onclick="return confirm('Are you sure you want to remove librarian?')">
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