<?php
session_start();
include "../../utils/isNotLoggedIn.php";
include "../../utils/koneksi.php";

$rootDirectory = "/unikma";

$itemsPerPage = 10;
$totalItemsQuery = "SELECT COUNT(*) AS total FROM ukm";
$result = $conn->query($totalItemsQuery);
$totalItems = $result->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$startItem = ($currentPage - 1) * $itemsPerPage;

$query = "
    SELECT 
        ukm.id_ukm,
        ukm.nama_ukm, 
        ukm.deskripsi, 
        users.nama AS ketua_nama, 
        ukm.kontak 
    FROM 
        ukm 
    LEFT JOIN 
        users 
    ON 
        ukm.ketua_ukm = users.id_user 
    LIMIT $startItem, $itemsPerPage
";
$data = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEMPLATE APLIKASI</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div id="template">
        <div id="header">
            <h1>UNIKMA Dashboard</h1>
            <p>Kamu login sebagai: <?= $_SESSION["role"] ?></p>
        </div>
        <div id="menu">
            <ul>
                <li><a href="<?= $rootDirectory ?>">Beranda</a></li>
                <li><a href="<?= $rootDirectory ?>/logout.php">Logout</a></li>
            </ul>
        </div>

        <div id="content-wrapper">
            <div id="content">

                <div class="action-buttons">
                    <a class="add" href="action/add.php">Tambah UKM</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Nama UKM</th>
                            <th>Deskripsi</th>
                            <th>Ketua UKM</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data->num_rows > 0): ?>
                            <?php while ($row = $data->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['nama_ukm'] ?></td>
                                    <td><?= $row['deskripsi'] ?></td>
                                    <td><?= $row['ketua_nama'] ?></td>
                                    <td><?= $row['kontak'] ?></td>
                                    <td>
                                        <a class="edit" href="action/edit.php?id=<?= $row["id_ukm"] ?>">Edit</a>
                                        <a class="delete" href="action/delete.php?id=<?= $row["id_ukm"] ?>">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No data found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=1">First</a>
                        <a href="?page=<?= $currentPage - 1 ?>">Previous</a>
                    <?php endif; ?>
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?= $currentPage + 1 ?>">Next</a>
                        <a href="?page=<?= $totalPages ?>">Last</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div id="footer">Copyright &copy; <?= date('Y') ?>. All rights reserved</div>
    </div>

    <?php

    $conn->close();
    ?>
</body>
</html>