<?php
session_start();
require_once 'config_db.php';
require_once 'classes/admin.php';
require_once 'classes/blogger.php';


if (isset($_SESSION['role'])) {
  if ($_SESSION['role'] === 3) {

    $user = new Blogger($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['emal']);
  } else {
    $user = new Admin($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['emal']);
  }

  $connected = true;
} else {
  $user = new User(null);
  $connected = false;
}


?>;

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BlogSphere - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

  <header class="bg-white shadow-sm fixed w-full z-50">
    <div class="container mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <a href="index.php" class="flex items-center space-x-2">
          <img src="assets/sphereblog.png" alt="Logo" class="w-24 h-auto">
        </a>

        <nav class="hidden md:flex items-center space-x-6">
          <a href="index.php" class="text-gray-900 hover:text-orange-500 font-medium transition">Home</a>
          <a href="articles/articles.php" class="text-gray-600 hover:text-orange-500 transition">Articles</a>
          <?php if (!$connected) { ?>
            <a href="auth/login.php"
              class="bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-600 transition">
              <i class="fa-solid fa-user-plus mr-2"></i>Sign In
            </a>
          <?php } else { ?>
            <div class="relative group">
              <button
                class="flex items-center space-x-2 bg-gray-900 text-white px-6 py-2 rounded-full hover:bg-gray-800 transition">
                <i class="fa-solid fa-user"></i>
                <span><?= $user ?></span>
              </button>
              <div
                class="absolute right-0 w-48 mt-2 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform">
                <a href="profile/profile.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                <?php if ($user->isAdmin()) { ?>
                  <a href="admin/dashboard.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Admin Dashboard</a>
                <?php } ?>
                <a href="auth/handel_auth/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
              </div>
            </div>
          <?php } ?>
        </nav>

        <!-- <button class="md:hidden bg-gray-100 p-2 rounded-lg">
            <i class="fas fa-bars text-gray-600"></i>
          </button> -->

      </div>
    </div>
  </header>

  <section class="pt-24 pb-12 bg-gradient-to-b from-orange-100 to-white">
    <div class="container mx-auto px-4 py-16 text-center">
      <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Welcome to BlogSphere</h1>
      <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Discover stories, ideas, and expertise from writers on any
        topic.</p>
      <?php if (!$connected) { ?>
        <a href="auth/login.php"
          class="inline-block bg-orange-500 text-white px-8 py-3 rounded-full font-medium hover:bg-orange-600 transform hover:-translate-y-0.5 transition">
          Start Writing Today
        </a>
      <?php } else { ?>
        <a href="profile/profile.php"
          class="inline-block bg-orange-500 text-white px-8 py-3 rounded-full font-medium hover:bg-orange-600 transform hover:-translate-y-0.5 transition">
          View Your Profile
        </a>
      <?php } ?>
    </div>
  </section>

  <section class="py-16 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Latest Articles</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <?php
        $articles = $user->getLatestArticles($conn);
        foreach ($articles as $article) { ?>
          <article
            class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 overflow-hidden group">
            <div class="aspect-w-16 aspect-h-9 overflow-hidden">
              <img src="../uploads/<?= $article['image']; ?>" alt="<?= $article['title']; ?>"
                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
            </div>
            <div class="p-6">
              <p class="text-sm text-orange-500 font-medium mb-2"><?= $article['publish_date']; ?></p>
              <h2 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                <?= $article['title']; ?>
              </h2>
              <p class="text-gray-600 mb-4 line-clamp-3">
                <?= $article['description']; ?>
              </p>
              <a href="article_details.php?article=<?= $article['id']; ?>"
                class="inline-flex items-center text-orange-500 hover:text-orange-600 font-medium group-hover:translate-x-1 transition-transform duration-200">
                Read More
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
              </a>
            </div>
          </article>
        <?php } ?>
      </div>
      <div class="text-center mt-12">
        <a href="articles/articles.php"
          class="inline-block bg-gray-900 text-white px-8 py-3 rounded-full font-medium hover:bg-gray-800 transform hover:-translate-y-0.5 transition">
          View All Articles
        </a>
      </div>
    </div>
  </section>

  <footer class="bg-gray-900 text-white mt-auto">
    <div class="container mx-auto px-4 py-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
        <div>
          <img src="assets/sphereblog.png" alt="Logo" class="w-20 mb-2">
          <p class="text-gray-400 text-sm">Share your stories with the world.</p>
        </div>
        <div class="flex justify-center">
          <ul class="space-y-1 text-center">
            <li><a href="#" class="text-gray-400 hover:text-white transition text-sm">Home</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition text-sm">Articles</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition text-sm">Contact</a></li>
          </ul>
        </div>
        <div class="flex flex-col items-end">
          <h3 class="text-sm font-semibold mb-2">Follow Us</h3>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-facebook"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="border-t border-gray-800 mt-4 pt-4 text-center">
        <p class="text-gray-400 text-xs">&copy; 2024 BlogSphere. All rights reserved.</p>
      </div>
    </div>
  </footer>

</body>

</html>