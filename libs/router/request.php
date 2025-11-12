<?php

// Ejemplo del livecoding to-do list !
// https://gitlab.com/unicen/Web2/livecoding2025/tandil/todo-list-rest/-/tree/main/libs/router

class Request
{
    # ->body: datos enviados en JSON (ej. POST/PUT)
    public $body = null; # { nombre: 'Saludar', descripcion: 'Saludar a todos' }
    public $params = null; # /api/songs/:id
    public $query = null; # ?sort=asc, ?finalizadas=true
    public $user = null; # Información del usuario autenticado
    public $authorization = null;

    public function __construct()
    {
        try {
            # file_get_contents('php://input') lee el body de la request
            $this->body = json_decode(file_get_contents('php://input'));
        } catch (Exception $e) {
            $this->body = null;
        }
        $this->authorization = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        $this->query = (object) $_GET;
    }
}
