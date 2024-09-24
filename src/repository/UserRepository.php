<?php

class UserRepository extends Db {
    public static function insert(User $user) {
        try {
            $username = $user->getUsername();
            $password = $user->getPassword();       
           
            $db = self::getInstance();
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            return $stmt->execute(['username' => $username, 'password' =>$user->getPassword()]);
        } catch (PDOException $e) {
            echo "Error inserting user: " . $e->getMessage();
            return false;
        }
    }

    public static function getUserByName($username) {
        try {
            $db = Db::getInstance();
            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

}

  