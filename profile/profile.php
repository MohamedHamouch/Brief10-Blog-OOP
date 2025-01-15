<?php
session_start();
require_once '../config_db.php';
require_once '../classes/admin.php';
require_once '../classes/superAdmin.php';
require_once '../classes/blogger.php';

if (isset($_SESSION['email'])) {
  if ($_SESSION['role'] === 3) {

    $user = new Blogger($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['email']);
  } elseif ($_SESSION['role'] === 2) {
    $user = new Admin($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['email']);
  } else {
    $user = new SuperAdmin($_SESSION['userId'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['email']);

  }

} else {
  header("Location: ../../index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BlogSphere - Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
  <link rel="stylesheet" href="../styles.css">

  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <header class="bg-white shadow-sm fixed w-full z-50">
    <div class="container mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <a href="../index.php" class="flex items-center space-x-2">
          <img src="../assets/sphereblog.png" alt="Logo" class="w-24 h-auto">
        </a>

        <nav class="hidden md:flex items-center space-x-6">
          <a href="../index.php" class="text-gray-600 hover:text-orange-500 transition">Home</a>
          <a href="../articles/articles.php" class="text-gray-600 hover:text-orange-500 transition">Articles</a>
          <div class="relative group">
            <button
              class="flex items-center space-x-2 bg-gray-900 text-white px-6 py-2 rounded-full hover:bg-gray-800 transition">
              <i class="fa-solid fa-user"></i>
              <span><?= $user ?></span>
            </button>
            <div
              class="absolute right-0 w-48 mt-2 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform">
              <a href="../profile/profile.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
              <?php if ($user->isAdmin()) { ?>
                <a href="../admin/dashboard.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Admin
                  Dashboard</a>
              <?php } ?>
              <a href="../auth/handel_auth/logout.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
            </div>
          </div>
        </nav>

        <!-- <button class="md:hidden bg-gray-100 p-2 rounded-lg">
          <i class="fas fa-bars text-gray-600"></i>
        </button> -->
      </div>
    </div>
  </header>

  <main class="pt-16 min-h-screen flex">
    <aside id="side-menu" class="w-64 bg-gray-900 text-white fixed h-full">
      <div class="p-6 space-y-4">
        <h3 class="text-lg font-semibold text-gray-200 mb-6">Menu</h3>

        <button data-section="profile"
          class="w-full flex items-center space-x-3 text-left text-gray-300 hover:text-white hover:bg-gray-800 py-2.5 px-4 rounded-lg transition-all duration-200">
          <i class="fa-solid fa-user"></i>
          <span>Profile</span>
        </button>

        <button data-section="postArticle"
          class="w-full flex items-center space-x-3 text-left text-gray-300 hover:text-white hover:bg-gray-800 py-2.5 px-4 rounded-lg transition-all duration-200">
          <i class="fa-solid fa-file-circle-plus"></i>
          <span>Post New Article</span>
        </button>

        <button data-section="historyArticles"
          class="w-full flex items-center space-x-3 text-left text-gray-300 hover:text-white hover:bg-gray-800 py-2.5 px-4 rounded-lg transition-all duration-200">
          <i class="fa-solid fa-newspaper"></i>
          <span>Articles History</span>
        </button>

        <button data-section="historyComments"
          class="w-full flex items-center space-x-3 text-left text-gray-300 hover:text-white hover:bg-gray-800 py-2.5 px-4 rounded-lg transition-all duration-200">
          <i class="fa-solid fa-comment"></i>
          <span>Comments History</span>
        </button>
      </div>
    </aside>


    <div class="ml-64 flex-1 p-8 bg-gray-50">

      <!-- profile -->
      <section id="profile" class="content-section">
        <div class="max-w-4xl mx-auto">

          <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Your Profile</h2>
            <p class="mt-2 text-gray-600">View and manage your account information</p>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="space-y-2">
                  <label class="text-sm font-medium text-gray-600">First Name</label>
                  <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-900 font-medium"><?= $user->getFirstName() ?></p>
                  </div>
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-gray-600">Last Name</label>
                  <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-900 font-medium"><?= $user->getLastName() ?></p>
                  </div>
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-gray-600">Email</label>
                  <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-900 font-medium"><?= $user->getEmail() ?></p>
                  </div>
                </div>
                <?php

                ?>
                <div class="space-y-2">
                  <label class="text-sm font-medium text-gray-600">Role</label>
                  <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-900 font-medium capitalize"><?= get_class($user) ?></p>
                  </div>
                </div>
              </div>

              <!-- Edit Profile Button -->
              <!-- <div class="mt-8 flex justify-end">
                <button
                  class="bg-orange-500 text-white px-6 py-2 rounded-full hover:bg-orange-600 transition-colors duration-200">
                  <i class="fa-solid fa-pen-to-square mr-2"></i>
                  Edit Profile
                </button>
              </div> -->
            </div>
          </div>
        </div>
      </section>

      <!-- add article -->
      <section id="postArticle" class="content-section hidden">
        <div class="max-w-4xl mx-auto">
          <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Post New Article</h2>
            <p class="mt-2 text-gray-600">Share your thoughts and ideas with the community</p>
          </div>

          <form action="handel_forms/add_article.php" method="POST" enctype="multipart/form-data"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 space-y-6">

              <div class="space-y-2">
                <label for="title" class="text-sm font-medium text-gray-600">Title</label>
                <input type="text" id="title" name="title" maxlength="100" required
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-colors"
                  placeholder="Enter article title (max 100 characters)">
              </div>

              <div class="space-y-2">
                <label for="description" class="text-sm font-medium text-gray-600">Description</label>
                <textarea id="description" name="description" maxlength="250" required rows="2"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-colors"
                  placeholder="Enter article description (max 250 characters)"></textarea>
              </div>

              <div class="space-y-2">
                <label for="content" class="text-sm font-medium text-gray-600">Content</label>
                <textarea id="content" name="content" required rows="6"
                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-colors"
                  placeholder="Write your article content here"></textarea>
              </div>

              <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                  <label for="image" class="text-sm font-medium text-gray-600">Upload Image</label>
                  <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                    <div class="space-y-1 text-center">
                      <i class="fas fa-image text-gray-400 text-3xl mb-3"></i>
                      <div class="flex text-sm text-gray-600">
                        <label for="image"
                          class="relative cursor-pointer bg-white rounded-md font-medium text-orange-500 hover:text-orange-600">
                          <span>Upload a file</span>
                          <input id="image" name="image" type="file" class="sr-only" accept="image/*" required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                      </div>
                      <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                    </div>
                  </div>
                </div>

                <div class="space-y-2">
                  <label for="tags" class="text-sm font-medium text-gray-600">Select Tags</label>
                  <select id="tags" name="tags[]" multiple
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-colors">
                    <?php
                    $tags = $user->getAllTags($conn);
                    foreach ($tags as $tag) {
                      echo "<option value='" . $tag['id'] . "' class='py-1'>" . $tag['name'] . "</option>";
                    }
                    ?>
                  </select>
                  <p class="text-xs text-gray-500">Hold Ctrl/Cmd to select multiple tags</p>
                </div>
              </div>

              <div class="flex justify-end pt-4">
                <button type="submit"
                  class="bg-orange-500 text-white px-8 py-2.5 rounded-full hover:bg-orange-600 transform hover:-translate-y-0.5 transition-all duration-200">
                  <i class="fa-solid fa-paper-plane mr-2"></i>
                  Publish Article
                </button>
              </div>
            </div>
          </form>
        </div>
      </section>


      <!-- Articles History Section -->
      <section id="historyArticles" class="content-section hidden">
        <div class="max-w-5xl mx-auto">
          <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Your Articles History</h2>
            <p class="mt-2 text-gray-600">Manage and track all your published articles</p>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div
              class="grid grid-cols-[3fr,2fr,2fr,1fr,1fr] items-center py-4 px-6 bg-gray-50 border-b border-gray-200">
              <div class="text-sm font-medium text-gray-600">Title</div>
              <div class="text-sm font-medium text-gray-600">Publisher</div>
              <div class="text-sm font-medium text-gray-600">Date</div>
              <div class="text-sm font-medium text-gray-600 text-center">Edit</div>
              <div class="text-sm font-medium text-gray-600 text-center">Delete</div>
            </div>

            <div class="divide-y divide-gray-200">
              <?php
              $articles = $user->getUserArticles($conn);
              if (!empty($articles)) {
                foreach ($articles as $article) {
                  ?>
                  <div
                    class="grid grid-cols-[3fr,2fr,2fr,1fr,1fr] items-center py-4 px-6 hover:bg-gray-50 transition-colors duration-150">

                    <div class="text-gray-900 font-medium truncate"><?= $article['title'] ?></div>
                    <div class="text-gray-600"><?= $user ?></div>
                    <div class="text-gray-600"><?= $article['published_at'] ?></div>
                    <div class="flex justify-center">
                      <button class="text-gray-400 hover:text-orange-500 transition-colors">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                    </div>
                    <div class="flex justify-center">
                      <form action="handle_forms/delete_article.php" method="POST" class="deleteForm">
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                <?php }
              } else { ?>
                <div class="py-12 px-6 text-center text-gray-500">
                  <i class="fa-solid fa-newspaper text-4xl mb-4"></i>
                  <p>No articles published yet</p>
                </div>
              <?php } ?>
            </div>

            <!-- <div class="py-4 px-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
              <p class="text-sm text-gray-600">Showing <span class="font-medium">1</span> of <span
                  class="font-medium">1</span> articles</p>
              <div class="flex space-x-2">
                <button disabled class="px-3 py-1 rounded-md bg-gray-100 text-gray-400">Previous</button>
                <button disabled class="px-3 py-1 rounded-md bg-gray-100 text-gray-400">Next</button>
              </div>
            </div> -->
          </div>
        </div>
      </section>

      <!-- Comments History Section -->
      <section id="historyComments" class="content-section hidden">
        <div class="max-w-5xl mx-auto">
          <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Your Comments History</h2>
            <p class="mt-2 text-gray-600">Track and manage all your comments on articles</p>
          </div>

          <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div
              class="grid grid-cols-[3fr,2fr,2fr,1fr,1fr] items-center py-4 px-6 bg-gray-50 border-b border-gray-200">
              <div class="text-sm font-medium text-gray-600">Associated Article</div>
              <div class="text-sm font-medium text-gray-600">Publisher</div>
              <div class="text-sm font-medium text-gray-600">Date</div>
              <div class="text-sm font-medium text-gray-600 text-center">Edit</div>
              <div class="text-sm font-medium text-gray-600 text-center">Delete</div>
            </div>

            <div class="divide-y divide-gray-200">
              <?php
              $comments = $user->getUserComments($conn);
              if (!empty($comments)) {
                foreach ($comments as $comment) {
                  ?>
                  <div
                    class="grid grid-cols-[3fr,2fr,2fr,1fr,1fr] items-center py-4 px-6 hover:bg-gray-50 transition-colors duration-150">
                    <div class="text-gray-900 font-medium truncate"><?= $comment['title'] ?></div>
                    <div class="text-gray-600"><?= $user ?></div>
                    <div class="text-gray-600"><?= $comment['posted_at'] ?></div>
                    <div class="flex justify-center">
                      <button class="text-gray-400 hover:text-orange-500 transition-colors">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </button>
                    </div>
                    <div class="flex justify-center">
                      <form action="handle_forms/delete_comment.php" method="POST" class="deleteForm">
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                <?php }
              } else { ?>

                <div class="py-12 px-6 text-center text-gray-500">
                  <i class="fa-solid fa-comments text-4xl mb-4"></i>
                  <p>No comments posted yet</p>
                </div>
              <?php } ?>
            </div>

            <!-- <div class="py-4 px-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
              <p class="text-sm text-gray-600">Showing <span class="font-medium">1</span> of <span
                  class="font-medium">1</span> comments</p>
              <div class="flex space-x-2">
                <button disabled class="px-3 py-1 rounded-md bg-gray-100 text-gray-400">Previous</button>
                <button disabled class="px-3 py-1 rounded-md bg-gray-100 text-gray-400">Next</button>
              </div>
            </div> -->
          </div>
        </div>
      </section>

    </div>
  </main>

  <script src="profile.js"></script>
</body>

</html>