<?php
class PostRepository extends Db
{
    public static function createPost($title, $content, $user_id)
    {
        $db = self::getInstance();
        $query = "INSERT INTO posts (title, content, user_id) VALUES (:title, :content, :user_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $lastInsertId = $db->lastInsertId();
        self::disconnect();
        return $result ? $lastInsertId : false;
    }

    public static function getPosts($limit = null, $offset = 0)
    {
        $db = self::getInstance();
        $query = "SELECT posts.*, users.username FROM posts 
                  LEFT JOIN users ON posts.user_id = users.id 
                  WHERE posts.deleted_at IS NULL 
                  ORDER BY posts.created_at DESC";
        if ($limit !== null) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        $stmt = $db->prepare($query);
        if ($limit !== null) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::disconnect();
        return $posts;
    }

    public static function getPostById($id)
    {
        $db = self::getInstance();
        $query = "SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        self::disconnect();
        return $post;
    }

    public static function deletePost($id)
    {
        $db = self::getInstance();
        $query = "UPDATE posts SET deleted_at = NOW() WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }

    public static function editPost($id, $title, $content)
    {
        $db = self::getInstance();
        $query = "UPDATE posts SET title = :title, content = :content, modified = TRUE WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }
}