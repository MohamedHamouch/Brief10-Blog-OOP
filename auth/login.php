<?php
session_start();
if (isset($_SESSION['emial'])) {
  $first_name = $_SESSION['firstName'];
  $last_name = $_SESSION['lastName'];
  $role = ($_SESSION['role'] == 3) ? 'user' : 'admin';
  $connected = true;
} else {
  $connected = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BlogSphere - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">

<header class="bg-white shadow-sm fixed w-full z-50">
    <div class="container mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <a href="../index.php" class="flex items-center space-x-2">
          <img src="../assets/sphereblog.png" alt="Logo" class="w-24 h-auto">
        </a>

        <nav class="hidden md:flex items-center space-x-6">
          <a href="../index.php" class="text-gray-600 hover:text-orange-500 transition">Home</a>
          <a href="../articles/articles.php" class="text-gray-600 hover:text-orange-500 transition">Articles</a>
          <?php if (!$connected) { ?>
            <a href="login.php" class="bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-600 transition">
              <i class="fa-solid fa-user-plus mr-2"></i>Sign In
            </a>
          <?php } else { ?>
            <div class="relative group">
              <button
                class="flex items-center space-x-2 bg-gray-900 text-white px-6 py-2 rounded-full hover:bg-gray-800 transition">
                <i class="fa-solid fa-user"></i>
                <span><?= "$first_name $last_name" ?></span>
              </button>
              <div
                class="absolute right-0 w-48 mt-2 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform">
                <a href="../profile/profile.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                <?php if ($role === "admin") { ?>
                  <a href="../admin/dashboard.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Admin
                    Dashboard</a>
                <?php } ?>
                <a href="handel_auth/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
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

  <main class="flex-grow flex items-center justify-center pt-24 pb-16">
    <div class="container mx-auto px-4">
      <?php if ($connected) { ?>

        <div class="max-w-md mx-auto bg-white rounded-xl shadow-sm p-8 text-center">
          <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-user-check text-3xl text-orange-500"></i>
          </div>
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome Back, <?= "$first_name $last_name" ?>!</h2>
          <p class="text-gray-600 mb-6">You are already logged in to your account.</p>
          <a href="../index.php"
            class="inline-block bg-orange-500 text-white px-8 py-3 rounded-full hover:bg-orange-600 transform hover:-translate-y-0.5 transition">
            Go to Homepage
          </a>
        </div>
      <?php } else { ?>

        <div class="max-w-md mx-auto">
          <div class="bg-white rounded-xl shadow-sm p-8">
            <div class="text-center mb-8">
              <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-user text-3xl text-orange-500"></i>
              </div>
              <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
              <p class="text-gray-600 mt-2">Don't have an account?
                <a href="register.php" class="text-orange-500 hover:text-orange-600">Register here</a>
              </p>
            </div>

            <?php if (isset($_SESSION['loginError'])) { ?>
              <div class="bg-red-50 text-red-500 text-sm p-4 rounded-lg mb-6">
                <?= $_SESSION['loginError'] ?>
              </div>
              <?php unset($_SESSION['loginError']); ?>
            <?php } ?>

            <form action="handel_auth/login_process.php" method="POST">
              <div class="space-y-6">
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                  <input type="email" name="email" id="email" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Enter your email">
                </div>

                <div>
                  <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                  <input type="password" name="password" id="password" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                    placeholder="Enter your password">
                </div>

                <button type="submit"
                  class="w-full bg-orange-500 text-white px-6 py-3 rounded-full hover:bg-orange-600 transform hover:-translate-y-0.5 transition">
                  Sign In
                </button>
              </div>
            </form>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>

  <footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 py-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
        <div>
          <img src="../assets/sphereblog.png" alt="Logo" class="w-20 mb-2">
          <p class="text-gray-400 text-sm">Share your stories with the world.</p>
        </div>
        <div class="flex justify-center">
          <ul class="space-y-1 text-center">
            <li><a href="../index.php" class="text-gray-400 hover:text-white transition text-sm">Home</a></li>
            <li><a href="../articles/articles.php"
                class="text-gray-400 hover:text-white transition text-sm">Articles</a></li>
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