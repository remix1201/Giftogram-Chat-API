<?php

class MessageController {
    private $message;
    private $user;

    /**
     * MessageController constructor.
     * 
     * @param $pdo The PDO object for database connection.
     */
    public function __construct($pdo) {
        $this->message = new MessageModel($pdo);
        $this->user = new UserModel($pdo);
    }

    /**
     * Retrieves and returns the messages between two users.
     *
     * @param array $queryParams The query parameters containing the user IDs.
     * @return void
     */
    public function viewMessages($queryParams) {
        if (!isset($queryParams['user_id_a']) || !isset($queryParams['user_id_b'])) {
            ResponseView::sendError(400, 'Bad Request', 'User ID A and User ID B are required!');
            return;
        }

        $user_id_a = $queryParams['user_id_a'];
        $user_id_b = $queryParams['user_id_b'];

        Validator::validate($queryParams, ['user_id_a', 'user_id_b']);

        if (!$this->user->exists($queryParams['user_id_a']) || !$this->user->exists($queryParams['user_id_b'])) {
            ResponseView::sendError(400, 'Bad Request', 'Sender or receiver User ID does not exist!'); // 400 Bad Request
            return;
        }

        $messages = $this->message->viewMessages($user_id_a, $user_id_b);

        if ($messages) {
            ResponseView::sendSuccess(['messages' => $messages]);
        } else {
            ResponseView::sendError(404, 'Not Found', 'No messages found between these users.');
        }
    }

    /**
     * Send a message from one user to another.
     * 
     * @param $data An array containing the sender user ID, receiver user ID, and the message content.
     */
    public function sendMessage($data) {
        Validator::validate($data, ['sender_user_id', 'receiver_user_id', 'message']);

        if (!$this->user->exists($data['sender_user_id']) || !$this->user->exists($data['receiver_user_id'])) {
            ResponseView::sendError(400, 'Bad Request', 'Sender or receiver User ID does not exist!'); // 400 Bad Request
            return;
        }

        $epoch = time();

        if ($this->message->sendMessage($data['sender_user_id'], $data['receiver_user_id'], $data['message'], $epoch)) {
            ResponseView::sendSuccess([
                'success_code' => '200',
                'success_title' => 'OK',
                'success_message' => 'Message was sent successfully!'
            ]);
        } else {
            ResponseView::sendError(500, 'Internal Server Error', 'Could not send the message. Please try again later.');
        }
    }
}
