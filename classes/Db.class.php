<?php

class Db {

    private static $conn;
    public static function getInstance() {
        if( is_null(self::$conn)) {
            self::$conn = new PDO("mysql:host=localhost;dbname=tasky", "root", "");
        }
        return self::$conn;
    }
}
