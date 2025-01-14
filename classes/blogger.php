<?php
require_once 'User.php';

class Blogger extends User
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $roleId = 3;

    public function __construct($id, $firstName, $lastName, $email)
    {
        parent::__construct($email);
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function loadInfoByEmail($db)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->id = $user['id'];
        $this->firstName = $user['first_name'];
        $this->lastName = $user['last_name'];
        $this->roleId = $user['role_id'];
    }

    public function loadInfoById($db)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->email = $user['email'];
        $this->firstName = $user['first_name'];
        $this->lastName = $user['last_name'];
        $this->roleId = $user['role_id'];
    }

    public function getRole()
    {
        return $this->roleId;
    }

    public function __tostring(){
        return "$this->firstName $this->lastName";
    }

    public function getAttributes()
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'roleId' => $this->roleId,
        ];
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    //articles
    public function addArticle(PDO $db, Article $article)
    {

    }

    public function deleteArticle(PDO $db, $articleId)
    {

    }

    public function editArticle(PDO $db, $articleId)
    {

    }

    //comments

    public function addComment(PDO $db, Comment $comment)
    {
        $article_id = $comment->getArticleId();
        $user_id = $comment->getUserId();
        $content = $comment->getContent();

        $query = 'INSERT INTO comments (article_id, user_id, content) VALUES (:articleId, :userId, :content)';
        $stmt = $db->prepare($query);

        $stmt->bindParam(':articleId', $article_id, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function deleteComment(PDO $db, $commentId)
    {
        $stmt = $db->prepare("DELETE FROM comment WHERE comment_id = ?");
        if ($stmt->execute([$commentId])) {
            return true;
        } else {
            return false;
        }
    }

    public function editComment()
    {

    }

    //profile

    public function editProfile()
    {

    }


}

?>