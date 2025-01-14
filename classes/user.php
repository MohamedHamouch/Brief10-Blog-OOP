<?php
require_once 'authentication.php';

class User implements Authentication
{
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAllArticles(PDO $db)
    {
        $query = "SELECT * FROM articles";
        $stmt = $db->query($query);
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }

    public function getLatestArticles($db)
    {
        $query = "SELECT * FROM articles
        ORDER BY publishedt DESC
        LIMIT 4";
        $stmt = $db->query($query);
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }

    public function getArticleDetails(PDO $db, $articleId)
    {
        $found = false;
        $article = null;
        $publisher = null;
        $tags = [];
        $comments = [];

        $stmt = $db->prepare("SELECT * FROM articles WHERE id = ?");
        $stmt->execute([$articleId]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            $found = true;

            $stmtPublisher = $db->prepare("SELECT * FROM users WHERE id = ?");
            $stmtPublisher->execute([$article['user_id']]);
            $publisher = $stmtPublisher->fetch(PDO::FETCH_ASSOC);

            $stmtTags = $db->prepare("
                SELECT tags.name FROM tags
                JOIN article_tag ON tags.id = article_tag.tag_id
                WHERE article_tag.article_id = ?
            ");
            $stmtTags->execute([$articleId]);
            $tags = $stmtTags->fetchAll(PDO::FETCH_ASSOC);

            $stmtComments = $db->prepare("
                SELECT users.name, comments.content, comments.created_at 
                FROM users
                JOIN comments ON users.id = comments.user_id
                WHERE comments.article_id = ?
            ");
            $stmtComments->execute([$articleId]);
            $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
        }

        return [
            'found' => $found,
            'article' => $article,
            'publisher' => $publisher,
            'tags' => $tags,
            'comments' => $comments
        ];
    }

    public function register(PDO $db, $firstName, $lastName, $password, $confirmPassword, $role = 3)
    {

        try {

            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $this->email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "This email is already registered.";
            }
            if ($password !== $confirmPassword) {
                return "Passwords do not match.";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (firstName, lastName, email, password, role) VALUES (:firstName, :lastName, :email, :password, :role)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            $userId = $db->lastInsertId();

            if ($userId) {

                $_SESSION['userId'] = $userId;
                $_SESSION['firstName'] = $firstName;
                $_SESSION['lastName'] = $lastName;
                $_SESSION['email'] = $this->email;
                $_SESSION['role'] = $role;
            }

            return true;

        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function login(PDO $db, $password)
    {
        try {

            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($password, $user['password'])) {
                return "Invalid email or password.";
            }

            $_SESSION['userId'] = $user['id'];
            $_SESSION['firstName'] = $user['first_name'];
            $_SESSION['lastName'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role_id'];

            return true;

        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        return true;
    }
    public function isAdmin()
    {
        return isset($_SESSION['role']) && ($_SESSION['role'] === 1 || $_SESSION['role'] === 2);
    }

    public function isSuperAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 1;
    }

}

?>