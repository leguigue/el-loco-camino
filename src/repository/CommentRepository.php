<?php
class CommentRepository extends Db
{
    public static function addComment($content, $user_id, $post_id, $parent_id = null)
    {
        $db = self::getInstance();
        $query = "INSERT INTO comments (content, user_id, post_id, parent_id) VALUES (:content, :user_id, :post_id, :parent_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }
    public static function getComments($post_id)
    {
        $db = self::getInstance();
        $query = "SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.post_id = :post_id ORDER BY comments.created_at DESC";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        self::disconnect();
        return $comments;
    }
    public static function getCommentById($id)
{
    $db = self::getInstance();
    $query = "SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    self::disconnect();
    return $comment;
}

    public static function editComment($id, $content, $user_id)
    {
        $db = self::getInstance();
        $query = "UPDATE comments SET content = :content, modified = TRUE WHERE id = :id AND user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }

    public static function deleteComment($id)
    {
        $db = self::getInstance();
        $query = "DELETE FROM comments WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }
}