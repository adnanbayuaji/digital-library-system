<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../src/Helpers/Session.php';

use App\Helpers\Session;

// Destroy the session to log the user out
Session::destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>