<?php
// Language Configuration

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default language
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'id'; // Default to Indonesian
}

// Handle language change
if (isset($_GET['lang']) && in_array($_GET['lang'], ['id', 'en'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Load language file
$lang = [];
$langFile = __DIR__ . '/../lang/' . $_SESSION['lang'] . '.php';
if (file_exists($langFile)) {
    $lang = require $langFile;
}

// Translation helper function
function __($key) {
    global $lang;
    $keys = explode('.', $key);
    $value = $lang;
    
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $key; // Return key if translation not found
        }
    }
    
    return $value;
}

// Get current language
function current_lang() {
    return $_SESSION['lang'] ?? 'id';
}
