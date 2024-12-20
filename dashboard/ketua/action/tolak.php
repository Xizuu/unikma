<?php
session_start();
include "../../../utils/isNotLoggedIn.php";
include "../../../utils/koneksi.php";

$rootDirectory = "/unikma";

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);


    $selectQuery = "SELECT user_id, ukm_id FROM pendaftaran WHERE id_pendaftaran = $id";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $userId = $data['user_id'];
        $ukmId = $data['ukm_id'];

    
        $deleteMemberQuery = "DELETE FROM anggota_ukm WHERE id_mahasiswa = $userId AND id_ukm = $ukmId";
        if ($conn->query($deleteMemberQuery)) {
        
            $updateQuery = "UPDATE pendaftaran SET status_pendaftaran = 'rejected' WHERE id_pendaftaran = $id";
            if ($conn->query($updateQuery)) {
                echo "<script>alert('Pendaftaran berhasil ditolak!'); window.location.href='" . $rootDirectory . "';</script>";
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengupdate pendaftaran: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus anggota: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Data pendaftaran tidak ditemukan!'); window.location.href='" . $rootDirectory . "';</script>";
    }
}
?>
