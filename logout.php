<?php
session_start();

$isLoggedIn = isset($_SESSION['isLoggedIn']);
$rootDirectory = "/unikma";

if ($isLoggedIn) {
    session_destroy();
}

header('Location: ' . $rootDirectory);
exit;