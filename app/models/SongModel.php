<?php

/* php no sabe dónde está model al declarar las clases hijas porque no carga automáticamente todos los archivos 
a menos que le haga un require/include o tenga un autoloader en config.php, por ahora lo pongo como require */
require_once 'Model.php';

class SongModel extends Model
{

    /*  GET /songs
    >>> FILTRO por artista (?artist=ID)
    >>> ORDENAMIENTO (?orderBy=columna&sort=ASC|DESC)
    >>> PAGINACION (?limit=N&page=M) */
    public function getSongs($id_artist = null, $orderBy = null, $sort = 'ASC', $limit = null, $page = null)
    {
        $sql = 'SELECT songs.*, artists.name AS artist_name FROM songs
            JOIN artists ON songs.id_artist = artists.id_artist';
        $params = [];

        // Filtrado por artista
        if ($id_artist !== null) {
            $sql .= ' WHERE songs.id_artist = ?';
            $params[] = $id_artist;
        }

        // Valida columnas permitidas
        $allowedOrder = ['id_song', 'title', 'album', 'duration', 'genre', 'artist_name'];
        if ($orderBy && in_array($orderBy, $allowedOrder)) {
            $sort = strtoupper($sort) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY $orderBy $sort";
        } else {
            $sql .= " ORDER BY songs.id_song ASC";
        }

        // Paginación
        if ($limit !== null && $page !== null && is_numeric($limit) && is_numeric($page)) {
            $offset = ($page - 1) * $limit;
            $sql .= ' LIMIT ' . intval($limit) . ' OFFSET ' . intval($offset);
        }

        $query = $this->db->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }


    # GET /songs/:id
    public function getSong($id)
    {
        $query = $this->db->prepare('
            SELECT songs.*, artists.name AS artist_name
            FROM songs
            JOIN artists ON songs.id_artist = artists.id_artist
            WHERE songs.id_song = ?
        ');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    # POST /songs
    public function addSong($id_artist, $title, $album, $duration, $genre, $video)
    {
        $query = $this->db->prepare('INSERT INTO songs (id_artist, title, album, duration, genre, video) VALUES (?,?,?,?,?,?)');
        $query->execute([$id_artist, $title, $album, $duration, $genre, $video]);
        return $this->db->lastInsertId();
    }

    # PUT /songs/:id
    public function editSong($id, $id_artist, $title, $album, $duration, $genre, $video)
    {
        $query = $this->db->prepare('UPDATE songs SET id_artist = ?, title = ?, album = ?, duration = ?, genre = ?, video = ? WHERE id_song = ?');
        return $query->execute([$id_artist, $title, $album, $duration, $genre, $video, $id]);
    }

    # no agregué DELETE al routing, en caso de ser usado sería DELETE /songs/:id
    public function removeSong($id)
    {
        $query = $this->db->prepare('DELETE FROM songs WHERE id_song=?');
        return $query->execute([$id]);
    }
}
