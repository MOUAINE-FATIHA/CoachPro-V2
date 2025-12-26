<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../pages/login.php');
    exit;
}
$role = $_SESSION['user']['role'];

switch ($role) {
    case 'coach':
        header('Location: ../pages/coach-dashboard.php');
        exit;
    case 'sportif':
        header('Location: ../pages/sportif-dashboard.php');
        exit;
    default:
        session_destroy();
        header('Location: ../pages/login.php');
        exit;
}
