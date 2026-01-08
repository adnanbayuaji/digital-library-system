<?php
namespace Middleware;

use Helpers\Session;

class AuthMiddleware {
    public static function check() {
        if (!Session::get('user_id')) {
            header('Location: /login.php');
            exit();
        }
    }
}
