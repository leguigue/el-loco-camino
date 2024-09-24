<?php
class LoginController extends Controller {
    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function index($params = [])
    {
                $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username');
            $password = $_POST['password'];

            if ($username && $password) {
                $user = $this->userRepository->getUserByName($username);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: /");
                    exit();
                } else {
                    $error = "Nom d'utilisateur ou mot de passe incorrect.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        include_once __DIR__.'/../../../views/login.php';
    }
}