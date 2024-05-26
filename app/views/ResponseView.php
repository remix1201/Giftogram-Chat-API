<?php

class ResponseView {
    /**
     * Sends a success response in JSON format.
     *
     * @param mixed $data The data to be encoded and sent as the response body.
     * @return void
     */
    public static function sendSuccess($data) {
        header('Content-Type: application/json');
        http_response_code(200);

        echo json_encode($data);
    }

    /**
     * Sends an error response in JSON format.
     *
     * @param int $error_code The error code associated with the error.
     * @param string $error_title The title of the error.
     * @param string $error_message The detailed error message.
     * @return void
     */
    public static function sendError($error_code, $error_title, $error_message) {
        header('Content-Type: application/json');
        http_response_code($error_code);

        $response = [
            'error_code' => $error_code,
            'error_title' => $error_title,
            'error_message' => $error_message
        ];
        echo json_encode($response);
        exit;
    }
}
