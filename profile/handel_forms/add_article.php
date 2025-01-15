<?php
session_start();
require "../../config_db.php";
require_once '../../classes/blogger.php';
require_once '../../classes/article.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $title = test_input($_POST['title']);
  $description = test_input($_POST['description']);
  $content = test_input($_POST['content']);
  $tags = $_POST['tags'];
  $image = $_FILES['image'];

  $article = new Article(null, $_SESSION['userId'], $title, $description, $content, $image, $tags);
  $user = new Blogger($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['email']);
  $user->addArticle($conn, $article);

  header("Location: ../profile.php");

} else {
  
  header("Location: ../../index.php");
  exit();
}