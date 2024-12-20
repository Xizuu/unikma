<?php
session_start();
include "../../../utils/isNotLoggedIn.php";
include "../../../utils/koneksi.php";

$rootDirectory = "/unikma";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $sessionName = $_SESSION["nama"];

    $selectQuery = "SELECT user_id, ukm_id FROM pendaftaran WHERE id_pendaftaran = $id";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $userId = $data['user_id'];
        $ukmId = $data['ukm_id'];

    
        $updateQuery = "UPDATE pendaftaran SET status_pendaftaran = 'accepted', verifikasi_oleh = '$sessionName' WHERE id_pendaftaran = $id";
        if ($conn->query($updateQuery)) {
        
            $tanggalBergabung = date("Y-m-d H:i:s");
            $insertQuery = "INSERT INTO anggota_ukm (id_mahasiswa, id_ukm, tanggal_bergabung) VALUES ($userId, $ukmId, '$tanggalBergabung')";

            if ($conn->query($insertQuery)) {
                echo "<script>alert('Pendaftaran berhasil diterima!'); window.location.href='" . $rootDirectory . "';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat menambahkan anggota: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengupdate pendaftaran: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Data pendaftaran tidak ditemukan!'); window.location.href='" . $rootDirectory . "';</script>";
    }
}
