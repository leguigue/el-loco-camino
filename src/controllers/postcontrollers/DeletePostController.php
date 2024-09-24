<?php

class DeletePostController extends Controller
{
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['post_id'] ?? null;
            if ($id) {
                // Vérifiez si l'utilisateur a le droit de supprimer ce post
                $post = PostRepository::getPostById($id);
                if ($post && $post['user_id'] == $_SESSION['user_id']) {
                    $result = PostRepository::deletePost($id);
                    if ($result) {
                        $_SESSION['message'] = "Post supprimé avec succès.";
                    } else {
                        $_SESSION['error'] = "Erreur lors de la suppression du post.";
                    }
                } else {
                    $_SESSION['error'] = "Vous n'avez pas la permission de supprimer ce post.";
                }
            } else {
                $_SESSION['error'] = "ID du post manquant.";
            }
        }
        header("Location: /");
        exit;
    }
}