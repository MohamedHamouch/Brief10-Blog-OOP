<?php

class User
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

}

?>