<?php

class MessageModel {
    private $pdo;

    /**
     * Constructs a new Message object.
     *
     * @param PDO $pdo The PDO object used for database connection.
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Retrieves all messages between two users.
     *
     * @param int $user_id_a The ID of the first user.
     * @param int $user_id_b The ID of the second user.
     * @return array An array of messages.
     */
    public function viewMessages($user_id_a, $user_id_b) {
        $sql = "SELECT * FROM messages WHERE (sender_user_id = ? AND receiver_user_id = ?) OR (sender_user_id = ? AND receiver_user_id = ?) ORDER BY created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id_a, $user_id_b, $user_id_b, $user_id_a]);
        return $stmt->fetchAll();
    }

    /**
     * Sends a message from one user to another.
     *
     * @param int $sender_user_id The ID of the sender user.
     * @param int $receiver_user_id The ID of the receiver user.
     * @param string $message The content of the message.
     * @param int $epoch The epoch timestamp of the message.
     * @return bool True if the message was sent successfully, false otherwise.
     */
    public function sendMessage($sender_user_id, $receiver_user_id, $message, $epoch) {
        $sql = "INSERT INTO messages (sender_user_id, receiver_user_id, message, epoch) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$sender_user_id, $receiver_user_id, $message, $epoch]);
    }
}
