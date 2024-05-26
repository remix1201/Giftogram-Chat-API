<?php

class UserController {
    private $user;

    /**
     * UserController constructor.
     * 
     * @param $pdo The PDO object used for database connection.
     */
    public function __construct($pdo) {
        $this->user = new UserModel($pdo);
    }

    /**
     * Register a new user.
     * 
     * @param $data An array containing user registration data.
     */
    public function register($data) {
        Validator::validate($data, ['email', 'password', 'first_name', 'last_name']);

        if ($this->user->register($data['email'], $data['password'], $data['first_name'], $data['last_name'])) {
            ResponseView::sendSuccess([
                'user_id' => $this->user->getLastInsertId(),
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name']
            ]);
        } else {
            ResponseView::sendError(500, 'Internal Server Error', 'Could not register the user. Please try again later.');
        }
    }

    /**
     * Login a user.
     * 
     * @param $data An array containing user login data.
     */
    public function login($data) {
        Validator::validate($data, ['email', 'password']);

        $user = $this->user->login($data['email']);
        if ($user && password_verify($data['password'], $user['password'])) {
            ResponseView::sendSuccess([
                'user_id' => $user['user_id'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            ]);
        } else {
            ResponseView::sendError(401, 'Unauthorized', 'Email or Password was Invalid!');
        }
    }

    /**
     * Lists all users excluding requester user ID via query parameter.
     *
     * @param array $queryParams The query parameters containing the User ID to be excluded.
     * @return void
     */
    public function listAllUsers($queryParams) {
        Validator::validate($queryParams, ['requester_user_id']);

        $requester_user_id = $queryParams['requester_user_id'];

        if (!$this->user->exists($queryParams['requester_user_id'])) {
            ResponseView::sendError(400, 'Bad Request', 'Requester User ID does not exist!'); // 400 Bad Request
            return;
        }

        $users = $this->user->listAll($requester_user_id);
        if ($users) {
            ResponseView::sendSuccess(['users' => $users]);
        } else {
            ResponseView::sendError(404, 'Not Found', 'No users found.');
        }
    }
}
