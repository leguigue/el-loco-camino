<?php
class MainController extends Controller {
    public function index($params = [])
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $postData = PostRepository::getPosts();
        
        $posts = [];
        foreach ($postData as $post) {
            $objectPost = Post::createFromArray($post);
            $comments = CommentRepository::getComments($post['id']);
            $objectPost->setComments($comments);
            array_push($posts, $objectPost);
        }

        // Gérer l'édition des posts
        $editPostId = $_GET['edit'] ?? null;
        $editCommentId = $_GET['editComment'] ?? null;

        require_once(__DIR__.'/../../views/main.php');
    }
}