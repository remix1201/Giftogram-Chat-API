<?php

class Router {
    /**
     * Router class handles incoming HTTP requests and routes them to the appropriate controllers and methods.
     *
     * @param object $pdo The PDO object used for database connection.
     */
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Handles the incoming HTTP request and routes it to the appropriate controller method.
     *
     * @return void
     */
    public function handleRequest() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $queryString = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $queryParams = [];
        if ($queryString) {
            parse_str($queryString, $queryParams);
        }

        $data = json_decode(file_get_contents('php://input'), true);

        $userController = new UserController($this->pdo);
        $messageController = new MessageController($this->pdo);

        switch ($uri) {
            case '/register':
                $this->routePostRequest($method, $data, [$userController, 'register']);
                break;
            case '/login':
                $this->routePostRequest($method, $data, [$userController, 'login']);
                break;
            case '/view_messages':
                $this->routeGetRequest($method, $queryParams, [$messageController, 'viewMessages']);
                break;
            case '/send_message':
                $this->routePostRequest($method, $data, [$messageController, 'sendMessage']);
                break;
            case '/list_all_users':
                $this->routeGetRequest($method, $queryParams, [$userController, 'listAllUsers']);
                break;
            default:
                ResponseView::sendError(404, 'Not Found', 'Endpoint not found.');
                break;
        }
    }

    /**
     * Routes a POST request to the appropriate controller method.
     *
     * @param string $requestMethod The HTTP request method.
     * @param array $data The data sent in the request body.
     * @param array $callback The controller method to call.
     * 
     * @return void
     */
    private function routePostRequest($requestMethod, $data, $callback) {
        if ($requestMethod !== 'POST') {
            ResponseView::sendError(405, 'Method Not Allowed', 'POST method required.');
            return;
        }

        if (is_null($data)) {
            ResponseView::sendError(400, 'Bad Request', 'Invalid JSON data.');
            return;
        }

        call_user_func($callback, $data);
    }

    /**
     * Routes a GET request to the appropriate controller method.
     *
     * @param string $requestMethod The HTTP request method.
     * @param array $queryParams The query parameters sent in the request.
     * @param array $callback The controller method to call.
     * 
     * @return void
     */
    private function routeGetRequest($requestMethod, $queryParams, $callback) {
        if ($requestMethod !== 'GET') {
            ResponseView::sendError(405, 'Method Not Allowed', 'GET method required.');
            return;
        }

        call_user_func($callback, $queryParams);
    }
}
