<?php

require_once "../config.php";

include ('fungsi.php');

$admin_user = query("SELECT * FROM tbl_user");

$title = "Dashboard";
require_once "../template_admin/header.php";
require_once "../template_admin/navbar.php";
require_once "../template_admin/sidebar.php";
require_once "../template_admin/sidebar.php";

?>
<head>
    <style>
        table {
            margin: auto;
            text-align: center;
        }

        th,
        td {
            padding: 10px;
        }
        .edit-button {
            background-color: #000;
            color: white;
            padding: 10px 25px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: auto;
        }
    </style>
</head>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 justify-content-center">
            <h1 class="mt-4 mb-5">List Username</h1>
            <div class="container justify-content-center">
                <table class="table" cellspacing="0" cellpadding="8" border="1" style="border-collapse: collapse; ">
                    <thead style="background-color: #f2f2f2;">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Update Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admin_user as $row) : ?>
                            <tr>
                                <td><?= $row["id"]; ?></td>
                                <td><?= $row["username"]; ?></td>
                                <td><?= $row["password"]; ?></td>
                                <td>
                                <button type="submit" name="submit" class="edit-button" onclick="window.location.href='edit_user.php?id=<?= $row["id"]; ?>'">Edit</button>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>



<?php

require_once "../template_admin/footer.php";

?>