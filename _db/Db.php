<?php 
class Db {
    private static $instance;

    public static function getInstance() {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=papayou", "root", "");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$instance;
    }

    public static function disconnect() {
        self::$instance = null;
    }
}