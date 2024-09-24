<?php
session_start();
//core
require_once '../core/Router.php';
require_once '../_db/Db.php';

//repository
require_once '../src/repository/UserRepository.php';
require_once '../src/repository/CommentRepository.php';
require_once '../src/repository/PostRepository.php';
require_once '../src/repository/LikeRepository.php';

//controllers
require_once '../src/controllers/Controller.php';
require_once '../src/controllers/MainController.php';
//log
require_once '../src/controllers/usercontrollers/LoginController.php';
require_once '../src/controllers/usercontrollers/RegisterController.php';
require_once '../src/controllers/usercontrollers/LogoutController.php';
// comment
require_once '../src/controllers/commentcontrollers/AddCommentController.php';
require_once '../src/controllers/commentcontrollers/EditCommentController.php';
require_once '../src/controllers/commentcontrollers/DeleteCommentController.php';
// like
require_once '../src/controllers/likecontrollers/ToggleLikeController.php';
require_once '../src/controllers/likecontrollers/AddLikeController.php';
require_once '../src/controllers/likecontrollers/RemoveLikeController.php';
// post
require_once '../src/controllers/postcontrollers/AddPostController.php';
require_once '../src/controllers/postcontrollers/EditPostController.php';
require_once '../src/controllers/postcontrollers/DeletePostController.php';

// models
require_once '../src/models/User.php';
require_once '../src/models/Comment.php';
require_once '../src/models/Post.php';

$router = new Router();
$router->start();