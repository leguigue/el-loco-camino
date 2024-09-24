<?php

class ToggleLikeController extends Controller
{
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['target_id']) && isset($_POST['type'])) {
            $user_id = $_SESSION['user_id'];
            $target_id = $_POST['target_id'];
            $type = $_POST['type']; // 'post' ou 'comment'

            if (LikeRepository::hasUserLiked($user_id, $target_id, $type)) {
                LikeRepository::removeLike($user_id, $target_id, $type);
            } else {
                LikeRepository::addLike($user_id, $target_id, $type);
            }
        }
        header("Location: /");
        exit;
    }
}