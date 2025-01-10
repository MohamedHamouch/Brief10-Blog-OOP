<?php

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
        $query = "SELECT * FROM article";
        $stmt = $db->query($query);
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }

    public function getArticle(PDO $db, $articleId){
        $query = "SELECT * FROM article WHERE id= :articleId";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':artucleId', $articleId);
        $stmt->execute();
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return $article;
    }

    public function addComment(PDO $db, Comment $comment){
        
    }

    public function register(PDO $db, $firstName, $lastName, $password, $confirmPassword, $role = 3)
    {

        try {

            $query = "SELECT * FROM user WHERE email = :email";
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

            $query = "INSERT INTO user (firstName, lastName, email, password, role) VALUES (:firstName, :lastName, :email, :password, :role)";
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

            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":email", $email);
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

    public function isLoggedIn()
    {
        return isset($_SESSION['userId']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 1;
    }

}

?>