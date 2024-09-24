<?php
class EditPostController extends Controller
{
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['post_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';

            if ($id && $title && $content) {
                $post = PostRepository::getPostById($id);
                if ($post && $post['user_id'] == $_SESSION['user_id']) {
                    $result = PostRepository::editPost($id, $title, $content);
                    if ($result) {
                        $_SESSION['message'] = "Post modifié avec succès.";
                    } else {
                        $_SESSION['error'] = "Erreur lors de la modification du post.";
                    }
                } else {
                    $_SESSION['error'] = "Vous n'avez pas la permission de modifier ce post.";
                }
            } else {
                $_SESSION['error'] = "Données invalides pour la modification du post.";
            }
        }
        header("Location: /");
        exit;
    }
}