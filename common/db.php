<?php
// DB Connection
$host = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'discuss';

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset (important)
$conn->set_charset("utf8mb4");