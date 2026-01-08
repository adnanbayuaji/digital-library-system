<?php
$host = 'localhost'; // Database host
$dbname = 'digital_library'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create MySQLi connection
$db = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set charset to utf8
$db->set_charset("utf8mb4");
?>