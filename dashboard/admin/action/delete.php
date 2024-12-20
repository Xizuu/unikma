<?php
session_start();
include "../../../utils/isNotLoggedIn.php";
include "../../../utils/koneksi.php";

$rootDirectory = "/unikma";

if (isset($_GET["id"])) {
    $ukmId = intval($_GET["id"]);


    $pendaftaranQuery = "SELECT * FROM pendaftaran WHERE ukm_id = $ukmId";
    $pendaftaranResult = $conn->query($checkQuery);

    $anggotaQuery = "SELECT * FROM anggota_ukm WHERE ukm_id = $ukmId";
    $anggotaResult = $conn->query($anggotaQuery);

    if ($checkResult->num_rows > 0 || $anggotaResult->num_rows > 0) {
    
        echo "<script>alert('UKM masih memiliki anggota terdaftar. Harap keluarkan semua anggota terlebih dahulu!'); window.location.href='" . $rootDirectory . "';</script>";
        exit;
    }


    $deleteQuery = "DELETE FROM ukm WHERE id_ukm = $ukmId";
    if ($conn->query($deleteQuery)) {
        echo "<script>alert('Data UKM berhasil dihapus!'); window.location.href='" . $rootDirectory . "';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan: " . $conn->error . "');</script>";
    }
} else {
    echo "<script>alert('ID UKM tidak ditemukan!'); window.location.href='" . $rootDirectory . "';</script>";
}
