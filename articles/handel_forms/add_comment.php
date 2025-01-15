<?php
session_start();

require '../../config_db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../index.php");
  exit();

} else {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['article']) && isset($_POST['comment'])) {
      $comment = test_input($_POST['comment']);
      $article_id = test_input($_POST['article']);
      $user_id = $_SESSION["user_id"];
      $sql = 'INSERT INTO comments (article_id, user_id, content) VALUES (?, ?, ?)';
      $stmt = mysqli_prepare($conn, $sql);
      mysqli_stmt_bind_param($stmt, "iis", $article_id, $user_id, $comment);

      if (mysqli_stmt_execute($stmt)) {
        header("Location: ../article_details.php?article=$article_id");
        exit();
      } else {
        echo "Error inserting comment: " . mysqli_error($conn);
        exit();
      }
    }
  }
  header("Location: ../../index.php");
  exit();
}



function test_input($input)
{
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}