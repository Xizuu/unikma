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
        pendaftaran.id_pendaftaran,
        pendaftaran.ukm_id,
        ukm.nama_ukm, 
        ukm.deskripsi, 
        users.nama AS ketua_nama, 
        ukm.kontak,
        pendaftaran.user_id,
        pendaftaran.tanggal_daftar,
        pendaftaran.status_pendaftaran
    FROM 
        pendaftaran
    LEFT JOIN 
        ukm ON pendaftaran.ukm_id = ukm.id_ukm
    LEFT JOIN 
        users ON pendaftaran.user_id = users.id_user
    WHERE 
        pendaftaran.status_pendaftaran IN ('accepted', 'pending')
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
                <li><a href="rejected_list.php">Daftar ditolak</a></li>
                <li><a href="<?= $rootDirectory ?>/logout.php">Logout</a></li>
            </ul>
        </div>

        <div id="content-wrapper">
            <div id="content">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>UKM</th>
                            <th>Mendaftar Pada</th>
                            <th>Status Pendaftaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data->num_rows > 0): ?>
                            <?php while ($row = $data->fetch_assoc()): ?>
                                <tr>
                                <td><?= $row['ketua_nama'] ?></td>
                                <td><?= $row['nama_ukm'] ?></td>
                                <td><?= $row['tanggal_daftar'] ?></td>
                                <td><?= $row['status_pendaftaran'] ?></td>
                                <td>
                                    <?php if ($row['status_pendaftaran'] === 'pending') : ?>
                                        <a class="edit" href="action/terima.php?id=<?= $row["id_pendaftaran"] ?>">Terima</a>
                                        <a class="delete" href="action/tolak.php?id=<?= $row["id_pendaftaran"] ?>">Tolak</a>
                                    <?php else : ?>
                                        <a class="delete" href="action/tolak.php?id=<?= $row["id_pendaftaran"] ?>">Tolak</a>
                                    <?php endif; ?>
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