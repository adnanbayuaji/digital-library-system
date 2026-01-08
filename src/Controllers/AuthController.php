<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Session;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = User::findByUsername($username);

            if ($user && password_verify($password, $user->password)) {
                Session::set('user_id', $user->id);
                Session::set('username', $user->username);
                Session::set('user_role', $user->role);
                Session::set('user_email', $user->email);
                header('Location: /dashboard.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        }

        include '../public/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $user = new User();
            $user->username = $username;
            $user->password = $password;

            if ($user->save()) {
                header('Location: /login.php');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }

        include '../public/register.php';
    }

    public function logout()
    {
        Session::destroy();
        header('Location: /login.php');
        exit;
    }
}