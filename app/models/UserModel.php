<?php

class UserModel {
    private $pdo;

    /**
     * User constructor.
     * 
     * @param PDO $pdo The PDO instance used for database operations.
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Registers a new user.
     * 
     * @param string $email The email address of the user.
     * @param string $password The password of the user.
     * @param string $first_name The first name of the user.
     * @param string $last_name The last name of the user.
     * @return bool Returns true if the user is successfully registered, false otherwise.
     */
    public function register($email, $password, $first_name, $last_name) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$email, $password_hashed, $first_name, $last_name]);
    }

    /**
     * Returns the last inserted ID from the database.
     *
     * @return int The last inserted ID.
     */
    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }

    /**
     * Logs in a user.
     * 
     * @param string $email The email address of the user.
     * @return array|false Returns an array containing the user data if the login is successful, false otherwise.
     */
    public function login($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Retrieves a list of all users except the requester user.
     *
     * @param int $requester_user_id The ID of the user making the request.
     * @return array Returns an array of user records containing user_id, email, first_name, and last_name.
     */
    public function listAll($requester_user_id) {
        $sql = "SELECT user_id, email, first_name, last_name FROM users WHERE user_id != ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$requester_user_id]);
        return $stmt->fetchAll();
    }

    /**
     * Check if a user exists in the database.
     *
     * @param int $user_id The ID of the user to check.
     * @return bool Returns true if the user exists, false otherwise.
     */
    public function exists($user_id) {
        $sql = "SELECT COUNT(*) FROM users WHERE user_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchColumn() > 0;
    }
}
