<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "unikma";

try {
    $conn = mysqli_connect($host, $user, $password, $database);
} catch (\Exception $error) {
    echo "Terjadi masalah saat menyambungkan ke database: " . $error->getMessage();
}