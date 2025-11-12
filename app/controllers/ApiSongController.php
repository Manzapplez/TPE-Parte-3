<?php

require_once './app/models/SongModel.php';

class ApiSongController
{
    private $model;

    public function __construct()
    {
        $this->model = new SongModel();
    }

    # GET /songs, puede o no venir con parámetros (por default null o ASC)
    public function getSongs($req, $res)
    {
        $orderBy = $_GET['orderBy'] ?? null;
        $sort = $_GET['sort'] ?? 'ASC';
        $limit = $_GET['limit'] ?? null;
        $page = $_GET['page'] ?? null;
        $id_artist = $_GET['artist'] ?? null;

        $songs = $this->model->getSongs($id_artist, $orderBy, $sort, $limit, $page);

        if ($songs)
            return $res->json($songs, 200);
        else
            return $res->json(["error" => "No se encontraron canciones"], 404);
    }

    # GET /songs/:id
    public function getSong($req, $res)
    {
        $id = $req->params->id ?? null;

        if (!$id)
            return $res->json(["error" => "Falta el parámetro ID"], 400);

        $song = $this->model->getSong($id);

        if ($song)
            return $res->json($song, 200);
        else
            return $res->json(["error" => "Canción con id=$id no encontrada"], 404);
    }

    # POST /songs
    public function addSong($req, $res)
    {
        $body = $req->body;

        if (
            !isset($body->id_artist) || !isset($body->title) ||
            !isset($body->album) || !isset($body->duration)
        ) {
            return $res->json(["error" => "Datos incompletos"], 400);
        }

        $this->model->addSong(
            $body->id_artist,
            $body->title,
            $body->album,
            $body->duration,
            $body->genre ?? null,
            $body->video ?? null
        );

        return $res->json(["message" => "Canción creada :D"], 201);
    }

    # PUT /songs/:id
    public function editSong($req, $res)
    {
        $id = $req->params->id ?? null;
        $body = $req->body;

        if (!$id || !$body)
            return $res->json(["error" => "Datos incompletos"], 400);

        $song = $this->model->getSong($id);
        if (!$song)
            return $res->json(["error" => "Canción con id=$id no encontrada"], 404);

        $success = $this->model->editSong(
            $id,
            $body->id_artist,
            $body->title,
            $body->album,
            $body->duration,
            $body->genre ?? null,
            $body->video ?? null
        );

        if ($success)
            return $res->json(["message" => "Canción actualizada correctamente :D"], 200);
        else
            return $res->json(["error" => "No se pudo actualizar la canción"], 500);
    }
}