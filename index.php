<?php
session_start();

$isLoggedIn = isset($_SESSION['isLoggedIn']);
$rootDirectory = "/unikma";

if (!$isLoggedIn) {
    header("Location: " . $rootDirectory . "/auth/login.php");
    exit;
}

include "utils/isLoggedIn.php";