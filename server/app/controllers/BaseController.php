<?php


namespace app\controllers;


class BaseController
{
    /**
     * @return bool
     */
    public function sendOK()
    {
        echo json_encode('OK');

        return true;
    }

    /**
     * @param array $response
     *
     * @return bool
     */
    public function sendResponse(array $response)
    {
        echo json_encode($response);

        return true;
    }

    /**
     * @param int $statusCode
     * @param string $message
     *
     * @return bool
     */
    public function sendError(int $statusCode, string $message)
    {
        http_response_code($statusCode);
        echo json_encode($message);

        return false;
    }
}