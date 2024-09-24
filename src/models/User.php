

<?php
class User {
    private $id = null;
    private $username;
    private $password;

    public function __construct($username, $password, ?int $id = null) {
        if (isset($id)) {
            $this->id = htmlspecialchars($id);
        }
        $this->username = $username;
        $this->password = $password;
    }
        public function getId() {
        return $this->id;
    }
    public function getUsername() {        
        return $this->username;
    }   
    public function getPassword() {
        return $this->password;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }   
}