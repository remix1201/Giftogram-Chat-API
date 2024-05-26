<?php

class Validator {
    /**
     * Validates the given data against the specified fields.
     *
     * @param array $data The input data to be validated.
     * @param array $fields The fields to be validated.
     * @return void
     */
    public static function validate($data, $fields) {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                ResponseView::sendError(400, 'Bad Request', "$field is required!");
                exit;
            }
            $data[$field] = htmlspecialchars(strip_tags($data[$field])); // Sanitize input
        }
        return $data;
    }
}
