<?php
session_start();
require_once '../../config_db.php';
require_once '../../classes/user.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = test_input($_POST['email']);
    $password = $_POST['password'];

    $user = new User($email);
    $status = $user->login($conn, $password);

    if ($status === true) {

      header('Location: ../../index.php');
      exit();
    } else {

      $_SESSION['loginError'] = $status;
      header('Location: ../login.php');
      exit();
    }

  } else {

    $_SESSION['loginError'] = "All fields are required";
    header('Location: ../login.php');
    exit();
  }
} else {

  header("Location: ../../index.php");
  exit();
}
