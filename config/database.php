<?php

$dsn = 'mysql:host=localhost;dbname=db_giftogram_chat;charset=utf8';
$username = 'giftogram_chat_user';
$password = 'giftogram_chat_pass';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
