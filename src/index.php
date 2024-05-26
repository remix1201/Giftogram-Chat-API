<?php

// Include necessary files
require_once '../config/database.php';
require_once '../app/models/UserModel.php';
require_once '../app/models/MessageModel.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/MessageController.php';
require_once '../app/views/ResponseView.php';
require_once '../app/helpers/Validator.php';
require_once '../app/core/Router.php';

// Handle the request
$router = new Router($pdo);
$router->handleRequest();
