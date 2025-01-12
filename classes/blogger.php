<?php

require_once 'User.php';

class Blogger extends User
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $roleId;

    public function __construct($firstName, $lastName, $email)
    {
        parent::__construct($email);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->roleId = 3;
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

    }

    public function deleteComment(PDO $db, $commentId)
    {

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