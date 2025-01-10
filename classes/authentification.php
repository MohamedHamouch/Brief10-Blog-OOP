<?php

class Authentication
{
    
    public function register(PDO $db, Blogger $blogger, $password, $confirmPassword)
    {
        $bloggerInfo = $blogger->getAttributes();

        try {

            $query = "SELECT * FROM user WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $bloggerInfo['email']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return "This email is already registered.";
            }
            if ($password !== $confirmPassword) {
                return "Passwords do not match.";
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO user (first_name, last_name, email, password, role_id) VALUES (:firstName, :lastName, :email, :password, :role)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':firstName', $bloggerInfo['firstName']);
            $stmt->bindParam(':lastName', $bloggerInfo['lastName']);
            $stmt->bindParam(':email', $bloggerInfo['email']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $bloggerInfo['roleId']);
            $stmt->execute();

            $userId = $db->lastInsertId();

            if ($userId) {

                $_SESSION['userId'] = $userId;
                $_SESSION['firstName'] = $bloggerInfo['firstName'];
                $_SESSION['lastName'] = $bloggerInfo['lastName'];
                $_SESSION['email'] = $bloggerInfo['email'];
                $_SESSION['role'] = $bloggerInfo['roleId'];
            }

            return true;

        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function login(PDO $db, $email, $password)
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