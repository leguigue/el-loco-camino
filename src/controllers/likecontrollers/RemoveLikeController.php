<?php
class RemoveLikeController extends Controller
{
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['target_id']) && isset($_POST['type'])) {
            $user_id = $_SESSION['user_id'];
            $target_id = $_POST['target_id'];
            $type = $_POST['type']; // 'post' ou 'comment'

            LikeRepository::removeLike($user_id, $target_id, $type);
        }
        header("Location: /");
        exit;
    }
}