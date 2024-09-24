<?php
class RegisterController extends Controller
{
    const MIN_PASSWORD_LENGTH = 8;
    const ERROR_PASSWORD_MISMATCH = "Les mots de passe ne correspondent pas.";
    const ERROR_USERNAME_TAKEN = "Ce nom d'utilisateur est déjà pris.";
    const ERROR_REGISTRATION_FAILED = "L'inscription a échoué. Veuillez réessayer.";
    const ERROR_PASSWORD_REQUIREMENTS = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un symbole.";
    const ERROR_INVALID_USERNAME = "Le nom d'utilisateur ne doit contenir que des lettres, des chiffres et des underscores.";
    public function index($params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // if (isset($_POST['username'])&& isset($_POST['password'])){
            //     $user=new User(0,$_POST['username'],password_hash($_POST['password'],PASSWORD_DEFAULT));
            //     User::insert($user->getUsername(),$user->getPassword());
            $username = $_POST['username'];
            $password = $_POST['password'];
            $user = new User($username, $password);
            UserRepository::insert($user);
            header('Location: /login');
        }
        include_once __DIR__ ."/../../../views/register.php";
    }
    private function isPasswordValid($password)
    {
        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return false;
        }
        return true;
    }
}
