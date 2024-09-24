<?php

class AddCommentController extends Controller
{
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $content = $_POST['content'] ?? '';
            $user_id = $_SESSION['user_id'] ?? null;
            $post_id = $_POST['post_id'] ?? null;
            $parent_id = $_POST['parent_id'] ?? null; // Récupération du parent_id

            if ($content && $user_id && $post_id) {
                CommentRepository::addComment($content, $user_id, $post_id, $parent_id);
                $_SESSION['message'] = "Commentaire ajouté avec succès.";
            } else {
                $_SESSION['error'] = "Données invalides pour l'ajout du commentaire.";
            }
        }
        header("Location: /");
        exit;
    }
}
