<?php

class Validator {
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePassword($password) {
        return strlen($password) >= 6;
    }

    public static function validateRequired($value) {
        return !empty(trim($value));
    }

    public static function validateBookData($data) {
        return self::validateRequired($data['title']) &&
               self::validateRequired($data['author']) &&
               self::validateRequired($data['isbn']);
    }

    public static function validateVisitorData($data) {
        return self::validateRequired($data['name']) &&
               self::validateRequired($data['purpose']);
    }
}