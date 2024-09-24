<?php
class AddPostController extends Controller
{
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $user_id = $_SESSION['user_id'] ?? null;

            if ($title && $content && $user_id) {
                $newPostId = PostRepository::createPost($title, $content, $user_id);
                if ($newPostId) {
                    $_SESSION['message'] = "Post créé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la création du post.";
                }
            } else {
                $_SESSION['error'] = "Données invalides pour la création du post.";
            }
        }
        header("Location: /");
        exit;
    }
}