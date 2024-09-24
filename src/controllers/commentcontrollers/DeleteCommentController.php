<?php

class DeleteCommentController extends Controller
{
    public function index($params = [])
    {
        if (isset($_POST['comment_id'])) {
            
            CommentRepository::deleteComment($_POST['comment_id']);
        }
        header("Location: /");
        exit;
    }
}

