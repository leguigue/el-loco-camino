<?php
class EditCommentController extends Controller
{
    public function index($params = [])
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['comment_id'] ?? null;
        $content = $_POST['content'] ?? '';
        $user_id = $_SESSION['user_id'] ?? null;

        if ($id && $content && $user_id) {
            $comment = CommentRepository::getCommentById($id);
            if ($comment && $comment['user_id'] == $user_id) {
                $result = CommentRepository::editComment($id, $content, $user_id);
                if ($result) {
                    $_SESSION['message'] = "Commentaire modifié avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la modification du commentaire.";
                }
            } else {
                $_SESSION['error'] = "Vous n'avez pas la permission de modifier ce commentaire.";
            }
        } else {
            $_SESSION['error'] = "Données invalides pour la modification du commentaire.";
        }
    }
    header("Location: /");
    exit;
}
}