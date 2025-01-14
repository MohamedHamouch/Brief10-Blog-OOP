<?php
session_start();
require_once '../../config_db.php';
require_once '../../classes/user.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    $email = test_input($_POST['email']);
    $first_name = test_input($_POST['first_name']);
    $last_name = test_input($_POST['last_name']);
    $password = test_input($_POST['password']);
    $confirm_password = test_input($_POST['confirm_password']);

    $user = new User($email);
    $status = $user->register($conn, $first_name, $last_name, $password, $confirm_password);

    if ($status === true) {

      header("location: ../../index.php");
      exit();
    } else {

      $_SESSION['registerError'] = $status;
      header("location: ../register.php");
      exit();
    }

  } else {

    $_SESSION['registerError'] = "All fields are required";
    header("location: ../register.php");
    exit();
  }
} else {

  header("Location: ../../index.php");
  exit();
}

