<?php
class Post
{
    private $id;
    private $user_id;
    private $title;
    private $content;
    private $created_at;
    private $modified;
    private $username;
    private $comments;

    public function __construct($id, $user_id, $title, $content, $created_at, $modified = false, $username = '', $comments = [])
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->modified = $modified;
        $this->username = $username;
        $this->comments = $comments;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function isModified()
    {
        return $this->modified;
    }

    public function getUsername()
    {
        return $this->username ?? 'Utilisateur inconnu';
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public static function createFromArray($data)
    {
        return new self(
            $data['id'],
            $data['user_id'],
            $data['title'],
            $data['content'],
            $data['created_at'],
            $data['modified'] ?? false,
            $data['username'] ?? '',
            $data['comments'] ?? []
        );
    }
}