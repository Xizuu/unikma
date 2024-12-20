<?php
$isLoggedIn = isset($_SESSION["isLoggedIn"]);
if ($isLoggedIn) {
    $role = $_SESSION["role"];

    match($role) {
        "admin" => header("Location: " . $rootDirectory . "/dashboard/admin/index.php"),
        "ketua_ukm" => header("Location: " . $rootDirectory . "/dashboard/ketua/index.php"),
        "mahasiswa" => header("Location: " . $rootDirectory . "/home/index.php"),
        default => header("Location: " . $rootDirectory . "/auth/login.php")
    };
}