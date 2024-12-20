<?php
$isLoggedIn = isset($_SESSION["isLoggedIn"]);
if (!$isLoggedIn) {
    header("Location: " . $rootDirectory . "/auth/login.php");
}