<?php
session_start();
include "../utils/isNotLoggedIn.php";
include "../utils/koneksi.php";

$rootDirectory = "/unikma";
$sessionId = $_SESSION["user_id"];

// Query utama
$query = "
    SELECT ukm.id_ukm, ukm.nama_ukm, ukm.deskripsi, ukm.kontak,
           ketua.nama AS nama_ketua
    FROM ukm
    LEFT JOIN users AS ketua ON ukm.ketua_ukm = ketua.id_user
    WHERE ukm.id_ukm NOT IN (
        SELECT p.ukm_id 
        FROM pendaftaran p 
        WHERE p.user_id = $sessionId AND p.status_pendaftaran = 'accepted'
    )
";
$data = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNIKMA Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div id="template">
        <div id="header">
            <h1>UNIKMA Dashboard</h1>
            <p>Kamu login sebagai: <?= htmlspecialchars($_SESSION["role"]) ?></p>
        </div>
        <div id="menu">
            <ul>
                <li><a href="<?= $rootDirectory ?>">Beranda</a></li>
                <li><a href="<?= $rootDirectory ?>/logout.php">Logout</a></li>
            </ul>
        </div>

        <div id="content-wrapper">
            <div id="content">
                <table>
                    <thead>
                        <tr>
                            <th>Nama UKM</th>
                            <th>Deskripsi UKM</th>
                            <th>Ketua UKM</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data->num_rows !== 0): ?>
                            <?php while ($row = $data->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_ukm']) ?></td>
                                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                    <td><?= htmlspecialchars($row['nama_ketua'] ?? 'Belum ada ketua') ?></td>
                                    <td><?= htmlspecialchars($row['kontak']) ?></td>
                                    <td>
                                        <a href="action/daftar.php?id_ukm=<?= urlencode($row['id_ukm']) ?>">Daftar</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Tidak ada data UKM yang tersedia.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="footer">Copyright &copy; <?= date('Y') ?>. All rights reserved.</div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
