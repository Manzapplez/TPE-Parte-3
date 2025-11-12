<?php

# Response se usa para responder al cliente

class Response
{
    private $finished = false;

    public function hasFinished()
    {
        return $this->finished;
    }

    # ->json($data, $status = 200): envía una respuesta en JSON con código HTTP.
    public function json($data, $status = 200)
    {
        header("Content-Type: application/json");
        $statusText = $this->_requestStatus($status);
        header("HTTP/1.1 $status $statusText");
        echo json_encode($data);
        $this->finished = true;
    }

    private function _requestStatus($code)
    {
        $status = array(
            200 => "OK",
            201 => "Created",
            204 => "No Content",
            400 => "Bad Request",
            401 => "Unauthorized",
            403 => "Forbidden",
            404 => "Not Found",
            500 => "Internal Server Error"
        );
        if (!isset($status[$code])) {
            $code = 500;
        }
        return $status[$code];
    }
}
