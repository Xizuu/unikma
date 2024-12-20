<?php
session_start();
include "../../utils/isNotLoggedIn.php";
include "../../utils/koneksi.php";

$rootDirectory = "/unikma";

if (isset($_GET["id_ukm"])) {
    $id = intval($_GET["id_ukm"]);
    $userId = $_SESSION["user_id"];
    $tanggalBergabung = date("Y-m-d H:i:s");

    $query = "INSERT INTO pendaftaran (user_id, ukm_id, tanggal_daftar) VALUES ('$userId', '$id', '$tanggalBergabung');";
    if ($conn->query($query)) {
        echo "<script>alert('Berhasil mendaftar! Harap tunggu ketua UKM untuk menerima pendaftaran'); window.location.href='" . $rootDirectory . "';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menambahkan anggota: " . $conn->error . "');</script>";
    }
}