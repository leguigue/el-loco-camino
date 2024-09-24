<?php
class LikeRepository extends Db
{
    public static function addLike($user_id, $target_id, $type)
    {
        $db = self::getInstance();
        if ($type === 'post') {
            $query = "INSERT INTO post_likes (post_id, user_id) VALUES (:target_id, :user_id)";
        } elseif ($type === 'comment') {
            $query = "INSERT INTO comment_likes (comment_id, user_id) VALUES (:target_id, :user_id)";
        } else {
            throw new Exception("Invalid like type");
        }
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }

    public static function removeLike($user_id, $target_id, $type)
    {
        $db = self::getInstance();
        if ($type === 'post') {
            $query = "DELETE FROM post_likes WHERE user_id = :user_id AND post_id = :target_id";
        } elseif ($type === 'comment') {
            $query = "DELETE FROM comment_likes WHERE user_id = :user_id AND comment_id = :target_id";
        } else {
            throw new Exception("Invalid like type");
        }
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
        $result = $stmt->execute();
        self::disconnect();
        return $result;
    }

    public static function getLikeCount($target_id, $type)
    {
        $db = self::getInstance();
        if ($type === 'post') {
            $query = "SELECT COUNT(*) as count FROM post_likes WHERE post_id = :target_id";
        } elseif ($type === 'comment') {
            $query = "SELECT COUNT(*) as count FROM comment_likes WHERE comment_id = :target_id";
        } else {
            throw new Exception("Invalid like type");
        }
        $stmt = $db->prepare($query);
        $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        self::disconnect();
        return $result['count'];
    }

    public static function hasUserLiked($user_id, $target_id, $type)
    {
        $db = self::getInstance();
        if ($type === 'post') {
            $query = "SELECT COUNT(*) as count FROM post_likes WHERE user_id = :user_id AND post_id = :target_id";
        } elseif ($type === 'comment') {
            $query = "SELECT COUNT(*) as count FROM comment_likes WHERE user_id = :user_id AND comment_id = :target_id";
        } else {
            throw new Exception("Invalid like type");
        }
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':target_id', $target_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        self::disconnect();
        return $result['count'] > 0;
    }
}