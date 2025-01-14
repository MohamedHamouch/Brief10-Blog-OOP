<?php
session_start();
require_once '../../classes/user.php';

if (!isset($_SESSION['email'])) {

    header("Location: ../../login.php");
    exit();
} else {

    $user = new User($SESSION['email']);
    $user->logout();
    header("Location: ../../index.php");
    exit();
}

