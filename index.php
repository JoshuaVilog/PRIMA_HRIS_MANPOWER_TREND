<?php
session_start();

$route = $_GET['route'] ?? 'login';

// $allowedRoutes = ['login', 'dashboard', 'profile','user_management', 'record', 'record2', 'masterlist', 'logout', 'error'];
$allowedRoutes = ['manpower', 'error'];

if (!in_array($route, $allowedRoutes)) {
    http_response_code(404);
    // echo "404 - Page not found";
    header("Location: error");
    exit;
}

if ($route === 'logout') {
    session_destroy();
    header("Location: login");
    exit;
}

/* if (!isset($_SESSION['USER_CODE']) && $route != "login" && $route != "error") {
    header("Location: login");
    exit();
} */


include 'includes/header.php';
include 'includes/script.php';
include "views/$route.php";

