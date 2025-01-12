<?php
class Article
{

    private $id;
    private $title;
    private $content;
    private $description;
    private $publishedAt;
    private $image;
    private $userId;
    private $tags;


    public function __construct($id = null, $userId, $title, $content, $description, $image, $tags = [], $publishedAt = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->description = $description;
        $this->publishedAt = $publishedAt ?? date("Y-m-d H:i:s");
        $this->image = $image;
        $this->userId = $userId;
        $this->tags = $tags;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }
    public function getTags()
    {
        return $this->tags;
    }

}

?>